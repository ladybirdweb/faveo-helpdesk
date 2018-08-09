@extends('themes.default1.installer.layout.installer')

@section('serial')
active
@stop

@section('content')
    <div class="wc-setup-content" ng-app="myApp">
        <h1 style="text-align: center;">Faveo Helpdesk Serial Key</h1>
        <p><strong>Please enter your serial key for Faveo Helpdesk PRO</strong></p>
                @if(Session::has('success'))
                    <div class="wc-setup-content">
                        <div class="woocommerce-message woocommerce-tracker">
                            <div class="ok">
                                <span id="fail">{{Session::get('success')}}</span><br/><br/>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails'))
                    <div class="wc-setup-content">
                        <div class="woocommerce-message woocommerce-tracker">
                            <div class="fail">
                                <span id="fail">{{Session::get('fails')}}</span><br/><br/>
                            </div>
                        </div>
                    </div>
                @endif
        {!! Form::open(['url'=> '/post-serial', 'id' => 'serail-verification']) !!}
            <input type="hidden" name="domain" value="{{domainUrl()}}">
            <input type="hidden" name="url" value="{{url('/')}}">
            <table ng-controller="AutotabController">
            <div>
                
                <p ng-bind="user"></p>
            </div>
                <tr >
                    <td style="width: 200px;">
                        <label for="box1" id="test">Order Number<span style="color: red;font-size:12px;">*</span>
                        </label>
                        <br/><br/>
                    </td>
                    <td style="">
                        {!! $errors->first('order_no', '<spam class="help-block">:message</spam>') !!}
                        <input type="text" name="order_no" id="order_no" style="margin-left:180px;width:274px;border-width','1px'" value="" required>
                        <br/><br/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">
                        <label for="box1" id="test">Serial key<span style="color: red;font-size:12px;">*</span>
                        </label>
                    </td>
                    <td ng-repeat="productKey in productKeys" style="margin-left: 150px;">
                        {!! $errors->first('serial', '<spam class="help-block">:message</spam>') !!}
                        <div class="container">
                            <input type="text" name="first" id="productKey1" ng-model="productKey.set1" maxlength="4" size="4" style="padding: 3px; margin-left: 180px; width: 50px; text-transform:uppercase;border-width','1px'" onkeydown="myFunction(event, this.id);" required>&nbsp;-
                            <input type="text" name="second" id="productKey2" ng-model="productKey.set2" maxlength="4" size="4" style="padding: 3px; margin-left: 3px; width: 50px; text-transform:uppercase;border-width','1px'" onkeydown="myFunction(event, this.id)" required>&nbsp;-
                            <input type="text" name="third" id="productKey3" ng-model="productKey.set3" maxlength="4" size="4" style="padding: 3px; margin-left: 3px; width: 50px; text-transform:uppercase;border-width','1px'" onkeydown="myFunction(event, this.id)">&nbsp;-
                            <input type="text" name="forth" id="productKey4" ng-model="productKey.set4" maxlength="4" size="4" style="padding: 3px; margin-left: 3px; width: 50px; text-transform:uppercase;border-width','1px'" onkeydown="myFunction(event, this.id)" required>
                        </div>
                    </td>
                </tr>
            </table>
            <br>
            <p class="setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continue">
            </p>
            <br>
        </form>
    </div>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script type="text/javascript">
    var keypressed = 0;
    var onField = '';
    var text = '';
    function myFunction(e, id) {
        var target = document.getElementById(id);
        var maxLength = target.getAttribute('maxlength');
        code = e.which || e.keyCode;
        // alert(code);
        if(onField == id) {
            if((code >= 65 && code <= 90) || (code >= 97 && code <= 122)) {
                if (e.ctrlKey === true) {
                    if((code == 65 || code == 97) || (code == 88 || code == 120)) {
                        target.value = '';
                    }
                } else {
                    keypressed = target.value.length;
                }
                focusOnNextField(keypressed, maxLength, target)
            }
        } else {
            keypressed = 0;
            onField = id;
        }
    }
    
    function focusOnNextField(keypressed, maxLength, target) {
        if (keypressed >= maxLength) {
            var next = target;
            while (next = next.nextElementSibling) {
                if (next == null)
                break;
                if (next.tagName.toLowerCase() == "input") {
                    next.focus();
                    break;
                }
            }
        }
     }

    $('#productKey1, #productKey2, #productKey3, #productKey4').on('paste',function(ev) {
        ev.preventDefault();
        text = (ev.originalEvent || ev).clipboardData.getData('text/plain');
        var clipboardDataLenght = text.length;
        var start = 0;
        var end = 3;
        var target = $(this);
        while(clipboardDataLenght > 0) {
            var element = target.attr('id');
            $('#'+element).val(text.substring(start, end+1));
            if(clipboardDataLenght < 4) {
                keypressed = clipboardDataLenght;
                focusOnNextField(keypressed, 4, document.getElementById(element));
                clipboardDataLenght = 0;
            } else if(clipboardDataLenght == 4) {
                clipboardDataLenght = 0;
                target = target.next();
                target.focus();
            } else {
                clipboardDataLenght = clipboardDataLenght - 4;
                start = start + 4;
                end = end + 4;
                target = target.next();
                target.focus();
            }
        }
    });

    $('#serail-verification').on('submit', function(e){
        $("#serail-verification input[type=text]").each(function(){
            if ($(this).val() == '') {
                $(this).css('border-color','red')
                $(this).css('border-width','1px');
                e.preventDefault();
                alert('Please fill all required values.');
            }
        });
    });

    $('#productKey1, #productKey2, #productKey3, #productKey4, #order_no').on('focus', function(){
        $(this).css('border-color','#A9A9A9')
        $(this).css('border-width','1px');
    });

    $('#productKey1, #productKey2, #productKey3, #productKey4, #order_no').on('blur', function(){
        if($(this).val() == ''){
            addErrorClass($(this).attr('name'));
        }
    });

    function addErrorClass(name){
        var target = document.getElementsByName(name);
        $(target[0]).css('border-color','red');
        $(target[0]).css('border-width','1px');
    }
</script>
@stop