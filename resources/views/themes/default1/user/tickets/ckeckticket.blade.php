@extends('themes.default1.layouts.client')


@section('HeadInclude')
        <link href="{{asset("dist/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
@stop

@section('breadcrumb')
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text">You are here: </li>
            <li><a href="#">Home</a></li>
            <li class="active">Ticket Status</li>
        </ol>
    </div>
@stop	

@section('content')               
<?php  
$tickets = App\Model\ticket\Tickets::where('id','=',\Crypt::decrypt($id))->first(); 
$thread = App\Model\ticket\Ticket_thread::where('ticket_id','=',\Crypt::decrypt($id))->first();
//$user = App\User::where('id','=',$id1)->first();?>


                    <!-- Main content -->
                    <div class="box box-primary">
                        <div class="box-header">

                            <section class="content-header"><h3 class="box-title"><i class="fa fa-user"> </i> {{$thread->title}} </h3> ( {{$tickets->ticket_number}} )
                            </section>
                            <div class="pull-right">
                                <!-- <button type="button" class="btn btn-default"><i class="fa fa-edit" style="color:green;"> </i> Edit</button> -->                            
                                <button type="button" class="btn btn-default"><i class="fa fa-print" style="color:blue;"> </i> {!! link_to_route('ticket.print','Print',[$tickets->id]) !!}</button>
                                <!-- </div> -->
                                <div class="btn-group"> 
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-exchange" style="color:teal;"> </i> 
                                        Change Status <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" id="open"><i class="fa fa-folder-open-o" style="color:yellow;"> </i>Open</a></li>
                                        <li><a href="#" id="close"><i class="fa fa-check" style="color:green;"> </i>Close</a></li>
                                        <li><a href="#" id="resolved"><i class="fa fa-check-circle-o " style="color:green;"> </i> Resolved</a></li>
                                    </ul>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <section class="content"  id="refresh">
                                    <div class="col-md-12"> 
                                        <?php 
                                        $priority = App\Model\Ticket\Ticket_Priority::where('priority_id','=',$tickets->priority_id)->first();
                                        ?>
                                        <div class="callout callout-{!! $priority->priority_color !!}">
                                            <div class="row">
                                                <div class="col-md-3"> 
                                                <?php
                                                $sla = $tickets->sla;
                                                $SlaPlan = App\Model\Manage\Sla_plan::where('id','=',1)->first();?>
                                                    <b>SLA Plan: {{$SlaPlan->grace_period}} </b> 
                                                </div>
                                                <div class="col-md-3"> 
                                                    <b>Created Date: </b> {{date_format($tickets->created_at, 'd/m/Y H:i:s')}}
                                                </div>
                                                <div class="col-md-3"> 
                                                    <b>Due Date: </b> 
                                                    <?php 
                                                    $time = $tickets->created_at;
                                                    $time = date_create($time);
                                                    date_add($time, date_interval_create_from_date_string($SlaPlan->grace_period));
                                                    echo date_format($time, 'd/m/Y H:i:s');
                                                    ?>
                                                </div>
                                                <div class="col-md-3">
                                                <?php $response = App\Model\Ticket\Ticket_Thread::where('ticket_id','=',$tickets->id)->get();?>
                                                @foreach($response as $last)
                                                <?php $ResponseDate  = $last->created_at; ?>
                                                @endforeach
                                                    <b>Last Response: </b> {{date_format($ResponseDate, 'd/m/Y H:i:s')}} 
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                    <div class="col-md-6"> 
                                        <table class="table table-hover">
                                            <!-- <tr><th></th><th></th></tr> -->
                                            <tr><td><b>Status:</b></td>       <?php $status = App\Model\Ticket\Ticket_Status::where('id','=',$tickets->status)->first();?><td title="{{$status->properties}}">{{$status->state}}</td></tr>
                                            <tr><td><b>Priority:</b></td>     <?php $priority = App\Model\Ticket\Ticket_Priority::where('priority_id','=',$tickets->priority_id)->first();?><td title="{{$priority->priority_desc}}">{{$priority->priority}}</td></tr>
                                            <tr><td><b>Department:</b></td>   <?php $help_topic = App\Model\Manage\Help_topic::where('id','=',$tickets->help_topic_id)->first();?><td title="{{$help_topic->topic}}">{{$help_topic->department}}</td></tr>
                                        </table>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-md-6"> 
                                        <!-- <div class="callout callout-success"> -->
                                        <table class="table table-hover">
                                            <!-- <tr><th></th><th></th></tr> -->
                                            <tr><td><b>Help Topic:</b></td>     <?php $help_topic = App\Model\Manage\Help_topic::where('id','=',$tickets->help_topic_id)->first();?><td title="{{$help_topic->topic}}">{{$help_topic->topic}}</td></tr>
                                            <tr><td><b>Last Message:</b></td>   <td>{{$last->poster}}</td></tr>
                                        </table>
                                    </div>
                                    <!-- </div> -->
                                </section> 
                            </div>
                        </div>
                    </div>

