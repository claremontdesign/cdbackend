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
 *
 * Example of a Module
 */
define('MODULE_DASHBOARD', 'dashboard');
$config = [
	'modules' => [
		'dashboard' => [
			'enable' => true,
			'name' => 'Dashboard',
			'config' => [],
			'access' => 'admin',
			'attributes' => [
				'breadcrumbs' => []
			],
			/**
			 * Actions
			 */
			'actions' => [
				'index' => [
					'enable' => true,
					'view' => [
						'enable' => false,
						'template' => cd_backend_view_name('index.index')
					],
					'widgets' => ['dashboard'],
				],
			],
		]
	],
	'widgets' => [
		'dashboard' => [
			'enable' => true,
			'type' => 'view',
			'access' => 'admin',
			'view' => [
				'enable' => true,
				'template' => cd_backend_view_name('dashboard.index')
			],
		]
	]
];

//return array_merge_recursive($config, require __DIR__ . '/form.php', require __DIR__ . '/datatable.php');
return $config;
