<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <!-- <link href="{{asset("downloads/bootstrap.min.css")}}" rel="stylesheet" type="text/css" /> -->
        <link href="{{asset("lb-faveo/aaaaaa/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h2>
            <div class="logo"><b>Faveo</b>HELPDESK</div><hr>	
        </h2>

        <h4>{{$thread->title}}</h4><br/>

<?php   $ticket_source = App\Model\helpdesk\Ticket\Ticket_source::where('id','=',$tickets->source)->first();
        $ticket_source = $ticket_source->value;

        
        
        $user = App\User::where('id', '=', $tickets->user_id)->first(); ?>
        <?php $response = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>
        @foreach($response as $last)
        <?php $ResponseDate = $last->created_at; ?>
        @endforeach

        <?php $status = App\Model\helpdesk\Ticket\Ticket_Status::where('id', '=', $tickets->status)->first(); ?>
        <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $tickets->priority_id)->first(); ?>
        <?php $help_topic = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>
        <?php $help_topic = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $tickets->help_topic_id)->first(); ?>
<?php $dept = App\Model\helpdesk\Agent\Department::where('id','=',$help_topic->department)->first();   ?>
        <table class="table">    
            <tr><th></th><th></th></tr>
            <tr><td><b>Status:</b></td>       	<td>{{$status->state}}</td></tr>
            <tr><td><b>Priority:</b></td>     	<td>{{$priority->priority}}</td></tr>
            <tr><td><b>Department:</b></td>   	<td>{{$dept->name}}</td></tr> 
            <tr><td><b>Email:</b></td>        	<td>{{$user->email}}</td></tr>
            <tr><td><b>Phone:</b></td>        	<td>{{$user->mobile}}</td></tr>
            <tr><td><b>Source:</b></td>         <td>{{$ticket_source}}</td></tr>
            <tr><td><b>Help Topic:</b></td>     <td>{{$help_topic->topic}}</td></tr>
        </table>

        <?php $conversations = App\Model\helpdesk\Ticket\Ticket_Thread::where('ticket_id', '=', $tickets->id)->get(); ?>
        @foreach($conversations as $conversation)
        <br/><hr>
        <span class="time-label">
                                <?php
    $role = App\User::where('id','=',$conversation->user_id)->first();
    ?>
                                <?php if($conversation->is_internal) { ?>
                                <i class="fa fa-tag bg-purple" title="Posted by System"></i>
                                    <?php }else{ if ($role->role == 'agent' || $role->role == 'admin') { ?>
                                    <i class="fa fa-mail-reply-all bg-yellow" title="Posted by Support Team"></i>
                                <?php } elseif ($role->role == 'user') {  ?>
                                    <i class="fa fa-user bg-aqua" title="Posted by Customer"></i>
                                <?php } else { ?>
                                    <i class="fa fa-mail-reply-all bg-purple" title="Posted by System"></i>
    <?php } }
    $attachment = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->first();
    if($attachment == null ) {
        $body = $conversation->body;
    }
    else {
        // dd($attachment->file);
        // print $attachment->file;
        // header("Content-type: image/jpeg");
        // echo "<img src='".base64_decode($attachment->file)."' style='width:128px;height:128px'/> ";
        $body = $conversation->body;

        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->orderBy('id', 'DESC')->get();

        // $i = 0;

                    foreach($attachments as $attachment)
                    {
                        // $i++;
                        if($attachment->type == 'pdf')
                        {
                            // echo "hello";
                        }elseif($attachment->type == 'docx')
                        {
                            // echo "hello";
                        }
                        else
                        {
                        $image = @imagecreatefromstring($attachment->file); 
                        ob_start();
                        imagejpeg($image, null, 80);
                        $data = ob_get_contents();
                        ob_end_clean();
                        $var  =  '<img width="20px" src="data:image/jpg;base64,' .  base64_encode($data)  . '" />';
                        // echo $var;
                        // echo $attachment->name;
                        // $body = explode($attachment->name, $body);
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
                    // echo $body;

        // $body = explode($attachment->file, $body);
        // $body = $body[0];
    }
    ?>

    <?php
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
                                <div class="timeline-item">
                                    <span id="date" class="time"  style="color:#fff;"><i class="fa fa-clock-o"> </i> {{date_format($conversation->created_at, 'd/m/Y H:i:s')}}</span>

                                    <h3 class="timeline-header"  style="background-color:<?php 
                                    if($conversation->is_internal)
                                    {
                                        $color = '#046380'; 
                                        echo $color; 
                                    }
                                    else
                                    {
                                    if ($role->role == 'agent' || $role->role == 'admin') 
                                        { 
                                            $color = '#FFD34E'; 
                                            echo $color; 
                                        } elseif ($role->role == 'user') 
                                        { 
                                            $color = '#00A388'; 
                                            echo $color; 
                                        } else 
                                        { 
                                            $color = '#046380'; 
                                            echo $color; 
                                        } 
                                    }
                                        ?>;
                                        ">
                                        <a href="#" style="color:#fff;"><?php if($role->role == "user") {echo $role->user_name; } else { echo $role->first_name . " " . $role->last_name; } ?> </a><strong>Date:</strong> {!! $thread->created_at !!}<br/></h3>
                                    <div class="timeline-body" style="padding-left:30px;">
                                            {!! $body !!}
                                    </div>
                                    <div class="timeline-footer" >
                                        <?php 
                                        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('thread_id','=',$conversation->id)->get();
                                        $i = 0;
                                        foreach($attachments as $attachment) {
                                        if($attachment->poster == 'ATTACHMENT') {
                                            $i++;
                                            } 
                                        }
                                        if($i>0)
                                        {
                                        echo "<hr style='height:1px;color:#2D3244;background-color:#2D3244;''><h4 class='box-title'><b>".$i." </b> Attachments</h4>";
                                        }
                                        ?>
                                        <ul class='mailbox-attachments clearfix'>
                                        <?php
                                        foreach($attachments as $attachment)
                                        {
                                            if($attachment->poster == 'ATTACHMENT')
                                            {
                                                if($attachment->type == 'jpg'||$attachment->type == 'JPG'||$attachment->type == 'jpeg'||$attachment->type == 'JPEG'||$attachment->type == 'png'||$attachment->type == 'PNG'||$attachment->type == 'gif'||$attachment->type == 'GIF')
                                                {
                                                $image = @imagecreatefromstring($attachment->file); 
                                                ob_start();
                                                imagejpeg($image, null, 80);
                                                $data = ob_get_contents();
                                                ob_end_clean();
                                                $var = '<a href="'.URL::route('image', array('image_id' => $attachment->id)).'" target="_blank"><img style="max-width:200px;max-height:150px;" src="data:image/jpg;base64,' . base64_encode($data)  . '"/></a>';
                                                echo '<li><span class="mailbox-attachment-icon has-img">'.$var.'</span></li>';
                                                }
                                                else
                                                {
                                                $var = '<a href="'.URL::route('image', array('image_id' => $attachment->id)).'" target="_blank">'.$attachment->name.'</a>';
                                                echo '<li>'.$var.'</li>';   
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