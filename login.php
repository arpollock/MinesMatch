<?php
	
	$email;
	$password;
	$firstName;
	$lastName;
	$userID;
	$new_user;
	$message_new = "";
	$message_returning = "";
	$cookieName = "user";
	$cookieValue;

	$mail = true;

	$cookieUserType = "user_type";
	$cookieUserTypeValue = "returning";

	
?>

<?php
	include('databse_conn.php');
	
	// checking cookie (DON'T DO ON login page itself -- only on all user-necessary pages)
	// if(!isset($_COOKIE["user"])) {
	// 	header("./login.php");
	// }

	if(isset($_POST['submit'])) {
		
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
		$stmt = $conn->prepare("Select * from login where email = ?;");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = mysqli_num_rows($result);
		
		if($count > 0){
			
			while($row = $result->fetch_assoc()){
				if(($password == $row['password'])){
					$userID = $row['user_id'];
					setcookie($cookieName, $userID, time()+3600);
					header('Location: ./dashboard.php');
				}
				else {
					$message_returning = "Your Mines Match Password was not a Match!!";
				}
			}
		}
		else {
			$message_returning = "Your Mines Match Email was not a Match!!";
		}
	}
	
	// Register component!
	if(isset($_POST['register'])){
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$firstName = $_POST['first'];
		$lastName = $_POST['last'];
		$email = $_POST['email'];
		
		// Making sure email is not already taken!
		$stmt = $conn->prepare("SELECT * from login WHERE email = ?;");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = mysqli_num_rows($result);
		
		if($count > 0){
			$message_new = "That email already has an account";
		}
		else {
		
			if($password == $confirm_password){
				
				// Create the new user and add them into the user database
				// echo($firstName ." ". $lastName);
				$stmt_user = $conn->prepare("INSERT INTO user(first_name, last_name, gender) VALUES(?, ?, ?);");
				$gender = 'Prefer not to Answer';
				$stmt_user->bind_param("sss", $firstName, $lastName, $gender);
				$stmt_user_value = $stmt_user->execute();
				$user_id = -1;
				if ($stmt_user_value) {
					$user_id = $conn->insert_id;
					// echo "New record created successfully. Last inserted ID is: " . $user_id;
				} else {
					// echo "Error: " . $stmt . "<br>" . $conn->error;
				}
				
				// Add the rest of their information into the login so they can get back in
				$hash = md5(rand(0,1000));
				$stmt_login = $conn->prepare("INSERT INTO login(user_id, email, password, hash) VALUES (?, ?, ?, ?);");
				// echo($user_id ." ". $email ." ". $password ." ". $hash);
				$stmt_login->bind_param("isss", $user_id, $email, $password, $hash);
				$stmt_login->execute();
				
				//send the activation email to the new user
				// $to = "eclm123@gmail.com";
				$to = $email;
				$subject = 'Account Verification';
				$body = '
				Thanks for siging up for Mines Match! 
				Your account has been created. To find the love of your Mines career, login with your credentials:
				
				Username: ' . $email . '
				Password: ' . $password . '
				
				Please copy and paste this link into your browser to activate your account:
				localhost/all/MinesMatch/verify.php?email='.$email.'&hash='.$hash.'
				'; //CHANGE FOR ACTUAL DIRECTORY!!!!!!!!!
				$headers = "From: may.emma127@gmail.com" . "\r\n";
				$mail = mail($to, $subject, $body, $headers);
				// $cookieValue = $user_id;
				// setcookie($cookieName, $cookieValue, time()+3600, "/");
				// header('Location: ./edit_profile.php');
			}
			else {
				$message_new = "Passwords did not match!";
			}
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
			var returning_user = true;
			var returning_user_string = 
				<?php
					if(isset($_COOKIE['user_type'])) {
						echo json_encode($_COOKIE['user_type']); 
					} else {
						echo "'returning'";
					}
				?>;
			if(returning_user_string === "new") {
				returning_user = false;
			}

			$(document).ready( function() {
				if(returning_user) {
					$("#new_user").hide();
					$("#toggle-login").html("Sign Up");
				} else {
					$("#returning_user").hide();
					$("#toggle-login").html("Login");
				}
			});

			function toggle_login() {
				returning_user = !returning_user;
				var cookieUserTypeValue = "returning";
				if (returning_user) {
					$("#returning_user").show();
					$("#new_user").hide();
					$("#toggle-login").html("Sign Up");
				} else { // new user 
					cookieUserTypeValue = "new";
					$("#returning_user").hide();
					$("#new_user").show();
					$("#toggle-login").html("Login");
				}
				document.cookie = `user_type=${cookieUserTypeValue}`;
			}

			function forgot_password() {
				window.location.href="./forgot_password.php";
			}
		</script>
    </head>
		
	<body>
		  <!-- This content is seen on the main viewport -->
        <section class="main-content">
            <div class="login-form">
                <div id="toggle-login" class="button" onclick="toggle_login()">Sign Up</div>
				<div id="rest-password" class="button" onclick="forgot_password()">Reset Password</div>
                <h1>Welcome to Mines Match!</h1>
                <p>The online dating service for geeks, by geeks.</p>
				<?php
				if($mail){
					echo "SUCCESS";
				}else{
					echo "FAIL";
				}
				?>
				
				<form id="new_user" method="POST">
					<div class="flex-input">
                        <label for="first">First Name: </label>
                        <input type="text" name="first" id="first_name" class="login-text-input" placeholder="First name" required>
                    </div>
					<div class="flex-input">
                        <label for="last">Last Name: </label>
                        <input type="last" name="last" id="last_name" class="login-text-input" placeholder="Last name" required>
                    </div>
					<div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="new_user_email" class="login-text-input" placeholder="Enter email" required>
						<span class="error">* <?php /* TODO */?></span>
					</div>
                    <br/>
                    <div class="flex-input">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="new_user_password" class="login-text-input" placeholder="Enter password" required>
						 <span class="error">*</span>
					</div>
                    <br/>
					<div class="flex-input">
                        <label for="confirm_password">Confirm Password: </label>
                        <input type="password" name="confirm_password" id="confirm_password" class="login-text-input" placeholder="Enter password" required>
                    </div>
					<span class="error">* <?php echo $message_new ?></span>
					<br>
                    <input type="submit" name="register" value="Register" class="submit-login button"/>
				</form>
				
                <form id="returning_user" method="POST">
                    <div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" class="login-text-input" placeholder="Enter email" required>
                    </div>
            
                    <br/>
                    <div class="flex-input">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" class="login-text-input" placeholder="Enter password" required>
                    </div>
					
					<?php
						if(isset($_POST['submit'])){
							echo "<span class='error'>*" . $message_returning . "</span>";
						}
						else {
							echo "<span class='error'>*</span>";
						}
					?>
					
                    <br/>
                    <input type="submit" name="submit" value="Login" class="submit-login button"/>
                </form>
			</div>
        </section>
	</body>
</html>