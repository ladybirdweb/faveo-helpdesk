@extends('themes.default1.layouts.login')

@section('body')

            <p class="login-box-msg">Enter E-mail to reset password</p>
            <!-- form open -->
            <form role="form" method="POST" action="{{ url('/password/email') }}">
            <!-- Email -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- Email -->
                    <div class="input-group margin">
                        <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}">
                        <span class="input-group-btn"><button type="submit" class="btn btn-primary btn-block btn-flat">Send</button></span>
                    </div>
            </form>

            <a href="{{url('auth/login')}}" class="text-center">I know my password</a>
<!-- /.login-page -->
@stop
