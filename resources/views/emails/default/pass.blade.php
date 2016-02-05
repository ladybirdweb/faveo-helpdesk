Hello {!! $name !!}, <br/><br/> 

This email is confirmation that you are now registered at our helpdesk. <br/> <br/> 

Registered Email: {!! $emailadd !!} <br/>
Password: {{$password}} <br/> <br/> 

You can visit the helpdesk to browse articles and contact us at any time: <a href="{!! \URL::route('ticket2') !!}">{!! \URL::route('ticket2') !!}</a><br/> <br/> 

Thank You.<br/><br/> 

Kind Regards,<br/><br/>

{!! $from !!}