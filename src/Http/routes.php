<?php

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 07, 2015 1:43:45 PM
 * @file routes.php
 * @project Claremontdesign
 * @package Cdbackend
 */
Route::filter('csrf', function() {
    $token = \Request::ajax() ? \Request::header('X-CSRF-Token') : Input::get('_token');
    if (Session::token() != $token)
	{
        throw new Illuminate\Session\TokenMismatchException;
	}
});

Route:get('claremontdesign/cdbackend', function(){
	return 'ClaremontDesign Backend Package. Try more at <a href="' . cd_route('admin') . '" title="Backend Entry">Backend Gate</a>';
});



Route::get('/admin/login', ['as' => 'adminlogin', function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.login.admin.class');
$controller = new $className;
return $controller->getLogin();
}]);
Route::post('/admin/login', ['as' => 'adminpostLogin', function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.login.admin.class');
$controller = new $className;
return $controller->postLogin(app('request'));
}]);
Route::get('/admin/logout', ['as' => 'adminlogout',
	function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.logout.admin.class');
$controller = new $className;
return $controller->getLogout();
}]);

/**
 * Wildcard routing for Admin
 */
Route::match(['get', 'post'], '/admin/{module?}/{action?}/{record?}/{paramOne?}/{paramTwo?}/{paramThree?}/{paramFour?}', function($module = null, $action = null, $record = null, $paramOne = null, $paramTwo = null, $paramThree = null, $paramFour = null){

	app('cdbase')->setSection('admin');
	$requestMethod = \Request::method();

	/**
	 * Check for minimum access to the Admin Section
	 */
	$minimumAccess = cd_config('backend.access.minimum', 'admin');
	if(!cd_auth_is($minimumAccess))
	{
		if(cd_auth_check())
		{
			return cd_abort(401, ucfirst($minimumAccess) . ' Permission is required to access "Admin".');
		}
		else
		{
			return redirect(cd_route('login'));
		}
	}

	if(empty($module))
	{
		$module = 'dashboard';
		$action = 'index';
	}
	app('cdbackend')->setRouteParams(compact('module', 'action', 'record', 'paramOne', 'paramTwo', 'paramThree', 'paramFour'));
	if(!empty($module))
	{
		$moduleInstance = cd_module($module);
		if($moduleInstance instanceof \Claremontdesign\Cdbase\Modules\ModuleInterface)
		{
			$action = $action === null ? 'index' : $action;
			/**
			 * Check if current user has access to this Module
			 */
			$hasAccess = $moduleInstance->hasAccess();
			if(empty($hasAccess))
			{
				if(cd_auth_check())
				{
					return cd_abort(401, ucfirst($moduleInstance->getAccess()) . ' Permission is required to access module "' . ucfirst($module) . '".');
				}
				else
				{
					return redirect(cd_route('login'));
				}
			}

			/**
			 * Check action Methods
			 */
			if(!$moduleInstance->checkActionMethods($action))
			{
				return cd_abort(401, 'Page cannot be accessed directly.');
			}

			/**
			 * Check if $action is dispatchable
			 */
			if(!$moduleInstance->checkAction($action))
			{
				return cd_abort(404, 'Module: ' . ucfirst($module) . ' or path not found');
			}
			/**
			 * Check if currentUser has access to this action
			 */
			if(!$moduleInstance->checkActionAccess($action))
			{
				if(cd_auth_check())
				{
					return cd_abort(401, ucfirst($moduleInstance->getAccess()) . ' Permission is required.');
				}
				else
				{
					return redirect(cd_route('login'));
				}
			}
			/**
			 * Action Record
			 */
			$parentRecord = $moduleInstance->checkParentRecord($action);
			if($parentRecord !== true)
			{
				return cd_abort(404, $parentRecord);
			}
			$controller = $moduleInstance->controllerInstance();
			$controller->setAction($action);
			$controller->setRecord($record);
			$controller->setParams(compact('paramOne', 'paramTwo', 'paramThree', 'paramFour'));
			$methodName = camel_case(strtolower($requestMethod . '_' . $action));
			if(method_exists($controller, $methodName))
			{
				return $controller->$methodName();
			}
			$widgets = $moduleInstance->widgets($action, $controller);
			if(!empty($widgets))
			{
				$widgetActionMethod = camel_case(strtolower($requestMethod . '_' . $action . '_widget'));
				if(method_exists($controller, $widgetActionMethod))
				{
					return $controller->$widgetActionMethod($widgets);
				}
				$widgetMethod = camel_case(strtolower($requestMethod . '_widget'));
				if(method_exists($controller, $widgetMethod))
				{
					return $controller->$widgetMethod($widgets);
				}
				return $controller->widgets($widgets);
			}
			$view = $moduleInstance->renderView($action, $controller);
			if($view instanceof \Illuminate\View\View)
			{
				return $view;
			}
		}
	}
	return cd_abort(404, 'Module Not Found.');
})->name('adminModule');
