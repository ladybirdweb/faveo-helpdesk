<!DOCTYPE html>
<html>
    <head>
        <title>PDF</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            * {
                font-family: "DejaVu Sans Mono", monospace;
            }
        </style>
    </head>
    <body>
        <h2>
            <div id="logo" class="site-logo text-center" style="font-size: 30px;">
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
                ?>
                <center>
                    @if($system->url)
                    <a href="{!! $system->url !!}" rel="home">
                        @else
                        <a href="{{url('/')}}" rel="home" style="text-decoration:none;">
                            @endif
                            @if($company->use_logo == 1)
                            <img src="{!! public_path().'/uploads/company'.'/'.$company->logo !!}" width="100px;"/>
                            @else
                            @if($system->name)
                            {!! $system->name !!}
                            @else
                            <b>SUPPORT</b> CENTER
                            @endif
                            @endif
                        </a>
                </center>
            </div>
        </h2>
        <hr>
        <h4>{!! $thread->title !!}</h4><br/>

        <?php
        $ticket_source = App\Model\helpdesk\Ticket\Ticket_source::where('id', '=', $tickets->source)->first();
        $ticket_source = $ticket_source->value;

        $user = App\User::where('id', '=', $tickets->user_id)->first();
        ?>
        <?php $response = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>
        @foreach($response as $last)
        <?php $ResponseDate = $last->created_at; ?>
        @endforeach

        <?php $status = App\Model\helpdesk\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first(); ?>
        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first(); ?>
        <?php $help_topic = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>
        <?php $help_topic = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>
        <?php $dept = App\Model\helpdesk\Agent\Department::where('id', '=', $help_topic->department)->first(); ?>
        <table class="table">    
            <tr><th></th><th></th></tr>
            <tr><td><b>{!! Lang::get('lang.status') !!}:</b></td>       	<td>{{$status->state}}</td></tr>
            <tr><td><b>{!! Lang::get('lang.priority') !!}:</b></td>     	<td>{{$priority->priority}}</td></tr>
            <tr><td><b>{!! Lang::get('lang.department') !!}:</b></td>   	<td>{{$dept->name}}</td></tr> 
            <tr><td><b>{!! Lang::get('lang.email') !!}:</b></td>        	<td>{{$user->email}}</td></tr>
            <tr><td><b>{!! Lang::get('lang.phone') !!}:</b></td>        	<td>{{$user->mobile}}</td></tr>
            <tr><td><b>{!! Lang::get('lang.source') !!}:</b></td>         <td>{{$ticket_source}}</td></tr>
            <tr><td><b>{!! Lang::get('lang.help_topic') !!}:</b></td>     <td>{{$help_topic->topic}}</td></tr>
        </table>

        <?php $conversations = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->orderBy('created_at', 'desc')->paginate(10); ?>
        @foreach($conversations as $conversation)
        <br/><hr>
        <span class="time-label">
            @if($conversation->user_id != null) 
                <?php
                
                $role = App\User::where('id', '=', $conversation->user_id)->first();
                ?>
            
                <?php if ($conversation->is_internal) { ?>
                    <i class="fa fa-tag bg-purple" title="Posted by System"></i>
                    <?php
                } else {
                    if ($role->role == 'agent' || $role->role == 'admin') {
                        ?>
                        <i class="fa fa-mail-reply-all bg-yellow" title="Posted by Support Team"></i>
                    <?php } elseif ($role->role == 'user') { ?>
                        <i class="fa fa-user bg-aqua" title="Posted by Customer"></i>
                    <?php } else { ?>
                        <i class="fa fa-mail-reply-all bg-purple" title="Posted by System"></i>
                        <?php
                    }
                }
                ?>
            @endif
            <?php
            $attachment = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $conversation->id)->first();
            if ($attachment == null) {
                $body = $conversation->body;
            } else {
                // dd($attachment->file);
                // print $attachment->file;
                // header("Content-type: image/jpeg");
                // echo "<img src='".base64_decode($attachment->file)."' style='width:128px;height:128px'/> ";
                $body = $conversation->body;
                $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $conversation->id)->where('poster', '=', 'INLINE')->get();

                foreach ($attachments as $attachment) {

                    if ($attachment->type == 'pdf' || $attachment->type == 'PDF') {
                        // echo "hello";
                    } elseif ($attachment->type == 'docx' || $attachment->type == 'DOCX') {
                        // echo "hello";
                    } elseif ($attachment->type == 'html' || $attachment->type == 'HTML') {
                        // echo "hello";
                    } elseif ($attachment->type == 'zip' || $attachment->type == 'ZIP') {
                        // echo "hello";
                    } else {
                        try {
                            $image = @imagecreatefromstring($attachment->file);
                            ob_start();
                            imagejpeg($image, null, 80);
                            $data = ob_get_contents();
                            ob_end_clean();
                            $var = '<img width="20px" src="data:image/jpg;base64,' . base64_encode($data) . '" />';
                            // echo $var;
                            // echo $attachment->name;
                            // $body = explode($attachment->name, $body);
                            $body = str_replace($attachment->name, "data:image/jpg;base64," . base64_encode($data), $body);

                            $string = $body;
                            $start = "<head>";
                            $end = "</head>";
                            if (strpos($string, $start) == false || strpos($string, $start) == false) {
                                
                            } else {
                                $ini = strpos($string, $start);
                                $ini += strlen($start);
                                $len = strpos($string, $end, $ini) - $ini;
                                $parsed = substr($string, $ini, $len);
                                $body2 = $parsed;
                                $body = str_replace($body2, " ", $body);
                            }
                        } catch (\Exception $e) {
                            
                        }
                    }
                }
                // echo $body;
                // $body = explode($attachment->file, $body);
                // $body = $body[0];
