<?php
    $current_page = "login";
    $path_to_home = "./";
	$process_login = "./process_login.php";
	$cookieName = "user";
?>
<?php
	$userID = $_POST['userID'];
	setcookie($cookieName, $userID, time()-6600);
?>
<?php
	header("location: ./login.php");
	exit();
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Logout</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Login"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="./scripts/login.js"></script>
		<script>
			window.onload = function logout() {
				alert("Logout successful!");
			};
		</script>
    </head>	
	<body onload="logout()"></body>
</html>



 