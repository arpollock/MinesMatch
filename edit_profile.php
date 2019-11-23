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
                    <div class="flex-input">
                        <label for="gender">What is your gender?</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                        <input type="text" name="gender" id="gender" class="pinfo-input" value="<?php echo $gender;?>"/>
                        <span class="error">* Required</span>
                    </div>
                    <br/>
                    <div class="flex-input">
                        <label for="orientation">What is your sexual orientation?</label> <!--TODO: should we technically get this from SQl--> <!-- could do this generation in a loop but is it actually easier or just less code?? -->
                        <input type="text" name="orientation" id="orientation" class="pinfo-input" value="<?php echo $orientation;?>"/>
                        <span class="error">* Required</span>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Academic Information</legend>
                    <div class="flex-input">
                        <label for="major">What is your major?</label>
                        <input type="text" name="major" id="major" class="pinfo-input" value="<?php echo $major;?>"/>
                        <span class="error">* Required</span>
                    </div>
                    <br/>
                    <div class="flex-input">
                        <label for="major">What majors are you interested in?</label>
                        <input type="text" name="majors_pref" id="majors_pref" class="pinfo-input" value="<?php echo $majors_pref;?>"/>
                        <span class="error">* Required</span>
                    </div>
                    <br/>
                    <div class="flex-input">
                        <label for="grad_year">What year are you graduating?</label>
                        <input type="text" name="grad_year" id="grad_year" class="pinfo-input" value="<?php echo $grad_year;?>"/>
                        <span class="error">* Required</span>
                    </div>
                    <br/>
                    <div class="flex-input">
                        <label for="grad_years_pref">What graduation years are you interested in?</label>
                        <input type="text" name="grad_years_pref" id="grad_years_pref" class="pinfo-input" value="<?php echo $grad_years_pref;?>"/>
                        <span class="error">* Required</span>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Free (and Fun) Response</legend>
                    <div class="flex-input">
                        <label for="ideal_date">What is your ideal date?</label>
                        <input type="text" name="ideal_date" id="ideal_date" class="pinfo-input" value="<?php echo $ideal_date;?>"/>
                    </div>
                    <br/>
                    <div class="flex-input">
                        <label for="nerdiness">What is your nerdiest characteristic?</label>
                        <input type="text" name="nerdiness" id="nerdiness" class="pinfo-input" value="<?php echo $nerdiness;?>"/>
                        </div>
                    <br/>
                    <div class="flex-input">
                        <label for="place">What is your favorite place to go in Golden?</label>
                        <input type="text" name="place" id="place" class="pinfo-input" value="<?php echo $place;?>"/>
                    </div>
                </fieldset>
                <div class="preference-buttons">
                    <button id="cancel">Cancel (TODO)</button>
                    <input type="submit" name="submit" value="Save Preferences" class="submit-preferences"/>
                </div>
            </form>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>