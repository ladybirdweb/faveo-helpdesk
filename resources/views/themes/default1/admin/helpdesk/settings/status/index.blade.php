@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.status') !!}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.list_of_status') !!}</h3>
        <div class="box-tools pull-right">
            <a href="{!! URL::route('statuss.create') !!}"><button class="btn btn-primary btn-sm" id="create" title="{!! Lang::get('lang.create') !!}">{!! Lang::get('lang.create') !!}</button></a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <b>{!! Lang::get('lang.success') !!}</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('success') !!}
        </div>
        @endif
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{!! Session::get('fails') !!}</p>
        </div>
        @endif
        <?php
        $status_type = new App\Model\helpdesk\Ticket\TicketStatusType();
        ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{!! Lang::get('lang.name') !!}</th>
                    <th>{!! Lang::get('lang.visible_to_client') !!}</th>
                    <th>{!! Lang::get('lang.purpose_of_status') !!}</th>
                    <th>{!! Lang::get('lang.send_email') !!}</th>
                    <th>{!! Lang::get('lang.order') !!}</th>
                    <th>{!! Lang::get('lang.icon') !!}</th>
                    <th>{!! Lang::get('lang.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuss as $status)
               
                <tr>
                    <td><a href="{!! route('status.edit',$status->id) !!}"> {!! $status->name !!} </a>
                        
                    @if($status->default == 1) 
                        ( {!! Lang::get('lang.Default') . " " . $status_type->where('id', $status->purpose_of_status)->first()->name; !!} )
                    @endif
                    </td>
                    @if ($status->visibility_for_client == 1)
                        <td><button class="btn btn-success btn-xs">{!! Lang::get('lang.yes') !!}</button></td>
                    @elseif ($status->visibility_for_client == 0)
                        <td><button class="btn btn-warning btn-xs">{!! Lang::get('lang.no') !!}</button></td>
                    @endif
                    <td>{!! $status_type->where('id', $status->purpose_of_status)->first()->name; !!}</td>
                    <td>{!! Finder::rolesGroup($status->send_email) !!}</td>
                    <td>{!! $status->order !!}</td>
                    <td><span style="color:{!! $status->icon_color !!}"><i class="{!! $status->icon !!}"></i></span></td>
                    <td>
                        <a href="{!! route('status.edit',$status->id) !!}"><button class="btn btn-info btn-xs"> <i class='fa fa-edit'> </i> {!! Lang::get('lang.edit') !!}</button></a>
                        <button class="btn btn-danger btn-xs" <?php if($status->default == 1 || $status->id == 6) { echo "disabled='disabled'"; } ?> data-toggle="modal" data-target="#{{$status->id}}delete"> <i class='fa fa-trash'> </i> {!! Lang::get('lang.delete') !!}</button>
                        <div class="modal fade" id="{{$status->id}}delete">
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
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        {!! link_to_route('statuss.delete',Lang::get('lang.delete'),[$status->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
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

@stop