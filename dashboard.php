<?php
    $current_page = "dashboard";
    $path_to_home = "./";
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
                    <table class="match-table">
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th> 
                        </tr>
                        <tr onclick="window.location='./other_profile.php?uid=123&p=1';"> 
                           <td>John</td>
                           <td>Doe</td> 
                        </tr>
                        <tr onclick="window.location='./other_profile.php?uid=456&p=1';">
                           <td>Foo</td>
                           <td>Blah</td> 
                        </tr>
                    </table>
                </div>
                <div class="tab-content" id="successful-matches" style="display: none;">
                    <h2>Successful Matches</h2>
                    <table class="match-table">
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th> 
                        </tr>
                        <tr onclick="window.location='./other_profile.php?uid=789&p=0';"> 
                           <td>Al</td>
                           <td>Dog</td> 
                        </tr>
                        <tr onclick="window.location='./other_profile.php?uid=666&p=0';">
                           <td>Snoop</td>
                           <td>Dog</td> 
                        </tr>
                    </table>
                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>