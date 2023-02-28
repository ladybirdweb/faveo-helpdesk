<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        oTable = jQuery('#{!! $id !!}').dataTable(
                {!! $options !!}
        );
    });
</script>