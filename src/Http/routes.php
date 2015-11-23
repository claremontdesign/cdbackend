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
Route:get('claremontdesign/cdbackend', function(){
	return 'ClaremontDesign Backend Package. Try more at <a href="' . cd_route('admin') . '" title="Backend Entry">Backend Gate</a>';
});

Route::get('/admin/login', ['as' => 'adminLogin', function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.login.class');
if(is_array($className))
{
	$className = cd_config('auth.login.class.admin');
}
$controller = new $className;
return $controller->getLogin();
}]);
Route::post('/admin/login', ['as' => 'adminAdminLogin', function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.login.class');
if(is_array($className))
{
	$className = cd_config('auth.login.class.admin');
}
$controller = new $className;
return $controller->postLogin(app('request'));
}]);
Route::get('/admin/logout', ['as' => 'adminLogout',
	function () {
app('cdbase')->setSection('admin');
$className = cd_config('auth.logout.class');
if(is_array($className))
{
	$className = cd_config('auth.logout.class.admin');
}
$controller = new $className;
return $controller->getLogout();
}]);

/**
 * Wildcard routing for Admin
 */
Route::match(['get', 'post'], '/admin/{module?}/{action?}/{record?}/{task?}/{paramOne?}/{paramTwo?}', function($module = null, $action = null, $record = null, $task = null, $paramOne = null, $paramTwo = null){

//	if(!cd_auth_check())
//	{
//		return redirect(route('adminLogin'));
//	}
//	if(!cd_auth_is('admin'))
//	{
//		cd_abort(401);
//	}

	app('cdbase')->setSection('admin');
	$requestMethod = \Request::method();

	/**
	 * Check if module can be instantiated
	 */
	if(empty($module))
	{
		$module = 'dashboard';
		$action = 'index';
	}
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
			if(!$hasAccess)
			{
				cd_abort(401);
			}
			/**
			 * Check if $action is dispatchable
			 */
			if(!$moduleInstance->checkAction($action))
			{
				cd_abort(404);
			}
			/**
			 * Check if currentUser has access to this action
			 */
			if(!$moduleInstance->checkActionAccess($action))
			{
				cd_abort(401);
			}

			$controller = $moduleInstance->controllerInstance();
			$controller->setAction($action);
			$controller->setTask($task);
			$controller->setRecord($record);
			$controller->setParams(compact('paramOne', 'paramTwo'));
			$methodName = camel_case(strtolower($requestMethod . '_' . $action));
			if(method_exists($controller, $methodName))
			{
				return $controller->$methodName();
			}
			if(!empty($task))
			{
				$actionTaskMethod = camel_case(strtolower($requestMethod . '_' . $action . '_' . $task));
				if(method_exists($controller, $actionTaskMethod))
				{
					return $controller->$actionTaskMethod();
				}
				$actionTask = camel_case(strtolower($action . '_' . $task));
				if(method_exists($controller, $actionTask))
				{
					return $controller->$actionTask();
				}
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
		}
		cd_abort(404);
	}

	$backendClassname = cd_config('backend.class');
	$backendController = new $backendClassname;
	$backendController->setModule($module);
	$backendController->setAction($action);
	$backendController->setTask($task);
	$backendController->setRecord($record);
	$backendController->setParams(compact('paramOne', 'paramTwo'));
	return $backendController->index();
})->name('adminModule');
