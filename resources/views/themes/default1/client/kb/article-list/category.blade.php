@extends('themes.default1.client.layout.client')

@section('title')
    All Category -
@stop

@section('kb')
    class = "active"
@stop
<?php  $category = App\Model\kb\Category::where('id','=',$id)->first(); ?>
@section('breadcrumb')
<div class="site-hero clearfix">

    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">{!! Lang::get('lang.you_are_here') !!}: </li>
        <li>{!! Lang::get('lang.home') !!}</li>
        <li class="active">{!! Lang::get('lang.knowledge_base') !!}</li>
        <li class="active">{!! Lang::get('lang.category') !!}</li>
        <li class="active">{!! $category->name !!}</li>
    </ol>
</div>
@stop
@section('content')
<div id="content" class="site-content col-md-9">
    <header class="archive-header">
        
        <h1 >{!! $category->name !!}</h1>
    </header><!-- .archive-header -->
    <blockquote class="archive-description" style="display: none;">
        <p>{!! $category->description !!}</p>
    </blockquote>
    <div class="archive-list archive-article">
        <?php foreach ($article_id as $id) { ?>
            <?php $article = App\Model\kb\Article::where('id', $id)->orderBy('created_at', 'ASC')->get(); ?>
            @foreach($article as $arti)
            <article class="hentry">
                <header class="entry-header">
                    <i class="fa fa-list-alt fa-2x fa-fw pull-left text-muted"></i>
                    <h2 class="entry-title h4"><a href="{{url('show/'.$arti->slug)}}" onclick="toggle_visibility('foo');">{{$arti->name}}</a></h2>
                </header><!-- .entry-header -->
                <?php $str = $arti->description; ?>
                <?php $excerpt = App\Http\Controllers\Client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 400); ?>
                <blockquote class="archive-description">
                    <?php $content = trim(preg_replace("/<img[^>]+\>/i", "", $excerpt), " \t.") ?>
                    <p>{!! strip_tags($content) !!}</p>
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
        //echo $all->render();
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




@section('category')
<h2 class="section-title h4 clearfix">{!! Lang::get('lang.categories') !!}<small class="pull-right"><i class="fa fa-hdd-o fa-fw"></i></small></h2>
<ul class="nav nav-pills nav-stacked nav-categories">
    @foreach($categorys as $category)
<?php
$num = \App\Model\kb\Relationship::where('category_id','=', $category->id)->get();
$article_id = $num->lists('article_id');
$numcount = count($article_id);
?>
    <li><a href="{{url('category-list/'.$category->slug)}}"><span class="badge pull-right">{{$numcount}}</span>{{$category->name}}</a></li>
    @endforeach
</ul>
@stop