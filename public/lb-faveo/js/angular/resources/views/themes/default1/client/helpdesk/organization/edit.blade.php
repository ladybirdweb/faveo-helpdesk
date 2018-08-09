@extends('themes.default1.agent.layout.agent')
@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.organization') !!}</h1>
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
<!-- open a form -->
{!! Form::model($orgs,['url'=>'organizations/'.$orgs->id,'method'=>'PATCH']) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{Lang::get('lang.edit')}}</h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('name'))
            <li class="error-message-padding">{!! $errors->first('name', ':message') !!}</li>
            @endif
            @if($errors->first('phone'))
            <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
            @endif
            @if($errors->first('website'))
            <li class="error-message-padding">{!! $errors->first('website', ':message') !!}</li>
            @endif
        </div>
        @endif
        <!-- name : text : Required -->
        <div class="row">
            <div class="col-xs-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!} <span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <!-- phone : Text : -->
            <div class="col-xs-4 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                {!! Form::label('phone',Lang::get('lang.phone')) !!}
                 {!! Form::input('number','phone',null,['class' => 'form-control']) !!}
                <!-- {!! Form::text('phone',null,['class' => 'form-control']) !!} -->
            </div>
            <!--website : Text :  -->
            <div class="col-xs-4 form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                {!! Form::label('website',Lang::get('lang.website')) !!}
                {!! Form::text('website',null,['class' => 'form-control']) !!}
            </div>
        </div>
        <!-- Internal Notes : Textarea -->
        <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('address',Lang::get('lang.address')) !!}
                {!! Form::textarea('address',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('internal_notes',Lang::get('lang.internal_notes')) !!}
                {!! Form::textarea('internal_notes',null,['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary'])!!}
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
@stop