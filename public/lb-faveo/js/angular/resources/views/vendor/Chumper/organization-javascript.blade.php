<?php
$segments = \Request::segments();
$segment = "";
foreach($segments as $seg){
    $segment.="/".$seg;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        oTable = myFunction();

        function myFunction(show)
        {
            return jQuery('#chumper').dataTable({
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "bStateSave" : true,
                "ajax": {
                    url: "{{route('org.list')}}",
                },
            });
        }        
    });
</script>