<?php
$conversations = App\Model\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->where('is_internal', '=', 0)->paginate(10);
foreach ($conversations as $conversation) {
$ConvDate1 = $conversation->created_at;
    $ConvDate = explode(' ', $ConvDate1);

    $date = $ConvDate[0];
    $time = $ConvDate[1];
    $time = substr($time, 0, -3);
    if (isset($data) && $date == $data) {

    } else {
$data = $ConvDate[0];
    }
    $role = App\User::where('id','=',$conversation->user_id)->first();

    $attachment = App\Model\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->first();
    if($attachment == null ) {
        $body = $conversation->body;
    }
    else {
        $body = $conversation->body;
        $attachments = App\Model\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->orderBy('id', 'DESC')->get();
                    foreach($attachments as $attachment)
                    {
                        if($attachment->type == 'pdf')
                        {
                        }elseif($attachment->type == 'docx')
                        {
                        }
                        else
                        {
                        $image = @imagecreatefromstring($attachment->file); 
                        ob_start();
                        imagejpeg($image, null, 80);
                        $data = ob_get_contents();
                        ob_end_clean();
                        $var  =  '<img src="data:image/jpg;base64,' .  base64_encode($data)  . '" />';
                        $body = str_replace($attachment->name, "data:image/jpg;base64," .  base64_encode($data), $body);

                            $string = $body;                        
                            $start = "<head>";
                            $end = "</head>";
                            if(strpos($string,$start) == false || strpos($string,$start) == false)
                            {
                            }
                            else
                            {
                            $ini = strpos($string,$start);
                            $ini += strlen($start);
                            $len = strpos($string,$end,$ini) - $ini;
                            $parsed = substr($string,$ini,$len);
                            $body2 = $parsed;
                            $body = str_replace($body2 ," " ,$body);
                            }
                        }
                    }
    }
                            $string = $body;                        
                            $start = "<head>";
                            $end = "</head>";                            
                            if(strpos($string,$start) == false || strpos($string,$start) == false)
                            {
                            }
                            else
                            {
                            $ini = strpos($string,$start);
                            $ini += strlen($start);
                            $len = strpos($string,$end,$ini) - $ini;
                            $parsed = substr($string,$ini,$len);
                            $body2 = $parsed;
                            $body = str_replace($body2 ," " ,$body);
                            }
?>

                                <ol class="comment-list" >
                                    <li class="comment">
                                        <article class="comment-body">
                                            <footer class="comment-meta"<?php if($role->role == "user") { ?> style="background-color: hsla(100, 100%, 51%, 0.15)" <?php } else { ?> style="background-color:#FFFCB3" <?php } ?>  > 
                                                <div class="comment-author" >
                                                    <img src="http://faveohelpdesk.com/demo/dist/img/avatar_1.png" alt="" height="50" width="50" class="avatar" <?php if($role->role == "user") { ?>style="box-shadow: 0 1px 3px #00FF26;" <?php } else { ?> style="box-shadow: 0 1px 3px #FFEC00;" <?php } ?> >
                                                    @if($role->role == "user")
                                                        <b class="fn"><a href="#" rel="external" class="url">{{$role->user_name}}</a></b>
                                                    @else
                                                        <b class="fn"><a href="#" rel="external" class="url">{{$role->first_name." ".$role->last_name}}</a></b>
                                                    @endif
                                                </div><!-- .comment-author -->
                                                <div class="comment-metadata">
                                                    <small class="date text-muted">
                                                        <time datetime="2013-10-23T01:50:50+00:00">{{date_format($conversation->created_at, 'd/m/Y H:i:s')}}</time>
                                                    </small>
                                                </div><!-- .comment-metadata -->
                                            </footer><!-- .comment-meta -->
                                            <div class="comment-content">
                                                <p>{!! $body !!}</p>
                                            </div><!-- .comment-content -->
                                        </article><!-- .comment-body -->
                                    </li><!-- .comment -->    
                                </ol>

<?php

                                        ?>
                                        
                                
<?php }
?>
                                        <div class="pull-right">
<?php echo $conversations->setPath( url('check_ticket/{'.$id.'}'))->render(); ?>
</div>
<br/><br/><br/><br/>
<div id="respond" class="comment-respond form-border">
    <h3 id="reply-title" class="comment-reply-title section-title"><i class="line"></i>Leave a Reply</h3>
    {!! Form::open(['route'=>'ticket.reply']) !!}
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group ">
                        <textarea class="form-control" name="comment" cols="30" rows="8"></textarea>
                    </div>
                </div>                                              
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-custom btn-lg">Post Comment</button>
        </div>
    {!! Form::close() !!}
</div>

             

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#close').on('click', function (e) {
        $.ajax({
            type        :   "GET",
            url         :   "http://localhost/faveo/public/ticket/close/{{$tickets->id}}",
            success : function(response) {
                    $( "#refresh" ).load( "http://localhost/faveo/public/thread/{{$tickets->id}}   #refresh");
            }
        })
        return false;
    });

    $('#resolved').on('click', function (e) {
        $.ajax({
            type        :   "GET",
            url         :   "http://localhost/faveo/public/ticket/resolve/{{$tickets->id}}",
            success : function(response) {
                    $( "#refresh" ).load( "http://localhost/faveo/public/thread/{{$tickets->id}}  #refresh");
            }
        })
        return false;
    });

    $('#open').on('click', function (e) {
        $.ajax({
            type        :   "GET",
            url         :   "http://localhost/faveo/public/ticket/open/{{$tickets->id}}",
            success : function(response) {
                    $( "#refresh" ).load( "http://localhost/faveo/public/thread/{{$tickets->id}}   #refresh");
                $('#refresh').load('thread/2 #refresh');
            }
        })
        return false;
    });


});

</script>


@stop

                
                    
                

               