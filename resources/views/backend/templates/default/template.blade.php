<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('meta_title')</title>
		<meta name="description" content="@yield('meta_description')">
		<meta name="keywords" content="@yield('meta_keywords')">
		@yield('head')

		@yield('head_bottom')
	</head>
	<body class="backend @yield('body_class')">
		{!! cd_display_errors() !!}
		{!! cd_display_msgs() !!}
		<!-- CONTENT -->
		@yield('content')
		<!-- CONTENT -->
		@yield('body_bottom')
	</body>
</html>
