<script type="text/javascript">
    jQuery(document).ready(function () {
        oTable = myFunction();
    });
    function myFunction()
    {
        return jQuery('#chumper').dataTable({
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave" : true,
            "ajax": {
                url: "{{route('get-team-table-data')}}",
            }
        });
    }
</script>