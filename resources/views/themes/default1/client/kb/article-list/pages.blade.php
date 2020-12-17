@extends('themes.default1.client.layout.client')

@section('title')
    Pages List -
@stop

@section('pages')
class = "nav-item  active"
@stop

@section('content')
    
    <div id="content" class="site-content col-sm-12">
                    
        <article class="hentry">
            
            <header class="entry-header">
                
                <h1 class="entry-title">{{$page->name}}</h1>
            </header>

            <div class="entry-content clearfix">
                
                {!! $page->description !!}                
            </div>
        </article>
    </div>
@stop