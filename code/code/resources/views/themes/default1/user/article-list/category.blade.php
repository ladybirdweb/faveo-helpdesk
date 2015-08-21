@extends('themes.default1.layouts.client')
@section('breadcrumb')
                                 <div class="site-hero clearfix">
                   
                                    <ol class="breadcrumb breadcrumb-custom">
                                            <li class="text">You are here: </li>
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#">Frequently Asked Questions</a></li>
                                            <li class="active">All Articles</li>
                                    </ol>
                   </div>
@stop
@section('content')
    
                   
							<header class="archive-header">
                                                            @foreach($categorys as $category)
								<h1 class="archive-title">{!! $category->name !!}</h1>
							</header><!-- .archive-header -->
							
                                                        <blockquote class="archive-description" style="display: none;">
							<p>{!! $category->description !!}</p>
                                                        </blockquote>
                                                        
                                                                @endforeach
							
							<div class="archive-list archive-article">
                                                            <?php foreach ($article_id as $id) {?>
<?php $article = App\Model\Article::where('id', $id)->get(); ?>
                          @foreach($article as $arti)
								<article class="hentry">
									<header class="entry-header">
										<i class="fa fa-list-alt fa-2x fa-fw pull-left text-muted"></i>
										<h2 class="entry-title h4"><a href="{{url('kb/show/'.$arti->id)}}" onclick="toggle_visibility('foo');">{{$arti->name}}</a></h2>
									</header><!-- .entry-header -->
                                                                        <?php $str = $arti->description?>
<?php $excerpt = App\Http\Controllers\UserController::getExcerpt($str, $startPos = 0, $maxLength = 100)?>
                                                                        <div id="foo">
									<blockquote class="archive-description">
                            <p>{!!$excerpt!!}</p><br/>
                             <a class="readmore-link" style="color: #d3391d" href="{{url('kb/show/'.$arti->id)}}">Read more</a>
                           
</blockquote>	
                                                                        </div>
									<footer class="entry-footer">
										<div class="entry-meta text-muted">
											<span class="date"><i class="fa fa-clock-o fa-fw"></i> <time datetime="2013-10-22T20:01:58+00:00">{{$arti->created_at->format('l, d-m-Y')}}</time></span>
									
										</div><!-- .entry-meta -->
									</footer><!-- .entry-footer -->
								</article><!-- .hentry -->
                                                                 @endforeach

                       
                        <?php }
                        echo $all->render();
                        ?>
                                        
                                                        </div>
                                                                <script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>
                                               
@stop


