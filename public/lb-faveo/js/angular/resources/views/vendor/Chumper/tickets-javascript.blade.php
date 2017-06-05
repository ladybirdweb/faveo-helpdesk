<?php
$segments = \Request::segments();
$segment = "";
foreach($segments as $seg){
    $segment.="/".$seg;
}
$inputs = json_encode(\Input::all());
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        oTable = myFunction();
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
                "lengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                "ajax": {
                    url: "{{url('filter')}}",
                    data: function (d) {
                        d.options = "{{$inputs}}";
                    }
                },
                "aaSorting": [[6, "desc"]],
                "columnDefs": [
                    { "orderable": false, "targets": 0},
                    { "searchable": false, "targets": [6,7] },
                    { "visible": true, "targets": 6 },
                    {"visible": false, "targets":7},
                ],
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    var str = aData[3];
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
    });
</script>