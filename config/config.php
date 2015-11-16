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
		'class' => Claremontdesign\Cdbackend\Http\Controllers\BackendController::class
	],
	/**
	 * Collection of Widgets that this module is offered
	 * each widget is a content on itself.
	 * a datatable, a form, a button
	 * each is an instanceof /Widget/WidgetInterface
	 * AttributableInterface, ConfigurableInterface, AccessibleInterface, ViewableInterface,
	 * 		Modelable,
	 */
	'widgets' => [
		'userDataForm' => [
			'type' => 'form',
		],
		'userData' => [
			/**
			 * The widget base route
			 * If module/action/task is given, route will be generated
			 * if url is given, will use URL instead
			 */
			'enable' => true,
			'type' => 'datatable',
			'messages' => [
				'empty' => [
					'nodata' => 'No records found.'
				],
			],
			'config' => [
				'attributes' => [
					'recordName' => [
						'singular' => 'Record',
						'plural' => 'Records'
					],
				],
			],
			/**
			 * Datatable CRUD Setup
			 */
			'action' => [
				'enable' => true,
				'route' => [
					/**
					 * Route will be generated using the module settings
					 * each ACTION is an action of a module.
					 * each ACTION can also pass its own route setup
					 */
					'name' => 'adminModule',
					'module' => 'userIndex'
				],
				'create' => [
					'enable' => true,
					'attributes' => [
						'label' => 'Create',
					],
				],
				'actions' => [
					'edit' => [
						'enable' => true,
					],
					'delete' => [
						'enable' => true,
					],
					'view' => [
						'enable' => true,
					],
				],
			],
			/**
			 * Each is an instanceof /Widget/Datatable/ColumnInterface
			 * Columnnable, Attributable, Uitable, Htmlable
			 */
			'columns' => [
				'id' => [
					/**
					 * The name of DB tableColumn, if joint tables,
					 * 	include the DB column prefix
					 * default to columnIndex
					 */
					'index' => 'user_id',
					'filter' => [
						'enable' => true,
					],
					'sort' => [
						'enable' => true,
					],
					/**
					 * Type of column
					 * The value that this column has to display
					 */
					'type' => 'integer',
					'attributes' => [
						'label' => 'ID',
					],
					/**
					 * Javascript Events
					 * Htmls attributes
					 * UI Actions,Events
					 */
					'ui' => [
						'html' => [
							'filterInput' => [
								'placeholder' => 'User Id'
							],
						],
						'events' => [],
					],
				],
				'email' => [
					'index' => 'email',
					'type' => 'string',
					'attributes' => [
						'label' => 'Email Address',
					],
					'enable' => true,
					'ui' => [
						'html' => [
							'filterInput' => [
								'placeholder' => 'Search Email address'
							],
						],
					],
					'sort' => [
						'enable' => true,
					],
				],
				'username' => [
					'index' => 'auser_name',
					'type' => 'string',
					'attributes' => [
						'label' => 'Username',
					],
					'ui' => [
						'html' => [
							'filterInput' => [
								'placeholder' => 'Search Username'
							],
						],
					],
					'sort' => [
						'enable' => true,
					],
				],
				'created' => [
					'index' => 'created_at',
					'type' => 'datetime',
					'attributes' => [
						'label' => 'Date Created',
					],
					'sort' => [
						'enable' => true,
					],
				],
				'updated' => [
					'type' => 'datetime',
					'index' => 'updated_at',
					'attributes' => [
						'label' => 'Last Update',
					],
					'sort' => [
						'enable' => true,
					],
				],
			],
			'model' => [
				/**
				 * value to pass from page to page, default to model primary key
				 */
				'valueIndex' => 'id',
				'class' => Claremontdesign\Cdbase\Model\User::class,
				'repository' => [
					/**
					 * Default sorting
					 */
					'sort' => ['id' => 'desc'],
					/**
					 * Records to view per page
					 */
					'rowsPerPage' => 20,
					'class' => Claremontdesign\Cdbase\Model\User\Repository\User::class
				],
			],
		]
	],
	'modules' => [
		/**
		 * admin/moduleIndex/actionIndex/taskIndex/recordIndex
		 * each module is an instanceof /Module/ModuleInterface
		 *
		 * AttributableInterface, ConfigurableInterface, AccessibleInterface
		 */
		'userIndex' => [
			'enable' => true,
			/**
			 * Module displayable name
			 * @var string
			 */
			'name' => 'User Module Name',
			/**
			 * Class to be used to instantiate this module
			 * instanceof /Model/Module/ModuleInterface
			 * @var string|null
			 */
			'class' => null,
			/**
			 * Module-specific configuration.
			 * Will be injected to the module
			 * instanceof Collection
			 * @var array|null
			 */
			'config' => [],
			/**
			 * Route to use for this Module
			 * If not empty, this will be skip in admin route generation
			 * @var string|null
			 */
			'route' => null,
			/**
			 * The minimum access level.
			 * 	If array, set of access level and not minimum access level
			 *  access levels are: guest, user, editor, moderator, admin, superadmin, sudo
			 */
			'access' => 'admin',
			/**
			 * The moduleIndex controller to be used.
			 * instanceof /Http/Controllers/ModuleControllerInterface
			 * @var string|null
			 */
			'controller' => null,
			/**
			 * The moduleIndex method to use
			 * @var string|null default to 'index'; see 'actions'
			 */
			'method' => null,
			/**
			 * Module Attributes
			 */
			'attributes' => [
				'breadcrumbs' => []
			],
			/**
			 * Actions
			 */
			'actions' => [
				/**
				 * All module properties can be inherited by an anction
				 * AttributableInterface, ConfigurableInterface, AccessibleInterface, Viewable
				 */
				'index' => [
					/**
					 * Enable/Disable this action
					 */
					'enable' => true,
					/**
					 * View configuration for this actionIndex
					 */
					'view' => [
						/**
						 * The viewTemplate to use.
						 * should be the final template name e.g. cd_cdbase_view_name('view.file')
						 */
						'template' => false
					],
					/**
					 * Dynamic Contents to be displayed on this /moduleIndex/actionIndex
					 * Array of widgetIndex
					 */
					'widgets' => ['userData']
				],
				'edit' => [
					'enable' => true,
					'widgets' => ['userDataForm']
				],
			],
		]
	],
];
