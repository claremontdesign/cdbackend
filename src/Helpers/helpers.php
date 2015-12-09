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
		return asset('assets') . '/claremontdesign/backend/' . fixDoubleSlash('templates/default/' . $asset);
	}

}
if(!function_exists('cd_backend_logo'))
{

	/**
	 * Return the backend logo
	 * @return string
	 */
	function cd_backend_logo()
	{
		return cd_config('backend.design.header.logo');
	}

}

// </editor-fold>




if(!function_exists('cd_backend_toolbars'))
{

	/**
	 * Display Toolbars
	 * @param type $position
	 */
	function cd_backend_toolbars($position)
	{
		return view(cd_cdbase_view_name('widgets.toolbar'), ['actions' => app('cdbackend')->toolbar($position), 'position' => 'topleft']);
	}

}

if(!function_exists('cd_backend_render_nav_main'))
{

	/**
	 * Render Main Navigation
	 * @param type $navs
	 */
	function cd_backend_render_nav_main($navs = null)
	{
		$breads = app('cdbackend')->breadcrumb();
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
					$active = false;
					$bread = 'nav::' . $index;
					if(in_array($bread, $breads))
					{
						$active = true;
					}
					$children = collect($nav->get('children'));
					$hasChildren = !$children->isEmpty();
					if(empty($children[0]))
					{
						$hasChildren = false;
					}
					$title = $nav->get('title', null);
					$url = cd_createUrl($nav->get('url', []));
					$icon = $nav->get('icon', null);
					$label = $nav->get('label', $title);
					$str .= '<li class="' . ($active ? 'active' : null) . '" id="main-nav-' . $index . '">';
					$str .= '<a href="' . $url . '" title="' . $title . '">';
					$str .= '<i class="' . $icon . '"></i> ';
					$str .= '<span class="title">' . $label . '</span>';
					if($hasChildren)
					{
						$str .= '<span class="arrow"></span>';
					}
					$str .= '</a>';
					if($hasChildren)
					{
						$str .= '<ul class="sub-menu">';

						$str .= '<li class="" id="main-nav-' . $index . '">';
						$str .= '<a href="' . $url . '" title="' . $title . '">';
						$str .= '<i class="' . $icon . '"></i> ';
						$str .= '<span class="title">' . $label . '</span>';
						$str .= '</a>';
						$str .= '</li>';
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
				$nav = collect(cd_config('template.backend.nav.main.' . str_replace('nav::', '', $bread)), []);
//				dd(cd_config('template.backend.nav.main.surveys'));
//				dd(cd_config('template.backend.nav.main.surveys.children.questions'));
				if(!$nav->isEmpty())
				{
					$enable = $nav->get('breadcrumbs', false);
					$access = $nav->get('access', 'admin');

					//if($enable && cd_auth_is($access))
					//{
					if($i <= count($breads))
					{
						$title = $nav->get('title', null);
						if($title == 'Dashboard')
						{
							continue;
						}
						$url = cd_createUrl($nav->get('url', []));
						$icon = $nav->get('icon', null);
						$label = $nav->get('label', $title);
						$str .= '<li>';
						if(!empty($icon))
						{
							// $str .= '<i class="' . $icon . '"></i> ';
						}

						$str .= '<a title="' . $title . '" href="' . $url . '">' . $label . '</a>';
						if($i < (count($breads)))
						{
							$str .= '<i class="fa fa-angle-right"></i>';
						}
					}
					//}
					$str .= '</li>';
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


if(!function_exists('cd_backend_set_entity'))
{

	/**
	 * Set the Entity that is currently loaded
	 * @param array $entity AssocArray of title, id
	 *
	 */
	function cd_backend_add_focusedEntity($entity = [])
	{
		app('cdbackend')->addFocusedEntity($entity);
	}

}

if(!function_exists('cd_backend_render_focusedEntity'))
{

	/**
	 * Render the current entity title
	 * return string
	 */
	function cd_backend_render_focusedEntity()
	{
		$str = [];
		$entities = app('cdbackend')->focusedEntity();
		if(!empty($entities))
		{
			$i = 0;
			foreach ($entities as $entity)
			{
				$helperAtt = [
					'data-trigger="hover"',
					'data-placement="right"'
				];
				$i++;
				$pre = !empty($entity['pre']) ? $entity['pre'] : null;
				$post = !empty($entity['post']) ? $entity['post'] : null;
				if(!empty($entity['title']))
				{
					$title = $entity['title'];
					$label = $title;
					if(strlen($label) > 100)
					{
						$label = substr($label, 0, 100) . '...';
					}
					else
					{
						$helperAtt = [];
					}
					if($i == count($entities))
					{
						$str[] = '<h3 class="page-title popovers" ' . implode(' ', $helperAtt) . ' title="' . $title . '">' . $pre . $label . $post . '</h3>';
					}
				}
			}
		}
		if(!empty($str))
		{
			return '<div class="portlet focusedEntity">
								<div class="portlet-title">
									<div class="caption">' . implode('', $str) . '</div></div></div>';
		}
		return null;
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

