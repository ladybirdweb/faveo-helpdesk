@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('tickets-bar')
active
@stop

@section('location')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.location') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop

<!-- content -->
@section('content')
@if ( $errors->count() > 0 )
<div class="alert alert-danger" aria-hidden="true">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!} !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
        @foreach( $errors->all() as $message )</p>
        <li class="error-message-padding">{{ $message }} </li>
        @endforeach
    </ul>
</div>
@endif

<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{Lang::get('lang.create_new_location')}}</h4>
    </div>

    <!-- form start -->

    <form action="{!!URL::route('helpdesk.post.location')!!}" method="post" role="form" id="Form">
     {{ csrf_field() }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title" class="control-label">{{Lang::get('lang.name')}}<span class="text-red"> *</span></label> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="title" id="name">
                    </div>
                </div>
                
                

                <div class="col-md-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="control-label">{{Lang::get('lang.email')}}<span class="text-red"> *</span></label> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="email" id="name" value="{{Auth::user()->email}}" readonly="readonly">
                    </div>
                </div>
              <!--   <div class="col-md-4 form-group {{ $errors->has('organization') ? 'has-error' : '' }}">
                    {!! Form::label('organization',Lang::get('lang.organization')) !!}
                    {!! Form::select('organization',[''=>'Select','Organizations'=>$organizations],null,['class'=>'form-control']) !!}
                </div> -->
            </div> 

            <div class="row">
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('lang.phone')}}</label> 
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <input type="text" name="phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  id="name" placeholder="phone">


                        <!-- <input type="text" class="form-control" name="phone" placeholder="phone" id="name"> -->
                    </div>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('lang.address')}}</label> 
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="address" placeholder="address" id="name">
                    </div>
                </div>
            </div> 

            

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{Lang::get('lang.create')}}</button>
                    <!-- <button type="submit" class="btn btn-primary" id="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'>&nbsp;</i> Saving..."><i class="fa fa-floppy-o">&nbsp;&nbsp;</i>{!!Lang::get('lang.save')!!}</button> -->
            </div>
            

        </div>
    </form>
</div>

@stop