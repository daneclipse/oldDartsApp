<?php

include('../connection.php');

$user_username = $_GET['username'];
$stats = $_GET['stats'];
$gameType = $_GET['game'];

// <th><a href="viewStats.php?username=' . $user_username . '&stats=every">Date</a></th>

function showTable($row, $arr, $user_username, $gameType)
  {
      echo
      '<table border = "1">
      <tr>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=date">Game Date</a></th>
      <th>Game Type</th>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=darts">Darts Used</a></th>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=single">Singles Hit</a></th>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=double">Doubles Hit</a></th>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=treble">Trebles Hit</a></th>
      <th><a href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=1&order=points">Points Scored</a></th>
      <th>Darts Missed</th>
      </tr>';

      // $order = $_GET['order'];

      while ($row = mysqli_fetch_array($arr)) 
      {
        $date = $row['game_date'];
        $gameType = $row['gameType'];
        $singlesHit = $row['singlesHit'];
        $doublesHit = $row['doublesHit'];
        $treblesHit = $row['treblesHit'];
        $numDarts = $row['numDarts'];
        $totalScored = $row['totalScored'];
        $dartsMissed = $row['dartsMissed'];

        echo '<td>' . $date . '</td>';
        echo '<td>' . $gameType . '</td>';
        echo '<td>' . $numDarts . '</td>';
        echo '<td>' . $singlesHit . '</td>';
        echo '<td>' . $doublesHit . '</td>';
        echo '<td>' . $treblesHit . '</td>';
        echo '<td>' . $totalScored . '</td>';
        echo '<td>' . $dartsMissed . '</td></tr>';
      }
      echo '</table><br />';
  } // END OF SHOWTABLE FUNCTION

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/account.css">
	<link rel="stylesheet" type="text/css" href="../css/stats.css">
