@extends('themes.default1.client.layout.client')
@section('content')  
<div id="page" class="hfeed site">
    <article class="hentry error404 text-center">
        <h1 class="error-title"><i class="fa fa-frown-o text-info"></i><span class="visible-print text-danger">0</span></h1>
        <h2 class="entry-title text-muted">{!! trans('lang.sorry_something_went_wrong') !!}</h2>
        <div class="entry-content clearfix">
            <p class="lead">{!! trans('lang.were_working_on_it_and_well_get_it_fixed_as_soon_as_we_can') !!}</p>
            <p><a onclick="goBack()" href="#">{!! trans('lang.go_back') !!}</a></p>
        </div><!-- .entry-content -->
    </article><!-- .hentry -->
</div><!-- #page -->

<script>
    function goBack() {
        window.history.back();
    }
</script>
@stop