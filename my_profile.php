<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
	
    $current_page = "my_profile";
    $path_to_home = "./";
	
	include "databse_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Your Profile</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Dashboard"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/profile.css">
        <script src="./scripts/profile.js"></script>
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <section class="about-wrapper">
                <img class="profile-pic" src="./images/user.png" style="max-width: 200px; height: auto;" alt="My profile pic."/>
                <div class="about-text">
                    <div class="title-wrapper">
						<?php
							$uid = $_COOKIE['user']; 
							$sql = "SELECT first_name, last_name FROM user WHERE user_id = ?";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param('i', $uid);
							$stmt->execute();
							$result = $stmt->get_result();
							$names = $result->fetch_assoc();
							echo '<h2>' . $names['first_name'] . " " . $names['last_name'] . '</h2>';
						?>
                        <button id="edit-preferences" onclick="location.href='./edit_profile.php'" class="button">Edit My Profile</button>
						<button id="edit-preferences" onclick="location.href='./edit_settings.php'" class="button">Edit My Settings</button>
                    </div>
                    <hr/>
					<!-- TODO: update this from the database-->
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
                    <p>This is my main bio blurb! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>          
            </section>
            <hr/>
            <section class="all-questions">
                <div class="question-wrapper">
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