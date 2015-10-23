@extends('themes.default1.admin.layout.admin')

@section('Manage')
class="active"
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
                        <i class="fa fa-ban"></i>
                        <b>Alert!</b> Success.
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{Session::get('success')}}
                    </div>
                @endif

            <!-- -->    
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        Forms
                    </div>
                    <a href="{!! url('forms/create') !!}" class="pull-right"><button class="btn btn-primary">Create Form</button></a> 
                </div>
                <div class="box-body">

                   <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Form Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    $forms =App\Model\helpdesk\Form\Forms::all();
    ?>
                            @foreach($forms as $form)
                               
                            <tr>
                                
                                <td>{!! $form->formname !!}</td>

                                
                                 <td>{!! link_to_route('forms.show','View This Form',[$form->id],['id'=>'View','class'=>'btn btn-primary btn-sm']) !!}
                                     
                                     
                                    
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$form->id}}delete">Delete Form</button>
                                                            
                                                            <div class="modal fade" id="{{$form->id}}delete">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title">Delete</h4>
                                      </div>
                                         <div class="modal-body">
                                             <p>Are you sure you want to Delete ?</p>
                                                </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                            {!! link_to_route('forms.delete','Delete',[$form->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
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

<!-- /content -->