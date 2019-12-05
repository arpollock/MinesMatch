<?php
include "databse_conn.php";
$uid_me = stripcslashes($_GET['uid_me']);
$uid_them = stripcslashes($_GET['uid_them']);
$answer = stripcslashes($_GET['ans']);

$user1_id = -1; 
$user2_id = -1; 
$curr_match_state = 0;

$stmt_get_ids = $conn->prepare("SELECT * FROM MATCHES WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?);");
$stmt_get_ids->bind_param("iiii", $uid_me, $uid_them, $uid_them, $uid_me);
$stmt_get_ids->execute();
$ids_result = $stmt_get_ids->get_result();
if($ids_result->num_rows == 1){
    while( $row = $ids_result->fetch_assoc() ){ // find who is which user id (1 or 2):
        if($row['user1_id'] == $uid_me) { // i am 1 and they are 2
            $user1_id = $uid_me;
            $user2_id = $uid_them;
        } else if($row['user2_id'] == $uid_me) { // i am 2 and they are 1
            $user2_id = $uid_me;
            $user1_id = $uid_them;
        } else {
            echo('id assignment failed');
        }
        $curr_match_state = $row['match_state'];
    }
} else {
    // error (more than 1 or 0 matches??)
}

if($curr_match_state != -1) {
    $new_match_state = -1;
    if($answer != -1) { 
        if($curr_match_state > 0) { // they already responded yes -> IT'S A MATCH!
            $new_match_state = 3;
        } else if ($user1_id == $uid_me) { // I am # 1 -> waiting for # 2
            $new_match_state = 2; 
        } else { // I am # 2 -> waiting for # 1
            $new_match_state = 1;
        }
    }
    $stmt = $conn->prepare("UPDATE matches SET match_state=? WHERE user1_id=? AND user2_id=?;");
    $stmt->bind_param("iii", $new_match_state, $user1_id, $user2_id);
    $stmt->execute();
    echo($new_match_state);
} else {
    echo($curr_match_state);
}
?>