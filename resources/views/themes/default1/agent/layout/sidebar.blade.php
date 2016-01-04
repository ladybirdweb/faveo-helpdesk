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
                                <i class="fa fa-list-ul"></i> <span>{{Lang::get('lang.category')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-category')><a href="{{url('category/create')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.addcategory')}}</a></li>
                                         <li @yield('all-category')><a href="{{url('category')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.allcategory')}}</a></li>
                                     </ul>
                        </li>
                        <li class="treeview @yield('article')">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>{{Lang::get('lang.article')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-article')><a href="{{url('article/create')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.addarticle')}}</a></li>
                                         <li @yield('all-article')><a href="{{url('article')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.allarticle')}}</a></li>
                                     </ul>
                        </li>
                        <li class="treeview @yield('pages')">
                            <a href="#">
                                <i class="fa fa-file-text"></i> <span>{{Lang::get('lang.pages')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('add-pages')><a href="{{url('page/create')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.addpages')}}</a></li>
                                         <li @yield('all-pages')><a href="{{url('page')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.allpages')}}</a></li>
                                     </ul>
                        </li>
                        <li class="treeview @yield('widget')">
                            <a href="#">
                                <i class="fa  fa-th"></i> <span>{{Lang::get('lang.widgets')}}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                    <ul class="treeview-menu">
                                        <li @yield('side1')><a href="{{url('side1')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.sidewidget1')}}</a></li>
                                        <li @yield('side2')><a href="{{url('side2')}}"><i class="fa fa-circle-o"></i> {{Lang::get('lang.sidewidget2')}}</a></li>
                                        <li @yield('social')><a href="{{url('social')}}"><i class="fa fa-circle-o"></i> {!! Lang::get('lang.social') !!}</a></li>
                                     </ul>
                        </li>
                         <li @yield('comment')>
                            <a href="{{url('comment')}}">
                                <i class="fa fa-comments-o"></i>
                                <span>{{Lang::get('lang.comments')}}</span>
                            </a>
                        </li>
                         <li @yield('settings')>
                            <a href="{{url('kb/settings')}}">
                                 <i class="fa fa-wrench"></i>
                                <span>{{Lang::get('lang.settings')}}</span>
                            </a>
                        </li>
                    @stop