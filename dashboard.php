<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}

    $current_page = "dashboard";
    $path_to_home = "./";
	include "databse_conn.php";
?>
<?php
	// Add in user to the matches database, with the potential to match to every user. Set state = 0, pending both 
	$state = 0;
	$my_uid = $_COOKIE['user'];
	$no_preferences = true;

	//get the gender they want to match with
	$my_genderpref_statement = "SELECT question_answer FROM preference WHERE question_id=2 AND user_id=?";
	$my_genderpref_sql = $conn->prepare($my_genderpref_statement);
	$my_genderpref_sql->bind_param("i", $my_uid);
	$my_genderpref_sql->execute();
	$my_genpref = $my_genderpref_sql->get_result();
	if($my_genpref->num_rows > 0){
		$my_gender_pref = $my_genpref->fetch_assoc();
		$gender_real_pref = $my_gender_pref['question_answer'];
		//get the gender of the current user
		$my_gender_sql = $conn->prepare("SELECT question_answer FROM preference WHERE question_id=1 AND user_id=?;");
		$my_gender_sql->bind_param("i", $my_uid);
		$my_gender_sql->execute();
		$my_gender_result = $my_gender_sql->get_result();
		$my_gen = '';
		if($my_gender_result->num_rows > 0){
			$no_preferences = false;
			$my_gen = $my_gender_result->fetch_assoc();
			$my_gender = $my_gen['question_answer'];
			$sql_get_all_possible_matches = "SELECT user_id FROM user WHERE user_id <> $my_uid;";
			$result_all_possib = $conn->query($sql_get_all_possible_matches);
			if($result_all_possib->num_rows > 0){
				while( $row = $result_all_possib->fetch_assoc() ){
					// see if already is a match
					$stmt_get_match = $conn->prepare("SELECT * FROM MATCHES WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?);");
					$stmt_get_match->bind_param("iiii", $my_uid, $row['user_id'], $row['user_id'], $my_uid);
					$stmt_get_match->execute();
					$stmt_get_match_result = $stmt_get_match->get_result();
					if($stmt_get_match_result->num_rows == 0){
						//get the gender of the other user
						$gendersql = $conn->prepare("SELECT question_answer FROM preference WHERE question_id=1 AND user_id=?;");
						$gendersql->bind_param("i", $row['user_id']);
						$gendersql->execute();
						$gen2 = $gendersql->get_result();
						$gender2 = $gen2->fetch_assoc();
						$genderReal = $gender2['question_answer'];
						//get the gender the other user wants to match with
						$genderpref_statement = "SELECT question_answer FROM preference WHERE question_id=2 AND user_id=?";
						$genderpref_sql = $conn->prepare($genderpref_statement);
						$genderpref_sql->bind_param("i", $row['user_id']);
						$genderpref_sql->execute();
						$genpref = $genderpref_sql->get_result();
						$gender_pref = $genpref->fetch_assoc();
						$their_gender_real_pref = $gender_pref['question_answer'];
						
						//if the gender prefs match, then display
						$compare1 = strcmp($gender_real_pref, $genderReal);
						$compare2 = strcmp($their_gender_real_pref, $my_gender);

						// string comparison doesn't work for both answer
						if($gender_real_pref == 'both' ) {
							$compare1 = 0;
						}
						if($their_gender_real_pref == 'both') {
							$compare2 = 0;
						}
						
						if($compare1 == 0 && $compare2 == 0){
							$sql_create_match = "INSERT INTO matches(user1_id, user2_id, match_state) VALUES(?,?,?);";
							$stmt_create_match = $conn->prepare($sql_create_match);
							$stmt_create_match->bind_param("iii", $my_uid, $row['user_id'], $state);
							$stmt_create_match->execute();
						}
					}
				}
			}
		}
	}
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
			<section class="blocked-tabs" <?php if ($no_preferences) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?> >
				<p>Go to <a href="./my_profile.php">My Profile<a> > <a href="./edit_profile.php">Edit My Profile</a> to fill out your match information. Then we can start looking for the geek of your dreams!</p>
			</section>
            <section class="tab-wrapper" <?php if ($no_preferences) { echo 'style="display: none;"'; } ?> >
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
						$sql_p_matches = "SELECT * FROM matches WHERE (user1_id=$my_uid OR user2_id=$my_uid) AND (match_state=0 OR match_state=1 OR match_state=2);";
						$result_p_matches = $conn->query($sql_p_matches);
						if($result_p_matches->num_rows > 0){
							while ( $row = $result_p_matches->fetch_assoc() ) {
								$user1_id = -1; 
								$user2_id = -1;
								$their_uid = -1;

								if($row['user1_id'] == $my_uid) { // i am 1 and they are 2
									$user1_id = $my_uid;
									$user2_id = $row['user2_id'];
									$their_uid = $row['user2_id'];
								} else if($row['user2_id'] == $my_uid) { // i am 2 and they are 1
									$user2_id = $my_uid;
									$user1_id = $row['user1_id'];
									$their_uid = $row['user1_id'];
								} else {
									echo('id assignment failed');
								}

								$sql_p_match_name = "SELECT first_name, last_name FROM user WHERE user_id=?;";
								$stmt_p_match_name = $conn->prepare($sql_p_match_name);
								$stmt_p_match_name->bind_param("i", $their_uid);
								$stmt_p_match_name->execute();
								$result_p_match_name = $stmt_p_match_name->get_result();
								$u2 = $their_uid;
					?>
									<tr onclick="window.location='./other_profile.php?uid=<?php echo $u2; ?>';">
					<?php
								while( $pnames = $result_p_match_name->fetch_assoc() ){
									echo '<td>' .$pnames['first_name']. '</td>';
									echo '<td>' .$pnames['last_name']. '</td>';
									echo '</tr>';
								}
							}
						} else {
							echo('<tr><td colspan=2>No pending matches at this time.</td></tr>');
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
						$sql_s_matches = "SELECT * FROM matches WHERE (user1_id=$my_uid OR user2_id=$my_uid) AND match_state=3;";
						$result_s_matches = $conn->query($sql_s_matches);
						if($result_s_matches->num_rows > 0){
							while($row = $result_s_matches->fetch_assoc()){
								$user1_id = -1; 
								$user2_id = -1;
								$their_uid = -1;

								if($row['user1_id'] == $my_uid) { // i am 1 and they are 2
									$user1_id = $my_uid;
									$user2_id = $row['user2_id'];
									$their_uid = $row['user2_id'];
								} else if($row['user2_id'] == $my_uid) { // i am 2 and they are 1
									$user2_id = $my_uid;
									$user1_id = $row['user1_id'];
									$their_uid = $row['user1_id'];
								} else {
									echo('id assignment failed');
								}

								$sql2_s_matches = "SELECT first_name, last_name FROM user WHERE user_id=?";
								$stmt_s_matches = $conn->prepare($sql2_s_matches);
								$stmt_s_matches->bind_param("i", $their_uid);
								$stmt_s_matches->execute();
								$result2_s_matches = $stmt_s_matches->get_result();
								$u2 = $their_uid;
								?>
								<tr onclick="window.location='./other_profile.php?uid=<?php echo $u2;?>';">
								<?php
								while($names = $result2_s_matches->fetch_assoc()){
									//echo '<tr onclick="window.location="./other_profile.php?uid=123&p=0";">';
										echo '<td>' .$names['first_name']. '</td>';
										echo '<td>' .$names['last_name']. '</td>';
										echo '</tr>';
								}
							}
						} else {
							echo('<tr><td colspan=2>No successful matches at this time.</td></tr>');
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