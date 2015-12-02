@extends(cd_backend_template())
@section('body_class', $bodyClass)
@section('meta_title', $metaTitle)
@section('page_title', $pageTitle)
@section('page_subtitle', $pageSubTitle)
@section('body_bottom')
@append
@section('content')
{!! view(cd_backend_view_name('module.partials.widgets'), compact('widgets','controller','module')) !!}
@stop