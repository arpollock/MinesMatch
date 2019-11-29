<?php
	
	$email;
	$password;
	$firstName;
	$lastName;
	$userID;
	$new_user;
	$message = "";
	
?>

<?php
	include "databse_conn.php";
	// checking cookie
	if(isset($_COOKIE["type"])) {
		header("./dashboard.php");
	}
	
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
		$stmt = $conn->prepare("Select * from login where email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute() or die("Failed to login!");
		$result = $stmt->get_result();
		$count = mysqli_num_rows($result);
		
		if($count > 0){
			
			while($row = $result->fetch_assoc()){
				if(($password == $row['password'])){
					$userID = $row['user_id'];
					setcookie($userID, time()+3600);
					header('Location: ./dashboard.php');
				}
				else {
					$message = "Password was incorrect.";
				}
			}
		}
		else {
			$message = "Email was incorrect";
		}
	}
	
	// Register component!
	if(isset($_POST['register'])){
		$firstName = $_POST['first'];
		$lastName = $_POST['last'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		
		if(!$conn){
			echo "I mean what the fuck man";
			die("Fuck your life");
		}
		
		if($password == $confirm_password){
			header('Location: ./edit_profile.php');
			
			// Create the new user and add them into the user database
			$sql = "INSERT INTO user(first, last) VALUES(?, ?)";
			$stmt = mysqli_prepare($sql);
			$stmt->bind_param("ss", $firstName, $lastName);
			$stmt->execute() or die("Failed to add you!");
			
			$stmt = $conn->prepare("SELECT user_id FROM user WHERE first = ? AND last = ?");
			$stmt->bind_param("ss", $firstName, $lastName);
			$stmt->execute() or die("Failed to add you!");
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$userID = $row['user_id'];
			
			// Add the rest of their information into the login so they can get back in
			$stmt = $conn->prepare("INSERT INTO login(user_id, email, passowrd) VALUES (?, ?)");
			$stmt->bind_param("sss", $user_id, $email, $password);
			$stmt->execute() or die("Failed to add you!");
			
			setcookie($userID, time()+3600);
			header('Location: ./edit_profile.php');
		}
		else {
			$message = "Passwords did not match!";
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
        <script src="./scripts/login.js"></script>
    </head>
		
	<body>
		  <!-- This content is seen on the main viewport -->
        <section class="main-content">
            <div class="login-form">
                <div id="toggle-login" class="button" onclick="toggle_login()">Sign Up</div>
                <h1>Welcome to Mines Match!</h1>
                <p>The online dating service for geeks, by geeks.</p>
				
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
                        <input type="confirm_password" name="confirm_password" id="confirm_password" class="login-text-input" placeholder="Enter password" required>
                    </div>
					<span class="error">* <?php echo $message ?></span>
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
							echo "<span class='error'>*" . $message . "</span>";
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