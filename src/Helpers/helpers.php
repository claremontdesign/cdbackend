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
		$defaultPackage = 'cdbackend';
		$defaultTemplate = 'default';
		$template = cd_config('backend.design.template');
		$package = cd_config('backend.design.package');
		$enable = cd_config('themes.backend.' . $template . '.enable', false);
		if($enable)
		{
			return $package . '::backend.templates.' . $template . '.template';
		}
		return $defaultPackage . '::backend.templates.' . $defaultTemplate . '.template';
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
		$template = cd_config('backend.design.template');
		$package = cd_config('backend.design.package');
		$defaultView = 'cdbackend::backend.templates.default.' . str_replace('/', '.', $view);
		$view = $package . '::backend.templates.' . $template . '.' . str_replace('/', '.', $view);
		if(\View::exists($view))
		{
			return $view;
		}
		return $defaultView;
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

if(!function_exists('cd_backend_render_nav_main'))
{

	/**
	 * Render Main Navigation
	 * @param type $navs
	 */
	function cd_backend_render_nav_main($navs = null)
	{
		$str = '';
		if(empty($navs))
		{
			$navs = cd_config('template.backend.nav.main');
		}
		$navs = collect($navs);
		if(!$navs->isEmpty())
		{
			foreach ($navs as $index => $nav)
			{
				$nav = collect($nav);
				$enable = $nav->get('enable', false);
				$access = $nav->get('access', 'admin');
				if($enable && cd_auth_is($access))
				{
					$children = collect($nav->get('children'));
					$hasChildren = !$children->isEmpty();
					$title = $nav->get('title', null);
					$url = cd_createUrl($nav->get('url', []));
					$icon = $nav->get('icon', null);
					$label = $nav->get('label', $title);
					$str .= '<li class="" id="main-nav-' . $index . '">';
					$str .= '<a href="' . $url . '" title="' . $title . '">';
					$str .= '<i class="' . $icon . '"></i>';
					$str .= '<span class="title">' . $label . '</span>';
					$str .= '</a>';
					if($hasChildren)
					{
						$str .= '<span class="arrow"></span>';
						$str .= '<ul class="sub-menu">';
						$str .= cd_backend_render_nav_main($children);
						$str .= '</ul>';
					}
					$str .= '</li>';
				}
			}
		}
		return $str;
	}

}

if(!function_exists('cd_backend_render_breadcrumb'))
{

	/**
	 * Render Breadcrumb
	 * @param type $nav
	 */
	function cd_backend_render_breadcrumb()
	{
		$breads = app('cdbackend')->breadcrumb();
		$str = '';
		if(!empty($breads))
		{
			$i = 0;
			foreach ($breads as $bread)
			{
				$i++;
				// nav:: search main navigation
				$nav = collect(cd_config('template.backend.nav.main.' . str_replace('nav::', '', $bread)), []);
				if(!$nav->isEmpty())
				{
					$enable = $nav->get('enable', false);
					$access = $nav->get('access', 'admin');
					if($enable && cd_auth_is($access))
					{
						$title = $nav->get('title', null);
						$url = cd_createUrl($nav->get('url', []));
						$icon = $nav->get('icon', null);
						$label = $nav->get('label', $title);
						$str .= '<li>';
						if(!empty($icon))
						{
							// $str .= '<i class="' . $icon . '"></i> ';
						}
						$str .= '<a title="' . $title . '" href="' . $url . '">' . $label . '</a>';
						if($i < count($breads))
						{
							$str .= '<i class="fa fa-angle-right"></i>';
						}
						$str .= '</li>';
					}
				}
			}
		}
		return $str;
	}

}


if(!function_exists('cd_backend_set_breadcrumb'))
{

	/**
	 * Set the breadcrum
	 * @param type $breads
	 */
	function cd_backend_set_breadcrumb($breads = [])
	{
		app('cdbackend')->setBreadcrumb($breads);
	}

}


if(!function_exists('cd_backend_set_entity_title'))
{

	/**
	 * Set the Entity that is currently loaded
	 * @param array $entity AssocArray of title, id
	 *
	 */
	function cd_backend_set_entity($entity = [])
	{
		app('cdbackend')->setEntity($entity);
	}

}

if(!function_exists('cd_backend_render_entity_title'))
{

	/**
	 * Render the current entity title
	 * return string
	 */
	function cd_backend_render_entity_title()
	{
		// app('cdbackend')->entity($entity);
	}

}



// <editor-fold defaultstate="collapsed" desc="NTIFICATIONS">
if(!function_exists('cd_backend_add_notification'))
{

	/**
	 * Add a Notification
	 * @param type $text
	 * @param type $type
	 * @param type $date
	 * @param type $url
	 */
	function cd_backend_add_notification($text, $type, $date, $url)
	{

	}

}

if(!function_exists('cd_backend_render_notification'))
{

	/**
	 * Render Breadcrumb
	 * @param type $nav
	 */
	function cd_backend_render_notification($nav = null)
	{

	}

}
// </editor-fold>

