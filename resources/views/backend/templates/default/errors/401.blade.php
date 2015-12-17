@extends(cd_backend_template())
@section('body_class', '')
@section('meta_title', 'Unauthorized')
@section('meta_keywords', '')
@section('meta_description', '')
@section('body_bottom')
@append
@section('content')
<h1>Oops! You don't have permission.</h1>
{{ $message }}
@stop
