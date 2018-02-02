@extends('themes.default1.client.layout.logclient')

@section('home')
    class = "active"
@stop

@section('HeadInclude')
<link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />
           <link href="{{asset("lb-faveo/css/widgetbox.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        {{-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> --}}
        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
@stop



<!-- @if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! trans('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</div>
@endif -->


@section('breadcrumb')
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">{!! trans('lang.you_are_here') !!}: </li>
            <li><a href="{!! URL::route('/') !!}">{!! trans('lang.home') !!}</a></li>
        </ol>
    </div>
@stop
@section('content')

@if(Session::has('status'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i> <b> {!! trans('lang.success') !!} </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('status')}}
</div>

@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa  fa-check-circle"> </i> <b> {!! trans('lang.alert') !!} </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('error')}}
</div>
@else

@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! trans('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</div>
@endif
@endif

<div id="content" class="site-content col-md-12">
    <div id="corewidgetbox">
        <div class="widgetrow text-center">
        @if(Auth::user())
        @else
            <span onclick="javascript: window.location.href='{{url('auth/register')}}';">
                <a href="{{url('auth/register')}}"  style="background-image:url({{ URL::asset('lb-faveo/media/images/register.png') }})">
                    <span class="widgetitemtitle">{!! trans('lang.register') !!}</span>
                </a>
            </span>
        @endif
        <?php $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();            
        ?>
        @if($system != null) 
            @if($system->status) 
                @if($system->status == 1)
                    <span onclick="javascript: window.location.href='{!! URL::route('form') !!}';">
                        <a href="{!! URL::route('form') !!}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/submitticket.png') }})">
                            <span class="widgetitemtitle">{!! trans('lang.submit_a_ticket') !!}</span>
                        </a>
                    </span>
                @endif
            @endif
        @endif
            <span onclick="javascript: window.location.href='{{url('mytickets')}}';">
                <a href="{{url('mytickets')}}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/news.png') }})">
                    <span class="widgetitemtitle">{!! trans('lang.my_tickets') !!}</span>
                </a>
            </span>
            <span onclick="javascript: window.location.href='{{url('/knowledgebase')}}';">
                <a href="{{url('/knowledgebase')}}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/knowledgebase.png') }})">
                    <span class="widgetitemtitle">{!! trans('lang.knowledge_base') !!}</span>
                </a>
            </span>
        </div>
    </div>
<script type="text/javascript"> $(function(){ $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');$("form").bind("submit", function(e){$(this).find("input:submit").attr("disabled", "disabled");});});</script>
<script type="text/javascript" >try {if (top.location.hostname != self.location.hostname) { throw 1; }} catch (e) { top.location.href = self.location.href; }</script>
</div></div>
 <div class="login-box" style=" width: 500px;
    height: 150px;"  valign = "center">
 <div class="form-border">
     
                <div align="center">
                 <h4 style="background-color: #0084b4;"> <a href="http://www.faveohelpdesk.com" class="logo"><img src="{{ asset('lb-faveo/media/images/logo.png')}}" width="100px;"></a>
</h4>
                  
                </div>
               
                <div>
 <h4 class="box-title" align="center">{{trans('lang.login_to_start_your_session')}}</h4>
                  
                </div>

  
<!-- form open -->
{!!  Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']) !!}
<!-- Email -->
 <div class="col-xs-12">
<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
    {!! Form::text('email',null,['placeholder'=> trans("lang.email") ,'class' => 'form-control']) !!}
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

</div>
</div>
 <div class="col-xs-12">

<!-- Password -->
<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
        
 {!! Form::password('password',['placeholder'=>trans("lang.password"),'class' => 'form-control']) !!}
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

</div>
</div>
        
        
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">{!! trans("lang.login") !!}</button>
    </div><!-- /.col -->


</form>


 
<div class="row">
        <div class="col-xs-12">

    <div class="col-xs-4">

<div>
            <label>
                <input type="checkbox" name="remember"> {!! trans("lang.remember") !!}
            </label>
        </div>  </div>
    <!-- /.col -->

    <div class="col-xs-6">
 
<a href="{{url('password/email')}}">{!! trans("lang.iforgot") !!}</a><br>

</div>
 <div class="col-xs-2">
 
<a href="{{url('auth/register')}}" class="text-center">{!! trans("lang.register") !!}</a>


</div>
            <div class="col-md-12">
                @include('themes.default1.client.layout.social-login')
            </div>

<!-- /.login-page -->
  </div><!-- /.col -->
</div>


{!! Form::close()!!}  

@stop
