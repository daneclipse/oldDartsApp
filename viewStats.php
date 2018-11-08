<?php

include('connection.php');
$user_username = $_GET['username'];

?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS FILES -->
        <link rel="stylesheet" type="text/css" href="css/general.css">
        <link rel="stylesheet" type="text/css" href="css/account.css">
    </head>
    <body>

        <div class="navBar">
            <h1 class="accountName"><?= $user_username;?></h1>
            <a href="account.php?username=<?=$user_username;?>">Back to account</a>
            <span class="logOutButton"><a href="login.php" >Log out</a></span>
        </div><!-- CLOSE DIV WITH CLASS NAVBAR -->

        <div class="page">
            <div class="viewStatsButtons">
                <a class="viewStatsButton" href="X01/viewX01Stats.php?username=<?=$user_username;?>">X01 Stats</a>
                <a class="viewStatsButton" href="100DartsAt/view100DartsStats.php?username=<?=$user_username;?>">100 Darts Stats</a>
                <a class="viewStatsButton" href="roundTheWorld/viewWorldStats.php?username=<?=$user_username;?>">Round the world stats</a>
                <a class="viewStatsButton" href="cricket/viewCricketStats.php?username=<?=$user_username;?>">Cricket stats</a>
                <a class="viewStatsButton" href="noughts&crosses/viewN&CStats.php?username=<?=$user_username;?>">Tic Tac Toe stats</a>
            </div><!-- CLOSE DIV WITH ID VIEWSTATSBUTTON -->
        </div><!-- CLOSE DIV WITH CLASS PAGE -->

    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    </body>
</html>