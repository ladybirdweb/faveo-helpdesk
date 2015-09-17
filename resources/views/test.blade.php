{{-- @extends('themes.default1.Agent.ticket.layout')

@section('content')
<link href="{{asset("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<form name="form1">
    <fieldset name="Group1">
        <legend>Group box</legend>Center Title:
        <select name="ctrTitles" id="ctrTitles">
            <option value="1">Corp 1</option>
            <option value="2">Shamrock Gold</option>
            <option value="3">Hensin Way</option>
        </select>
        <br/>
        <br/>Address 1:
        <textarea name="TextArea1" id="TextArea1" class="form-control" ></textarea>
        <br/>
    </fieldset>
</form>
<script type="text/javascript">


$(function () {
    $("#TextArea1").wysihtml5();
});


	var centerLocations = {
    text1: 'some text1',
    text2: 'some text2',
    text3: 'some text3'
};

// $(function () {
$('#ctrTitles').change(function () {
//     $.ajax({
//                 type: "POST",
//                 url: "../test1234",
//                 beforeSend: function() {
//                     // $("#hidespin").hide();
//                     // $("#spin").show();
//                     // $("#hide2").hide();
//                     // $("#show2").show();
//                 },
//                 success: function(response) {
//                     alert(response);
//                     // $("#refresh").load("../thread   #refresh");
//                     // $("#show2").hide();
//                     // $("#spin").hide();
//                     // $("#hide2").show();
//                     // $("#hidespin").show();
//                     // $("#d1").trigger("click");
//                     // var message = "Success! Your Ticket have been Closed";
//                     // $("#alert11").show();
//                     // $('#message-success1').html(message);
//                     // setInterval(function(){$("#alert11").hide(); },4000);   
//                 // }
//             })
//             return false;
    $("#TextArea1").wysihtml5({centerLocations["text" + this.value]});
}).change();
// });

                        
</script>
@stop --}}