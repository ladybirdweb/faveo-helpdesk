---Reply above this line---<br/><br/>

<?php
if(isset($content)) {
?>

<h4 style="background-color:#F3F3F3;padding:20px;border:1px;border-radius:7px;">{!! $content !!}<br/><br/>{!! $sign !!}</h4>
You can check the status of or update this ticket online at: <a href="{!! \URL::route('ticket2') !!}">{!! \URL::route('ticket2') !!}</a><br/><br/>

<?php 
} else { 
?>

Hello {!!$name!!} <br/><br/>
Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br/><br/>
Ticket ID: <b>{!!$ticket_number!!}</b><br/>
{{-- Subject: <b>Ticket Subject</b><br/> --}}
{{-- Department: <b>Support</b><br/> --}}
{{-- Status: <b>Open</b><br/> --}}
{{-- Priority: <b>Normal</b><br/><br/> --}}
{!! $sign !!}
You can check the status of or update this ticket online at: <a href="{!! \URL::route('ticket2') !!}">{!! \URL::route('ticket2') !!}</a><br/><br/>
Thank You.<br/><br/>
Kind Regards,<br/><br/>
{!! $sign !!}

<?php 
}
?>