//                }
            }
            ?>

            <?php
            $string = $body;
            $start = "<head>";
            $end = "</head>";
            if (strpos($string, $start) == false || strpos($string, $start) == false) {
                
            } else {
                $ini = strpos($string, $start);
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                $parsed = substr($string, $ini, $len);
                $body2 = $parsed;
                $body = str_replace($body2, " ", $body);
            }
            ?>
            <div class="timeline-item">
                <!--<span id="date" class="time"  style="color:#fff;"><i class="fa fa-clock-o"> </i> {{date_format($conversation->created_at, 'd/m/Y H:i:s')}}</span>-->

                <h3 class="timeline-header"  style="background-color:<?php
                if ($conversation->is_internal) {
                    $color = '#046380';
                    echo $color;
                } else {
                    if ($role->role == 'agent' || $role->role == 'admin') {
                        $color = '#FFD34E';
                        echo $color;
                    } elseif ($role->role == 'user') {
                        $color = '#00A388';
                        echo $color;
                    } else {
                        $color = '#046380';
                        echo $color;
                    }
                }
                ?>;
                    ">
                    <a href="#" style="text-decoration:none; color:#fff;"><?php
                    if($conversation->user_id != null) {
                        if ($role->role == "user") {
                            echo $role->user_name;
                        } else {
                            echo $role->first_name . " " . $role->last_name;
                        }
                    } else { echo Lang::get('lang.system'); }   ?> </a><strong>{!! Lang::get('lang.date') !!}:</strong> {!! $thread->created_at !!}<br/></h3>
                <div class="timeline-body" style="padding-left:30px;">
                    {!! $body !!}
                </div>
                <div class="timeline-footer" >
                    <?php
                    $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id', '=', $conversation->id)->get();
                    $i = 0;
                    foreach ($attachments as $attachment) {
                        if ($attachment->poster == 'ATTACHMENT') {
                            $i++;
                        }
                    }
                    if ($i > 0) {
                        echo "<hr style='height:1px;color:#2D3244;background-color:#2D3244;''><h4 class='box-title'><b>" . $i . " </b> Attachments</h4>";
                    }
                    ?>
                    <ul class='mailbox-attachments clearfix'>
                        <?php
                        foreach ($attachments as $attachment) {
                            if ($attachment->poster == 'ATTACHMENT') {
                                try {
                                    if ($attachment->type == 'jpg' || $attachment->type == 'JPG' || $attachment->type == 'jpeg' || $attachment->type == 'JPEG' || $attachment->type == 'png' || $attachment->type == 'PNG' || $attachment->type == 'gif' || $attachment->type == 'GIF') {
                                        $image = @imagecreatefromstring($attachment->file);
                                        ob_start();
                                        imagejpeg($image, null, 80);
                                        $data = ob_get_contents();
                                        ob_end_clean();
                                        $var = '<a href="' . URL::route('image', array('image_id' => $attachment->id)) . '" target="_blank"><img style="max-width:200px;max-height:150px;" src="data:image/jpg;base64,' . base64_encode($data) . '"/></a>';
                                        echo '<li><span class="mailbox-attachment-icon has-img">' . $var . '</span></li>';
                                    } else {
                                        $var = '<a href="' . URL::route('image', array('image_id' => $attachment->id)) . '" target="_blank">' . $attachment->name . '</a>';
                                        echo '<li>' . $var . '</li>';
                                    }
                                } catch (\Exception $e) {
                                    
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            @endforeach
    </body>
</html>