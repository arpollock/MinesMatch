<?php
    include('databse_conn.php');
    $result_string = "";
    $can_login = false;
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
        // Verify data & protect from SQL injection
        $email = stripcslashes($_GET['email']); // Set email variable
        $hash = stripcslashes($_GET['hash']); // Set hash variable
        $stmt_verify = $conn->prepare("SELECT * FROM login WHERE email=? AND hash=?;");
        $stmt_verify->bind_param("ss", $email, $hash);
        $stmt_verify->execute();
        $result = $stmt_verify->get_result();
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                if($row['active'] == 0) {
                    $stmt_complete_verify = $conn->prepare("UPDATE login SET active=1 WHERE email=? AND hash=?;");
                    $stmt_complete_verify->bind_param("ss", $email, $hash);
                    $stmt_complete_verify_value = $stmt_complete_verify->execute();
                    if($stmt_complete_verify_value) {
                        $result_string = "Account activated successfully!";
                        $can_login = true;
                    } else {
                        $result_string = "Account activation failed.";
                    }
                } else {
                    $result_string = "You already have activated your account.";
                    $can_login = true;
                }
            }
        } else {
            $result_string = "The url is either invalid, please use the link that has been send to your email.";
        }
    } else {
        // Invalid approach
        $result_string = "Invalid approach, please use the link that has been send to your email.";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Account Verification</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Login"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
		
	<body>
		  <!-- This content is seen on the main viewport -->
        <section class="main-content">
            <div class="verify-block">
                <h1>Mines Match - Account Verification</h1>
                <p><?php echo($result_string); ?></p>
                <?php
                    if($can_login) {
                        echo('<button onclick="location.href=\'./login.php\'" class="button">Go to Login</button>');
                    }
                ?>
			</div>
        </section>
	</body>
</html>