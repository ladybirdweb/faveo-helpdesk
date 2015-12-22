@extends('themes.default1.client.layout.client')
@section('breadcrumb')
<div class="site-hero clearfix">

    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">{!! Lang::get('lang.you_are_here') !!}: </li>
        <li class="active">{{$page->name}}</li>

    </ol>
</div>
@stop
@section('content')

<!-- Start of Page Container -->
<div class="col-md-12">
    <div class="row home-listing-area">
        <div class="span8">
            <h2>{{$page->name}}</h2>
        </div>
    </div>

    <div class="row separator">


        <section>
            {!! $page->description !!}
        </section>


    </div>


    <!-- end of page content -->
</div>
@stop