@section('Tools')
    class="active"
@stop
@section('tools-bar')
    active
@stop
@section('kb')
    class="active"
@stop
@section('sidebar')
                        <li class="header">KNOWLEDGE BASE</li>
                        <li class="treeview @yield('category')">
                            <a href="#">
                                <i class="fa fa-list-ul"></i> <span>{{trans('lang.category')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-category')><a href="{{url('category/create')}}"><i class="fa fa-circle-o"></i> {{trans('lang.addcategory')}}</a></li>
                                         <li @yield('all-category')><a href="{{url('category')}}"><i class="fa fa-circle-o"></i> {{trans('lang.allcategory')}}</a></li>
                                     </ul>
                        </li>
                        <li class="treeview @yield('article')">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{trans('lang.article')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-article')><a href="{{url('article/create')}}"><i class="fa fa-circle-o"></i> {{trans('lang.addarticle')}}</a></li>
                                         <li @yield('all-article')><a href="{{url('article')}}"><i class="fa fa-circle-o"></i> {{trans('lang.allarticle')}}</a></li>
                                     </ul>
                        </li>
                        <li class="treeview @yield('pages')">
                            <a href="#">
                                <i class="fa fa-file-text"></i> <span>{{trans('lang.pages')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-pages')><a href="{{url('page/create')}}"><i class="fa fa-circle-o"></i> {{trans('lang.addpages')}}</a></li>
                                         <li @yield('all-pages')><a href="{{url('page')}}"><i class="fa fa-circle-o"></i> {{trans('lang.allpages')}}</a></li>
                                     </ul>
                        </li>
                    
                        <li @yield('comment')>
                            <a href="{{url('comment')}}">
                                <i class="fa fa-comments-o"></i>
                                <span>{{trans('lang.comments')}}</span>
                            </a>
                        </li>
                        <li @yield('settings')>
                            <a href="{{url('kb/settings')}}">
                                 <i class="fa fa-wrench"></i>
                                <span>{{trans('lang.settings')}}</span>
                            </a>
                        </li>
                    @stop