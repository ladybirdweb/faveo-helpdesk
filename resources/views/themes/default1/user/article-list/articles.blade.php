@extends('themes.default1.layouts.client')
@section('content')

<!-- start of page content -->
@foreach($article as $arti)

    <article class="format-standard type-post hentry clearfix">

        <header class="clearfix">

                <h3 class="post-title">
                        <a href="{{url('kb/show/'.$arti->id)}}">{{$arti->name}}</a>
                </h3>

                <div class="post-meta clearfix">
                    <span class="category"><a href="#" title="View all posts in Server &amp; Database">Server &amp; Database</a></span>
                </div><!-- end of post meta -->

        </header>

<?php $str = $arti->description?>
<?php $excerpt = App\Http\Controllers\UserController::getExcerpt($str, $startPos = 0, $maxLength = 100)?>

        <p>{!!$excerpt!!} <a class="readmore-link" href="{{url('kb/show/'.$arti->id)}}">Read more</a></p>

    </article>

@endforeach

<div class="pagination">
    <?php echo $article->render();?>
</div>

@stop
</div>

