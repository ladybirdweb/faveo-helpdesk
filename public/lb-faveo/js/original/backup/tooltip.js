$(document).ready(function() {
    $("button").mouseover(function() {
        $.ajax({
            url: "demo_test.txt",
            success: function(result) {
                $(".tool").html(result);
            }
        });
    });
});