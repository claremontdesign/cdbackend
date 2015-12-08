<?php

namespace Claremontdesign\Cdbackend;

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 07, 2015 3:54:34 PM
 * @file Narbase.php
 * @project Claremontdesign
 * @package Cdbackend
 */
use Claremontdesign\Cdbase\Cdbase;

class Cdbackend extends Cdbase
{

	/**
	 * the Current BreadCrumb
	 * @var array
	 */
	protected $breadcrumb;

	/**
	 * The Current entity that is loaded
	 * @var type
	 */
	protected $entity;

	/**
	 * Collection of toolbars by position
	 * topleft, topright, bottomleft, bottomright
	 * @var Collection
	 */
	protected $toolbars = [];

	/**
	 * Route Parameters
	 * @var array
	 */
	protected $routeParams = [];

	/**
	 * Set the Route Parameters
	 * @param array $params
	 */
	public function setRouteParams($params)
	{
		$this->routeParams = collect($params);
	}

	/**
	 * Return the Route Parameters
	 * @param type $index The route parameter to return
	 * @retrun string|integer
	 */
	public function routeParam($index, $default = null)
	{
		if($this->routeParams->has($index))
		{
			return $this->routeParams->get($index);
		}
		return $default;
	}

	/**
	 * Add a toolbar
	 * @param type $position
	 * @param type $index
	 * @param type $config
	 */
	public function addToolbar($position, $index, $config)
	{
		if(empty($this->toolbars))
		{
			$this->toolbars = collect([]);
		}
		if(!$this->toolbars->has($position))
		{
			$this->toolbars->put($position, collect([]));
		}
		$this->toolbars->get($position)->put($index, $config);
	}

	/**
	 * Get toolbar by position
	 * @param type $position
	 */
	public function toolbar($position)
	{
		if(empty($this->toolbars))
		{
			$this->toolbars = collect([]);
		}
		if($this->toolbars->has($position))
		{
			return $this->toolbars->get($position);
		}
		return collect([]);
	}

	/**
	 * Set BreadCrumb
	 * @param array $breadcrumb
	 */
	public function setBreadcrumb($breadcrumb)
	{
		$this->breadcrumb = $breadcrumb;
	}

	/**
	 * Return the BreadCrumb
	 * @return array
	 */
	public function breadcrumb()
	{
		return $this->breadcrumb;
	}

	/**
	 * Set the Entity that is currently loaded
	 * @param array $entity AssocArray of title, id
	 *
	 */
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	public function entity()
	{
		return $this->entity;
	}

	/**
	 * Return the configuration file
	 */
	public function config()
	{
		return [
			__DIR__ . '/../config/admin.php',
			__DIR__ . '/../config/dashboard/dashboard.php'
		];
	}

}
