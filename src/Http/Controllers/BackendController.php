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
use Claremontdesign\Cdbase\Http\Controllers\Controller;

class BackendController extends Controller
{

	use Flasherror,
	 CurrentUser;

	/**
	 *
	 */
	public function __construct()
	{
//		$arr = collect(['email' => 'd','username' => 'x']);
//		$arr2 = collect(['email' => 'd','username' => 'x']);
//		dd($arr->diff($arr2));
		//$repo = app('cdbase')->createModelRepo(cd_config('auth.model'));
		//dd($repo->byId(43)->roles());
//		$repo = app('cdbase')->createModelRepo(cd_config('auth.roles'));
//		dd($repo->ancestors(3));
	}

	public function index()
	{
		return view($this->viewName('index/index'));
	}

	/**
	 * REturn the View Name
	 * @param string $viewName The View Name
	 * @return string
	 */
	protected function viewName($viewName)
	{
		return cd_backend_view_name($viewName);
	}

}
