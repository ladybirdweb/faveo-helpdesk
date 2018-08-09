@extends('themes.default1.client.layout.client')
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