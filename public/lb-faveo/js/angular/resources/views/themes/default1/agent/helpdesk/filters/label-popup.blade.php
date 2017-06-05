<?php
$labels = \App\Model\helpdesk\Filters\Label::orderBy('order', 'asc')->select('id','title', 'color')->where('status', 1)->get();


?>
<div id="labels-div" class="btn-group">
    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="labels-button"><i class="fa fa-lastfm" style="color:teal;"> </i>
        Labels <span class="caret"></span>
    </button>
    <ul  class="dropdown-menu pull-right" role="menu">
        <form id="form-label">
        @forelse($labels as $label)
        <li><p>&nbsp;&nbsp;<input type="checkbox" name="labels" id="label" value="{{$label->title}}" {{$label->isChecked($tickets->id)}}> {!!$label->titleWithColor()!!}</p></li>
        @empty 
        <li><p><a href="{{url('labels/create')}}"  class="col-md-offset-3 btn btn-sm btn-primary">New Label</a></p></li>
        @endforelse
        </form>
            @if(count($labels) > 0)
            <li style="background:#E7E7E7"><a href="#" onClick="myfunction()"><center>{{Lang::get('lang.apply')}}</center></a></li>
            @endif
    </ul>
</div>

@section('FooterInclude')
<script>
    function myfunction() {
        var selected = [];
        $("#labels-div").find("input:checked").each(function (i, ob) {
            selected.push($(ob).val());
        });
        $.ajax({
            url : "{{url('labels-ticket')}}",
            dataType : 'html',
            data : {'ticket_id':'{{$tickets->id}}','labels':selected},
            success: function(){
                location.reload();
            }
        });
    }


</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
<script>
        $('#tag').tagit(
        {
            tagSource: "{{url('get-tag')}}", 
            allowNewTags : true,
            placeholder : 'Enter tags',
            select  : true,
            tagsChanged : function(tagValue, action, element){
            var tag = $('select[name=tag]').val();
                    $.ajax({
                    data : {'tags':tag,'ticket_id':'{{$tickets->id}}'},
                            url : "{{url('add-tag')}}",
                            success:function(){
                            //$('#refresh').load(document.URL +  ' #refresh');
                            },
                    });
            },
        });
</script>
@stop