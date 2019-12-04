function match(uid_me, uid_them, yes_or_no) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(yes_or_no) {  
                if(this.responseText == -1) {
                    match_result(false);
                } else if(this.responseText == 3) {
                    match_result(true);
                }     
            }
        }
    };
    const int_answer = yes_or_no ? 1: -1;
    xmlhttp.open("GET", `./update_match.php?uid_me=${uid_me}&uid_them=${uid_them}&ans=${int_answer}`, true);
    xmlhttp.send();
    if(!yes_or_no) { // they said no
        window.location.href="./dashboard.php";
		//set match_state to 0
    } else {
        $("#match-buttons").hide();
        $("#waiting").show(); 
    }
}

function match_result(their_answer) {
    $("#waiting").hide();
    if(their_answer) { // they said yes too!!
        $("#successful").show();
        alert(`The M stands for match!`); 
    } else {
        window.location.href = "./dashboard.php";
    }
}
