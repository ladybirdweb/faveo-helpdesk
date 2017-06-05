@if(is_object($thread))
{!! $thread->inlineAttachment($data,$message) !!}
@else 
{!! $data !!}
@endif