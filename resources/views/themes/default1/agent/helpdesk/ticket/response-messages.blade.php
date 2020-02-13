@if (count($errors) > 0)
<div id="heading"></div>
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div id="response"></div>
<!-- check whether success or not -->
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!!Session::get('warn')!!}
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<!-- fail message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
