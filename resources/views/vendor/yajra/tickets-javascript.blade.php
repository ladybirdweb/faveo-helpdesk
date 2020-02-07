<?php
$load_old_state = false;
if (Session::has('current_page')) {
    if (Session::get('current_page') == \Request::fullUrl()) {
        $load_old_state = true;
    } else {
        Session::put('current_page', \Request::fullUrl());
    }
} else {
    Session::put('current_page', \Request::fullUrl());
}

$segments = \Request::segments();
$segment = "";
foreach ($segments as $seg) {
    $segment.="/".$seg;
}
$inputs = json_encode(\Input::all());
$path = public_path();
$record_per_page = (Cache::has('ticket_per_page')) ? Cache::get('ticket_per_page') : 10;
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var oTable = myFunction();
        function myFunction()
        {
            return jQuery('#chumper').dataTable({
                "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>"+
                        "t"+
                        "<'row'<'col-xs-6'i><'col-xs-6'p>>",
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "bStateSave" : true,
                "bStateDuration": -1,
                "oLanguage": {
                    "sLengthMenu": "_MENU_ Records per page",
                    "sSearch"    : "Search: ",
                    "sProcessing": '<img id="blur-bg" class="backgroundfadein" style="top:40%;left:50%; width: 50px; height:50 px; display: block; position:    fixed;" src="">'
                },
                "stateLoadParams": function (settings, data) {
                    if ('{{$load_old_state}}') {
                        return true;
                    } else {
                        return false;
                    }
                },
                columns:[
                    {data:'id', name:'id'},
                    {data:'title', name:'threadSelectedFields.title', orderable: true},
                    {data:'ticket_number', name:'ticket_number', orderable: true},
                    {data:'user.user_name', name:'user.user_name', orderable: true},
                    {data:'assigned.user_name', name:'assigned.user_name',},
                    {data:'last_response', name:'last_response', orderable: true},
                ],
                "fnDrawCallback": function( oSettings ) {
                    $("#chumper").css({"opacity": "1"});
                    $('#blur-bg').css({"opacity": "0.7", "z-index": "99999"});
                    $('.loader1').css('display', 'none');
                    t_id = [];
                    showAssign(t_id);
                },
                "fnPreDrawCallback": function(oSettings, json) {
                    $('.loader1').css('display', 'block');
                    $("#chumper").css({"opacity":"0.3"});
                    $('#blur-bg').css({"opacity": "0.7", "z-index": "99999"});

                },

                "headerCallback": function headerCallback(thead, data, start, end, display) {
                    $(thead).find('th').first().css('text-align','center');
                    $(thead).find('th').first().css('padding','3px 5px 3px 5px');
                    if ($(thead).find('th').first().find('i').hasClass('fa-check-square-o')) {
                        $(thead).find('th').first().find('i').removeClass('fa-check-square-o');
                        $(thead).find('th').first().find('i').addClass('fa-square-o');
                    }
                },
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "ajax": {
                    url: "{{url('get-filtered-tickets')}}",
                    data: function (d) {
                        d.options = "{{$inputs}}";
                    },
                },
                "pageLength": '{!! (int)$record_per_page !!}',
                "aaSorting": [[5, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": 0},
                    { "searchable": false, "targets": [5] },
                    { "visible": true, "targets": 5 },
                    {
                        "aTargets": [0],
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var str = sData;
                            var start = str.indexOf('#');
                            var color = hexToRgbA(str.substr(start, 7));
                                $(nTd).css("border-left", "5px solid "+color);
                        }
                    } 

                ],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    var str = aData.id;
                    var length = aData.ticket_number.indexOf('*') - aData.ticket_number.indexOf('$');
                    var p = aData.ticket_number.substr(aData.ticket_number.indexOf('$')+1, length-1);
                    $("td", nRow).attr('title', "{!! Lang::get('lang.ticket-has-x-priority', ['priority' => '"+p+"']) !!}");
                    if (str.search("#000") == -1) {
                        $("td", nRow).css({"background-color": "#F3F3F3", "font-weight": "600", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px #F3F3F3"});
                        $("td", nRow).mouseenter(function () {
                            $("td", nRow).css({"background-color": "#DEDFE0", "font-weight": "600", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px #DEDFE0"});
                        });
                        $("td", nRow).mouseleave(function () {
                            $("td", nRow).css({"background-color": "#F3F3F3", "font-weight": "600", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px #F3F3F3"});
                        });
                    } else {
                        $("td", nRow).css({"background-color": "white", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px white"});
                        $("td", nRow).mouseenter(function () {
                            $("td", nRow).css({"background-color": "#DEDFE0", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px #DEDFE0"});
                        });
                        $("td", nRow).mouseleave(function () {
                            $("td", nRow).css({"background-color": "white", "border-bottom": "solid 0.5px #ddd", "border-right": "solid 0.5px white"});
                        });
                    }
                }
            });
        }

        function hexToRgbA(hex){
            var c;
            if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                c= hex.substring(1).split('');
                if(c.length== 3){
                    c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c= '0x'+c.join('');
                return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+', 0.67)';
            }
            throw new Error('Bad Hex');
        }
    });
</script>