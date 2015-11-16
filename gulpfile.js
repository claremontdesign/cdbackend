var elixir = require('laravel-elixir');
elixir.config.srcDir = 'src';
elixir.config.cssOutput = '../../../public/assets/claremontdesign/backend/';
elixir.config.jsOutput = '../../../public/assets/claremontdesign/backend/';
elixir.config.assetsDir = 'resources/assets';
/*
 *
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir(function(mix) {
	mix.scripts([
		'cdbackend.js'
	], '../../../public/assets/claremontdesign/backend/cd.js');
	mix.styles([
		'cdbackend.css'
	], '../../../public/assets/claremontdesign/backend/cd.css');
});