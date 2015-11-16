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
 * @file BackendController.php
 * @project Cdbackend
 */
use Claremontdesign\Cdbase\Traits\Flasherror;
use Claremontdesign\Cdbase\Traits\CurrentUser;
use Claremontdesign\Cdbase\Modules\Traits\Controller as ModuleController;
use Claremontdesign\Cdbase\Modules\ControllerInterface as ModuleControllerInterface;
use Claremontdesign\Cdbase\Http\Controllers\Controller;

class BackendController extends Controller implements ModuleControllerInterface
{

	use Flasherror,
	 CurrentUser,
	 ModuleController;

	public function index()
	{
		return view($this->viewName('index/index'));
	}

	public function widgets($widgets)
	{
		return view($this->viewName('index/widget'), compact('widgets'));
	}

	/**
	 * REturn the View Name
	 * @param string $viewName The View Name
	 * @return string
	 */
	protected function viewName($viewName)
	{
		return cd_backend_tag() . '::backend.templates.default.' . $viewName;
	}

}
