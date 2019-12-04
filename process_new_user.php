<?php 
	// Data base connection
	include "databse_conn.php";
	
	$firstName = $_POST['first'];
	$lastName = $_POST['last'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if($password == $confirm_password){
		header('Location: ./edit_profile.php');
		
		// Create the new user and add them into the user database
		$stmt = $conn->prepare("INSERT INTO user(first, last) VALUES(?, ?)");
		$stmt->bind_param("ss", $firstName, $lastName);
		$stmt->execute();// or die("Failed to add you!");
		
		// Add the rest of their information into the login so they can get back in
		$hash = md5(rand(0,1000));
		$stmt = $conn->prepare("INSERT INTO login(email, password, hash) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $email, $password, $hash);
		$stmt->execute() or die("Failed to add you!");
		
		echo "You are now a user!";
		$new_user = "./edit_profile.php?id=" .  urlencode($row[2]);
	}
	else {
		
	}
	
	

?>

