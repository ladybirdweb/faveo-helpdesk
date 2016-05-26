
@if($data->count()>0)
@foreach($data as $notify)
@if($notify->value)
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! ucfirst($notify->value) !!}
</div>
@endif
@endforeach
@endif
