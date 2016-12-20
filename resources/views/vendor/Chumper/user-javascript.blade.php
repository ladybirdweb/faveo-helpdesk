<?php
$segments = \Request::segments();
$segment = "";
foreach($segments as $seg){
    $segment.="/".$seg;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var show = 'all';
        var searchTerm = '';
        oTable = myFunction(show, searchTerm);
        
        $("select[name=type_of_profile]").change(function () {
            //alert($('select[name=type_of_profile]').val());
            $("#chumper").dataTable().fnDestroy();
            myFunction();
        });

        function myFunction(show)
        {
            return jQuery('#chumper').dataTable({
                "sDom": "<'row'<'col-xs-6'l><'col-xs-6'>r>"+
                        "t"+
                        "<'row'<'col-xs-6'i><'col-xs-6'p>>",
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "{{url('user-list')}}",
                    data: function (d) {
                        d.profiletype = show;
                        d.searchTerm = searchTerm;
                    }
                }
                
            });
        }

        $('.all').on('click', function(){
            show = 'all';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.active-users').on('click', function(){
            show = 'active';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.inactive').on('click', function(){
            show = 'inactive';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.agents').on('click', function(){
            show = 'agents';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.users').on('click', function(){
            show = 'users';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.banned').on('click', function(){
            show = 'banned';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        $('.deleted').on('click', function(){
            show = 'deleted';
            $("#chumper").dataTable().fnDestroy();
            myFunction(show, searchTerm);
        });

        document.getElementById('search-text').onkeypress = function(e){
            if (!e) e = window.event;
            var keyCode = e.keyCode || e.which;
            if (keyCode == '13'){ 
                searchTerm = $('input[name=search]').val();
                $("#chumper").dataTable().fnDestroy();
                myFunction(show, searchTerm);
            }
        }
    });
</script>