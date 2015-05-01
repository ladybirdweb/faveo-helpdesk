<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <!-- <link href="{{asset("downloads/bootstrap.min.css")}}" rel="stylesheet" type="text/css" /> -->
        <link href="{{asset("dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h2>
            <div class="logo"><b>Faveo</b>HELP DESK</div><hr>	
        </h2>

        <h4>{{$thread->title}}</h4><br/>


        <?php $user = App\User::where('id', '=', $tickets->user_id)->first(); ?>
        <?php $response = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>
        @foreach($response as $last)
        <?php $ResponseDate = $last->created_at; ?>
        @endforeach

        <?php $status = App\Model\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first(); ?>
        <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first(); ?>
        <?php $help_topic = App\Model\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>
        <?php $help_topic = App\Model\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>

        <table class="table">    
            <tr><th></th><th></th></tr>
            <tr><td><b>Status:</b></td>       	<td>{{$status->state}}</td></tr>
            <tr><td><b>Priority:</b></td>     	<td>{{$priority->priority}}</td></tr>
            <tr><td><b>Department:</b></td>   	<td>{{$help_topic->department}}</td></tr> 
            <tr><td><b>Email:</b></td>        	<td>{{$user->email}}</td></tr>
            <tr><td><b>Phone:</b></td>        	<td>{{$thread->user_id}}</td></tr>
            <tr><td><b>Source:</b></td>         <td>{{$thread->ip_address}}</td></tr>
            <tr><td><b>Help Topic:</b></td>     <td>{{$help_topic->topic}}</td></tr>
            <tr><td><b>Last Message:</b></td>   <td>{{$last->poster}}</td></tr>
        </table>

        <?php $conversations = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>

        @foreach($conversations as $conversation)
        <br/><hr>
        <div style="color:green;" class="pull-right">{!! $conversation->poster !!}</div><br/><br/>
        {!! $conversation->body !!}<br/><br/>
        <strong>Date:</strong> {!! $thread->created_at !!}<br/>

        @endforeach


    </body>
</html>