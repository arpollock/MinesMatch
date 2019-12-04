<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
	include "databse_conn.php";
	
    $current_page = "other_profile";
    $path_to_home = "./";
    $uid = $_REQUEST["uid"];
    $my_match_userid = 2;
    $their_match_userid = 1;
    $is_pending = intval($is_pending);
    // TODO: query sql for first and last name from uid
    // ... and all other profile info
	$sql = "SELECT first_name, last_name FROM user WHERE user_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $uid);
	$stmt->execute();
	$result = $stmt->get_result();
	$names = $result->fetch_assoc();
	$first = $names['first_name'];
	$last = $names['last_name'];
	$my_uid = $_COOKIE['user'];
	$user1_id = -1; 
	// figure out who is which # user id
	$user2_id = -1; 
	$curr_match_state = -1;

	$stmt_get_ids = $conn->prepare("SELECT * FROM MATCHES WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?);");
	$stmt_get_ids->bind_param("iiii", $uid_me, $uid_them, $uid_them, $uid_me);
	$stmt->execute();
	$ids_result = $stmt_get_ids->get_result();
	if($ids_result->num_rows == 1){
		while($row = $result->fetch_assoc()){ // find who is which user id (1 or 2):
			if($row['user1_id'] == $uid_me) { // i am 1 and they are 2
				$my_match_userid = 1;
				$their_match_userid = 2;
			} else if($row['user2_id'] == $uid_me) { // i am 2 and they 1
				$my_match_userid = 2;
				$their_match_userid = 1;
			}
			$is_pending = $row['match_state'];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - _____'s Profile</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Dashboard"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/profile.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="./scripts/profile.js"></script>
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <section class="about-wrapper">
                <img class="profile-pic" src="./images/user.png" style="max-width: 200px; height: auto;" alt="Their profile pic."/>
                <div class="about-text">
                    <div class="title-wrapper">
                        <h2><?php echo $first . " " . $last?>'s profile</h2>
						<!-- TODO: Adjust the match_state in the database based on button clicked here-->
                        <div id="match-buttons" <?php if ( $is_pending!=0 && $is_pending!=$my_match_userid ) { echo 'style="display: none;"'; } ?> >
                            <div id="match-yes" onclick="match(<?php echo($my_uid . ', ' . $uid); ?>, true)">Yes &lt;3</div>
                            <div id="match-no" onclick="match(<?php echo($my_uid . ', ' . $uid); ?>, false)">No &lt;/3</div>
                        </div>
                        <!-- TODO: maybe this is a mailto click of their email? -->
                        <div class="love" <?php if ($is_pending!=3) { echo 'style="display: none;"'; } ?> >Matched!</div>
                        <div class="love" id="waiting" <?php if ($is_pending==$their_match_userid) { echo 'style="display: inline-block;"'; } ?> >Waiting for <?php echo $first?>'s Response...</div>
                    </div>
                    <hr/>
					<?php
						$sql = "SELECT question_text, question_id FROM question WHERE question_id < 7";
						$result = $conn->query($sql);
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								$sql2 = "SELECT question_answer FROM preference WHERE user_id=? AND question_id = ?";
								$stmt = $conn->prepare($sql2);
								$stmt->bind_param("ii", $uid, $row['question_id']);
								$stmt->execute();
								$result2 = $stmt->get_result();
								$answer = $result2->fetch_assoc();
								if($row['question_id'] == 1){
									echo '<p class="gen-info">' . $answer['question_answer'] . '</p>';
								}
								if($row['question_id'] == 3){
									echo '<p class="gen-info">' . $answer['question_answer'] . '</p>';
								}
								if($row['question_id'] == 5){
									echo '<p class="gen-info">' . "Class of " .$answer['question_answer'] . '</p>';
								}
						}
					 }
					?>
					<p id="help"><?php echo($is_pending)?></p>
                    <p>This is my main bio blurb! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
					<p>Clicked Status: <?php echo($clickedBut); ?></p>
				</div>          
            </section>
            <hr/>
            <section class="all-questions">
                <div class="question-wrapper">
					<!-- popultae with their answers to questions from the database-->
					<?php
					 $sql = "SELECT question_text, question_id FROM question WHERE question_id > 6";
					 $result = $conn->query($sql);
					 if($result->num_rows > 0){
						while($row = $result->fetch_assoc()){
							echo '<h3>' .$row['question_text'] . '</h3>';
							$sql2 = "SELECT question_answer FROM preference WHERE user_id=? AND question_id = ?";
							$stmt = $conn->prepare($sql2);
							$stmt->bind_param("ii", $uid, $row['question_id']);
							$stmt->execute();
							$result2 = $stmt->get_result();
							$answer = $result2->fetch_assoc();
							echo '<p>' . $answer['question_answer'] . '</p>';
						}
					 }
					?>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>