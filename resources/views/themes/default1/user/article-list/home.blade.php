@extends('themes.default1.layouts.client')
@section('breadcrumb')
                                 <div class="site-hero clearfix">
                   
                                    <ol class="breadcrumb breadcrumb-custom">
                                            <li class="text">You are here: </li>
                                            <li><a href="#">Home</a></li>
                                            <li class="active">Frequently Asked Questions</li>
                                    </ol>
                   </div>
@stop
@section('check')
	<div class="banner-wrapper text-center clearfix">
										<h3 class="banner-title text-info h4">Have a Ticket?</h3>
										<div class="banner-content">
                                                                                    {!! Form::open(['url' => 'kb/checkmyticket' , 'method' => 'post'] )!!}
											{!! Form::label('email',Lang::get('lang.email')) !!}
			{!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('email',null,['class' => 'form-control']) !!}
                        {!! Form::label('ticket_number',Lang::get('lang.ticket_number'),['style' => 'display: block']) !!}
			{!! $errors->first('ticket_number', '<spam class="help-block">:message</spam>') !!}
			{!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
                      <br/>  <input type="submit" value="Check Ticket Status" class="btn btn-info">
                        
                        {!! Form::close() !!}
										</div>
									</div>	
@stop
@section('content')
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Alert!</b> Failed.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
<div id="content" class="site-content col-md-9">
							<div class="row">
<?php $categories = App\Model\Category::paginate(4);
                         ?>
                                                            @foreach($categorys as $category)
{{-- get the article_id where category_id == current category --}}
<?php

$all = App\Model\Relationship::where('category_id', $category->id)->get();
/* from whole attribute pick the article_id */
$page = App\Model\Relationship::where('category_id', $category->id)->paginate(3);
/* from whole attribute pick the article_id */
$article_id = $page->lists('article_id');
$count = count($article_id);
?>
                                                      
								<div class="col-md-6">
									<section class="box-categories">
										<h1 class="section-title h4 clearfix">
											<i class="fa fa-folder-open-o fa-fw text-muted"></i>
											<small class="pull-right"><i class="fa fa-hdd-o fa-fw"></i> 6</small>
											{{$category->name}}
										</h1>
										<ul class="fa-ul">
                                                                                      <?php foreach ($article_id as $id) {
	?>
<?php 
$article = App\Model\Article::where('id','=', $id)->where('status','=','1')->where('type','=', '1')->get();
?>
                          @foreach($article as $arti)
											<li>
												<i class="fa-li fa fa-list-alt fa-fw text-muted"></i>
												<h3 class="h5"><a href="#"><a href="{{url('kb/show/'.$arti->id)}}">{{$arti->name}}</a></h3>
                                                                                                <span class="article-meta">{!! $arti->created_at !!}</span>
                            <?php $str = $arti->description; $len = strlen($str); ?>
<?php $excerpt = App\Http\Controllers\UserController::getExcerpt($str, $startPos = 0, $maxLength = 100); ?>

                                                                                                <p >{!!$excerpt!!} <br/><a class="more-link text-center" href="{{url('kb/show/'.$arti->id)}}" style="color: #009aba">Read more</a></p>
                                                                                
											</li>
                                                                                                 @endforeach
                    <?php }?>
											
										</ul>
                                                                          
										<p class="more-link text-center"><a href="{{url('kb/category-list/'.$category->id)}}" class="btn btn-custom btn-xs">View All</a></p>
									</section>
                                                                   
								</div>
                 
                           @endforeach
                           {!!  $categories->setPath('kb/show/'); !!}
                                                        </div>
                                                    
								<section class="section">
								<div class="banner-wrapper banner-horizontal clearfix">
									<h4 class="banner-title h3">Need more support?</h4>
									<div class="banner-content">
										<p>If you did not find an answer, contact us for further help.</p>
									</div>
									<p><a href="{{url('kb/form')}}" class="btn btn-custom">Open A Ticket</a></p>
								</div>
							</section>
</div>
@stop
@section('category')
                                                        <h2 class="section-title h4 clearfix">Categories</h2>
									<ul class="nav nav-pills nav-stacked nav-categories">
                                                                       
                                                            @foreach($categorys as $category)
                                                            <?php $num = \App\Model\Relationship::where('category_id',$category->id)->get() ;
                                                        
                                                            $article_id = $num->lists('article_id');
                                                                    $numcount = count($article_id); 
                                                            ?>
										<li><a href="{{url('kb/category-list/'.$category->id)}}"><span class="badge pull-right">{{$numcount}}</span>{{$category->name}}</a></li>
							@endforeach
									</ul>
                                                        @stop
