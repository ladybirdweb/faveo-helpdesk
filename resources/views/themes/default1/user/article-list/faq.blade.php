@extends('themes.default1.layouts.client')
@section('breadcrumb')
                                 <div class="site-hero clearfix">
                   
                                    <ol class="breadcrumb breadcrumb-custom">
                                            <li class="text">You are here: </li>
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#">Frequently Asked Questions</a></li>
                                           
                                    </ol>
                   </div>
@stop
@section('content')
<div id="content" class="site-content col-md-9">
<!-- Start of Page Container -->

<article class="hentry">
								<header class="entry-header">
            <h2>Faq</h2>
    </header><!-- .entry-header -->

   <div class="entry-content clearfix">
            {!! $faq->faq !!}
</div>

</article><!-- .hentry -->


<!-- end of page content -->
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

