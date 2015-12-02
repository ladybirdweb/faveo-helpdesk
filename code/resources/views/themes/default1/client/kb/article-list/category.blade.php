@extends('themes.default1.client.layout.client')

@section('title')
    All Category -
@stop

@section('kb')
    class = "active"
@stop
@section('breadcrumb')
<div class="site-hero clearfix">

    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">{!! Lang::get('lang.you_are_here') !!}: </li>
        <li>{!! Lang::get('lang.home') !!}</li>
        <li class="active">{!! Lang::get('lang.allcategory') !!}</li>
    </ol>
</div>
@stop
@section('content')
<div id="content" class="site-content col-md-12">
    <header class="archive-header">
        @foreach($categorys as $category)
        <h1 >{!! $category->name !!}</h1>
    </header><!-- .archive-header -->
    <blockquote class="archive-description" style="display: none;">
        <p>{!! $category->description !!}</p>
    </blockquote>
    @endforeach
    <div class="archive-list archive-article">
        <?php foreach ($article_id as $id) { ?>
            <?php $article = App\Model\kb\Article::where('id', $id)->get(); ?>
            @foreach($article as $arti)
            <article class="hentry">
                <header class="entry-header">
                    <i class="fa fa-list-alt fa-2x fa-fw pull-left text-muted"></i>
                    <h2 class="entry-title h4"><a href="{{url('show/'.$arti->slug)}}" onclick="toggle_visibility('foo');">{{$arti->name}}</a></h2>
                </header><!-- .entry-header -->
                <?php $str = $arti->description; ?>
                <?php $excerpt = App\Http\Controllers\Client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 400); ?>
                <blockquote class="archive-description">
                    <p>{!!$excerpt!!}</p><br/>
                    <a class="readmore-link" href="{{url('show/'.$arti->slug)}}">{!! Lang::get('lang.read_more') !!}</a>
                </blockquote>	
                <footer class="entry-footer">
                    <div class="entry-meta text-muted">
                        <span class="date"><i class="fa fa-clock-o fa-fw"></i> <time datetime="2013-10-22T20:01:58+00:00">{{$arti->created_at->format('l, d-m-Y')}}</time></span>
                    </div><!-- .entry-meta -->
                </footer><!-- .entry-footer -->
            </article><!-- .hentry -->
            @endforeach
        <?php
        }
        echo $all->render();
        ?>                      
    </div>
</div>
<script type="text/javascript">
<!--
    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if (e.style.display == 'block')
            e.style.display = 'none';
        else
            e.style.display = 'block';
    }
//-->
</script>

@stop


