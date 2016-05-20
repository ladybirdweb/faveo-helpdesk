@extends('themes.default1.admin.layout.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
            @endif
            <div class="box-body">
                {!! Form::open(['url'=>'api','method'=>'post','files'=>true]) !!}
                <table class="table table-condensed">
                    <tr>
                        <td><h3 class="box-title">{{Lang::get('lang.webhooks')}}</h3></td>
                        <td>{!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary pull-right'])!!}</td>
                    </tr>
                    <tr>
                        <td><b>{!! Form::label('ticket_detail',Lang::get('lang.ticket_detail'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('ticket_detail') ? 'has-error' : '' }}">
                                {!! Form::text('ticket_detail',$ticket_detail,['class' => 'form-control','placeholder'=>'http://www.example.com']) !!}
                                <p><i> {{Lang::get('lang.enter_url_to_send_ticket_details')}}</i> </p>
                            </div>
                        </td>
                    </tr>
                    {!! Form::close() !!}
                </table>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@stop