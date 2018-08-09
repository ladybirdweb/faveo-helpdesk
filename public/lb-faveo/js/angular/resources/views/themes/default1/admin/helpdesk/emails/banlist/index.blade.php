@extends('themes.default1.admin.layout.admin')

@section('Emails')
active
@stop

@section('emails-bar')
active
@stop

@section('ban')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.ban_email') !!}</h1>
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
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.list_of_banned_emails')}}</h2><a href="{{route('banlist.create')}}" class="pull-right btn btn-primary"><i class="fa fa-ban">&nbsp;&nbsp;</i>{{Lang::get('lang.ban_email')}}</a>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
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
            <b>{!! Lang::get('lang.fails') !!} ! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <table class="table table-bordered dataTable" style="overflow:hidden;">
            <tr>
                <th width="100px">{{Lang::get('lang.email_address')}}</th>
                <th width="100px">{{Lang::get('lang.last_updated')}}</th>
                <th width="100px">{{Lang::get('lang.action')}}</th>
            </tr>
            <!-- Foreach @var bans as @var ban -->
            @foreach($bans as $ban)
            <tr>
                <!-- Email Address with Link to Edit page along Id -->
                <td><a href="{{route('banlist.edit',$ban->id)}}">{!! $ban->email !!}</a></td>
                <!-- Last Updated -->
                <td> {!! faveoDate($ban->updated_at) !!} </td>
                <!-- Deleting Fields -->
                <td>
                    <a href="{{route('banlist.edit',$ban->id)}}" class="btn btn-primary btn-xs "><i class="fa fa-edit" style="color:white;"> </i>&nbsp; {!! Lang::get('lang.edit') !!}</a> &nbsp;<a href="{{route('banlist.delete',$ban->id)}}" class="btn btn-primary btn-xs "><i class="fa fa-trash" style="color:white;"> </i> &nbsp;{!! Lang::get('lang.delete') !!}</a>
                </td>
                @endforeach
            </tr>
            <!-- Set a link to Create Page -->
        </table>
    </div>
</div>
@stop
