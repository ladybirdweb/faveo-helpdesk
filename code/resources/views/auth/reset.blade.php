@extends('themes.default1.layouts.login')

@section('body')
        @if(Session::has('status'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> <b> {!! Lang::get('lang.success') !!} </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('status')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
        @endif
                <p class="login-box-msg">{!! Lang::get('lang.reset_password') !!}</p>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Email -->
                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="email" class="form-control" name="email" placeholder="{!! Lang::get('lang.e-mail') !!}" value="{{ old('email') }}">
                                {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <!-- password -->
                        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" name="password" placeholder="Lang::get('lang.password')">
                                {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <!-- confirm password -->
                        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Lang::get('lang.confirm_password')">
                                {!! $errors->first('password_confirmation', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        </div>

            <!-- Confirm password -->

                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-flat">
                                    {!! Lang::get('lang.reset_password') !!}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            
@stop
