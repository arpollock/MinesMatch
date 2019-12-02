<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
	include "databse_conn.php";
	
    $current_page = "other_profile";
    $path_to_home = "./";
    $uid = $_REQUEST["uid"];
    $my_match_userid = 2; // TODO: assign if the user's uid is in the 1 or 2 slot in db
    $their_match_userid = 1; // TODO: assign if their match's uid is in the 1 or 2 slot in db
    $is_pending = $_REQUEST["p"]; // TODO: change from query param to either (1) use cookie from below TODO OR (2) lookup match state in DB
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
                            <div id="match-yes" onclick="match(true)">Yes &lt;3</div>
                            <div id="match-no" onclick="match(false)">No &lt;/3</div>
                        </div>
                        <!-- TODO: maybe this is a mailto click of their email? -->
                        <div class="love" <?php if ($is_pending!=3) { echo 'style="display: none;"'; } ?> >Matched!</div>
                        <div class="love" id="waiting" <?php if ($is_pending==$their_match_userid) { echo 'style="display: inline-block;"'; } ?> >Waiting for <?php echo $uid?>'s Response...</div>
                    </div>
                    <hr/>
					<!-- TODO: update this from the database -->
                    <p class="gen-info">M/F | my gender</p>
                    <p class="gen-info">My Major | Class of 20##</p>
                    <p>This is my main bio blurb! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>          
            </section>
            <hr/>
            <section class="all-questions">
                <div class="question-wrapper">
					<!-- popultae with their answers to questions from the database-->
                    <h3>This is the question?</h3>
                    <p>This is the answer.</p>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>