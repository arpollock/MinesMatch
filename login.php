<?php
    $current_page = "login";
    $path_to_home = "./";
?>

<!DOCTYPE html>
<html lang="en">
    <head>  
        <!-- This content is hidden from the main viewport -->
        <title>Mines Match - Login</title>
        <meta charset="utf-8"/>
        <meta name="description" content="Mines Match Login"/>
        <meta name="author" content="Alex P, Emma M, and Morgan C"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/global.css">
        <link rel="stylesheet" type="text/css" href="./styles/login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="./scripts/login.js"></script>
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <section class="main-content">
            <div class="login-form">
                <div id="toggle-login" onclick="toggle_login()">Sign Up</div>
                <h1>Welcome to Mines Match!</h1>
                <p>The online dating service for geeks, by geeks.</p>
                <form id="returning_user">
                    <div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" class="login-text-input"/>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <div class="flex-input">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" class="login-text-input"/>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <input type="submit" name="submit" value="Login" class="submit-login"/>
                </form>
                <form id="new_user">
                    <div class="flex-input">
                        <label for="email">Email: </label>
                        <input type="text" name="email" id="email" class="login-text-input"/>
                    </div>
                    <span class="error">* <?php /* TODO */?></span>
                    <br/>
                    <input type="submit" name="submit" value="Sign Up" class="submit-login"/>
                </form>
            </div>
        </section>
    </body>
</html>