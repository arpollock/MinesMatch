<?php
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
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            
            <section class="about-wrapper">
                <img class="profile-pic" src="./images/user.png" style="max-width: 33vw; height: auto;"/>
                <div class="about-text">
                    <h2>My Profile</h2>
                    <p>This is my main bio blurb!</p>
                </div>
                
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>