@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('email')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>Notification Settings</h1>
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
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{Lang::get('lang.settings')}}</h3>
            </div>
            <!-- check whether success or not -->
            @if(Session::has('success'))<!-- open a form -->

            <div class="alert alert-success alert-dismissable">
                <i class="fa  fa-check-circle"></i>
                <b>Success!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!!Session::get('success')!!}
            </div>
            @endif
            <!-- failure message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Fail!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!!Session::get('fails')!!}
            </div>
            @endif
            <div class="box-body table-responsive"style="overflow:hidden;">
                <div class="row">
                    <!-- Default System Email:	DROPDOWN value from emails table : Required -->
                    <div class="col-md-12">
                        <div class="col-md-3 no-padding">
                            <div class="form-group">
                                {!! Form::label('del_noti','Delete All read notification?') !!}

                            </div></div>
                        <div class="col-md-6">
                            <a href="{{ url('delete-read-notification') }}" class="btn btn-danger">Delete All Read</a>
                        </div>
                    </div><br>

                    <div class="col-md-12">
                        <div class="col-md-3 no-padding">
                            <div class="form-group">
                                {!! Form::label('del_noti','Days to delete notification logs') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ url('delete-notification-log') }}" method="post">
                                <blockquote><em>You can enter the no of days of database logs to be deleted and the history of notifications will be deleted since the day specified.</em></blockquote>
                                <input type="text" class="form-control" name='no_of_days' placeholder="Enter No of days">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div></div>
                </div>
            </div>

        </div>

    </div>
</div>


@stop
