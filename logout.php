<?php
    $current_page = "login";
    $path_to_home = "./";
	$process_login = "./process_login.php";
	$new_user;
	include "databse_conn.php";
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
    </head>
		
	<body>
	</body>
</html>

<?php 
	function new_user() {
		
		console.log("1");
		if(isset($_POST['register'])) {
			echo "HAHA";
			console.log("2");
			$email = $_POST['new_user_email'];
			$password = $_POST['new_user_password'];
			$confirm_password = $_POST['confirm_password'];
			
			if($password != $confirm_password){
				console.log("3");
			}
			else {
				console.log("4");
				$stmt = $conn->prepare("INSERT INTO login(email, passowrd) VALUES (?, ?)");
				$stmt->bind_param("ss", $email, $password);
				$stmt->execute() or die("Failed to login!");
				$result = $stmt->get_result();
				$row = mysqli_fetch_row($result);
				echo "You are now a user!";
				$new_user = "./user_page.php?id=" .  urlencode($row[2]);
			}
			
		}
		
		console.log("5");
	}

?>

 