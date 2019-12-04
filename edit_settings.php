<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
    $current_page = "edit_settings";
    $path_to_home = "./";
	
	include "databse_conn.php";
	
	$userID = $_COOKIE['user'];
	echo $userID;
	
	$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
	$stmt->bind_param("ss", $userID);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	$first = $row['first_name'];
	$last = $row['last_name'];
	
	if(isset($_POST['Change Settings'])) {
		if(empty($_POST['new_password']) || empty($_POST['confirm_password'])){
			//only update name
		}
		else if(empty($_POST['first']) || empty($_POST['last'])){
			//only update password
		}
		else {
			//update all
			$stmt = $conn->prepare("UPDATE login SET password = ? WHERE email = ?");
			$stmt->bind_param("ss", $new_pass, $email);
			$stmt->execute();
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
			<?php
				if($error){
					echo "<p class='error'>*You did not fill in all required fields!</p>";
				}
			?>
            <form id="edit_settings" method="POST">
                <div class="flex-input">
                    <label for="first">First Name: </label>
                    <input type="text" name="first" id="first_name" class="login-text-input" placeholder="First name" required>
                </div>
                <div class="flex-input">
                    <label for="last">Last Name: </label>
                    <input type="last" name="last" id="last_name" class="login-text-input" placeholder="<?php echo $first ?>" required>
                </div>
                <div class="flex-input">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="new_user_email" class="login-text-input" placeholder="Enter email" required>
                    <span class="error">* <?php /* TODO */?></span>
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
                <span class="error">* <?php echo $message_new ?></span>
                <br>
                <input type="submit" name="Change Settings" value="Register" class="submit-login button"/>
            </form>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>