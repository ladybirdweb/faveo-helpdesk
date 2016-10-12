@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('departments')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{Lang::get('lang.departments')}}</h1>
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
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{!! Lang::get('lang.list_of_departments') !!}</h2><a href="{{route('departments.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_a_department')}}</a></div>
    <div class="box-body table-responsive ">
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('success') !!}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.fails') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('fails') !!}
        </div>
        @endif
        <!-- table -->
        <table class="table table-bordered dataTable" style="overflow:hidden;">
            <tr>
                <th>{{Lang::get('lang.name')}}</th>
                <th>{{Lang::get('lang.type')}}</th>
                <th>{{Lang::get('lang.sla_plan')}}</th>
                <th>{{Lang::get('lang.department_manager')}}</th>
                <th>{{Lang::get('lang.action')}}</th>
            </tr>
            <?php
            $default_department = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
            $default_department = $default_department->department;
            ?>
            @foreach($departments as $department)
            <tr>
                <td><a href="{{route('departments.edit', $department->id)}}"> {{$department -> name }}
                        @if($default_department == $department->id)
                        ( Default )
                        <?php
                        $disable = 'disabled';
                        ?>
                        @else
                        <?php
                        $disable = '';
                        ?>
                        @endif
                    </a></td>
                <td>
                    @if($department->type=='1')
                    <span style="color:green">{!! Lang::get('lang.public') !!}</span>
                    @else
                    <span style="color:red">{!! Lang::get('lang.private') !!}</span>
                    @endif
                </td>
                <?php
                if ($department->manager == 0) {
                    $manager = "";
                } else {
                    $manager = App\User::whereId($department->manager)->first();
                    $manager = $manager->full_name;
                }

                if ($department->sla == null) {
                    $sla = "";
                } else {
                    $sla = App\Model\helpdesk\Manage\Sla_plan::whereId($department->sla)->first();
                    $sla = $sla->grace_period;
                }
                ?>

                <td>{{ $sla }}</td>
                <td>{{ $manager }}</td>
                <td>
                    {!! Form::open(['route'=>['departments.destroy', $department->id],'method'=>'DELETE']) !!}
                    <a href="{{route('departments.edit', $department->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!}</a>
                    {{-- @if($default_department == $department->id) --}}
                    {{-- @else --}}
                    <!-- To pop up a confirm Message -->
                    {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.Lang::get('lang.delete'),
                    ['type' => 'submit',
                    'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
                    'onclick'=>'return confirm("Are you sure?")'])
                    !!}
                    {{-- @endif --}}

                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop