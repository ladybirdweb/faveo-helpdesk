@extends('themes.default1.admin.layout.admin')

@section('system-settings')
active
@stop

@section('settings-bar')
active
@stop

@section('template')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>Edit Ratings</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

{!! Form::model($rating,['route'=>['settings.rating', $rating->id],'method'=>'PATCH','files' => true]) !!} 

	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
    
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{Session::get('success')}}</p>                
                    </div>
                @endif
<div class="box-body">
<div class="box-header">
<h2 class="box-title">{{Lang::get('lang.edit')}}</h2>
<div class="pull-right">
   {!! Form::submit(Lang::get('lang.save'),['class'=>'btn btn-primary'])!!}</div>
   </div>

	 <div class="box-body table-responsive no-padding"style="overflow:hidden">
	     
                         <div class="row">
                              <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.rating_label')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
                             <div class="col-md-6 form-group {{ $errors->has('display_order') ? 'has-error' : '' }}">
                {!! Form::label('display_order',Lang::get('lang.display_order')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('display_order', '<spam class="help-block">:message</spam>') !!}
                {!! Form::text('display_order',null,['class' => 'form-control']) !!}
            </div>
                                     </div>
                       
                              <div class="form-group {{ $errors->has('rating_scale') ? 'has-error' : '' }}">
                {!! Form::label('rating_scale',Lang::get('lang.rating_scale')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('rating_scale', '<spam class="help-block">:message</spam>') !!}
                <blockquote>{!! Lang::get('lang.rating-msg1') !!}</blockquote>
                {!! Form::select('rating_scale',['1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8'],null,['class' => 'form-control']) !!}
          
            </div>
                             <div class="form-group {{ $errors->has('rating_area') ? 'has-error' : '' }}">
                {!! Form::label('rating_area',Lang::get('lang.rating_area')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('rating_area', '<spam class="help-block">:message</spam>') !!}
                {!! Form::select('rating_area',['Helpdesk Area' => 'Helpdesk Area','Comment Area'=>'Comment Area'],null,['class' => 'form-control','disabled' => 'disabled']) !!}
            </div>
                                    
         <div class="form-group {{ $errors->has('restrict') ? 'has-error' : '' }}">
		<!-- gender -->
			{!! Form::label('gender',Lang::get('lang.rating_restrict')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('restrict', '<spam class="help-block">:message</spam>') !!}
                        <blockquote>{!! Lang::get('lang.rating-msg2') !!}</blockquote>
			{!! Form::select('restrict',['General' => 'general','Support'=>'support'],null,['class' => 'form-control']) !!}
          
		</div>
                           <div class="form-group {{ $errors->has('allow_modification') ? 'has-error' : '' }}">
		<!-- Email user -->
						
{!! Form::label('allow_modification',Lang::get('lang.rating_change')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('allow_modification', '<spam class="help-block">:message</spam>') !!}
                        <blockquote>{!! Lang::get('lang.rating-msg3') !!}</blockquote>
			<div class="row">
				<div class="col-xs-3">
					{!! Form::radio('allow_modification','1') !!} {{Lang::get('lang.yes')}}
				</div>
				<div class="col-xs-3">
					{!! Form::radio('allow_modification','0') !!} {{Lang::get('lang.no')}}
				</div>
		</div>        
                     </div>
	</div>
	</div>
	</div>


@stop
