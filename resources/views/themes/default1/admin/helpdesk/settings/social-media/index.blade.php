@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="nav-link active"
@stop

@section('settings-menu-parent')
class="nav-item menu-open"
@stop

@section('settings-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('social-login')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>Social Media</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- check whether success or not -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fas fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('success')!!}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fas fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('fails')!!}
</div>
@endif
<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">Social Media</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Provider</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Facebook</td>
                        <td>
                            @if($social->checkActive('facebook')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/facebook')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Google</td>
                        <td>
                            @if($social->checkActive('google')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/google')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Github</td>
                        <td>
                            @if($social->checkActive('github')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/github')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Twitter</td>
                        <td>
                            @if($social->checkActive('twitter')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/twitter')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Linkedin</td>
                        <td>
                            @if($social->checkActive('linkedin')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/linkedin')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Bitbucket</td>
                        <td>
                            @if($social->checkActive('bitbucket')===true)
                            <span style="color: green">Active</span>
                            @else 
                            <span style="color: red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('social/media/bitbucket')}}" class="btn btn-primary">Settings</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
