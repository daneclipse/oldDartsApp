<?php

include('connection.php');
$user_username = $_GET['name'];
$game = $_GET['game'];

if ($game == 'X01') 
{
	$opponent = $_GET['opponent'];
	$target = $_GET['target'];
	$totalScored = $_GET['scored'];
	$dartsUsed = $_GET['darts'];
	$getAverage = $_GET['average'];
	$user_checkout = $_GET['checkout'];
	$doublePercent = $_GET['doublePercent'];
	$doubleHit = $_GET['doubleHit'];
	$highScore = $_GET['highScore'];
	$missedDarts = $_GET['dartsMissed'];

	$average = number_format($getAverage, 2);


	// if username is in users table, insert as opponent, otherwise opponent = username
	// if opponent is in users table allow the name to be pressed and go to their account

	if ($totalScored == $target) 
	{
		$legOutcome = 'won';
	}
	else
	{
		$legOutcome = 'lost';
	}

	$threeAverage = $average * 3;
	$tda = number_format($threeAverage, 2);

	$insertData = mysqli_query($dbc, "INSERT INTO legStats (username, opponent, game_date, legTarget, totalScored, legOutcome, dartsUsed, average, tda, checkout, doublePercent, doubleHit, highScore, dartsMissed) VALUES ('$user_username', '$opponent', NOW(), '$target', '$totalScored', '$legOutcome', '$dartsUsed', '$average', '$tda', '$user_checkout', '$doublePercent', '$doubleHit', '$highScore', '$missedDarts')");
	$dataInserted = mysqli_affected_rows($dbc);
	if ($dataInserted > 0) 
	{
		echo 'stats inserted';
		$getUserData = mysqli_query($dbc, "SELECT * FROM userStats WHERE username='" . $user_username . "'");
		$dataRow = mysqli_num_rows($getUserData);
		if ($dataRow > 0) 
		{
			while($row = mysqli_fetch_array($getUserData))
			{
				$user_legsPlayed = $row['legsPlayed'];
				$user_legsWon = $row['legsWon'];
				$user_highestOut = $row['highestOut'];
				$user_double = $row['favDouble'];
				$user_highestScore = $row['highestScore'];
				$user_totalScored = $row['totalScored'];
				$user_dartsThrown = $row['dartsThrown'];
				$user_average = $row['average'];
			}

			// ADD 1 TO LEGS PLAYED & UPDATE USERSTATS TABLE
			$newNumLegs = $user_legsPlayed + 1;
			$updateLegs = mysqli_query($dbc, "UPDATE userStats SET legsPlayed='$newNumLegs' WHERE username='$user_username'");
			// IF THEY WON THE LEG, ADD 1 TO LEGS WON & UPDATE USERSTATS TABLE
			if ($totalScored == $target) 
			{
				$newLegsWon = $user_legsWon + 1;
				$updateLegsWon = mysqli_query($dbc, "UPDATE userStats SET legsWon='$newLegsWon' WHERE username='$user_username'");
			}
			else
			{
				echo 'LEGS WON NOT UPDATED';
			}
			
			// IF CHECKOUT IS HIGHER THAN CHECKOUT IN DATABASTE, UPDATE TO NEW ONE
			if ($user_checkout > $user_highestOut) 
			{
				$updateCheckout = mysqli_query($dbc, "UPDATE userStats SET highestOut='$user_checkout' WHERE username='$user_username'");
			}
			else
			{
				echo 'HIGHEST CHECKOUT ALREADY SET';
			}

			// SET FAVOURITE DOUBLE - DOUBLE THEY HAVE HIT THE MOST
			// set favourite double - get all doubles hit from doublehit column in legStats table and order them the one that has been hit the most = favourite double
			$getDouble = "SELECT doubleHit, COUNT(doubleHit) AS amount FROM legStats WHERE doubleHit > 0 AND username='$user_username' GROUP BY doubleHit ORDER BY amount DESC LIMIT 1";
			$doubleQuery = mysqli_query($dbc, $getDouble);
			$doubleRows = mysqli_num_rows($doubleQuery);
			if ($doubleRows > 0) 
			{
				while($row = mysqli_fetch_array($doubleQuery))
				{
					$favDouble = $row['doubleHit'];
				}
				if ($user_double != $favDouble) 
				{
					$updateDouble = mysqli_query($dbc, "UPDATE userStats SET favDouble='$favDouble' WHERE username='$user_username'");
				}
				else
				{
					echo 'FAVOURITE DOUBLE ALREADY SET';
				}
			}
			else
			{
				echo 'NO ROWS FOUND DOUBLE QUERY';
			}

			// IF HIGHSCORE IS HIGHER THAN HIGHSCORE IN DATABASE, UPDATE TO NEW ONE
			if ($highScore > $user_highestScore) 
			{
				$updateHighScore = mysqli_query($dbc, "UPDATE userStats SET highestScore='$highScore' WHERE username='$user_username'");
			}
			else
			{
				echo 'HIGH SCORE ALREADY SET';
			}
			$newTotalScored = $user_totalScored + $totalScored;
			$updateTotalScored = mysqli_query($dbc, "UPDATE userStats SET totalScored='$newTotalScored' WHERE username='$user_username'");
			$newDartsUsed = $user_dartsThrown + $dartsUsed;
			$updateDarts = mysqli_query($dbc, "UPDATE userStats SET dartsThrown='$newDartsUsed' WHERE username='$user_username'");
			$overallAverage = $newTotalScored / $newDartsUsed;
			$updateAverage = mysqli_query($dbc, "UPDATE userStats SET average='$overallAverage' WHERE username='$user_username'");
			echo 'STATS UPDATED!';
		}
		else
		{
			echo 'NO USER IN USER STATS TABLE';
		}
	}
	else
	{
		echo 'STATS NOT INSERTED TO LEG STATS TABLE';
	}
}
else if ($game == '100')
{
	$targetNumber = $_GET['targetNumber'];
	$singlesHit = $_GET['singles'];
	$doublesHit = $_GET['doubles'];
	$treblesHit = $_GET['trebles'];
	$pointsScored = $_GET['points'];
	$totalScored = $_GET['score'];
	$dartsMissed = $_GET['missed'];


	$insertUser = "INSERT INTO hundredDarts (username, targetNumber, singlesHit, doublesHit, treblesHit, pointsScored, totalScored, dartsMissed, game_date) VALUES ('$user_username', '$targetNumber', '$singlesHit', '$doublesHit', '$treblesHit', '$pointsScored', '$totalScored', '$dartsMissed', NOW())";
	$insertQuery = mysqli_query($dbc, $insertUser);
	$databaseRows = mysqli_affected_rows($dbc);

	if($databaseRows > 0)
	{
		echo 'STATS ADDED';
	}
	else
	{
		echo 'Error ' . E_ALL;
	}
}
else if ($game == 'world')
{
	$gameType = $_GET['gameType'];
	$singlesHit = $_GET['singles'];
	$doublesHit = $_GET['doubles'];
	$treblesHit = $_GET['trebles'];
	$totalScored = $_GET['score'];
	$dartsMissed = $_GET['missed'];
	$numDarts = $_GET['darts'];

	$insertUser = "INSERT INTO roundTheWorld (username, gameType, singlesHit, doublesHit, treblesHit, totalScored, dartsMissed, numDarts, game_date) VALUES ('$user_username', '$gameType', '$singlesHit', '$doublesHit', '$treblesHit', '$totalScored', '$dartsMissed', '$numDarts', NOW())";
	$insertQuery = mysqli_query($dbc, $insertUser);
	$databaseRows = mysqli_affected_rows($dbc);

	if($databaseRows > 0)
	{
		echo 'STATS ADDED';
	}
	else
	{
		echo 'Error ' . E_ALL;
	}
}
else if ($game == 'cricket')
{
	$opponent = $_GET['opponent'];
	$innings = $_GET['innings'];
	$firstScore = $_GET['first'];
	$secondScore = $_GET['second'];
	$totalScored = $_GET['total'];
	$over = $_GET['over'];
	$under = $_GET['under'];
	$outerBulls = $_GET['outerBulls'];
	$bullseyes = $_GET['bullseyes'];
	$trebles = $_GET['trebles'];
	$wides = $_GET['wides'];
	$runOuts = $_GET['runOuts'];
	$numDarts = $_GET['numDarts'];
	$gameOutcome = $_GET['gameOutcome'];
	$winMethod = $_GET['winMethod'];
	$difference = $_GET['difference'];

	$insertUser = "INSERT INTO cricket (username, opponent, game, firstInnings, secondInnings, totalScored, over, under, outerBulls, bullseyes, trebles, wides, runOuts, numDarts, game_date, gameOutcome, winMethod, difference) VALUES ('$user_username', '$opponent', '$innings', '$firstScore', '$secondScore', '$totalScored', '$over', '$under', '$outerBulls', '$bullseyes', '$trebles', '$wides', '$runOuts', '$numDarts', NOW(), '$gameOutcome', '$winMethod', '$difference')";
	$insertQuery = mysqli_query($dbc, $insertUser);
	$databaseRows = mysqli_affected_rows($dbc);

	if($databaseRows > 0)
	{
		echo 'STATS ADDED';
	}
	else
	{
		echo 'Error ' . E_ALL;
	}

}
else if ($game == 'ticTacToe')
{
	$opponent = $_GET['opponent'];
	$marker = $_GET['marker'];
	$games = $_GET['games'];
	$gamesWon = $_GET['gamesWon'];
	$outcome = $_GET['outcome'];
	$targets = $_GET['targets'];
	$targetOne = $_GET['targetOne'];
	$targetTwo = $_GET['targetTwo'];
	$targetThree = $_GET['targetThree'];
	$targetFour = $_GET['targetFour'];
	$targetFive = $_GET['targetFive'];
	$targetSix = $_GET['targetSix'];
	$average = $_GET['average'];
	$dartsUsed = $_GET['darts'];

	$insertUser = "INSERT INTO ticTacToe (username, opponent, marker, games, gamesWon, gameOutcome, targets, targetOne, targetTwo, targetThree, targetFour, targetFive, targetSix, dartsUsed, average, game_date) VALUES ('$user_username', '$opponent', '$marker', '$games', '$gamesWon', '$outcome', '$targets', '$targetOne', '$targetTwo', '$targetThree', '$targetFour', '$targetFive', '$targetSix', '$dartsUsed', '$average', NOW())";
	$insertQuery = mysqli_query($dbc, $insertUser);
	$databaseRows = mysqli_affected_rows($dbc);
	if ($databaseRows > 0) 
	{
		echo 'STATS ADDED';
	}
	else
	{
		echo 'Error ' . E_ALL;
	}
}

?>