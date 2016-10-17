@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('forms')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.manage')}}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
<div class="box">
    <div class="box-header">
        <div class="box-title">
            {!! Lang::get('lang.forms') !!}
        </div>
        <a href="{!! url('forms/create') !!}" class="pull-right"><button class="btn btn-primary">{!! Lang::get('lang.create_form') !!}</button></a> 
    </div>
    <div class="box-body">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.form_name') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $forms = App\Model\helpdesk\Form\Forms::all();
                ?>
                @foreach($forms as $form)
                <tr>
                    <td>{!! $form->formname !!}</td>
                    <td>
                        <div class="btn-group">
                            {!! link_to_route('forms.edit', Lang::get('lang.edit') ,[$form->id],['id'=>'View','class'=>'btn btn-primary btn-sm']) !!}
                        </div>
                        <div class="btn-group">
                            {!! link_to_route('forms.show', Lang::get('lang.view_this_form') ,[$form->id],['id'=>'View','class'=>'btn btn-primary btn-sm']) !!}
                        </div>
                        <div class="btn-group">
                            {!! link_to_route('forms.add.child', 'Add Child' ,[$form->id],['id'=>'add-child','class'=>'btn btn-primary btn-sm']) !!}
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$form->id}}delete">{!! Lang::get('lang.delete_from') !!}</button>
                        </div>
                        <div class="modal fade" id="{{$form->id}}delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">{!! Lang::get('lang.delete') !!}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{!! Lang::get('lang.are_you_sure_you_want_to_delete') !!} ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{!! Lang::get('lang.close') !!}</button>
                                        {!! link_to_route('forms.delete', Lang::get('lang.delete'),[$form->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
</div>
@stop