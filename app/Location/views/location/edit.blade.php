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
<h1>{!! Lang::get('lang.edit_location') !!}</h1>
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

<!-- <section class="content-header">
    <h1>
        {{Lang::get('lang.edit_location')}}

    </h1>

</section> -->
<div class="box box-primary">
    <div class="box-header with-border">
      
    </div>

    <!-- form start -->
    <form action="{!!URL::route('helpdesk.location.postedit',$hd_location->id)!!}" method="post" role="form" id="Form" >
    {{ csrf_field() }}
        <input type="hidden" name="location_id" value="{{$hd_location->id}}">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="name" class="control-label">{{Lang::get('lang.name')}}<span class="text-red"> *</span></label> 
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="title" value="{{$hd_location->title}}" id="name">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="name" class="control-label">{{Lang::get('lang.email')}}<span class="text-red"> *</span></label> 

                    <?php
                    $location_email=$hd_location->email;
                    if($location_email){
                        $email=$location_email;
                    }
                    else{

                        $email=Auth::user()->email;
                    }
                    ?>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="email" value="{{$email}}" id="name" readonly="readonly">
                    </div>
                </div>
               
            </div> 
            <div class="row">
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('lang.phone')}}</label> 
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">

                      <input type="text" name="phone" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  id="name" value="{{$hd_location->phone}}">

                    </div>
                </div>
                <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6 form-group">
                    <label for="name" class="control-label">{{Lang::get('lang.address')}}</label> 
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="address" value="{{$hd_location->address}}" id="name">
                    </div>
                </div>
            </div> 
            
            <div class="box-footer">
<!--                <button type="submit" class="btn btn-primary">{{Lang::get('service::lang.update')}}</button>
            -->
             <button type="submit" class="btn btn-primary" id="submit" data-loading-text="<i class='fa fa-refresh fa-spin fa-1x fa-fw'>&nbsp;</i> updating..."><i class="fa fa-refresh">&nbsp;&nbsp;</i>{!!Lang::get('lang.update')!!}</button>    
            </div>

    </form>
</div>

@stop
