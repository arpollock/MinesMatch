<?php
    $current_page = "edit_profile";
    $path_to_home = "./";
	
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
            <form id="edit_preferences">
                <fieldset>
                    <legend>Gender &amp; Sexual Preferences</legend>

                    <span>What is your gender?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="gender" id="male" class="pinfo-input" value="male"/>
                    <label for="male">Male</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="gender" id="female" class="pinfo-input" value="female"/>
                    <label for="female">Female</label>
                    <br/>
                    <input type="radio" name="gender" id="nb" class="pinfo-input" value="nb"/>
                    <label for="nb">Non-binary</label>
                    <br/>
                    <input type="radio" name="gender" id="na" class="pinfo-input" value="na"/>
                    <label for="na">Prefer not to Answer</label>
                    <br/>
                    <br/>

                    <span>What is your sexual orientation?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="orientation" id="straight" class="pinfo-input" value="straight"/>
                    <label for="straight">Straight</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="orientation" id="gay" class="pinfo-input" value="gay"/>
                    <label for="gay">Gay/Lesbian</label>
                    <br/>
                    <input type="radio" name="orientation" id="bi" class="pinfo-input" value="bi"/>
                    <label for="bi">Bisexual</label>
                    <br/>
                    <input type="radio" name="orientation" id="pan" class="pinfo-input" value="pan"/>
                    <label for="pan">Pansexual</label>
                </fieldset>
                <fieldset>
                    <legend>Academic Information</legend>

                    <span>What is your major?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="major" id="math" class="pinfo-input" value="math"/>
                    <label for="math">Applied Mathematics and Statistics</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                    <br/>
                    <input type="radio" name="major" id="biochem" class="pinfo-input" value="biochem"/>
                    <label for="biochem">Biochemistry</label>
                    <br/>
                    <input type="radio" name="major" id="cheme" class="pinfo-input" value="cheme"/>
                    <label for="cheme">Chemical Engineering</label>
                    <br/>
                    <input type="radio" name="major" id="chem" class="pinfo-input" value="chem"/>
                    <label for="chem">Chemistry</label>
                    <br/>
                    <input type="radio" name="major" id="civil" class="pinfo-input" value="civil"/>
                    <label for="civil">Civil Engineering</label>
                    <br/>
                    <input type="radio" name="major" id="compsci" class="pinfo-input" value="compsci"/>
                    <label for="compsci">Computer Science</label> 
                    <br/>
                    <input type="radio" name="major" id="econ" class="pinfo-input" value="econ"/>
                    <label for="econ">Economics</label> 
                    <br/>
                    <input type="radio" name="major" id="electrical" class="pinfo-input" value="electrical"/>
                    <label for="electrical">Electrical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="engineering" class="pinfo-input" value="engineering"/>
                    <label for="engineering">Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="physics" class="pinfo-input" value="physics"/>
                    <label for="physics">Engineering Physics</label> 
                    <br/>
                    <input type="radio" name="major" id="enviro" class="pinfo-input" value="enviro"/>
                    <label for="enviro">Environmental Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="geo" class="pinfo-input" value="geo"/>
                    <label for="geo">Geological Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="geophys" class="pinfo-input" value="geophys"/>
                    <label for="geophys">Geophysical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="hass" class="pinfo-input" value="hass"/>
                    <label for="hass">Humanities, Arts, &amp; Social Sciences</label> 
                    <br/>
                    <input type="radio" name="major" id="meche" class="pinfo-input" value="meche"/>
                    <label for="meche">Mechanical Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="mme" class="pinfo-input" value="mme"/>
                    <label for="mme">Metallurgical &amp; Materials Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="mining" class="pinfo-input" value="mining"/>
                    <label for="mining">Mining Engineering</label> 
                    <br/>
                    <input type="radio" name="major" id="petro" class="pinfo-input" value="petro"/>
                    <label for="petro">Petroleum Engineering</label> 
                    <br/>
                    <br/>

                    <span>What majors are you interested in?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="checkbox" name="majors_pref" id="math_pref" class="pinfo-input" value="math"/>
                    <label for="math_pref">Applied Mathematics and Statistics</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
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
                    <br/>
                    <br/>

                    <span>What year are you graduating?</span><span class="error"> * Required</span>
                    <br/>
                    <input type="radio" name="grad_year" id="2020" class="pinfo-input" value="2020"/>
                    <label for="2020">2020</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2021" class="pinfo-input" value="2021"/>
                    <label for="2021">2021</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2022" class="pinfo-input" value="2022"/>
                    <label for="2022">2022</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2023" class="pinfo-input" value="2023"/>
                    <label for="2023">2023</label> 
                    <br/>
                    <input type="radio" name="grad_year" id="2024" class="pinfo-input" value="2024"/>
                    <label for="2024">2024</label> 
                    <br/>
                    <br/>

                    <span>What graduation years are you interested in?</span><span class="error"> * Required</span>
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
                    <label for="2024_pref">2024</label> 

                </fieldset>
                <fieldset>
                    <legend>Free (and Fun) Response</legend>

                    <label for="ideal_date">What is your ideal date?</label>
                    <br/>
                    <textarea name="ideal_date" id="ideal_date" class="pinfo-input"></textarea>
                    <br/>
                    <br/>

                    <label for="nerdiness">What is your nerdiest characteristic?</label>
                    <br/>
                    <textarea name="nerdiness" id="nerdiness" class="pinfo-input"></textarea>
                    <br/>
                    <br/>

                    <label for="place">What is your favorite place in Golden?</label>
                    <br/>
                    <textarea name="place" id="place" class="pinfo-input"></textarea>
                
                </fieldset>
                <div class="preference-buttons">
                    <button id="cancel" class="button">Cancel (TODO)</button>
                    <input type="submit" name="submit" value="Save Preferences" class="submit-preferences button"/>
                </div>
            </form>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>