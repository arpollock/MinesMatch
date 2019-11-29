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
				
				<form id="new_user" action="process_new_user.php" method="POST">
					<div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="new_user_email" class="login-text-input" placeholder="Enter email" required>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <div class="flex-input">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="new_user_password" class="login-text-input" placeholder="Enter password" required>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
					<div class="flex-input">
                        <label for="confirm_password">Confirm Password: </label>
                        <input type="confirm_password" name="confirm_password" id="confirm_password" class="login-text-input" placeholder="Enter password" required>
                    </div>
					<span class="error">* <?php /* TODO */?></span>
					<br>
                    <input type="submit" name="register" value="Register" class="submit-login button"/>
				</form>
				
                <form id="returning_user" action="process_login.php" method="POST">
                    <div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" class="login-text-input" placeholder="Enter email" required>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <div class="flex-input">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" class="login-text-input" placeholder="Enter password" required>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <input type="submit" name="submit" value="Login" class="submit-login button"/>
                </form>
			</div>
        </section>
	</body>
</html>