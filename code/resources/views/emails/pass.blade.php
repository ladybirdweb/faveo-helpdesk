Hello {!! $name !!}, <br/><br/> 

This email is confirmation that you are now registered at our helpdesk. <br/> <br/> 

Registered email: support@ladybirdweb.com<br/>
Password: {{$password}} <br/> <br/> 

You can visit the helpdesk to browse articles and contact us at any time: {!! \URL::route('ticket2') !!}<br/> <br/> 

Thank You.<br/><br/> 

Kind Regards,<br/><br/>

{!! $from !!}