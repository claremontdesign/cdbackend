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
 * @since Nov 07, 2015 1:40:20 PM
 * @file ServiceProvider.php
 * @project Claremontdesign
 * @package Cdbackend
 */

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

	public function register()
	{
		// Register this service
		$this->app->singleton('cdbackend', function($app){
			return new Cdbackend;
		});
		app('cdbase')->addPackage(\Claremontdesign\Cdbackend\Cdbackend::class);
	}

	public function boot()
	{
		// Define the path for the view files
		$this->loadViewsFrom(__DIR__ . '/../resources/views', cd_backend_tag());

		$this->publishes([
			__DIR__ . '/../resources/assets' => public_path('assets/claremontdesign/backend'),
				], 'public');

		$this->publishes([
			__DIR__ . '/../resources/views' => base_path('resources/views/claremontdesign/cdbackend'),
				], 'views');

//		$this->publishes([
//			__DIR__ . '/../database' => base_path('database')
//				], 'migrations');


		// Loading the routes file
		require __DIR__ . '/Http/routes.php';
	}

}
