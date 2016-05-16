@extends('themes.default1.admin.layout.admin')

@section('Emails')
active
@stop

@section('emails-bar')
active
@stop

@section('template')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')

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

  {!! Form::open(['route'=>'rating.store']) !!}

	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-body">
<div class="box-header">
<h2 class="box-title">{{Lang::get('lang.create')}}</h2>
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
                <blockquote>The maximum rating that can be given. For example, if 5 is selected, the lowest possible rating will be 1 and the highest 5.</blockquote>
                {!! Form::select('rating_scale',['1' => '1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8'],null,['class' => 'form-control']) !!}
           </div>
                             <div class="form-group {{ $errors->has('rating_area') ? 'has-error' : '' }}">
                {!! Form::label('rating_area',Lang::get('lang.rating_area')) !!}<span style="color:red;">*</span>
                        {!! $errors->first('rating_area', '<spam class="help-block">:message</spam>') !!}
                {!! Form::select('rating_area',['Helpdesk Area' => 'Helpdesk Area','Comment Area'=>'Comment Area'],null,['class' => 'form-control']) !!}
            </div>
                                
         <div class="form-group {{ $errors->has('restrict') ? 'has-error' : '' }}">
		<!-- gender -->
			{!! Form::label('gender','Restrict rating to a department') !!}<span style="color:red;">*</span>
                        {!! $errors->first('restrict', '<spam class="help-block">:message</spam>') !!}
                        <blockquote>Select a department to restrict this rating to tickets or chats within a specific department. If no department is selected, the rating will appear across all departments.</blockquote>
			{!! Form::select('restrict',['General' => 'general','Support'=>'support'],null,['class' => 'form-control']) !!}
          
		</div>
                           <div class="form-group {{ $errors->has('allow_modification') ? 'has-error' : '' }}">
		<!-- Email user -->
						
{!! Form::label('allow_modification','Allow user to change the rating?') !!}<span style="color:red;">*</span>
                        {!! $errors->first('allow_modification', '<spam class="help-block">:message</spam>') !!}
                        <blockquote>If you choose 'YES' user can modify the rating.</blockquote>
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
