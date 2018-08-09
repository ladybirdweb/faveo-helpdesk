<style type="text/css">
    .bootstrap-switch-container{ white-space:nowrap; }
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap2/bootstrap-switch.css" rel="stylesheet">
        <h3 class="box-title">{{Lang::get('lang.cron_settings')}}</h3>
        {!! Form::checkbox('url',1,isCronUrl(),['id'=>'url-status']) !!}
    </div>

    <div class="box-body">
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
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! trans('lang.cron-cli-recommend') !!}
        </div>
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('success')!!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!!Session::get('fails')!!}
        </div>
        @endif


        <table class="table table-responsive">
            <tr>
                <td>Readmails</td>
                <td><pre>{!! url('readmails') !!}</pre></td>
                <td>{!! trans('lang.period-5-min') !!}</td>
            </tr>
            <tr>
                <td>Ticket Close Workflow</td>
                <td><pre>{!! url('auto-close-tickets') !!}</pre></td>
                <td>{!! trans('lang.period-once-a-day') !!}</td>
            </tr>
            <tr>
                <td>Follow Up</td>
                <td><pre>{!! url('ticket/followup/inbox') !!}</pre></td>
                <td>{!! trans('lang.period-once-a-day') !!}</td>
            </tr>
            <tr>
                <td>System Report</td>
                <td><pre>{!! url('notification') !!}</pre></td>
                <td>{!! trans('lang.period-once-a-day') !!}</td>
            </tr>
            <tr>
                <td>Remind For Calenders</td>
                <td><pre>{!! url('event-reminders-cron')!!}</pre></td>
                <td>{!! trans('lang.period-once-a-day') !!}</td>
            </tr>
            <tr>
                <td>SMS Notification</td>
                <td><pre>{!! url('send-message-cron') !!}</pre></td>
                <td>{!! trans('lang.period-once-a-day') !!}</td>
            </tr>
            <tr>
                <td>SLA escalation</td>
                <td><pre>{!! url('send/sla') !!}</pre></td>
                <td>{!! trans('lang.period-30-min') !!}</td>
            </tr>
            <tr>
                <td>Facebook Page messages</td>
                <td><pre>{!! url('facebook/page') !!}</pre></td>
                <td>{!! trans('lang.period-5-min') !!}</td>
            </tr>
            <tr>
                <td>Twitter messages</td>
                <td><pre>{!! url('twitter/messages') !!}</pre></td>
                <td>{!! trans('lang.period-5-min') !!}</td>
            </tr>
            <tr>
                <td>Twitter tweets</td>
                <td><pre>{!! url('twitter/tweets') !!}</pre></td>
                <td>{!! trans('lang.period-5-min') !!}</td>
            </tr>
        </table>


    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.js"></script>
<script>
// $.fn.bootstrapSwitch.defaults.size = 'normal';
// $.fn.bootstrapSwitch.defaults.onColor = 'success';
// $.fn.bootstrapSwitch.defaults.offColor = 'danger';
$("#url-status").bootstrapSwitch({
    onColor: 'success',
    offColor: 'danger',
    onSwitchChange: function(event, state){
        $.ajax({
            url : "{{url('cron/url')}}",
            data : {
                "_token": "{{ csrf_token() }}",
                'status':state
            },
            type: 'POST',
            success: function(){
                location.reload();
            }
        });
    }
});

</script>
@endpush


