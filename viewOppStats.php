<?php

include('connection.php');

$account = $_GET['account'];
$user_username = $_GET['username'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="navBar">
  <h1><?= $user_username;?></h1>
  <a href="account.php?username=<?=$account;?>">Back to account</a>
  <a href="login.php">Log out</a>
</div>

<button id="legStats">Stats by legs</button>
<button id="overallStats">Overall stats</button>

<div id="viewStats"></div>



<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <script type="text/javascript">
  	var legStats = $('#legStats');
  	var overallStats = $('#overallStats');
  	var viewStats = $('#viewStats');

  	legStats.on('click', function()
  	{
      $(viewStats).empty();
      var xmlhttp;
      xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState == 4 && this.status == 200) 
        {
          $(viewStats).html(this.responseText);
        }
      }
      xmlhttp.open('GET', 'stats.php?username=<?=$user_username;?>'+'&stats=leg', true);
      xmlhttp.send();
  	})

  	overallStats.on('click', function()
    {
      $(viewStats).empty();
      var xmlhttp;
      xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState == 4 && this.status == 200) 
        {
          $(viewStats).html(this.responseText);
        }
      }
      xmlhttp.open('GET', 'stats.php?username=<?=$user_username;?>'+'&stats=overall', true);
      xmlhttp.send();
    })



  </script>

  


</body>
</html>