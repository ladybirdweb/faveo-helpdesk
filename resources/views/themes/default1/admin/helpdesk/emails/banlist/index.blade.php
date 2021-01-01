@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="nav-link active"
@stop

@section('email-menu-parent')
class="nav-item menu-open"
@stop

@section('email-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('ban')
class="nav-link active"
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
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{{Lang::get('lang.list_of_banned_emails')}}</h3>
        <div class="card-tools">
            <a href="{{route('banlist.create')}}" class="btn btn-default btn-tool"><i class="fas fa-ban"> </i> {{Lang::get('lang.ban_email')}}</a>
        </div>
    </div>
    <div class="card-body">
        
        <table class="table table-bordered dataTable" style="overflow:scroll;">
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
                <td> {!! UTC::usertimezone($ban->updated_at) !!} </td>
                <!-- Deleting Fields -->
                <td>
                    <a href="{{route('banlist.edit',$ban->id)}}" class="btn btn-primary btn-xs"><i class="fas fa-edit"> </i> {!! Lang::get('lang.edit') !!}</a> 
                    <a href="{{route('banlist.delete',$ban->id)}}" class="btn btn-danger btn-xs"><i class="fas fa-trash"> </i> {!! Lang::get('lang.delete') !!}</a>
                </td>
                @endforeach
            </tr>
            <!-- Set a link to Create Page -->
        </table>
    </div>
</div>
@stop
