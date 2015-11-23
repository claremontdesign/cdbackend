@extends(cd_backend_template())
@section('body_class', '')
@section('meta_title', '')
@section('meta_keywords', '')
@section('meta_description', '')
@section('body_bottom')
@append
@section('content')
{!! view(cd_backend_view_name('module.partials.widgets'), compact('widgets','controller','module')) !!}
@stop