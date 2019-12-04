<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
    $current_page = "edit_settings";
    $path_to_home = "./";
	
	include "databse_conn.php";
	
	$userID = $_COOKIE['user'];
	$message = '';
	
	$stmt = $conn->prepare("SELECT * FROM login WHERE user_id = ?");
	$stmt->bind_param("s", $userID);
	$stmt->execute();
	$pass_result = $stmt->get_result();
	$pass_row = $pass_result->fetch_assoc();
	
	
	$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
	$stmt->bind_param("s", $userID);
	$stmt->execute();
	$user_result = $stmt->get_result();
	$user_row = $user_result->fetch_assoc();
	
	$first = $user_row['first_name'];
	$last = $user_row['last_name'];
	$password = $pass_row['password'];
	
	
	if(isset($_POST['change_settings'])) {
		$first = $_POST['first'];
		$last = $_POST['last'];
		$new_pass = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		$current_pass = $_POST['curr_password'];
		
		if($current_pass == $password){
			
			if($new_pass == $confirm_password){
				$stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ? WHERE user_id = ?");
				$stmt->bind_param("ssi", $first, $last, $userID);
				$stmt->execute(); 
				
				$stmt = $conn->prepare("UPDATE login SET password = ? WHERE user_id = ?");
				$stmt->bind_param("si", $new_pass, $userID);
				$stmt->execute(); 
			}
			else {
				$message = "New passwords did not match!";
			}
		}
		else {
			$message = "Your current password was not correct!";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Edit Settings</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Edit Settings"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/form.css">
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <h2>Edit My Settings</h2>
			
            <form id="edit_settings" method="POST">
                <div class="flex-input">
                    <label for="first">First Name: </label>
                    <input type="text" name="first" id="first_name" class="login-text-input" value="<?php echo ucfirst($first) ?>" required>
                </div>
                <div class="flex-input">
                    <label for="last">Last Name: </label>
                    <input type="last" name="last" id="last_name" class="login-text-input" value="<?php echo ucfirst($last) ?>" required>

                </div>
                <br/>
                <div class="flex-input">
                    <label for="curr_password">Current Password: </label>
                    <input type="password" name="curr_password" id="curr_password" class="login-text-input" placeholder="Enter Current Password" required>
                        <span class="error">*</span>
                </div>
                <br/>
                <div class="flex-input">
                    <label for="new_password">New Password: </label>
                    <input type="password" name="new_password" id="new_password" class="login-text-input" placeholder="New Password" required>
                </div>
                <br/>
                <div class="flex-input">
                    <label for="confirm_password">Confirm New Password: </label>
                    <input type="password" name="confirm_password" id="confirm_password" class="login-text-input" placeholder="Confirm New Password" required>
                </div>
                <span class="error">* <?php echo $message ?></span>
                <br>
                <input type="submit" name="change_settings" value="Submit" class="submit-login button"/>
            </form>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>