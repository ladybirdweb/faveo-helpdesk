@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('system')
class="active"
@stop

@section('HeadInclude')

@stop
<!-- header -->
@section('PageHeader')

@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<div class="box box-primary">
	<div class="box-header">
        <h4 class="box-title">{{Lang::get('lang.ratings')}}</h4>
    </div>
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif

<div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                
                                <th>Title</th>
                                
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ratings as $rating)
                               
                            <tr>
                                <td>{!! $rating->id !!}</td>
                                
                                <td>{!! $rating->rating_name !!}</td>
                                
                                 <td>
                                     
                                   <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$rating->slug}}">Edit Rating</button> 
                                   
                                  <div class="modal fade" id="{{$rating->slug}}">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                  {!! Form::model($rating,['route'=>['settings.rating', $rating->slug],'method'=>'PATCH']) !!}
                    <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Rating</h4>
        </div>
                     <div class="modal-body">
                              <table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
<tbody>

    <tr>
<td valign="top" id="staffnavbar" colspan="2">
<div id="cpmenu"><div id="customnavhtmlcontainer" style="display: none;"></div>
    
<div class="ui-tabs-hide ui-tabs ui-widget ui-widget-content ui-corner-all" id="View_Ratingtabs">
    <div class="ui-tabs ui-tabs-panel ui-widget-content ui-corner-bottom" id="View_Rating_tab_general">
        <table width="100%" cellspacing="1" cellpadding="4" border="0">
<tbody>
<tr class="tablerow1_tr">
    <td class="tablerow1" align="left" valign="top" width="50%"><span class="tabletitle">Rating label</span><br>
        <span style="font-style: italic">For example, <em>Overall satisfaction</em> or <em>Speed of resolution</em>.</span></td>
    <td class="tablerow1" align="left" valign="top">
        {!! Form::text('rating_name',null,['class'=>'form-control'])!!}
</td></tr>
<tr class="tablerow1_tr"><td width="50%" valign="top" align="left" class="tablerow1"><span class="tabletitle">Publish the rating system?</span><br>
        <span style="font-style: italic">
            <strong>Enable Rating System</strong> Ratings are available to the users. Select this option if you want to collect feedback from your end users and have the ratings visible to staff too.
        </span></td>
<td valign="top" align="left" class="tablerow1">
                <label for="publicratingvisibility"><input type="radio" checked="" value="1" id="publicratingvisibility" class="swiftradio" name="publish" autocomplete="OFF"> Yes</label>
<label for="privateratingvisibility"><input type="radio" value="0" id="privateratingvisibility" name="publish" autocomplete="OFF"> No</label>
</td></tr>
<tr class="tablerow1_tr"><td width="50%" valign="top" align="left" class="tablerow1">
    <td width="50%" valign="top" align="left" class="tablerow1"></td>
</tr>
<tr class="tablerow1_tr">
    <td width="50%" valign="top" align="left" class="tablerow1">
        <span class="tabletitle">Allow modification after first submission</span><br>
        <span style="font-style: italic">The value set for this rating can be modified, if enabled.</span></td>
    <td valign="top" align="left" class="tablerow1"><label for="yiseditable">
            <input type="radio" checked="" value="1" id="yiseditable" onclick="" class="swiftradio" name="modify" autocomplete="OFF"> Yes</label>
<label for="niseditable">
    <input type="radio" value="0"  onclick="" name="modify" autocomplete="OFF"> No</label>
</td></tr>

</tbody></table></div></div>

</div>
</td>
					</tr>
				</tbody></table>
                                     </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                {!! Form::submit('Update Rating',['class'=>'btn btn-primary'])!!}
                                                                            
                                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        </div></div>
                                                                        {!! Form::close() !!}
                                                                    </div>  
                                                                </div>  
                                                            </div>
                                    
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{$rating->slug}}delete">Delete Rating</button>
                                                            
                                                            <div class="modal fade" id="{{$rating->slug}}delete">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title">Delete</h4>
                                      </div>
                                         <div class="modal-body">
                                             <p>Are you sure you want to Delete ?</p>
                                                </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                            {!! link_to_route('ratings.delete','Delete',[$rating->slug],['id'=>'delete','class'=>'btn btn-danger btn-sm']) !!}
                                                                        </div>
                                                                    </div> 
                                                                </div>  
                                                            </div> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

</div>
                        @stop
</div><!-- /.box -->