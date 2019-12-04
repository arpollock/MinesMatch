<?php
	include('databse_conn.php');
	
	if(isset($_POST['reset'])) {
		$email = $_POST['email'];
		
		$stmt = $conn->prepare("Select * from login where email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = mysqli_num_rows($result);
		
		if($count == 1){
			echo "Send email to user with password";
			$password = 
			$msg = "Here is your password: " . $password . "\n Click here to login: http://localhost/MinesMatch/MinesMatch/login.php";
			$msg = wordwrap($msg, 70);
			$subject = "Passowrd Reset";
			mail($email, $subject, $msg);
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
    </head>
	
<body>
	<section class="main-content">
		<div class="login-form">
		<h1>Welcome to Mines Match!</h1>
		<p>Enter Your email to recevie your password.</p>
		
		<form id="returning_user" method="POST">
			<div class="flex-input">
				<label for="email">Email: </label>
				<input type="email" name="email" id="email" class="login-text-input" placeholder="Enter email" required>
			</div>
			
			<?php
				if(isset($_POST['submit'])){
					echo "<span class='error'>*" . $message . "</span>";
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