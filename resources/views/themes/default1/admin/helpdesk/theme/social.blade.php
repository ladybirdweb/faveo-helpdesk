@extends('themes.default1.admin.layout.admin')

@section('Themes')
active
@stop

@section('theme-bar')
active
@stop

@section('socail')
class="active"
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title">{!! Lang::get('lang.widgets') !!} </h4>
    </div>
    <!-- check whether success or not -->
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b> 
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif
    <div class="box-footer">
        {!! Datatable::table()
            ->addColumn(Lang::get('lang.name'),
                Lang::get('lang.link'),
                Lang::get('lang.action'))  // these are the column headings to be shown
                ->setUrl('list-social-buttons')  // this is the route where data will be retrieved
                ->render() !!}
    </div>
</div>

@stop
