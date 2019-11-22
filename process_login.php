<?php
	// Data base connection
	include "databse_conn.php";

	// Setting variables
	if(isset($_POST['email'])){
		$email = $_POST["email"];
		$email = stripcslashes($email);		// Prevent sql injections
	}
	
	if(isset($_POST['password'])) {
		$password = $_POST["password"];
		$password = stripcslashes($password);		// Prevent sql injections
	}
	
	// Execute
	// Select from DB with prepared statements to see if valid user
	$stmt = $conn->prepare("SELECT * FROM login where email = ? and password = ?");
	$stmt->bind_param("ss", $email, $password);
	$stmt->execute() or die("Failed to login!");
	$result = $stmt->get_result();
	
	$row = mysqli_fetch_row($result);
	
	if(($row[0] == $email) && ($row[1] == $password)){
		$user_id = $row[3];
		header('Location: ./dashboard.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Login</title>
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
		  <!-- This content is seen on the main viewport -->
        <section class="main-content">
            <div class="login-form">
				<h1 id="login_error">Login Failed</h1>
                <h2>Your Mines Match Email or Pass was not a Match!!</h2>
				<button id="login_error_btn" onclick="location.href='./login.php'">Try again</button>
			</div>
        </section>
	</body>
</html>