function match(uid_me, uid_them, yes_or_no) {
    // TODO: put their answer entry to DB
    if(!yes_or_no) { // they said no
        window.location.href="./dashboard.php";
		//set match_state to 0
    } else {
        $("#match-buttons").hide();
        $("#waiting").show(); 
    }
    // TODO: put hook to php look up in database for other person's answer?
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(yes_or_no) {
                // if get DB result do these lines:
                // var their_answer = true/false;
                // match_result(their_answer);     
                document.getElementById(`help`).innerHTML = this.responseText;           
            }
        }
    };
    xmlhttp.open("GET", `./update_match.php?uid_me=${uid_me}&uid_them=${uid_them}&ans=${yes_or_no}`, true);
    xmlhttp.send();
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
