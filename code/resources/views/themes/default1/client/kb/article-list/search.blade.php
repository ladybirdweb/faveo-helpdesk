@extends('themes.default1.client.layout.client')
@section('breadcrumb')
<div class="site-hero">
    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">You are here: </li>
        <li>Home</li>
        <li class="active">Search Results</li>
    </ol>
</div>
@stop
@section('content')
<div id="content" class="site-content col-md-12">
    @foreach($result as $arti)
    <article class="format-standard type-post hentry clearfix">

        <header class="clearfix">
            <h3 class="post-title">
                <a href="{{url('show/'.$arti->slug)}}">{{$arti->name}}</a>
            </h3>
            <div class="post-meta clearfix">
                <span class="date">{{$arti->created_at->format('l, d-m-Y')}}</span>
                <span class="category"><a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a></span>
            </div><!-- end of post meta -->
        </header>
        <?php $str = $arti->description ?>
        <?php $excerpt = App\Http\Controllers\client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 100) ?>
        <p>{!!$excerpt!!} <a class="readmore-link" href="{{url('show/'.$arti->slug)}}">Read more</a></p>
        @endforeach
    </article>

    <!-- end of page content -->

    <div class="pagination">
        <?php echo $result->render(); ?>
    </div>
</div>

@stop
</div>