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
    </head>
    <body>
        <!-- This content is seen on the main viewport -->
        <?php include './templateHeader.php'; ?>
        <section class="main-content">
            <section class="tab-wrapper">
                <div class="tab-header">
                    <div class="tab-item tab-item-active">
                        Pending Matches
                    </div>
                    <div class="tab-item">
                        Successful Matches
                    </div>
                </div>
                <div class="tab-content" id="pending-matches">
                    <table class="match-table">
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th> 
                        </tr>
                        <tr>
                           <td>John</td>
                           <td>Doe</td> 
                        </tr>
                        <tr>
                           <td>Foo</td>
                           <td>Blah</td> 
                        </tr>
                    </table>
                </div>
                <div class="tab-content" id="successful-matches">

                </div>
            </section>
        </section>
        <?php include './templateFooter.php'; ?>
    </body>
</html>