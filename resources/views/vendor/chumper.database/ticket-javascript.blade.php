
<script type="text/javascript">
    jQuery(document).ready(function () {

        oTable = jQuery('#chumper').dataTable({
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            //"sAjaxSource": "{{url('filter')}}",
            "bServerSide": true,
//            "fnServerParams": function (aoData) {
//                $("select[name=label]").change(function () {
//                    var labels = $("select[name=label]").val();
//                    aoData.push({"name": "thing", "value": "thingsvalue"});
//                });
//
//            },
            "ajax": {
                "type": "POST",
                "url": '/myUrl/MyMethod/',
                "contentType": 'application/json; charset=utf-8',
                "data": function (data) {
                    return data = JSON.stringify(data);
                }
            },
            "aaSorting": [[6, "desc"]],
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
            }}
        );
        $("select[name=label]").change(function () {
            oTable.fnDraw();
        });
    });

</script>