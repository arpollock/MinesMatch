<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
	
    $current_page = "my_profile";
    $path_to_home = "./";
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
                        <h2>Profile</h2>
                        <button id="edit-preferences" onclick="location.href='./edit_profile.php'" class="button">Edit My Profile</button>
                    </div>
                    <hr/>
                    <p class="gen-info">M/F | my gender</p>
                    <p class="gen-info">My Major | Class of 20##</p>
                    <p>This is my main bio blurb! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>          
            </section>
            <hr/>
            <section class="all-questions">
                <div class="question-wrapper">
                    <h3>This is the question?</h3>
                    <p>This is the answer.</p>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>