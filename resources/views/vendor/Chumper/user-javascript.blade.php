<?php
$segments = \Request::segments();
$segment = "";
foreach($segments as $seg){
    $segment.="/".$seg;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var show = 'active';
        oTable = myFunction(show);
        
        $("select[name=type_of_profile]").change(function () {
            //alert($('select[name=type_of_profile]').val());
            $("#chumper").dataTable().fnDestroy();
            myFunction();
        });

        function myFunction(show)
        {
            return jQuery('#chumper').dataTable({
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "ajax": {
                    url: "{{url('user-list')}}",
                    data: function (d) {
                        d.profiletype = show;
                    }
                }
                
            });
        }

        $('.active').on('click', function(){
            show = 'active';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show);
        });

        $('.inactive').on('click', function(){
            show = 'inactive';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show);
        });
    });

</script>