<?php 
			echo "HAHA";
			$email = $_POST['email'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			
			if($password == $confirm_password){
				header('Location: ./edit_profile.php');
				$stmt = $conn->prepare("INSERT INTO login(email, passowrd) VALUES (?, ?)");
				$stmt->bind_param("ss", $email, $password);
				$stmt->execute() or die("Failed to login!");
				$result = $stmt->get_result();
				$row = mysqli_fetch_row($result);
				echo "You are now a user!";
				$new_user = "./edit_profile.php?id=" .  urlencode($row[2]);
				header('Location: ./edit_profile.php');
			}

?>

