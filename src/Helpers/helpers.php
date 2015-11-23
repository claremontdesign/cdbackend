<?php

/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Nov 06, 2015 2:02:23 PM
 * @file helpers.php
 * @project Claremontdesign
 * @package Cdbackend
 */
// <editor-fold defaultstate="collapsed" desc="cd_backend">
if(!function_exists('cd_backend'))
{

	function cd_backend()
	{
		return app('cdbackend');
	}

}
if(!function_exists('cd_backend_tag'))
{

	/**
	 * Return this packge tag
	 * @return string
	 */
	function cd_backend_tag()
	{
		return 'cdbackend';
	}

}
if(!function_exists('cd_backend_template'))
{

	/**
	 * Return this packge template
	 * @return string
	 */
	function cd_backend_template()
	{
		return cd_backend_tag() . '::backend.templates.default.template';
	}

}
if(!function_exists('cd_backend_view_name'))
{

	/**
	 * Return this package view name
	 * view(cd_backend_view_name('view-name')) = cdbackend::view-name
	 * @param string $view The View Name
	 * @return string
	 */
	function cd_backend_view_name($view)
	{
		return cd_backend_tag() . '::backend.templates.default.' . $view;
	}

}
if(!function_exists('cd_backend_asset'))
{

	/**
	 * Return the public path to an asset.
	 * 	path to return is relative to package template folder.
	 * 	If you want to return an asset relative to the public folder,
	 * 	use larvel's asset() instead
	 * @param string $asset The asset
	 * @return string
	 */
	function cd_backend_asset($asset = null)
	{
		return asset('assets') . '/backend/' . fixDoubleSlash(cd_backend_tag() . '/templates/default/' . $asset);
	}

}

// </editor-fold>



