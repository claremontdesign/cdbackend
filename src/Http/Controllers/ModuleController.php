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
	 *
	 * @param type $widgets
	 * @return type
	 */
	public function widgets($widgets)
	{
		$module = $this->module();
		$meta = $module->getMetas($this->action());
		$bodyClass = $meta->get('body_class');
		$metaTitle = $meta->get('meta_title');
		$pageTitle = $meta->get('page_title');
		$pageSubTitle = $meta->get('page_subtitle');
		cd_backend_set_breadcrumb($module->getBreadcrumb($this->action()));
		$controller = $this;
		return view($this->viewName('module.widget'), compact('widgets', 'controller', 'module', 'bodyClass', 'metaTitle', 'pageTitle', 'pageSubTitle'));
	}

	/**
	 * Request method is POST
	 * @param type $widgets
	 */
	public function postWidget($widgets)
	{
		if(!empty($widgets))
		{
			foreach ($widgets as $widgetIndex)
			{
				$response = cd_widget($widgetIndex, $this, $this->module());
				if($response instanceof \Illuminate\Http\RedirectResponse)
				{
					return $response;
				}
			}
		}
		return $this->widgets($widgets);
	}

}
