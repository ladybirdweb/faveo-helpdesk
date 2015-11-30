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

<!-- content -->
@section('content')

<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{{Lang::get('lang.organization')}}</h2><a href="{{route('organizations.create')}}" class="btn btn-primary pull-right">{{Lang::get('lang.create_organization')}}</a></div>
    <div class="box-body table-responsive no-padding">
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
            <b>Alert!</b> Failed.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
<?php
$orgs = App\Model\helpdesk\Agent_panel\Organization::orderBy('id', 'ASC')->paginate(20);
?>
        <table class="table table-hover" style="overflow:hidden;">
            <tr>
                <th width="100px">{{Lang::get('lang.name')}}</th>
                <th width="100px">{{Lang::get('lang.phone')}}</th>
                <th width="100px">{{Lang::get('lang.website')}}</th>
                <th width="100px">{{Lang::get('lang.action')}}</th>
            </tr>
            @foreach($orgs as $org)
            <tr>
                <td><a href="{{route('organizations.show', $org->id)}}"> {{$org->name }}</a></td>
                
                <td>{{ $org->phone }}</td>
                <td>{{ $org->website }}</td>
                <td>
                    {!! Form::open(['route'=>['organizations.destroy', $org->id],'method'=>'DELETE']) !!}

                    <div class="">
                        <a href="{{route('organizations.edit', $org->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!}</a>
                        <!-- To pop up a confirm Message -->
                        {!! Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.Lang::get('lang.edit'),
                        ['type' => 'submit',
                        'class'=> 'btn btn-warning btn-xs btn-flat',
                        'onclick'=>'return confirm("Are you sure?")'])
                        !!}

                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>
        <div class="pull-right">
                <?php echo $orgs->setPath(url('/organizations'))->render();?>&nbsp;
            </div>
    </div>
</div>


@section('FooterInclude')

@stop
@stop
<!-- /content -->
@stop
@section('FooterInclude')

@stop

<!-- /content -->