<?php

namespace Claremontdesign\Cdbackend\Http\Controllers;

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 9, 2015 8:52:24 PM
 * @file ModuleController.php
 * @project Cdbackend
 */
use Claremontdesign\Cdbase\Modules\Http\ModuleController as CdbaseModuleController;
use Claremontdesign\Cdbase\Modules\ControllerInterface as ModuleControllerInterface;
use Claremontdesign\Cdbackend\Traits\Viewname;

class ModuleController extends CdbaseModuleController implements ModuleControllerInterface
{
	use Viewname;

	/**
	 * If to Display errors to alerts
	 * @var boolean
	 */
	protected $errorsToAlerts = false;
}
