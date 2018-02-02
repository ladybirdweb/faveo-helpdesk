@extends('themes.default1.client.layout.client')

<?php $category = App\Model\kb\Category::where('id', '=', $id)->first(); ?>
@section('title')
{!! $category->name !!} -
@stop

@section('kb')
class = "active"
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
            <?php
            $article = App\Model\kb\Article::where('id', $id);
            if (!Auth::user() || Auth::user()->role == 'user') {
                $article = $article->where('status', 1);
                $article = $article->where('type', 1);
            }
            $article = $article->orderBy('publish_time', 'desc');
            $article = $article->get();
            ?>
            @forelse($article as $arti)
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
                    <a class="readmore-link" href="{{url('show/'.$arti->slug)}}">{!! trans('lang.read_more') !!}</a>
                </blockquote>	
                <footer class="entry-footer">
                    <div class="entry-meta text-muted">
                        <span class="date"><i class="fa fa-clock-o fa-fw"></i> <time datetime="2013-10-22T20:01:58+00:00">{{$arti->created_at->format('l, d-m-Y')}}</time></span>
                    </div><!-- .entry-meta -->
                </footer><!-- .entry-footer -->
            </article><!-- .hentry -->
            @empty
            <p>No articles available</p>
            @endforelse
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
<h2 class="section-title h4 clearfix">{!! trans('lang.categories') !!}<small class="pull-right"><i class="fa fa-hdd-o fa-fw"></i></small></h2>
<ul class="nav nav-pills nav-stacked nav-categories">
    @foreach($categorys as $category)
    <?php
    $num = \App\Model\kb\Relationship::where('category_id', '=', $category->id)->get();
    $article_id = $num->lists('article_id');
    $numcount = count($article_id);
    ?>
    <li><a href="{{url('category-list/'.$category->slug)}}"><span class="badge pull-right">{{$numcount}}</span>{{$category->name}}</a></li>
    @endforeach
</ul>
@stop