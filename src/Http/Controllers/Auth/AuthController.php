<?php

namespace Claremontdesign\Cdbackend\Http\Controllers\Auth;

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Oct 6, 2015 3:52:38 PM
 * @file Cdbase.php
 * @project Claremontdesign
 * @package Cdbase
 */
use Claremontdesign\Cdbase\Http\Controllers\Auth\AuthController as Controller;
use Claremontdesign\Cdbase\Traits\Flasherror;
use Claremontdesign\Cdbase\Traits\Section;

class AuthController extends Controller
{

	use Flasherror,
	 Section;

	/**
	 * The View Name
	 * @param string $viewName
	 * @return string
	 */
	protected function viewName($viewName)
	{
		return cd_backend_view_name($viewName);
	}

	/**
	 * Get the post register / login redirect path.
	 * @return string
	 */
	public function redirectPath()
	{
		return cd_route(cd_config('auth.login.admin.routeToRedirectIfAuth'));
	}

}
