$(document).ready( function() {
    $("#new_user").hide();
});

function match(yes_or_no) {
    // TODO: put their answer entry to DB
    if(!yes_or_no) { // they said no
        window.location.href="./dashboard.php";
    } else {
        $("#match-buttons").hide();
        $("#waiting").show();
        // TODO: put hook to php look up in database for other person's answer?
        // if get DB result do these lines:
        // var their_answer = true/false;
        // match_result(their_answer);
    }
}

function match_result(their_answer) {
    $("#waiting").hide();
    if(their_answer) { // they said yes too!!
        const email = "mdcox@mymail.mines.edu"; // TODO: make me actual email
        alert(`The M stands for match! Email them at: ${email}`); 
    } else {
        window.location.href = "./dashboard.php";
    }
}