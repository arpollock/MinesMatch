<?php
    $current_page = "other_profile";
    $path_to_home = "./";
    $uid = $_REQUEST["uid"];
    // TODO: query sql for first and last name from uid
    // ... and all other profile info
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
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <h2><?php echo $uid?>'s profile</h2>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>