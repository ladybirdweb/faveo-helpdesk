<?php
    $array = [
        trans('lang.status')=>$status->name,
        trans('lang.priority')=>$priority->priority_desc,
        trans('lang.department')=>$dept123->name,
        trans('lang.email')=>str_limit($user->email,30),
        trans('lang.source')=>$ticket_source,
        trans('lang.help_topic')=>$help_topic->topic,
        trans('lang.last_message')=>str_limit($username,30),
        trans('lang.organization') => $LastResponse->getOrgWithLink(),
    ];
    
    if($user->ban > 0){
        array_push($array, [trans('lang.this_ticket_is_under_banned_user')=>'']);
    }
    if($user->phone_number !=null){
        array_push($array, [trans('lang.phone')=>$user->phone_number]);
    }
    if($user->mobile !=null){
        array_push($array, [trans('lang.mobile')=>$user->mobile]);
    }
    $collection = collect($array);
    ?>
@foreach($collection->chunk(4) as $chunk)
<div class="col-md-6">
    <table class="table table-responsive">
            @foreach($chunk as $key=>$value)
            <tr>
                <td><b>{!! $key !!}:</b></td>
                <td>{!!$value!!}</td>
            </tr>
            @endforeach
    </table>
</div>
@endforeach
@include('themes.default1.agent.helpdesk.filters.tags')
<?php Event::fire(new App\Events\TicketDetailTable($TicketData)); ?>
        