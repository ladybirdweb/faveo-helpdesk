@extends('themes.default1.installer.layout.installer')

@section('license')
done
@stop

@section('environment')
done
@stop

@section('database')
active
@stop

@section('content')
<div ng-app="myApp">
    <h1 style="text-align: center;">Database Setup</h1>
    <p class="wc-setup-content">Below you should enter your database connection details. If you’re not sure about these, contact your host.</p>

    @if(Cache::has('fails'))
    <div class="wc-setup-content">
        <div class="woocommerce-message woocommerce-tracker">
            <div class="fail">
                <span id="fail">{!! Lang::get('lang.fails') !!}! {{Cache::get('fails')}}</span><br/><br/>
            </div>
        </div>        
    </div>  
    <?php Cache::forget('fails')?>
    @endif

    @if($errors->has('default') || $errors->has('host') || $errors->has('port') || $errors->has('databasename') || $errors->has('username') || $errors->has('password'))
    <div class="wc-setup-content">
        <div class="woocommerce-message woocommerce-tracker">
            <div class="fail">
                {!! $errors->first('default', '<spam id="fail">:message</spam><br/>') !!}
                {!! $errors->first('host', '<spam id="fail">:message</spam><br/>') !!}
                {!! $errors->first('port', '<spam id="fail">:message</spam><br/>') !!}
                {!! $errors->first('databasename', '<spam id="fail">:message</spam><br/>') !!}
                {!! $errors->first('username', '<spam id="fail">:message</spam><br/>') !!}
                {!! $errors->first('password', '<spam id="fail">:message</spam><br/>') !!}
                <br/>
            </div>
        </div>
    </div>
    @endif


    {!! Form::open(['url'=> '/step4post']) !!}
    <table ng-controller="MainController">
        <tr>
            <td>
                <label for="selectbox1">Database <span style="color
                                                       : red;font-size:12px;">*</span></label>
            </td>
            <td>
                <div class="side-by-side clearfix moveleftthre">
                    <div>
                        <select name="default" data-placeholder="Choose a SQL format..." class="chosen-select" style="width:290px;" tabindex="2">
                            <option value="mysql">MySQL</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Databasetitle}}" data-content="@{{Databasecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <label for="box1">Host<span style="color
                                            : red;font-size:12px;">*</span></label>
            </td>
            <td>
                <input type="text" name="host">
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Hosttitle}}" data-content="@{{Hostcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <label for="box2">Port</label>
            </td>
            <td>
                <input type="number" name="port"> 
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Porttitle}}" data-content="@{{Portcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <label for="box3">Database Name<span style="color
                                                     : red;font-size:12px;">*</span></label>
            </td>
            <td>
                <input type="text" name="databasename"> 
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Databasenametitle}}" data-content="@{{Databasenamecontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <label for="box4">User Name<span style="color
                                                 : red; font-size: 12px;">*</span></label>
            </td>
            <td>
                <input type="text" name="username"> 
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Usertitle}}" data-content="@{{Usercontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td>
                <label for="box5">Password</label>
            </td>
            <td>
                <input type="text" name="password"> 
            </td>
            <td>
                <button type="button" data-toggle="popover" data-placement="right" data-arrowcolor="#eeeeee" data-bordercolor="#bbbbbb" data-title-backcolor="#cccccc" data-title-bordercolor="#bbbbbb" data-title-textcolor="#444444" data-content-backcolor="#eeeeee" data-content-textcolor="#888888" title="@{{Passwordtitle}}" data-content="@{{Passwordcontent}}" style="padding: 0px;border: 0px; border-radius: 5px;"><i class="fa fa-question-circle" style="padding: 0px;"></i>
                </button>
            </td>
        </tr>
    </table>
    <br>
    <p class="wc-setup-actions step">
        <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continue">
        <a href="{!! route('prerequisites') !!}" class="button button-large button-next" style="float: left">Previous</a>
    </p>
</form>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.min.js"></script>
<script src="{{asset("lb-faveo/js/angular2.js")}}" type="text/javascript"></script>
</div>
@stop