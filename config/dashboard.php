<?php

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 18, 2015 1:02:15 PM
 * @file login.php
 * @project Cdbackend
 */
return [
	'modules' => [
		'dashboard' => [
			'enable' => true,
			'actions' => [
				'index' => [
					'enable' => true,
					'view' => [
						'template' => false
					],
					'widgets' => ['userData']
				],
			],
		]
	],
];
