@extends('themes.default1.installer.layout.installer')

@section('licence')
done
@stop

@section('environment')
done
@stop

@section('database')
done
@stop

@section('locale')
active
@stop

@section('content')

        {!! Form::open(['url'=>route('postaccount')]) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if($errors->first('firstname')||$errors->first('Lastname')||$errors->first('email')||$errors->first('username')||$errors->first('password')||$errors->first('confirmpassword'))
            <blockquote>
                @if($errors->first('firstname'))
                    <li class="error-message-padding">{!! $errors->first('firstname', ':message') !!}</li>
                @endif
                @if($errors->first('Lastname'))
                    <li class="error-message-padding">{!! $errors->first('Lastname', ':message') !!}</li>
                @endif
                @if($errors->first('email'))
                    <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
                @endif
                @if($errors->first('username'))
                    <li class="error-message-padding">{!! $errors->first('username', ':message') !!}</li>
                @endif
                @if($errors->first('password'))
                    <li class="error-message-padding">{!! $errors->first('password', ':message') !!}</li>
                @endif
                @if($errors->first('confirmpassword'))
                    <li class="error-message-padding">{!! $errors->first('confirmpassword', ':message') !!}</li>
                @endif
            </blockquote>        
        @endif
            <table>
                <h1>Personal Information</h1>
                <tr>
                    <td>
                        {!! Form::label('firstname',Lang::get('lang.first_name')) !!}
                    </td>
                    <td> 
                        {!! Form::text('firstname',null,['style' =>'margin-left:250px']) !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('Last Name',Lang::get('lang.last_name')) !!}
                    </td>
                    <td>
                        {!! Form::text('Lastname',null,['style' =>'margin-left:250px']) !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('email',Lang::get('lang.email')) !!}
                    </td>
                    <td>
                        {!! Form::text('email',null,['style' =>'margin-left:250px']) !!}
                    </td>
                </tr>
            </table>

            <table>
                <h1>Login Information</h1>
                <tr>
                    <td>
                        {!! Form::label('user_name',Lang::get('lang.user_name')) !!}
                    </td>
                    <td>
                        {!! Form::text('username',null,['style' =>'margin-left:200px']) !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('Password',Lang::get('lang.password')) !!}
                    </td>
                    <td>
                        <div style="margin-left:50px;">
                            {!! Form::password('password',null,[]) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('confirmpassword',Lang::get('lang.confirm_password')) !!}
                    </td>
                    <td>
                        <div style="margin-left:50px;">
                            {!! Form::password('confirmpassword',null,[]) !!}
                        </div>
                    </td>
                </tr>            
            </table>

            <table id="datepairExample">
                <h1>Local Information</h1>
                <tr>
                    <td>
                        {!! Form::label('language',Lang::get('lang.language')) !!}
                    </td>
                    <td>
                        <select style="margin-left: 170px" name="language">
                            <option value="English(India)">English(India)</option>
                            <option value="English(U.k)">English(U.K)</option>
                        </select>
                    </td>
                </tr>    
                <tr>
                    <td>
                        {!! Form::label('time_zone',Lang::get('lang.time_zone')) !!}
                    </td>
                    <td>
                        <select name="timezone" style="margin-left: 170px">
                            <option value="US/Samoa">US/Samoa</option>
                            <option value="US/Hawaii">US/Hawaii</option>
                            <option value="US/Alaska">US/Alaska</option>
                            <option value="US/Pacific">US/Pacific</option>
                            <option value="America/Tijuana">America/Tijuana</option>
                            <option value="US/Arizona">US/Arizona</option>
                            <option value="US/Mountain">US/Mountain</option>
                            <option value="America/Chihuahua">America/Chihuahua</option>
                            <option value="America/Mazatlan">America/Mazatlan</option>
                            <option value="America/Mexico_City">America/Mexico_City</option>
                            <option value="America/Monterrey">America/Monterrey</option>
                            <option value="Canada/Saskatchewan">Canada/Saskatchewan</option>
                            <option value="US/Central">US/Central</option>
                            <option value="US/Eastern">US/Eastern</option>
                            <option value="US/East-Indiana">US/East-Indiana</option>
                            <option value="America/Bogota">America/Bogota</option>
                            <option value="America/Lima">America/Lima</option>
                            <option value="America/Caracas">America/Caracas</option>
                            <option value="Canada/Atlantic">Canada/Atlantic</option>
                            <option value="America/La_Paz">America/La_Paz</option>
                            <option value="America/Santiago">America/Santiago</option>
                            <option value="Canada/Newfoundland">Canada/Newfoundland</option>
                            <option value="America/Buenos_Aires">America/Buenos_Aires</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Atlantic/Stanley">Atlantic/Stanley</option>
                            <option value="Atlantic/Azores">Atlantic/Azores</option>
                            <option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde</option>
                            <option value="Africa/Casablanca">Africa/Casablanca</option>
                            <option value="Europe/Dublin">Europe/Dublin</option>
                            <option value="Europe/Lisbon">Europe/Lisbon</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Africa/Monrovia">Africa/Monrovia</option>
                            <option value="Europe/Amsterdam">Europe/Amsterdam</option>
                            <option value="Europe/Belgrade">Europe/Belgrade</option>
                            <option value="Europe/Berlin">Europe/Berlin</option>
                            <option value="Europe/Bratislava">Europe/Bratislava</option>
                            <option value="Europe/Brussels">Europe/Brussels</option>
                            <option value="Europe/Budapest">Europe/Budapest</option>
                            <option value="Europe/Copenhagen">Europe/Copenhagen</option>
                            <option value="Europe/Ljubljana">Europe/Ljubljana</option>
                            <option value="Europe/Madrid">Europe/Madrid</option>
                            <option value="Europe/Paris">Europe/Paris</option>
                            <option value="Europe/Prague">Europe/Prague</option>
                            <option value="Europe/Rome">Europe/Rome</option>
                            <option value="Europe/Sarajevo">Europe/Sarajevo</option>
                            <option value="Europe/Skopje">Europe/Skopje</option>
                            <option value="Europe/Stockholm">Europe/Stockholm</option>
                            <option value="Europe/Vienna">Europe/Vienna</option>
                            <option value="Europe/Warsaw">Europe/Warsaw</option>
                            <option value="Europe/Zagreb">Europe/Zagreb</option>
                            <option value="Europe/Athens">Europe/Athens</option>
                            <option value="Europe/Bucharest">Europe/Bucharest</option>
                            <option value="Africa/Cairo">Africa/Cairo</option>
                            <option value="Africa/Harare">Africa/Harare</option>
                            <option value="Europe/Helsinki">Europe/Helsinki</option>
                            <option value="Europe/Istanbul">Europe/Istanbul</option>
                            <option value="Asia/Jerusalem">Asia/Jerusalem</option>
                            <option value="Europe/Kiev">Europe/Kiev</option>
                            <option value="Europe/Minsk">Europe/Minsk</option>
                            <option value="Europe/Riga">Europe/Riga</option>
                            <option value="Europe/Sofia">Europe/Sofia</option>
                            <option value="Europe/Tallinn">Europe/Tallinn</option>
                            <option value="Europe/Vilnius">Europe/Vilnius</option>
                            <option value="Asia/Baghdad">Asia/Baghdad</option>
                            <option value="Asia/Kuwait">Asia/Kuwait</option>
                            <option value="Africa/Nairobi">Africa/Nairobi</option>
                            <option value="Asia/Riyadh">Asia/Riyadh</option>
                            <option value="Asia/Tehran">Asia/Tehran</option>
                            <option value="Europe/Moscow">Europe/Moscow</option>
                            <option value="Asia/Baku">Asia/Baku</option>
                            <option value="Europe/Volgograd">Europe/Volgograd</option>
                            <option value="Asia/Muscat">Asia/Muscat</option>
                            <option value="Asia/Tbilisi">Asia/Tbilisi</option>
                            <option value="Asia/Yerevan">Asia/Yerevan</option>
                            <option value="Asia/Kabul">Asia/Kabul</option>
                            <option value="Asia/Karachi">Asia/Karachi</option>
                            <option value="Asia/Tashkent">Asia/Tashkent</option>
                            <option value="Asia/Kolkata">Asia/Kolkata</option>
                            <option value="Asia/Kathmandu">Asia/Kathmandu</option>
                            <option value="Asia/Yekaterinburg">Asia/Yekaterinburg</option>
                            <option value="Asia/Almaty">Asia/Almaty</option>
                            <option value="Asia/Dhaka">Asia/Dhaka</option>
                            <option value="Asia/Novosibirsk">Asia/Novosibirsk</option>
                            <option value="Asia/Bangkok">Asia/Bangkok</option>
                            <option value="Asia/Ho_Chi_Minh">Asia/Ho_Chi_Minh</option>
                            <option value="Asia/Jakarta">Asia/Jakarta</option>
                            <option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk</option>
                            <option value="Asia/Chongqing">Asia/Chongqing</option>
                            <option value="Asia/Hong_Kong">Asia/Hong_Kong</option>
                            <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur</option>
                            <option value="Australia/Perth">Australia/Perth</option>
                            <option value="Asia/Singapore">Asia/Singapore</option>
                            <option value="Asia/Taipei">Asia/Taipei</option>
                            <option value="Asia/Ulaanbaatar">Asia/Ulaanbaatar</option>
                            <option value="Asia/Urumqi">Asia/Urumqi</option>
                            <option value="Asia/Irkutsk">Asia/Irkutsk</option>
                            <option value="Asia/Seoul">Asia/Seoul</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                            <option value="Australia/Adelaide">Australia/Adelaide</option>
                            <option value="Australia/Darwin">Australia/Darwin</option>
                            <option value="Asia/Yakutsk">Asia/Yakutsk</option>
                            <option value="Australia/Brisbane">Australia/Brisbane</option>
                            <option value="Australia/Canberra">Australia/Canberra</option>
                            <option value="Pacific/Guam">Pacific/Guam</option>
                            <option value="Australia/Hobart">Australia/Hobart</option>
                            <option value="Australia/Melbourne">Australia/Melbourne</option>
                            <option value="Pacific/Port_Moresby">Pacific/Port_Moresby</option>
                            <option value="Australia/Sydney">Australia/Sydney</option>
                            <option value="Asia/Vladivostok">Asia/Vladivostok</option>
                            <option value="Asia/Magadan">Asia/Magadan</option>
                            <option value="Pacific/Auckland">Pacific/Auckland</option>
                            <option value="Pacific/Fiji">Pacific/Fiji</option>
                        </select>

                    </td>
                </tr>    
                <tr>
                    <td>
                        {!! Form::label('date',Lang::get('lang.date_time')) !!}
                    </td>
                    <td>
                        <select name="datetime" style="margin-left: 170px">
                            <option value="d/m/Y H:i:s">DD/MM/YYYY H:i:s</option>
                            <option value="m/d/Y H:i:s">MM/DD/YYYY H:i:s</option>
                            <option value="Y/m/d H:i:s">YYYY/MM/DD H:i:s</option>
                        </select>
                    </td>
                </tr>    
            </table>

            <br>
            <p class="wc-setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Install">
                <a href="step4.html" class="button button-large button-next"  style="float: left">Previous</a>
            </p>
        {!! Form::token() !!}
        {!! Form::close() !!}

@stop