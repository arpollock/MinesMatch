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
    $is_pending = -1;
    // TODO: query sql for first and last name from uid
    // ... and all other profile info
	$sql = "SELECT first_name, last_name FROM user WHERE user_id=?;";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $uid);
	$stmt->execute();
	$result = $stmt->get_result();
	$names = $result->fetch_assoc();
	$first = $names['first_name'];
	$last = $names['last_name'];

	$my_uid = $_COOKIE['user'];

	$sql_email = "SELECT email FROM login WHERE user_id=?;";
	$stmt_email = $conn->prepare($sql_email);
	$stmt_email->bind_param('i', $uid);
	$stmt_email->execute();
	$result_email = $stmt_email->get_result();
	$email = $result_email->fetch_assoc()['email'];

	$stmt_get_ids = $conn->prepare("SELECT * FROM MATCHES WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?);");
	$stmt_get_ids->bind_param("iiii", $my_uid, $uid, $uid, $my_uid);
	$stmt_get_ids->execute();
	$ids_result = $stmt_get_ids->get_result();
	if($ids_result->num_rows == 1){
		while($row = $ids_result->fetch_assoc()){ // find who is which user id (1 or 2):
			if($row['user1_id'] == $my_uid) { // i am 1 and they are 2
				$my_match_userid = 1;
				$their_match_userid = 2;
			} else if($row['user2_id'] == $my_uid) { // i am 2 and they 1
				$my_match_userid = 2;
				$their_match_userid = 1;
			}
			$is_pending = $row['match_state'];
		}
	} else {
		$is_pending = $ids_result->num_rows;
	}
	

	$sql = "SELECT question_answer FROM preference WHERE question_id=1 AND user_id=?;";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $uid);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	$compareMale = strcmp($row['question_answer'], 'male');
	$compareFemale = strcmp($row['question_answer'], 'female');
	$compareNB = strcmp($row['question_answer'], 'nb');
	
	if($compareFemale == 0){
		$imgData = "./avatars/female.png";
	} else if($compareMale == 0) {
		$imgData = "./avatars/male.png";
	} else if($compareNB == 0) {
		$imgData = "./avatars/nb.png";
	} else {
		$imgData = "./avatars/na.png";
	}	
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - <?php echo $first . " " . $last?>'s Profile</title>
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
                <img class="profile-pic" src=<?php echo $imgData ?> style="max-height: 200px; width: auto;" alt="Their profile pic."/>
                <div class="about-text">
                    <div class="title-wrapper">
                        <h2><?php echo $first . " " . $last?>'s Profile</h2>
						<!-- TODO: Adjust the match_state in the database based on button clicked here-->
                        <div id="match-buttons" <?php if ( $is_pending!=0 && $is_pending!=$my_match_userid ) { echo 'style="display: none;"'; } ?> >
                            <div id="match-yes" onclick="match(<?php echo($my_uid . ', ' . $uid); ?>, true)">Yes &lt;3</div>
                            <div id="match-no" onclick="match(<?php echo($my_uid . ', ' . $uid); ?>, false)">No &lt;/3</div>
                        </div>
                        <!-- TODO: maybe this is a mailto click of their email? -->
                        <div class="love" id="successful" <?php if ($is_pending!=3) { echo 'style="display: none;"'; } ?> >Matched! Email them at: <?php echo($email);?></div>
                        <div class="love" id="waiting" <?php if ($is_pending==$their_match_userid) { echo 'style="display: inline-block;"'; } ?> >Waiting for <?php echo $first?>'s Response...</div>
                    </div>
                    <hr/>
					<?php
						$sql = "SELECT question_text, question_id FROM question";// WHERE question_id < 7";
						$result = $conn->query($sql);
						if($result->num_rows > 0){
							$basic_bio_info = array(); // use array to control order of appearance (just for basic bio info)
							if($result->num_rows > 0){
								while($row = $result->fetch_assoc()){
									$sql2 = "SELECT question_answer FROM preference WHERE user_id=? AND question_id =?;";
									$stmt = $conn->prepare($sql2);
									$stmt->bind_param("ii", $uid, $row['question_id']);
									$stmt->execute();
									$result2 = $stmt->get_result();
									if ($result2->num_rows > 0) {
										$answer = $result2->fetch_assoc();
										$basic_bio_info[ strval($row['question_id']) ] = $answer['question_answer'];
									}
								}
							} 
							if(count($basic_bio_info) == 0) { // they have not entered their basic bio preferences
								echo('<p class="gen-info">This user has not entered in bio information yet.</p>');
							} else {
								ksort($basic_bio_info);
								foreach($basic_bio_info as $q_number=>$q_answer) {
									if($q_number == '5') {
										echo '<span class="gen-info">' . "Class of " .$q_answer . '</span>';
									} else if ($q_number == '10'){
										echo '<p class="gen-info">' . $q_answer . '</p>';
									} else if ($q_number == '1' || $q_number == '3') {
										echo '<span class="gen-info">' . $q_answer . ' | ' .'</span>';
									}
								}
							}
					 	}
					?>
				</div>          
            </section>
            <section class="all-questions">
                <div class="question-wrapper">
					<!-- popultae with their answers to questions from the database-->
					<fieldset>
					<legend>About</legend>
					<?php
					 $sql = "SELECT question_text, question_id FROM question WHERE question_id > 6 AND question_id < 10";
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
					</fieldset>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>