@extends('themes.default1.layouts.login')
@section('body')

            <h4 class="login-box-msg">Registration</h4>

        @if(Session::has('status'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> <b> Success </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('status')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> Alert! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
        @endif


            <!-- form open -->
            {!!  Form::open(['action'=>'Auth\AuthController@postRegister', 'method'=>'post']) !!}

            <!-- fullname -->
            <div class="form-group has-feedback {{ $errors->has('full_name') ? 'has-error' : '' }}">

                {!! Form::text('full_name',null,['placeholder'=>'Full Name','class' => 'form-control']) !!}
                {!! $errors->first('full_name', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

            </div>

            <!-- Email -->
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">

                {!! Form::text('email',null,['placeholder'=>'Email','class' => 'form-control']) !!}
                {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            </div>

            <!-- Password -->
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::password('password',['placeholder'=>'Password','class' => 'form-control']) !!}
                {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <!-- Confirm password -->
            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {!! Form::password('password_confirmation',['placeholder'=>'Retype Password','class' => 'form-control']) !!}
                {!! $errors->first('password_confirmation', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>




            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div><!-- /.col -->
            </div>



            <a href="{{url('auth/login')}}" class="text-center">I already have a membership</a>
    {!! Form::close()!!}



    @stop


