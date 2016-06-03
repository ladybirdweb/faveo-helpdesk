@extends('themes.default1.agent.layout.agent')
@extends('themes.default1.agent.layout.sidebar')    

@section('category')
active
@stop

@section('add-category')
class="active"
@stop

@section('content')
{!! Form::open(array('action' => 'Agent\kb\CategoryController@store' , 'method' => 'post') )!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.addcategory') !!}</h4> 
    </div>
    <div class="box-body">
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
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
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
            @if($errors->first('slug'))
            <li class="error-message-padding">{!! $errors->first('slug', ':message') !!}</li>
            @endif
            @if($errors->first('parent'))
            <li class="error-message-padding">{!! $errors->first('parent', ':message') !!}</li>
            @endif
            @if($errors->first('status'))
            <li class="error-message-padding">{!! $errors->first('status', ':message') !!}</li>
            @endif
            @if($errors->first('description'))
            <li class="error-message-padding">{!! $errors->first('description', ':message') !!}</li>
            @endif          
        </div>
        @endif
        <div class="row">
            <div class="col-xs-3 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-3 form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                {!! Form::label('slug',Lang::get('lang.slug')) !!}<span class="text-red"> *</span>
                {!! Form::text('slug',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-3 form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
                {!! Form::label('parent',Lang::get('lang.parent')) !!}
                {!!Form::select('parent',[''=>'Select a Group','Categorys'=>$category->lists('name','name')->toArray()],null,['class' => 'form-control select']) !!}
            </div>
            <div class="col-xs-3 form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                {!! Form::label('status',Lang::get('lang.status')) !!}
                <br/>
                {!! Form::radio('status','1',true) !!} {{Lang::get('lang.active')}}
                {!! Form::radio('status','0',null) !!} {{Lang::get('lang.inactive')}}
            </div>
            <div class="col-md-12 form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                {!! Form::label('description',Lang::get('lang.description')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('description',null,['class' => 'form-control','id'=>'description','placeholder'=>Lang::get('lang.enter_the_description') ]) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
@stop
