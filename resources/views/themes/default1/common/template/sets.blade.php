@extends('themes.default1.admin.layout.admin')

@section('Emails')
class="nav-link active"
@stop

@section('email-menu-parent')
class="nav-item menu-open"
@stop

@section('email-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('template')
class="nav-link active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.template_set') !!}</h1>
@stop

@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif

@if(Session::has('failed'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b>{!! Lang::get('lang.alert') !!} !</b> <br>
    <li>{{Session::get('failed')}}</li>
</div>
@endif

<div class="card card-light">
    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.list_of_templates_sets') !!}</h3>
        <div class="card-tools">
            <button class="btn btn-default btn-tool" data-toggle="modal" data-target="#create" title="Create" id="2create">
                <i class="fas fa-plus"> </i> Create
            </button>
        </div>
    </div><!-- /.box-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.name') !!}</th>
                    <th>{!! Lang::get('lang.status') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sets as $set)
                <tr>
                    <td>{!! $set->name !!}</td>
                    <?php
                    $status = DB::table('settings_email')->first();
                    if (strpos($status->template, '_') !== false) {
                        $ratName = str_replace('_', ' ', $status->template);
                    } else {
                        $ratName = $status->template;
                    }
                    ?>
                    <td>
                        @if($ratName == $set->name)
                        <a style='color:green'>Active</a>
                         @else()
                          <a style='color:red'>Inactive</a>
                          @endif

                       
                    <td>
                        <?php
                        $settings = DB::table('settings_email')->whereId(1)->first();
                        if ($set->name == $settings->template) {
                            $dis = "disabled";
                        } else {
                            $dis = "";
                        }
                        ?>
                        @if($set->name == $settings->template)
                       <button class="btn btn-success btn-sm {!! $dis !!}" data-toggle="modal" data-target="">{!! Lang::get('lang.activate_this_set') !!}</button>
                        @else()
                        {!! link_to_route('active.template-set',Lang::get('lang.activate_this_set'),[$set->name],['class'=>'btn btn-success btn-sm $dis']) !!}
                         @endif

                        {!! link_to_route('show.templates',Lang::get('lang.show'),[$set->id],['class'=>'btn btn-success btn-sm']) !!}
                        <div class="modal fade" id="{{$set->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {!! Form::model($set,['route'=>['template-sets.update', $set->id],'method'=>'PATCH','files' => true]) !!}
                                    <div class="modal-header">
                                        <h4 class="modal-title">{!! Lang::get('lang.edit_details') !!}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="form-control">
                                                <label for="title">Name:</label><br>
                                                {!! Form::text('name',null,['class'=>'form-control'])!!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        {!! Form::submit('Update Details',['class'=>'btn btn-primary'])!!}
                                    </div>
                                    {!! Form::close() !!}
                                </div> 
                            </div>
                        </div>
                        <?php
                        $settings = DB::table('settings_email')->whereId(1)->first();
                        if ($set->name == $settings->template) {
                            $dis = "disabled";
                        } else {
                            $dis = "";
                        }
                        ?>
                        <button class="btn btn-danger btn-sm {!! $dis !!}" data-toggle="modal" data-target="#delete{{$set->id}}">{!! Lang::get('lang.delete') !!}</button>
                        <div class="modal fade" id="delete{{$set->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{!! Lang::get('lang.delete') !!}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <span>Are you sure you want to Delete ?</span>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        {!! link_to_route('sets.delete',Lang::get('lang.delete'),[$set->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                    </div>
                                </div> 
                            </div>
                        </div> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>

<div class="modal fade" id="create" class="modal fade in {{ $errors->has('name') ? 'has-error' : '' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route'=>'template-sets.store']) !!}
            <div class="modal-header">
                <h4 class="modal-title">{!! Lang::get('lang.create') !!}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissable">
                    <i class="fas fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <b>{!! Lang::get('lang.alert') !!} !</b><br>
                    <li style="list-style: none">{{ $error }}</li>
                </div>
                @if($error == "The name field is required.")
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#2create").click();
                    });
                </script>
                @endif
                @endforeach 
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="title">{!! Lang::get('lang.name') !!}:<span style="color:red;">*</span></label><br>
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{!! Lang::get('lang.close') !!}</button>
                {!! Form::submit(Lang::get('lang.create_set'),['class'=>'btn btn-primary'])!!}
            </div>
            {!! Form::close() !!}
        </div> 
    </div>
</div>  
<!-- set script -->
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
@stop