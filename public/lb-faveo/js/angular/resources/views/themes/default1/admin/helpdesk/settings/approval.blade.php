@extends('themes.default1.admin.layout.admin')

@section('Settings')
active
@stop

@section('settings-bar')
active
@stop

@section('Approval')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.settings') !!}</h1>
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
<div class="alert alert-success alert-dismissable" style="display: none;">
    <i class="fa  fa-check-circle"></i>
    <span class="success-msg"></span>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('lang.approval_settings')}}</h3>
            </div>
            <!-- check whether success or not -->
            <div class="box-body table-responsive"style="overflow:hidden;">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-check-circle"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!!Session::get('success')!!}
                </div>
                @endif
                <!-- failure message -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <b> {!! Lang::get('lang.alert') !!} ! </b>
                    <li class="error-message-padding">{!!Session::get('fails')!!}</li>
                </div>
                @endif

                <div class="row">
                    <!-- Default System Email:  DROPDOWN value from emails table : Required -->
                    <div class="col-md-12">
                        <div class="col-md-3 no-padding">
                            <div class="form-group">
                                {!! Form::label('del_noti', Lang::get('lang.close_all_ticket_for_approval')) !!}
                            </div>
                        </div>
     
                        <div class="col-md-6">
                            <div class="btn-group {{$approval_status->status == '0' ? 'locked_active unlocked_inactive' : 'locked_inactive unlocked_active'}}" id="toggle_event_editing">
                                <button type="button"  class="btn {{$approval_status->status == '0' ? 'btn-info' : 'btn-default'}}">OFF</button>
                                <button type="button"  class="btn {{$approval_status->status == '1' ? 'btn-info' : 'btn-default'}}">ON</button>
                            </div>
                            <!-- <div class="alert alert-info" id="switch_status"></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#toggle_event_editing').click(function () {
        var settings_approval=1;
         var settings_approval=0;
        if ($(this).hasClass('locked_inactive')) {
            settings_approval = 0
        } if ($(this).hasClass('locked_active')) {
            settings_approval = 1;
        }

        /* reverse locking status */
        $('#toggle_event_editing button').eq(0).toggleClass('btn-info btn-default');
        $('#toggle_event_editing button').eq(1).toggleClass('btn-default btn-info');
        $('#toggle_event_editing').toggleClass('locked_active unlocked_inactive');
        $('#toggle_event_editing').toggleClass('locked_inactive unlocked_active');
        $.ajax({
            type: 'post',
            url: '{{route("settingsUpdateApproval.settings")}}',
            data: {
                "_token": "{{ csrf_token() }}",
                settings_approval: settings_approval
            },
            success: function (result) {
                $('.success-msg').html(result);
                $('.alert-success').css('display', 'block');
                setInterval(function(){
                    $('.alert-success').slideUp( 3000, function() {});
                }, 500);
            }
        });
    });
</script>
@stop