@extends('themes.default1.installer.layout.installer')

@section('content')
<style type="text/css">
  select {
    width:150px;
    border:1px solid red;
    -webkit-border-top-right-radius: 15px;
    -webkit-border-bottom-right-radius: 15px;
    -moz-border-radius-topright: 15px;
    -moz-border-radius-bottomright: 15px;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    padding:2px;
}

</style>

<h1>Localisation</h1>
<div class="login-box-body" >

<form action="{{URL::route('postlocalization')}}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<select class="form-control" name="language" >
    	<option value="English(India)">English(India)</option>
    	<option value="English(U.k)">English(U.K)</option>
	</select>
    <br>

	<select class="form-control" name="timezone" >
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
    <br>

    <select class="form-control" name="date" >
    	<option value="d/m/Y">DD/MM/YYYY</option>
    	<option value="m/d/Y">MM/DD/YYYY</option>
    	<option value="Y/m/d">YYYY/MM/DD</option>
	</select>
    <br>

    <select class="form-control" name="datetime" >
    	<option value="d/m/Y H:i">DD/MM/YYYY H:i</option>
    	<option value="m/d/Y H:i">MM/DD/YYYY H:i</option>
    	<option value="Y/m/d H:i">YYYY/MM/DD H:i</option>
	</select>

    <br>
    <a href="{{URL::route('prerequisites')}}" style="text-color:black" id="access1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Prev</a>
    <input type="submit" value="Next" id="access">
</form>
<br>
</div>
</p>
@stop