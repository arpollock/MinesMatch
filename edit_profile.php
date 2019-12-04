<?php
	if(!isset($_COOKIE['user'])){
		header("location: ./login.php");
	}
    $current_page = "edit_profile";
    $path_to_home = "./";
	
    include "databse_conn.php";
    
	// Form Validation
	$required = array('gender', 'orientation', 'major', 'grad_year');
	$error = false;
	
	if(isset($_POST['submit'])) {
		foreach($required as $field) {
			if(empty($_POST[$field])){
				$error = true;
			}
		}
		if(!$error){
			
			$u1id = $_COOKIE['user'];
			//Delete any existing question answers if they are answering again
			$clearsql = "DELETE FROM preference WHERE user_id=? AND question_id < 7";
			$clear = $conn->prepare($clearsql);
			$clear->bind_param('i', $u1id);
			$clear->execute();
			
			$sql_check = "SELECT * FROM preference WHERE user_id = ? AND question_id > 6";
			$stmt = $conn->prepare($sql_check);
			$stmt->bind_param('i', $u1id);
			$stmt->execute();
			$result = $stmt->get_result();
			$count = mysqli_num_rows($result);
			$insert = false;
			
			if($count < 3){
				$insert = true;
			}
			
			
			//Insert question answers into the database
			$sql = "INSERT INTO preference(user_id, question_id, question_answer) VALUES(?, ?, ?)";
			$stmt = $conn->prepare($sql);
			
			$gender = 1;
			$stmt->bind_param('iis', $u1id, $gender, $_POST['gender']);
			$stmt->execute();
			
			$orientation = 2;
			$stmt->bind_param('iis', $u1id, $orientation, $_POST['orientation']);
			$stmt->execute();
			
			$major = 3;
			$stmt->bind_param('iis', $u1id, $major, $_POST['major']);
			$stmt->execute();
			
			/*$major_p = 4;
			$stmt->bind_param('iis', $u1id, $major_p, $_POST['majors_pref']);
			$stmt->execute();*/
			
			$grad = 5;
			$stmt->bind_param('iis', $u1id, $grad, $_POST['grad_year']);
			$stmt->execute();
			
			/*$grad_p = 6;
			$stmt->bind_param('iis', $u1id, $grad_p, $_POST['grad_year_pref']);
			$stmt->execute();*/
			$updatesql = "UPDATE preference SET question_answer=? WHERE question_id=?";
			$update = $conn->prepare($updatesql);
			
			if(!$insert){
				$ideal_date_p = 7;
				$update->bind_param("si", $_POST['ideal_date'], $ideal_date_p);
				$update->execute();
				
				$nerd_char = 8;
				$update->bind_param("si", $_POST['nerdiness'], $nerd_char);
				$update->execute();
				
				$golden = 9;
				$update->bind_param("si", $_POST['place'], $golden);
				$update->execute();
				
				$bio = 10;
				$update->bind_param('si', $_POST['bio'], $bio);
				$update->execute();
			}
			else {
				$ideal_date_p = 7;
				$stmt->bind_param('iis', $u1id, $ideal_date_p, $_POST['ideal_date']);
				$stmt->execute();
				
				$nerd_char = 8;
				$stmt->bind_param('iis', $u1id, $nerd_char, $_POST['nerdiness']);
				$stmt->execute();
				
				$golden = 9;
				$stmt->bind_param('iis', $u1id, $golden, $_POST['place']);
				$stmt->execute();
				
				$bio = 10;
				$stmt->bind_param('iis', $u1id, $bio, $_POST['bio']);
				$stmt->execute();
			}
			
			header('Location: ./my_profile.php');
		}
	}
	if(isset($_POST['cancel'])){
		header('Location: ./my_profile.php');
	}

?>


