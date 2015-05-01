@extends('themes.default1.Agent.ticket.layout')

@section('nav1')
class="active"
@stop

@section('My')
class="active"
@stop

@section('content')

                <section class="content-header">
                    <h1>
                        Ticket
                        <!-- <small>example</small> -->
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Main content -->
                    <div class="box box-primary">
                        {!! Form::model($ticket_id, ['url' => 'ticket/post/edit/'.$ticket_id->id,'method' => 'PATCH'] )!!}
                            <div class="box-header">
                                <h3 class="box-title">Edit <b>({!! $ticket_id->ticket_number !!})</b>({!! $user->user_name !!})</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="" class="form-control" value="{{$thread_id->title}}">
                                </div>
                                <div class="form-group">
                                    <label>Body</label>
                                    <textarea name="" class="form-control">{!! $thread_id->body !!}</textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        {!! Form::close() !!}

                    
                    
                    </div>
                </section>


@stop