@extends('themes.default1.client.layout.client')
@section('breadcrumb')
<div class="site-hero clearfix">

    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">You are here: </li>
        <li>Home</li>
        <li>Frequently Asked Questions</li>

    </ol>
</div>
@stop
@section('content')

<!-- Start of Page Container -->
<div id="content" class="site-content col-md-9">
    <div class="row home-listing-area">
        <div class="span8">
            <h2>Faq</h2>
        </div>
    </div>

    <div class="row separator">


        <section>
            {!! $faq->faq !!}
        </section>


    </div>

</div>
<!-- end of page content -->

@stop
