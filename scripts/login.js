var returning_user = true;

$(document).ready( function() {
    $("#new_user").hide();
});

function toggle_login() {
    returning_user = !returning_user;
    if (returning_user) {
        $("#returning_user").show();
        $("#new_user").hide();
        $("#toggle-login").html("Sign Up");
    } else {
        $("#returning_user").hide();
        $("#new_user").show();
        $("#toggle-login").html("Login");
    }
}