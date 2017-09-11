@extends('themes.default1.layouts.master')
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
                <i class="fa fa-ban"></i>
                <b>{{trans('message.alert')}}!</b> {{trans('message.success')}}.
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('success')}}
            </div>
            @endif
            <!-- fail message -->
            @if(Session::has('fails'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>{{trans('message.alert')}}!</b> {{trans('message.failed')}}.
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{Session::get('fails')}}
            </div>
            @endif

            <div class="box-body no-padding">
                {!! Form::model($setting,['url'=>'settings','method'=>'patch','files'=>true]) !!}

                <table class="table table-condensed">

                    <tr>
                        <td><h3 class="box-title">{{trans('message.company')}}</h3></td>
                        <td>{!! Form::submit(trans('message.update'),['class'=>'btn btn-primary pull-right'])!!}</td>

                    </tr>

                    <tr>

                        <td><b>{!! Form::label('company',trans('message.company'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">


                                {!! Form::text('company',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-the-company-name')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('website',trans('message.website')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">


                                {!! Form::text('website',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-the-company-website')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('phone',trans('message.phone')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">


                                {!! Form::text('phone',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-the-company-phone-number')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('address',trans('message.address'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">

                                {!! Form::textarea('address',null,['class' => 'form-control','size' => '128x10','id'=>'address']) !!}
                                <p><i> {{trans('message.enter-company-address')}}</i> </p>
                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('logo',trans('message.logo')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">

                                {!! Form::file('logo') !!}
                                <p><i> {{trans('message.enter-the-company-logo')}}</i> </p>
                                @if($setting->logo) 
                                <img src="{{asset('cart/img/logo/'.$setting->logo)}}" class="img-thumbnail" style="height: 100px;">
                                @endif
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td><h3 class="box-title">{{trans('message.smtp')}}</h3></td>
                        <td></td>
                    </tr>
                    <tr>

                        <td><b>{!! Form::label('driver',trans('message.driver'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">


                                {!! Form::select('driver',['mail'=>'Mail','smtp'=>'SMTP'],null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.select-email-driver')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('port',trans('message.port')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('port') ? 'has-error' : '' }}">


                                {!! Form::text('port',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-email-port')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('host',trans('message.host')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('host') ? 'has-error' : '' }}">


                                {!! Form::text('host',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-email-host')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('encryption',trans('message.encryption')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('encryption') ? 'has-error' : '' }}">

                                {!! Form::text('encryption',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.select-email-encryption-method')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('email',trans('message.email'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                                {!! Form::text('email',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-email')}}</i> </p>

                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('password',trans('message.password'),['class'=>'required']) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">

                                {!! Form::password('password',['class' => 'form-control']) !!}
                                <p><i> {{trans('message.enter-email-password')}}</i> </p>

                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td><h3 class="box-title">{{trans('message.error-log')}}</h3></td>
                        <td></td>
                    </tr>

                    <tr>

                        <td><b>{!! Form::label('error_log',trans('message.error-log')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('error_log') ? 'has-error' : '' }}">


                                {!! Form::radio('error_log','1',true) !!}<span>   {{trans('message.yes')}}</span>
                                {!! Form::radio('error_log','0') !!}<span>   {{trans('message.no')}}</span>
                                <p><i> {{trans('message.enable-error-logging')}}</i> </p>


                            </div>
                        </td>

                    </tr>

                    <tr>

                        <td><b>{!! Form::label('error_email',trans('message.error-email')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('error_email') ? 'has-error' : '' }}">


                                {!! Form::text('error_email',null,['class' => 'form-control']) !!}
                                <p><i> {{trans('message.provide-error-reporting-email')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    
                    <tr>
                        <td><h3 class="box-title">{{trans('message.templates')}}</h3></td>
                        <td></td>
                    </tr>

                    <tr>

                        <td><b>{!! Form::label('welcome_mail',trans('message.welcome-mail')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('welcome_mail') ? 'has-error' : '' }}">


                                {!! Form::select('welcome_mail',['Templates'=>$template->where('type',1)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-welcome-mail-template')}}</i> </p>


                            </div>
                        </td>

                    </tr>

                    <tr>

                        <td><b>{!! Form::label('order_mail',trans('message.order-mail')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('order_mail') ? 'has-error' : '' }}">


                                {!! Form::select('order_mail',['Templates'=>$template->where('type',7)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-order-mail-template')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('forgot_password',trans('message.forgot-password')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('forgot_password') ? 'has-error' : '' }}">


                                {!! Form::select('forgot_password',['Templates'=>$template->where('type',2)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-forgot-password-mail-template')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('subscription_going_to_end',trans('message.subscription-going-to-end')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('subscription_going_to_end') ? 'has-error' : '' }}">


                                {!! Form::select('subscription_going_to_end',['Templates'=>$template->where('type',4)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-subscription-going-to-end-notification-email-template')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('subscription_over',trans('message.subscription-over')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('subscription_over') ? 'has-error' : '' }}">


                                {!! Form::select('subscription_over',['Templates'=>$template->where('type',5)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-mail-template-to-notify-subscription-has-over')}}</i> </p>


                            </div>
                        </td>

                    </tr>
                    <tr>

                        <td><b>{!! Form::label('cart',trans('message.cart')) !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('cart') ? 'has-error' : '' }}">


                                {!! Form::select('cart',['Templates'=>$template->where('type',3)->lists('name','id')->toArray()],null,['class'=>'form-control']) !!}
                                <p><i> {{trans('message.choose-shoping-cart-template')}}</i> </p>


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