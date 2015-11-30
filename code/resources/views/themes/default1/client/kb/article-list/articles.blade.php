@extends('themes.default1.client.layout.client')

@section('kb')
    class = "active"
@stop

@section('breadcrumb')
<div class="site-hero clearfix">

    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">{!! Lang::get('lang.you_are_here')!!}: </li>
        <li>{!! Lang::get('lang.home') !!}</li>
        <li>{!! Lang::get('lang.frequently_asked_questions') !!}</li>
        <li class="active">{!! Lang::get('lang.allarticle') !!}</li>
    </ol>
</div>
@stop

@section('content')
<div id="content" class="site-content col-md-12">
    @foreach($article as $arti)
    <h3><a href="{{route('show',$arti->slug)}}">{{$arti->name}}</a></h3>
    <hr>
    <ul class="col-md-10" id="article1">
        <li class="pull-left"><img src="{{asset('lb-faveo/Img/icon/time.png')}}">&nbsp;&nbsp;&nbsp;<?php $utc = $arti->created_at;
$time = UTC::usertimezone($utc);
?>{!! $time !!}&nbsp;&nbsp;
            <?php
            $category_id = App\Model\kb\Relationship::where('article_id', $arti->id)->lists('category_id');
            foreach ($category_id as $id) {
                $category = App\Model\kb\Category::where('id', $id)->first();
                ?>
                <a href="{{asset('category-list/'.$category->slug)}}"><img src="{{asset('lb-faveo/Img/icon/category.png')}}">&nbsp;&nbsp;&nbsp;{{$category->name}}</a> &nbsp;&nbsp;</li>
<?php }
?>
    </ul>

    <br>
    <hr>

<?php $str = $arti->description ?>
<?php $excerpt = App\Http\Controllers\client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 300) ?>

    <p>{!!$excerpt!!} <a class="readmore-link" href="{{route('show',$arti->slug)}}">{!! Lang::get('lang.read_more') !!}</a></p>


    @endforeach
    <div class="pagination">
<?php echo $article->render(); ?>
    </div>
</div>
@stop