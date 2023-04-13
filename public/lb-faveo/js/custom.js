function myFunction() {
    var element = document.body;
    element.classList.toggle("dark-mode");
}

$(document).ready(function(){
    $('.navbar-login i').click(function(){
        $('#login-form').toggleClass('show');
        $(this).toggleClass('addrotate');
    });
});
