@extends('themes.default1.layouts.client')
@section('breadcrumb')

    {{-- get the article_id where category_id == current category --}}
<?php

$all = App\Model\Relationship::where('article_id', $arti->id)->get();
/* from whole attribute pick the article_id */
$category_id = $all->lists('category_id');

?>

 <div class="site-hero clearfix">
                   
                                    <ol class="breadcrumb breadcrumb-custom">
                                            <li class="text">You are here: </li>
                                            <?php $category = App\Model\Category::where('id', $category_id)->first();?>
                                            <li><a href="{{url('kb/category-list/'.$category->id)}}">{{$category->name}}</a></li>
                                            <li class="active">{{$arti->name}}</li>
                                    </ol>
                   </div>
	@stop		
@section('content')
 <div id="content" class="site-content col-md-12">

<!--
<article class=" type-post format-standard hentry clearfix">

		<h1 class="post-title"><a href="#">{{$arti->name}}</a></h1>

				<div class="post-meta clearfix">
				<span class="date">{{$arti->created_at}}</span>
				<span class="category"><a href="#" title="View all posts in Server &amp; Database">{{$category->name}}</a></span>
		</div> end of post meta 
		{!!$arti->description!!}
</article>-->
						
							<article class="hentry">
								<header class="entry-header">
									<h1 class="entry-title">{{$arti->name}}</h1>

									<div class="entry-meta text-muted">
										<span class="date"><i class="fa fa-film fa-fw"></i> <time datetime="2013-09-19T20:01:58+00:00">{{$arti->created_at}}</time></span>
										<span class="category"><i class="fa fa-folder-open-o fa-fw"></i> <a href="#">{{$category->name}}</a></span>
									</div><!-- .entry-meta -->
								</header><!-- .entry-header -->
									
								<div class="entry-content clearfix">
									
									<p>{!!$arti->description!!}</p>
									
								</div><!-- .entry-content -->
									
								<footer class="entry-footer">
									<div class="entry-attribute clearfix">
										<div class="row">
											<div class="rate-post col-sm-6">
												<ul class="list-inline pull-left">
													<li><a href="#" class="btn btn-social btn-like disabled" title="This article was helpful" data-toggle="tooltip"><i class="fa fa-thumbs-o-up fa-fw"></i></a></li>
													<li><a href="#" class="btn btn-social btn-dislike disabled" title="This article was not helpful" data-toggle="tooltip"><i class="fa fa-thumbs-o-down fa-fw"></i></a></li>
												</ul>
												<strong>19 <small class="text-muted">votes</small></strong>
												<ul class="list-inline rate-average text-warning pull-left">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star-half-o"></i></li>
													<li><i class="fa fa-star-o"></i></li>
												</ul>
											</div><!-- .rate-post -->

											<div class="share-links text-right col-sm-6">
												<strong class="text-muted">Share it</strong>
												<ul class="list-inline pull-right">
													<li><a href="#" class="btn btn-social btn-facebook"><i class="fa fa-facebook fa-fw"></i></a></li>
													<li><a href="#" class="btn btn-social btn-twitter"><i class="fa fa-twitter fa-fw"></i></a></li>
												
													<li><a href="#" class="btn btn-social btn-linkedin"><i class="fa fa-linkedin fa-fw"></i></a></li>
													<li><a href="#" class="btn btn-social btn-pinterest"><i class="fa fa-pinterest fa-fw"></i></a></li>
												</ul>
											</div><!-- .share-links -->
										</div>
									</div><!-- .entry-attribute -->
								</footer><!-- .entry-footer -->
							</article><!-- .hentry -->
<?php $comments = App\Model\Comment::where('article_id', $arti->id)->get(); ?>
                                                       
							<div id="comments" class="comments-area">
                                                             @foreach($comments as $comment)
								<ol class="comment-list">
									<li class="comment">
										<article class="comment-body">
											<footer class="comment-meta">
												<div class="comment-author">
													<img src="{{asset("dist/img/avatar_1.png")}}" alt="" height="50" width="50" class="avatar" />
													<b class="fn"><a href="#" rel="external" class="url">{!! $comment->name !!}</a></b>
												</div><!-- .comment-author -->

												<div class="comment-metadata">
													<small class="date text-muted">
														<time datetime="2013-10-23T01:50:50+00:00">{!! $comment->created_at !!}</time>
													</small>
												</div><!-- .comment-metadata -->
											</footer><!-- .comment-meta -->

											<div class="comment-content">
												
												<p>{!! $comment->comment !!}</p>
											</div><!-- .comment-content -->

											<div class="comment-reply text-right">
												<a class="btn btn-custom btn-sm" href="#">Reply</a>
											</div><!-- .comment-reply -->
										</article><!-- .comment-body -->
									</li><!-- .comment -->

									
								</ol><!-- .comment-list -->
                                                                @endforeach
								<div id="respond" class="comment-respond form-border">
									<h3 id="reply-title" class="comment-reply-title section-title">Leave a Reply</h3>
									{!! Form::open(['method'=>'post','url'=>'kb/postcomment/'.$arti->id]) !!}
										<div class="row">
											<div class="form-group">
											<div class="col-md-6">
												
                                                                                                    
                                                                                                    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                    {!! Form::label('name','Name') !!}
                    {!! $errors->first('name', '<spam class="help-block" style="red">:message</spam>') !!}
                    {!! Form::text('name',null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                    {!! Form::label('email','Email') !!}
                    {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('email',null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">

                    {!! Form::label('website','website') !!}
                    {!! $errors->first('website', '<spam class="help-block">:message</spam>') !!}
                    {!! Form::text('website',null,['class' => 'form-control']) !!}

                </div>
                                                                                        </div>
                                                                                            <div class="col-md-6">
                <div class="form-group {{ $errors->has('comment') ? 'has-   error' : '' }}">
                    {!! Form::label('comment','Messege') !!}
                    {!! $errors->first('comment', '<spam class="help-block">:message</spam>') !!}

                        {!! Form::textarea('comment',null,['class' => 'form-control','size' => '30x8','id'=>'comment']) !!}

                </div>
              									</div>												
											</div>
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-custom btn-lg">Post Comment</button>
										</div>
								
                                                                        {!! Form::close() !!}
								</div><!-- #respond -->
							</div>
							
			</div>			
                
@stop