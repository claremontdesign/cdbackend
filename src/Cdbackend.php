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
