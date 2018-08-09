

<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">

<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

<div id="filter-box" style="display: none;">
    <div>
        <div class="row">
            <!-- /.col -->
            <div class="col-md-3">
                <div class="form-group">
                   <label>{!! Lang::get('lang.labels') !!}</label>
                    <ul id="label" data-name="nameOfSelect" name="label"></ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>{!! Lang::get('lang.tags') !!}</label>
                    <ul id="tag" data-name="nameOfSelect" name="tag"></ul>
                </div>
            </div>
             <div class="col-md-3">
                <div class="form-group">
                <label>{!! Lang::get('lang.type') !!}</label>
                    <ul id="type" data-name="nameOfSelect" name="type"></ul>
                </div>
            </div>

        </div>
    </div>
</div>
@section('FooterInclude')
<script>
    function showhidefilter()
    {
        var div = document.getElementById("filter-box");
        if (div.style.display !== "none") {
            div.style.display = "none";
        } else {
            div.style.display = "block";
        }
    }
</script>
<script src="{{asset('lb-faveo/plugins/hailhood-tag/js/tagit.js')}}"></script>
<script>
    $('#label').tagit({
        tagSource: "{{url('json-labels')}}",
        allowNewTags: false,
       placeholder: '{!! Lang::get('lang.enter_labels') !!}',
        select: true, 
    });
    $('#tag').tagit({
        tagSource: "{{url('get-tag')}}",
        allowNewTags: false,
       placeholder: '{!! Lang::get('lang.enter_tags') !!}',
        select: true,
    });
    $('#type').tagit({
        tagSource: "{{url('get-type')}}",
        allowNewTags: false,
       placeholder: '{!! Lang::get('lang.enter_type') !!}',
        select: true,
    });
</script>
@stop