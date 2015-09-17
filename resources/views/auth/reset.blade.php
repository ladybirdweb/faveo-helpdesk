@extends('themes.default1.layouts.login')

@section('body')
                <p class="login-box-msg">Reset Password</p>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Email -->
                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}">
                                {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <!-- password -->
                        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <!-- confirm password -->
                        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                {!! $errors->first('password_confirmation', '<spam class="help-block">:message</spam>') !!}
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        </div>

            <!-- Confirm password -->

                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-flat">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            
@stop
