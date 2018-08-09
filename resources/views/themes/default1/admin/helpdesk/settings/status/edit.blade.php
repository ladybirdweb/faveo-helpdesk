@extends('themes.default1.admin.layout.admin')

@section('Tickets')
active
@stop

@section('status')
class="active"
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.status_settings') !!}</h1>
@stop

@section('content')
<link href="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.css")}}" rel="stylesheet">
{!! Form::model($status,['route'=>['statuss.update', $status->id],'method'=>'PATCH','files' => true]) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.edit_details') !!}</h4>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @foreach ($errors->all() as $error)
            <li class="error-message-padding">{{ $error }}</li>
            @endforeach 
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('success') !!}
        </div>
        @endif
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!} !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>{!! Session::get('fails') !!}</p>
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.name') !!}: <span class="text-red"> *</span></label><br>
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.display_order') !!}: <span class="text-red"> *</span></label><br>
                    <input type="number" name="sort" min="1" class="form-control" value="{!! $status->order !!}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('icon_class') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.icon_class') !!}: <span class="text-red"> *</span></label><br>
                    <select class="form-control"  name="icon_class" style="font-family: FontAwesome, sans-serif;" required>
                        <option <?php if ($status->icon == "fa fa fa-edit") echo 'selected="selected"' ?> value="fa fa-edit">&#xf044</option>
                        <option <?php if ($status->icon == "fa fa fa-bars") echo 'selected="selected"' ?> value="fa fa-bars">&#xf0c9</option>
                        <option <?php if ($status->icon == "fa fa-bell-o") echo 'selected="selected"' ?> value="fa fa-bell-o">&#xf0a2</option>
                        <option <?php if ($status->icon == "fa fa-bookmark-o") echo 'selected="selected"' ?> value="fa fa-bookmark-o">&#xf097</option>
                        <option <?php if ($status->icon == "fa fa-bug") echo 'selected="selected"' ?> value="fa fa-bug">&#xf188</option>
                        <option <?php if ($status->icon == "fa fa-bullhorn") echo 'selected="selected"' ?> value="fa fa-bullhorn">&#xf0a1</option>
                        <option <?php if ($status->icon == "fa fa-calendar") echo 'selected="selected"' ?> value="fa fa-calendar">&#xf073</option>
                        <option <?php if ($status->icon == "fa fa-cart-plus") echo 'selected="selected"' ?> value="fa fa-cart-plus">&#xf217</option>
                        <option <?php if ($status->icon == "fa fa-check") echo 'selected="selected"' ?> value="fa fa-check">&#xf00c</option>
                        <option <?php if ($status->icon == "fa fa-check-circle") echo 'selected="selected"' ?> value="fa fa-check-circle">&#xf058</option>
                        <option <?php if ($status->icon == "fa fa-check-circle-o") echo 'selected="selected"' ?> value="fa fa-check-circle-o">&#xf05d</option>
                        <option <?php if ($status->icon == "fa fa-check-square") echo 'selected="selected"' ?> value="fa fa-check-square">&#xf14a</option>
                        <option <?php if ($status->icon == "fa fa-check-square-o") echo 'selected="selected"' ?> value="fa fa-check-square-o">&#xf046</option>
                        <option <?php if ($status->icon == "fa fa-circle-o-notch") echo 'selected="selected"' ?> value="fa fa-circle-o-notch">&#xf1ce</option>
                        <option <?php if ($status->icon == "fa fa-clock-o") echo 'selected="selected"' ?> value="fa fa-clock-o">&#xf017</option>
                        <option <?php if ($status->icon == "fa fa-close") echo 'selected="selected"' ?> value="fa fa-close">&#xf00d</option>
                        <option <?php if ($status->icon == "fa fa-code") echo 'selected="selected"' ?> value="fa fa-code">&#xf121</option>
                        <option <?php if ($status->icon == "fa fa-cog") echo 'selected="selected"' ?> value="fa fa-cog">&#xf013</option>
                        <option <?php if ($status->icon == "fa fa-cogs") echo 'selected="selected"' ?> value="fa fa-cogs">&#xf085</option>
                        <option <?php if ($status->icon == "fa fa-comment") echo 'selected="selected"' ?> value="fa fa-comment">&#xf075</option>
                        <option <?php if ($status->icon == "fa fa-comment-o") echo 'selected="selected"' ?> value="fa fa-comment-o">&#xf0e5</option>
                        <option <?php if ($status->icon == "fa fa-commenting") echo 'selected="selected"' ?> value="fa fa-commenting">&#xf27a</option>
                        <option <?php if ($status->icon == "fa fa-commenting-o") echo 'selected="selected"' ?> value="fa fa-commenting-o">&#xf27b</option>
                        <option <?php if ($status->icon == "fa fa-comments") echo 'selected="selected"' ?> value="fa fa-comments">&#xf086</option>
                        <option <?php if ($status->icon == "fa fa-comments-o") echo 'selected="selected"' ?> value="fa fa-comments-o">&#xf0e6</option>
                        <option <?php if ($status->icon == "fa fa-edit") echo 'selected="selected"' ?> value="fa fa-edit">&#xf044</option>
                        <option <?php if ($status->icon == "fa fa-envelope-o") echo 'selected="selected"' ?> value="fa fa-envelope-o">&#xf003</option>
                        <option <?php if ($status->icon == "fa fa-exchange") echo 'selected="selected"' ?> value="fa fa-exchange">&#xf0ec</option>
                        <option <?php if ($status->icon == "fa fa-exclamation") echo 'selected="selected"' ?> value="fa fa-exclamation">&#xf12a</option>
                        <option <?php if ($status->icon == "fa fa-exclamation-triangle") echo 'selected="selected"' ?> value="fa fa-exclamation-triangle">&#xf071</option>
                        <option <?php if ($status->icon == "fa fa-external-link") echo 'selected="selected"' ?> value="fa fa-external-link">&#xf08e</option>
                        <option <?php if ($status->icon == "fa fa-eye") echo 'selected="selected"' ?> value="fa fa-eye">&#xf06e</option>
                        <option <?php if ($status->icon == "fa fa-feed") echo 'selected="selected"' ?> value="fa fa-feed">&#xf09e</option>
                        <option <?php if ($status->icon == "fa fa-flag-o") echo 'selected="selected"' ?> value="fa fa-flag-o">&#xf11d</option>
                        <option <?php if ($status->icon == "fa fa-flash") echo 'selected="selected"' ?> value="fa fa-flash">&#xf0e7</option>
                        <option <?php if ($status->icon == "fa fa-folder-o") echo 'selected="selected"' ?> value="fa fa-folder-o">&#xf114</option>
                        <option <?php if ($status->icon == "fa fa-folder-open-o") echo 'selected="selected"' ?> value="fa fa-folder-open-o">&#xf115</option>
                        <option <?php if ($status->icon == "fa fa-group") echo 'selected="selected"' ?> value="fa fa-group">&#xf0c0</option>
                        <option <?php if ($status->icon == "fa fa-info") echo 'selected="selected"' ?> value="fa fa-info">&#xf129</option>
                        <option <?php if ($status->icon == "fa fa-life-ring") echo 'selected="selected"' ?> value="fa fa-life-ring">&#xf1cd</option>
                        <option <?php if ($status->icon == "fa fa-line-chart") echo 'selected="selected"' ?> value="fa fa-line-chart">&#xf201</option>
                        <option <?php if ($status->icon == "fa fa-location-arrow") echo 'selected="selected"' ?> value="fa fa-location-arrow">&#xf124</option>
                        <option <?php if ($status->icon == "fa fa-lock") echo 'selected="selected"' ?> value="fa fa-lock">&#xf023</option>
                        <option <?php if ($status->icon == "fa fa-mail-forward") echo 'selected="selected"' ?> value="fa fa-mail-forward">&#xf064</option>
                        <option <?php if ($status->icon == "fa fa-mail-reply") echo 'selected="selected"' ?> value="fa fa-mail-reply">&#xf112</option>
                        <option <?php if ($status->icon == "fa fa-mail-reply-all") echo 'selected="selected"' ?> value="fa fa-mail-reply-all">&#xf122</option>
                        <option <?php if ($status->icon == "fa fa-times") echo 'selected="selected"' ?> value="fa fa-times">&#xf00d</option>
                        <option <?php if ($status->icon == "fa fa-trash-o") echo 'selected="selected"' ?> value="fa fa-trash-o">&#xf014</option>
                        <option <?php if ($status->icon == "fa fa-user") echo 'selected="selected"' ?> value="fa fa-user">&#xf007</option>
                        <option <?php if ($status->icon == "fa fa-user-plus") echo 'selected="selected"' ?> value="fa fa-user-plus">&#xf234</option>
                        <option <?php if ($status->icon == "fa fa-user-secret") echo 'selected="selected"' ?> value="fa fa-user-secret">&#xf21b</option>
                        <option <?php if ($status->icon == "fa fa-user-times") echo 'selected="selected"' ?> value="fa fa-user-times">&#xf235</option>
                        <option <?php if ($status->icon == "fa fa-users") echo 'selected="selected"' ?> value="fa fa-users">&#xf0c0</option>
                        <option <?php if ($status->icon == "fa fa-wrench") echo 'selected="selected"' ?> value="fa fa-wrench">&#xf0ad</option>
                        <option <?php if ($status->icon == "fa fa-circle-o-notch") echo 'selected="selected"' ?> value="fa fa-circle-o-notch">&#xf1ce</option>
                        <option <?php if ($status->icon == "fa fa-refresh") echo 'selected="selected"' ?> value="fa fa-refresh">&#xf021</option>
                        <option <?php if ($status->icon == "fa fa-spinner") echo 'selected="selected"' ?> value="fa fa-spinner">&#xf110</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group {{ $errors->has('icon_color') ? 'has-error' : '' }}">
                    <label>{!! Lang::get('lang.icon_color') !!}: <span class="text-red"> *</span></label><br>
                    <input type="text" name="icon_color" value="{!! $status->icon_color !!}" class="form-control  my-colorpicker1" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                {!! Form::label('visibility',Lang::get('lang.visibility_to_client')) !!}   <span class="text-red"> *</span>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Form::radio('visibility_for_client','1', true ,['id' => 'state1', 'onclick' => 'handleClick(this);']) !!} {{Lang::get('lang.yes')}}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::radio('visibility_for_client','0',false ,['id' => 'state1', 'onclick' => 'handleClick(this);']) !!} {{Lang::get('lang.no')}}
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.if_yes_status_name_will_be_displayed') !!}</div>
            </div>
            <div class="col-md-2 form-group">
                {!! Form::label('allow_client',Lang::get('lang.allow_client')) !!}   <span class="text-red"> *</span>
                <div class="row">
                    <div class="col-xs-6">
                        {!! Form::radio('allow_client','1',true,['id' => 'allow_client']) !!} {{Lang::get('lang.yes')}}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::radio('allow_client','0',false,['id' => 'allow_client']) !!} {{Lang::get('lang.no')}}
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.if_yes_then_clients_can_choose_this_status') !!}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                {!! Form::label('visibility',Lang::get('lang.purpose_of_status')) !!}  <span class="text-red"> *</span>
                <?php
                $status_types = App\Model\helpdesk\Ticket\TicketStatusType::where('id', '<', 3)->get();
                ?>
                <select name="purpose_of_status" class="form-control"  id="purpose_of_status" onchange="changeStatusType()" required>
                    @foreach($status_types as $status_type)
                        <option value="{!! $status_type->id !!}"  <?php if($status->purpose_of_status == $status_type->id) { echo 'selected'; } ?> >{!! ucfirst($status_type->name) !!}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-8">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.purpose_of_status_will_perform_the_action_to_be_applied_on_the_status_selection') !!}</div>
            </div>
        </div>
        <div class="row" id="secondary" style="display:none;">
            <div class="col-md-4 form-group">
                {!! Form::label('visibility',Lang::get('lang.status_to_display')) !!}
                <select name="secondary_status" class="form-control">
                    @foreach($status_types as $status_type)
                        <option value="{!! $status_type->id !!}"  <?php if($status->secondary_status == $status_type->id) { echo 'selected'; } ?>>{!! ucfirst($status_type->name) !!}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-8">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.this_status_will_be_displayed_to_client_if_visibility_of_client_chosen_no') !!}</div>
            </div>
        </div>
        <div class="row"  id="sending_email">
            <div class="col-md-4 form-group">
                {!! Form::label('send_email',Lang::get('lang.send_email')) !!}
                <div class="row">
                    <div class="col-xs-3">
                        <input name="client" type="checkbox"  value="1"<?php if($status->send_email == 1 || $status->send_email == 3 || $status->send_email == 5 || $status->send_email == 7) { echo "checked"; } ?> > {{Lang::get('lang.client')}}
                    </div>
                    <div class="col-xs-3">
                        <input name="agent" type="checkbox" value="2" <?php if($status->send_email == 2 || $status->send_email == 3 || $status->send_email == 6 || $status->send_email == 7) { echo "checked"; } ?> > {{Lang::get('lang.agent')}}
                    </div>
                    <div class="col-xs-3">
                        <input name="admin" type="checkbox" value="4"<?php if($status->send_email == 4 || $status->send_email == 5 || $status->send_email == 6 || $status->send_email == 7) { echo "checked"; } ?> > {{Lang::get('lang.admin')}}
                    </div>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.tick_who_all_to_send_notification') !!}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 form-group">
                {!! Form::label('message',Lang::get('lang.message')) !!}
                <textarea name="message" class="form-control" style="height:100px;" >{!! $status->message !!}</textarea>
            </div>
            <div class="col-xs-4">
                <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.this_message_will_be_displayed_in_the_thread_as_internal_note') !!}</div>
            </div>
           



        </div>
        <div class="form-group">
            <input type="checkbox" name="default" <?php if($status->default == 1) { echo "checked='checked' value='1'"; } ?> > {{ Lang::get('lang.make_system_default_for_selected_purpose') }}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary'])!!}
    </div>
    {!! Form::close() !!}
</div>
<!-- bootstrap color picker -->
<script src="{{asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.js")}}"></script>
<script>
var currentValue = 0;
function handleClick(myRadio) {
    currentValue = myRadio.value;
    if (currentValue == '1') {
        $("#secondary").hide();
    } else if (currentValue == '0') {
        $("#secondary").show();
    }
}

$(function(){
    var myRadio = {!! $status->visibility_for_client !!};
    currentValue = myRadio;
    if (currentValue == '1') {
        $("#secondary").hide();
    } else if (currentValue == '0') {
        $("#secondary").show();
    }
});

// $(function(){
//     var purpose_of_status = document.getElementById('purpose_of_status').value;
//     if(purpose_of_status == 2) {
//         $('#sending_email').show();
//     } else {
//         $('#sending_email').hide();
//     }
// });
   
// function changeStatusType() {
//     var purpose_of_status = document.getElementById('purpose_of_status').value;
//     if(purpose_of_status == 2) {
//         $('#sending_email').show();
//     } else {
//         $('#sending_email').hide();
//     }
// }

//Colorpicker
$(".my-colorpicker1").colorpicker();
</script>
@stop