<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Edit Profile</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Dashboard"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/form.css">
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <h2>Edit My Profile</h2>
			<?php
				$u1id = $_COOKIE['user'];
				if($error){
					echo "<p class='error'>*You did not fill in all required fields!</p>";
				}
				//value bind for your gender
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=1";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$fem = $pref['question_answer'];
				//value bind for preferred gender
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=2";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$genpref = $pref['question_answer'];
				//value bind for your major
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=3";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$maj = $pref['question_answer'];
				//value bind for your grad year
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=5";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$gy = $pref['question_answer'];
				//value bind for ideal date
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=7";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$date_ideal = $pref['question_answer'];
				//value bind for nerdiest characteristic
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=8";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$char_nerdy = $pref['question_answer'];
				//value bind for fave golden place
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=9";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$place_fave = $pref['question_answer'];
				//value bind for bio
				$sqlPrefs = "SELECT question_answer FROM preference WHERE user_id = ? AND question_id=10";
				$sqlPref = $conn->prepare($sqlPrefs);
				$sqlPref->bind_param("i", $u1id);
				$sqlPref->execute();
				$prefs = $sqlPref->get_result();
				$pref = $prefs->fetch_assoc();
				$bio_full = $pref['question_answer'];
				
			?>
            <form id="edit_preferences" method="POST">
                <fieldset>
                    <legend>Gender &amp; Sexual Preferences</legend>
					<!--TODO: These responses must be saved in the database-->
                    <span>What is your gender?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="gender" id="male" class="pinfo-input" value="male" <?php if(strcmp($fem, "male") == 0){echo "checked";} ?> />
                    <label for="male">Male</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="gender" id="female" class="pinfo-input" value="female" <?php if(strcmp($fem, "female") == 0){echo "checked";} ?>/>
                    <label for="female">Female</label>
                    <br/>
                    <input type="radio" name="gender" id="nb" class="pinfo-input" value="nb" <?php if(strcmp($fem, "nb") == 0){echo "checked";} ?>/>
                    <label for="nb">Non-binary</label>
                    <br/>
                    <input type="radio" name="gender" id="na" class="pinfo-input" value="na" <?php if(strcmp($fem, "Prefer not to Answer") == 0){echo "checked";} ?>/>
                    <label for="na">Prefer not to Answer</label>
                    <br/>
                    <br/>

                    <span>What genders would you like to match with?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="orientation" id="male" class="pinfo-input" value="male" <?php if(strcmp($genpref, "male") == 0){echo "checked";} ?>/>
                    <label for="male">Males</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="orientation" id="female" class="pinfo-input" value="female" <?php if(strcmp($genpref, "female") == 0){echo "checked";} ?>/>
                    <label for="female">Females</label>
                    <br/>
                    <input type="radio" name="orientation" id="both" class="pinfo-input" value="both" <?php if(strcmp($genpref, "both") == 0){echo "checked";} ?>/>
                    <label for="both">Both!</label>
                    <br/>
                    <br/>

                    <label for="bio">Your bio:</label>
                    <br/>
                    <textarea name="bio" id="bio" class="pinfo-input"><?php echo $bio_full;?></textarea>

                </fieldset>
                <fieldset>
                    <legend>Academic Information</legend>

                    <span>What is your major?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="major" id="math" class="pinfo-input" value="math" <?php if(strcmp($maj, "math") == 0){echo "checked";} ?>/>
                    <label for="math">Applied Mathematics and Statistics</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="major" id="biochem" class="pinfo-input" value="biochem" <?php if(strcmp($maj, "biochem") == 0){echo "checked";} ?>/>
                    <label for="biochem">Biochemistry</label>
                    <br/>
                    <input type="radio" name="major" id="cheme" class="pinfo-input" value="cheme" <?php if(strcmp($maj, "cheme") == 0){echo "checked";} ?>/>
                    <label for="cheme">Chemical Engineering</label>
                    <br/>
                    <input type="radio" name="major" id="chem" class="pinfo-input" value="chem" <?php if(strcmp($maj, "chem") == 0){echo "checked";} ?>/>
                    <label for="chem">Chemistry</label>
                    <br/>
                    <input type="radio" name="major" id="civil" class="pinfo-input" value="civil" <?php if(strcmp($maj, "civil") == 0){echo "checked";} ?>/>
                    <label for="civil">Civil Engineering</label>
                    <br/>
                    <input type="radio" name="major" id="compsci" class="pinfo-input" value="compsci" <?php if(strcmp($maj, "compsci") == 0){echo "checked";} ?>/>
                    <label for="compsci">Computer Science</label> 
                    <br/>
                    <input type="radio" name="major" id="econ" class="pinfo-input" value="econ" <?php if(strcmp($maj, "econ") == 0){echo "checked";} ?>/>
                    <label for="econ">Economics</label> 
                    <br/>
                    <input type="radio" name="major" id="electrical" class="pinfo-input" value="electrical" <?php if(strcmp($maj, "electrical") == 0){echo "checked";} ?>/>
                    <label for="electrical">Electrical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="engineering" class="pinfo-input" value="engineering <?php if(strcmp($maj, "engineering") == 0){echo "checked";} ?>"/>
                    <label for="engineering">Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="physics" class="pinfo-input" value="physics" <?php if(strcmp($maj, "physics") == 0){echo "checked";} ?>/>
                    <label for="physics">Engineering Physics</label> 
                    <br/>
                    <input type="radio" name="major" id="enviro" class="pinfo-input" value="enviro" <?php if(strcmp($maj, "enviro") == 0){echo "checked";} ?>/>
                    <label for="enviro">Environmental Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="geo" class="pinfo-input" value="geo" <?php if(strcmp($maj, "geo") == 0){echo "checked";} ?>/>
                    <label for="geo">Geological Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="geophys" class="pinfo-input" value="geophys" <?php if(strcmp($maj, "geophys") == 0){echo "checked";} ?>/>
                    <label for="geophys">Geophysical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="hass" class="pinfo-input" value="hass" <?php if(strcmp($maj, "hass") == 0){echo "checked";} ?>/>
                    <label for="hass">Humanities, Arts, &amp; Social Sciences</label> 
                    <br/>
                    <input type="radio" name="major" id="meche" class="pinfo-input" value="meche" <?php if(strcmp($maj, "meche") == 0){echo "checked";} ?>/>
                    <label for="meche">Mechanical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="mme" class="pinfo-input" value="mme" <?php if(strcmp($maj, "mme") == 0){echo "checked";} ?>/>
                    <label for="mme">Metallurgical &amp; Materials Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="mining" class="pinfo-input" value="mining" <?php if(strcmp($maj, "mining") == 0){echo "checked";} ?>/>
                    <label for="mining">Mining Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="petro" class="pinfo-input" value="petro" <?php if(strcmp($maj, "petro") == 0){echo "checked";} ?>/>
                    <label for="petro">Petroleum Engineering</label> 
                    <br/>
                    <br/>

                    <!--<span>What majors are you interested in?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="math_pref" class="pinfo-input" value="math"/>
                    <label for="math_pref">Applied Mathematics and Statistics</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="biochem_pref" class="pinfo-input" value="biochem"/>
                    <label for="biochem_pref">Biochemistry</label>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="cheme_pref" class="pinfo-input" value="cheme"/>
                    <label for="cheme_pref">Chemical Engineering</label>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="chem_pref" class="pinfo-input" value="chem"/>
                    <label for="chem_pref">Chemistry</label>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="civil_pref" class="pinfo-input" value="civil"/>
                    <label for="civil_pref">Civil Engineering</label>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="compsci_pref" class="pinfo-input" value="compsci"/>
                    <label for="compsci_pref">Computer Science</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="econ_pref" class="pinfo-input" value="econ"/>
                    <label for="econ_pref">Economics</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="electrical_pref" class="pinfo-input" value="electrical"/>
                    <label for="electrical_pref">Electrical Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="engineering_pref" class="pinfo-input" value="engineering"/>
                    <label for="engineering_pref">Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="physics_pref" class="pinfo-input" value="physics"/>
                    <label for="physics_pref">Engineering Physics</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="enviro_pref" class="pinfo-input" value="enviro"/>
                    <label for="enviro_pref">Environmental Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="geo_pref" class="pinfo-input" value="geo"/>
                    <label for="geo_pref">Geological Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="geophys_pref" class="pinfo-input" value="geophys"/>
                    <label for="geophys_pref">Geophysical Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="hass_pref" class="pinfo-input" value="hass"/>
                    <label for="hass_pref">Humanities, Arts, &amp; Social Sciences</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="meche_pref" class="pinfo-input" value="meche"/>
                    <label for="meche_pref">Mechanical Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="mme_pref" class="pinfo-input" value="mme"/>
                    <label for="mme_pref">Metallurgical &amp; Materials Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="mining_pref" class="pinfo-input" value="mining"/>
                    <label for="mining_pref">Mining Engineering</label> 
                    <br/>
                    <input type="checkbox" name="majors_pref" id="petro_pref" class="pinfo-input" value="petro"/>
                    <label for="petro_pref">Petroleum Engineering</label> 
                    <br/>-->
           

                    <span>What year are you graduating?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="grad_year" id="2020" class="pinfo-input" value="2020" <?php if(strcmp($gy, "2020") == 0){echo "checked";} ?>/>
                    <label for="2020">2020</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2021" class="pinfo-input" value="2021" <?php if(strcmp($gy, "2021") == 0){echo "checked";} ?>/>
                    <label for="2021">2021</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2022" class="pinfo-input" value="2022" <?php if(strcmp($gy, "2022") == 0){echo "checked";} ?>/>
                    <label for="2022">2022</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2023" class="pinfo-input" value="2023" <?php if(strcmp($gy, "2023") == 0){echo "checked";} ?>/>
                    <label for="2023">2023</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2024" class="pinfo-input" value="2024" <?php if(strcmp($gy, "2024") == 0){echo "checked";} ?>/>
                    <label for="2024">2024</label> 
                    <br/>
                    <br/>

                    <!--<span>What graduation years are you interested in?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="checkbox" name="grad_year_pref" id="2020_pref" class="pinfo-input" value="2020"/>
                    <label for="2020_pref">2020</label> 
                    <br/>
                    <input type="checkbox" name="grad_year_pref" id="2021_pref" class="pinfo-input" value="2021"/>
                    <label for="2021_pref">2021</label> 
                    <br/>
                    <input type="checkbox" name="grad_year_pref" id="2022_pref" class="pinfo-input" value="2022"/>
                    <label for="2022_pref">2022</label> 
                    <br/>
                    <input type="checkbox" name="grad_year_pref" id="2023_pref" class="pinfo-input" value="2023"/>
                    <label for="2023_pref">2023</label> 
                    <br/>
                    <input type="checkbox" name="grad_year_pref" id="2024_pref" class="pinfo-input" value="2024"/>
                    <label for="2024_pref">2024</label> -->

                </fieldset>
                <fieldset>
                    <legend>Free (and Fun) Response</legend>

                    <label for="ideal_date">What is your ideal date?</label>
                    <br/>
                    <textarea name="ideal_date" id="ideal_date" class="pinfo-input"><?php echo $date_ideal;?></textarea>
                    <br/>
                    <br/>

                    <label for="nerdiness">What is your nerdiest characteristic?</label>
                    <br/>
                    <textarea name="nerdiness" id="nerdiness" class="pinfo-input"><?php echo $char_nerdy;?></textarea>
                    <br/>
                    <br/>

                    <label for="place">What is your favorite place in Golden?</label>
                    <br/>
                    <textarea name="place" id="place" class="pinfo-input"><?php echo $place_fave;?></textarea>
                
                </fieldset>
                <div class="preference-buttons">
                    <input type="submit" id="cancel" name="cancel" class="submit-preferences button" value="Cancel"/>
                    <input type="submit" name="submit" value="Save Preferences" class="submit-preferences button"/>
                </div>
            </form>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>