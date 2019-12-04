<?php
	include('databse_conn.php');
	
	$message_new = '';
	
	if(isset($_POST['reset'])) {
		$email = $_POST['email'];
		
		$stmt = $conn->prepare("Select * from login where email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = mysqli_num_rows($result);
		
		if($count == 1){
			
			// Random Pass Generation
			$char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for($i = 0; $i < 5; $i++){
				$index = rand(0, strlen($char) - 1);
				$randomString .= $char[$index];
			}
			
			$new_pass = $randomString;
			
			$stmt = $conn->prepare("UPDATE login SET password = ? WHERE email = ?");
			$stmt->bind_param("ss", $new_pass, $email);
			$stmt->execute();
			
			$msg = "Here is your password: " . $ . "\n Click here to login: http://localhost/MinesMatch/MinesMatch/login.php";
			$msg = wordwrap($msg, 70);
			$subject = "Passowrd Reset";
			mail($email, $subject, $msg);
			$message_new = "Email has been sent!";
		}
		else {
				$message_new = "*Email not found";
		}
		
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
		<script>
			function back_to_login() {
				window.location.href="./login.php";
			}
		</script>
    </head>
	
<body>
	<section class="main-content">
		<div class="login-form">
			<div id="rest-password" class="button" onclick="back_to_login()">< Back to Login</div>
			<h1>Welcome to Mines Match!</h1>
			<p>Enter Your email to recevie your password.</p>
			
			
			<form id="returning_user" method="POST">
				<div class="flex-input">
					<label for="email">Email: </label>
					<input type="email" name="email" id="email" class="login-text-input" placeholder="Enter email" required>
				</div>
				
				<?php
					if(isset($_POST['reset'])){
						echo "<span class='error'>" . $message_new . "</span>";
					}
					else {
						echo "<span class='error'>*</span>";
					}
				?>
				
				<br/>
				<input type="submit" name="reset" value="Send Email" class="submit-login button"/>
			</form>
		</div>
	</section>
</body>