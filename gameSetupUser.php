<!-- 

PAGE USED WHEN A USER PLAYS ANOTHER USER
USERNAME V OPPONENT - BOTH LOGGED IN

 -->

<?php

$user_username = $_GET['username'];
$opponent_username = $_GET['opponent'];

include('connection.php');

// if (isset($_POST['userStats'])) {
// 	$userData = "SELECT * FROM stats WHERE username='" . $user_username . "'";
// 	$userDataQuery = mysqli_query($dbc, $userData);
// 	$userRows = mysqli_num_rows($userDataQuery);

// 	if ($userRows > 0) 
// 	{
// 		while($row = mysqli_fetch_array($userDataQuery))
// 		{
// 			echo '<h3>' . $user_username . ' stats</h3>';
// 			echo '<ul>';
// 			echo '<li>Legs Played: ' . $row['legsPlayed'] . '</li>';
// 			echo '<li>Legs Won: ' . $row['legsWon'] . '<li>';
// 			echo '</ul>';
// 		}
// 	}
// 	else
// 	{
// 		echo 'NO USER';
// 	}
// }


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

	<div class="navBar">
		<h1 class="accountName"><?= $user_username;?></h1>
		<a href="account.php?username=<?=$user_username;?>">Back to account</a>
		<a href="index.php">Home</a>
	</div>

	<div class="page">

		<h4>Opponent <?=$opponent_username;?></h4>

		<select id="selectTarget">
			<option>Select Target</option>
			<option value="101">101</option>
			<option value="301">301</option>
			<option value="501">501</option>
		</select>

		<select id="selectLegs">
			<option>Select Legs</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>

		<button class="viewStatsButton">
			Start Game
		</button>
	</div>

<!-- <form method="post" action="gameSetupUser.php?username=<?=$user_username;?>&opponent=<?=$opponent_username;?>">
	<input type="submit" name="userStats" value="View user stats"><br />
	<input type="submit" name="oppStats" value="View opponent stats">
</form> -->


<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
	var selectTarget = $('#selectTarget');
	var selectLegs = $('#selectLegs');

	$('button').on('click', function()
	{
		var playerTarget = $('#selectTarget :selected').val();
		var playerLegs = $('#selectLegs :selected').val();
		location.replace('X01/x01Game.php?username=<?=$user_username;?>&opponent=<?=$opponent_username;?>&target=' + playerTarget + '&legs=' + playerLegs)
	})
</script>

</body>
</html>

