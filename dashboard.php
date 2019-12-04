<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}

    $current_page = "dashboard";
    $path_to_home = "./";
	include "databse_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Your Dashboard</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Dashboard"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/dashboard.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="./scripts/dashboard.js"></script>
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <h2 style="display: none;">Dashboard Tabs</h2>
            <!-- TODO: store cookies here so can do "Back to Pending/Successful Matches"-->
            <section class="tab-wrapper">
                <div class="tab-header">
                    <div class="tab-item tab-item-active" id="pending-matches-tab" onclick="toggle_match_tab('pending')">
                        Pending Matches
                    </div>
                    <div class="tab-item" id="successful-matches-tab" onclick="toggle_match_tab('successful')">
                        Successful Matches
                    </div>
                </div>
                <div class="tab-content" id="pending-matches">
                    <h2>Pending Matches</h2>
					<!--TODO: here is where this will be populated by grabbing every person in the database who matches gender wanted, major wanted-->
                    <table class="match-table">
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th> 
                        </tr>
					<?php
						$u1id = $_COOKIE['user']; 
						$sql = "SELECT user2_id FROM matches WHERE user1_id = $u1id AND match_state=1";
						$result = $conn->query($sql);
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								$sql2 = "SELECT first_name, last_name FROM user WHERE user_id=?";
								$stmt = $conn->prepare($sql2);
								$stmt->bind_param("i", $row['user2_id']);
								$stmt->execute();
								$result2 = $stmt->get_result();
								$u2 = $row['user2_id'];
								?>
								<tr onclick="window.location='./other_profile.php?uid=<?php echo $u2; ?>&p=0';">
								<?php
								while($names = $result2->fetch_assoc()){
									echo '<td>' .$names['first_name']. '</td>';
									echo '<td>' .$names['last_name']. '</td>';
									echo '</tr>';
								}
							}
						}
					?>
                    </table>
                </div>
                <div class="tab-content" id="successful-matches" style="display: none;">
                    <h2>Successful Matches</h2>
					<!--TODO: here is where this will be populated by grabbing every matched person-->
                    <table class="match-table">
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th> 
                        </tr>
						<?php
						$sql = "SELECT user2_id FROM matches WHERE user1_id = $u1id AND match_state=3";
						$result = $conn->query($sql);
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								$sql2 = "SELECT first_name, last_name FROM user WHERE user_id=?";
								$stmt = $conn->prepare($sql2);
								$stmt->bind_param("i", $row['user2_id']);
								$stmt->execute();
								$result2 = $stmt->get_result();
								$u2 = $row['user2_id'];
								?>
								<tr onclick="window.location='./other_profile.php?uid=<?php echo $u2;?>&p=0';">
								<?php
								while($names = $result2->fetch_assoc()){
									//echo '<tr onclick="window.location="./other_profile.php?uid=123&p=0";">';
										echo '<td>' .$names['first_name']. '</td>';
										echo '<td>' .$names['last_name']. '</td>';
										echo '</tr>';
								}
							}
						}
					/*?>
						
                        <tr onclick="window.location='./other_profile.php?uid=123&p=0';"> 
                           <td>John</td>
                           <td>Doe</td> 
                        </tr>
                       */
					?>
                    </table>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>