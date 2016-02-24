@extends('themes.default1.installer.layout.installer')

@section('license')
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
<div ng-app="myApp">
        <h1 style="text-align: center;">Locale Information</h1>
        {!! Form::open(['url'=>route('postaccount')]) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <!-- checking if the form submit fails -->
        @if($errors->first('firstname')||$errors->first('Lastname')||$errors->first('email')||$errors->first('username')||$errors->first('password')||$errors->first('confirmpassword'))
            <div class="woocommerce-message woocommerce-tracker">
                <div class="fail">
                    @if($errors->first('firstname'))
                        <span id="fail">{!! $errors->first('firstname', ':message') !!}</span><br/>
                    @endif
                    @if($errors->first('Lastname'))
                        <span id="fail">{!! $errors->first('Lastname', ':message') !!}</span><br/>
                    @endif
                    @if($errors->first('email'))
                        <span id="fail">{!! $errors->first('email', ':message') !!}</span><br/>
                    @endif
                    @if($errors->first('username'))
                        <span id="fail">{!! $errors->first('username', ':message') !!}</span><br/>
                    @endif
                    @if($errors->first('password'))
                        <span id="fail">{!! $errors->first('password', ':message') !!}</span><br/>
                    @endif
                    @if($errors->first('confirmpassword'))
                        <span id="fail">{!! $errors->first('confirmpassword', ':message') !!}</span><br/><br/>
                    @endif
                </div>
            </div>        
        @endif

        <!-- checking if the system fails -->
        @if(Session::has('fails'))
            <div class="woocommerce-message woocommerce-tracker">
                <div class="fail">
                    <span id="fail">{{Session::get('fails')}} </span><br/><br/>
                </div>
            </div>
        @endif

    <div ng-controller="MainController">
            <table>
                
                <p>Welcome to the five-minute Faveo installation process! Just fill in the information below.</p>
            
                <h1 style="border-top:1px solid #dedede; border-bottom:1px solid #dedede; padding: 10px 0px 10px 0px;">Personal Information</h1>
                <p>Please provide the following information. Don’t worry, you can always change these settings later.</p>

                <div>
                    <tr>
                        <td>
                            <label for="box1">{!! Lang::get('lang.name') !!}<span style="color
                                : red;font-size:12px;">*</span></label>
                        </td>
                        <td>
                            {!! Form::text('firstname',null,['style' =>'margin-left:250px']) !!}
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Nametitle}}" data-content="@{{Namecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="box2">Last Name<span style="color
                                : red;font-size:12px;">*</span></label>
                        </td>
                        <td>
                            {!! Form::text('Lastname',null,['style' =>'margin-left:250px']) !!}
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Lasttitle}}" data-content="@{{Lastcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="box2">Email<span style="color
                                : red;font-size:12px;">*</span></label>
                        </td>
                        <td>
                            {!! Form::text('email',null,['style' =>'margin-left:250px']) !!}
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Emailtitle}}" data-content="@{{Emailcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>

                </div>

            </table>

            <table>
                <h1>Login Information</h1>
                <div>

                    <tr>
                        <td>
                            <label for="box4">User Name <span style="color
                                    : red;font-size:12px;">*</span>
                            </label>
                        </td>
                        <td>
                            {!! Form::text('username',null,['style' =>'margin-left:195px']) !!}
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{UserNametitle}}" data-content="@{{UserNamecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="box4">Password <span style="color
                                    : red;font-size:12px;">*</span>
                            </label>
                        </td>
                        <td>
                            <input type="password" name="password" style="margin-left: 195px" >
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Passtitle}}" data-content="@{{Passcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="box5">Confirm Password<span style="color
                                    : red;font-size:12px;">*</span>
                            </label>
                        </td>
                        <td>
                            <input type="password" name="confirmpassword" style="margin-left: 195px" >
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Confirmtitle}}" data-content="@{{Confirmcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                </div>
            </table>
            <table>
                <h1>Locale Information</h1>
                <div>
                    <tr>
                        <td>
                            {!! Form::label('date',Lang::get('lang.date_time')) !!}
                        </td>
                        <td>
                            <div class="side-by-side clearfix moveleft">
                                <div>
                                    <select name="datetime" data-placeholder="Choose a date format..." class="chosen-select" style="width:295px;" tabindex="2">
                                        <option value="d/m/Y H:i:s">DD/MM/YYYY H:i:s</option>
                                        <option value="m/d/Y H:i:s">MM/DD/YYYY H:i:s</option>
                                        <option value="Y/m/d H:i:s">YYYY/MM/DD H:i:s</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Datetimetitle}}" data-content="@{{Datetimecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {!! Form::label('time_zone',Lang::get('lang.time_zone')) !!}
                        </td>
                        <td>
                            <div class="side-by-side clearfix moveleft">
                                <div>
                                    <select name="timezone" data-placeholder="Choose a timezone..." class="chosen-select" style="width:295px;" tabindex="2">
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
                                </div>
                            </div>                
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Timezonetitle}}" data-content="@{{Timezonecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {!! Form::label('language',Lang::get('lang.language')) !!}
                        </td>
                        <td>
                            <div class="side-by-side clearfix moveleft">
                            <?php 
                            $path = base_path('resources/lang'); 
                            $values = scandir($path);
                            $values = array_slice($values, 2);
                            ?>  
                                <select name="language" data-placeholder="Choose a timezone..." class="chosen-select" style="width:295px;" tabindex="2">
                                    @foreach($values as $value)
                                        <option value="{!! $value !!}">{!! Config::get('languages.' . $value) !!}</option>
                                    @endforeach
                                </select>
                           </div>
                        </td>
                        <td>
                            <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Languagetitle}}" data-content="@{{Languagecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                            </button>
                        </td>
                    </tr>
                </div>
            </table>
            <br>
            <p class="wc-setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Install">
                <a href="step4.html" class="button button-large button-next" style="float: left">Previous</a>
            </p>
        </form>
    </div>
    </p>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.min.js"></script>
    <script src="{{asset("lb-faveo/js/angular2.js")}}" type="text/javascript"></script>
    </div>
@stop