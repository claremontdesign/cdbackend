<?php
namespace Claremontdesign\Cdbackend\Traits;
/**
 * Dx
 *
 * @link http://dennesabing.com
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @license proprietary
 * @copyright Copyright (c) 2015 ClaremontDesign/MadLabs-Dx
 * @version 0.0.0.1
 * @since Dec 2, 2015 11:09:54 AM
 * @file Viewname.php
 * @project Cdbase
 * @package Expression package is undefined on line 14, column 15 in Templates/Scripting/EmptyPHP.php.
 */
trait Viewname
{

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
