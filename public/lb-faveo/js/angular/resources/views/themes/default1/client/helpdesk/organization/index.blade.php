@extends('themes.default1.agent.layout.agent')

@section('Users')
class="active"
@stop

@section('user-bar')
active
@stop

@section('organizations')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.organizations') !!}</h1>
@stop
<!-- content -->
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">{{Lang::get('lang.organization_list')}}</h2>
        <a href="{{route('organizations.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_organization')}}</a>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        {!!$table->render('vendor.Chumper.template')!!}
    </div>
</div>

<script type="text/javascript">
    function confirmDelete(id) {
        return false;
    }
</script>
{!! $table->script('vendor.Chumper.organization-javascript') !!}
@stop