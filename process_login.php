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
		echo "Login sucesses!!";
		$user_id = $row[3];
		header('Location: ./user_page.php');
		echo "<a href=./user_page.php?id=" . $row[0]. ">click me</a>";
	}
	else {
		echo "Incorrect email or passowrd";
	}
?>