</head>
<body>

	<div class="navBar">
		<h1 class="accountName"><?= $user_username;?></h1>
		<a href="../account.php?username=<?=$user_username;?>">Back to account</a>
		<span class="logOutButton"><a href="../login.php">Log out</a></span>
	</div>

	<div class="page">
		<h1>Round the World stats</h1>
		<div class="viewStatsButtons">
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=every&game=all&page=1">EVERY GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=every&game=singles&page=1">EVERY SINGLES GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=every&game=doubles&page=1">EVERY DOUBLES GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=every&game=trebles&page=1">EVERY TREBLES GAME</a>
			<br /><br /><br />
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=best&game=all">BEST GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=best&game=singles">BEST SINGLES GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=best&game=doubles">BEST DOUBLES GAME</a>
			<a class="viewStatsButton" href="viewWorldStats.php?username=<?=$user_username;?>&stats=best&game=trebles">BEST TREBLES GAME</a> 

		</div>

		<div id="viewStats">
			
			<?php

			if (isset($_GET['stats'])) 
			{
				if (isset($_GET['game'])) 
				{
					$gameType = $_GET['game'];

					if ($_GET['stats'] == 'every') 
					{
		                $page = $_GET['page'];
		                $perPage = 10;
		                if ($page == '' || $page == 1) 
		                {
		                    $currentPage = 0;
		                }
		                else
		                {
		                    $currentPage = ($page * $perPage) - $perPage;
		                }
	             
		                if (isset($_GET['order'])) 
		                {
		                	if ($_GET['order'] == 'date') 
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'single')
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY singlesHit DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY singlesHit DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'double')
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY doublesHit DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY doublesHit DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'treble')
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY treblesHit DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY treblesHit DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'score')
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY totalScored DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY totalScored DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'darts')
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY numDarts ASC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY numDarts ASC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else
		                	{
		                		if ($gameType == 'all') 
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
		                		}
		                		else
		                		{
		                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
		                		}
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                }
		                else
		                {
		                		if ($gameType == 'all') 
	                		{
	                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
	                		}
	                		else
	                		{
	                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
	                		}
			                $statsQuery = mysqli_query($dbc, $getStats);
			                $numRows = mysqli_num_rows($statsQuery);
			            }

		                if ($numRows > 0) 
		                {
		                	showTable($numRows, $statsQuery, $user_username, $gameType);
		                    $query = mysqli_query($dbc, "SELECT * FROM roundTheWorld WHERE username='$user_username'");
		                    $totalRows = mysqli_num_rows($query);
		                    // how many records per page we want
		                    // work out total number of pages needed 
		                    // ceil gives you the next integar
		                    $totalPages = ceil($totalRows / $perPage);

		                    if ($page > 1) 
		                    {
		                        echo '<a class="pagination" href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=' . ($page - 1) . '"><< Previous</a>';
		                    }

		                    for($i = 1; $i <= $totalPages; $i++)
		                    {
		                        if ($page == $i) 
		                        {
		                          echo '<a class="pagination activePage" href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=' . $i . '">' . $i . '</a>';
		                        }
		                        else
		                        {
		                          echo '<a class="pagination" href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=' . $i . '">' . $i . '</a>';
		                        }
		                    }

		                    if ($page < $totalPages) 
		                    {
		                        echo '<a class="pagination" href="viewWorldStats.php?username=' . $user_username . '&stats=every&game=' . $gameType . '&page=' . ($page + 1) . '">Next >></a>';
		                    }
		                }
		                else
		                {
		                	echo '<p class="alertMessage redButton">NO STATS AVAILABLE</p>';
		                	echo '<button class="logIn"><a href="../gameSetup.php?username=' . $user_username . '">Start a game</a></button>';
		                }
					}
					else if ($_GET['stats'] == 'best') 
					{
                		if ($gameType == 'all') 
                		{
                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' ORDER BY totalScored DESC LIMIT 1";
                		}
                		else
                		{
                			$getStats = "SELECT * FROM roundTheWorld WHERE username='$user_username' AND gameType='$gameType' ORDER BY totalScored DESC LIMIT 1";
                		}
		                $statsQuery = mysqli_query($dbc, $getStats);
		                $numRows = mysqli_num_rows($statsQuery);

		                if ($numRows > 0) 
		                {
		            	    echo
						    '<table border = "1">
						    <tr>
						    <th>Game Date</th>
						    <th>Game Type</th>
						    <th>Darts Used</th>
						    <th>Singles Hit</th>
						    <th>Doubles Hit</th>
						    <th>Trebles Hit</th>
						    <th>Total Scored</th>
						    <th>Darts Missed</th>
						    </tr>';
						    // $order = $_GET['order'];

						    while ($row = mysqli_fetch_array($statsQuery)) 
						    {
						      $date = $row['game_date'];
						      $gameType = $row['gameType'];
						      $numDarts = $row['numDarts'];
						      $singlesHit = $row['singlesHit'];
						      $doublesHit = $row['doublesHit'];
						      $treblesHit = $row['treblesHit'];
						      $totalScored = $row['totalScored'];
						      $dartsMissed = $row['dartsMissed'];
						      

						      echo '<td>' . $date . '</td>';
						      echo '<td>' . $gameType . '</td>';
						      echo '<td>' . $numDarts . '</td>';
						      echo '<td>' . $singlesHit . '</td>';
						      echo '<td>' . $doublesHit . '</td>';
						      echo '<td>' . $treblesHit . '</td>';
						      echo '<td>' . $totalScored . '</td>';
						      echo '<td>' . $dartsMissed . '</td></tr>';
						    }
						    echo '</table><br />';
		                }
		                else
		                {
		                	echo '<p class="alertMessage redButton">NO STATS AVAILABLE</p>';
		                	echo '<button class="logIn"><a href="../gameSetup.php?username=' . $user_username . '">Start a game</a></button>';
		                }
					}
					else
					{
						echo '<p class="alertMessage redButton">NO STATS AVAILABLE</p>';
						echo '<button class="logIn"><a href="../gameSetup.php?username=' . $user_username . '">Start a game</a></button>';
					}
				}
				else
				{
					echo 'NO GAME SELECTED';
				}
			}

			?>

		</div><!-- CLOSE DIV WITH ID VIEW STATS-->

	</div><!-- CLOSE DIV WITH CLASS PAGE -->


<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

</body>
</html>