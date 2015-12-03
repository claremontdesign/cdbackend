<?php

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 7, 2015 1:25:03 PM
 * @file config.php
 * @project Cdbackend
 */
return [
	'backend' => [
		'class' => Claremontdesign\Cdbackend\Http\Controllers\BackendController::class,
		'access' => [
			'minimum' => 'salesman',
		],
		'design' => [
			'template' => 'default',
			'package' => 'cdbackend'
		],
	],
	'module' => [
		'class' => Claremontdesign\Cdbackend\Http\Controllers\ModuleController::class
	],
	'auth' => [
		'enable' => true,
		'login' => [
			'enable' => true,
			'admin' => [
				'routeToRedirectIfAuth' => 'Module',
				'class' => Claremontdesign\Cdbackend\Http\Controllers\Auth\AuthController::class
			],
		],
		'logout' => [
			'enable' => true,
			'admin' => [
				'routeToRedirectIfAuth' => 'Module',
				'class' => Claremontdesign\Cdbackend\Http\Controllers\Auth\AuthController::class
			],
		],
	],
];
