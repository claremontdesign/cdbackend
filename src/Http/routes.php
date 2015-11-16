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


/**
 * Wildcard routing for Admin
 */
Route::match(['get', 'post'], '/admin/{module?}/{action?}/{record?}/{task?}/{paramOne?}/{paramTwo?}', function($module = null, $action = null, $record = null, $task = null, $paramOne = null, $paramTwo = null){

	$urlArray = cd_cdbase_fix_wildcard_url([$module, $action, $record, $task, $paramOne, $paramTwo]);
	$route = str_replace(array('.html', '.php'), '', implode('/', $urlArray));
	$requestMethod = \Request::method();

	/**
	 * Check if module can be instantiated
	 */
	if(!empty($module))
	{
		$moduleInstance = cd_module($module);
		if($moduleInstance instanceof \Claremontdesign\Cdbase\Modules\ModuleInterface)
		{
			$controller = $moduleInstance->controllerInstance();
			$action = $action === null ? 'index' : $action;
			if(!$moduleInstance->checkAction($action))
			{
				cd_abort(404);
			}
			$controller->setAction($action);
			$controller->setTask($task);
			$controller->setRecord($record);
			$controller->setParams(compact('paramOne', 'paramTwo'));
			$methodName = camel_case($requestMethod . '_' . $action);
			if(method_exists($controller, $methodName))
			{
				return $controller->$methodName();
			}
			if(!empty($task))
			{
				$actionTaskMethod = camel_case($requestMethod . '_' . $action . '_' . $task);
				if(method_exists($controller, $actionTaskMethod))
				{
					return $controller->$actionTaskMethod();
				}
				$actionTask = camel_case($action . '_' . $task);
				if(method_exists($controller, $actionTask))
				{
					return $controller->$actionTask();
				}
			}
			$widgets = $moduleInstance->widgets($action);
			if(!empty($widgets))
			{
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
