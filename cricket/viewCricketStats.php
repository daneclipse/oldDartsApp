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
      <th><a href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=1&order=date">Game Date</a></th>
      <th>Opponent</th>
      <th>Game</th>
      <th>Game Outcome</th>
      <th><a href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=1&order=first">First Innings</a></th>
      <th><a href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=1&order=second">Second Innings</a></th>
      <th><a href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=1&order=total">Total Scored</a></th>
      <th>Outcome Method</th>
      <th><a href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=1&order=difference">Run Difference</a></th>
      </tr>';

      // $order = $_GET['order'];

      while ($row = mysqli_fetch_array($arr)) 
      {
        $date = $row['game_date'];
        $opponent = $row['opponent'];
        $game = $row['game'];
        $outcome = $row['gameOutcome'];
        $first = $row['firstInnings'];
        $second = $row['secondInnings'];
        $total = $row['totalScored'];
        $method = $row['winMethod'];
        $difference = $row['difference'];

        echo '<td>' . $date . '</td>';
        echo '<td>' . $opponent . '</td>';
        echo '<td>' . $game . ' innings</td>';
        if ($outcome == 'won') 
        {
        	echo '<td class="greenButton">' . $outcome . '</td>';
        }
        else
        {
        	echo '<td class="redButton">' . $outcome . '</td>';
        }
        echo '<td>' . $first . '</td>';
        echo '<td>' . $second . '</td>';
        echo '<td>' . $total . '</td>';
        if ($outcome == 'won') 
        {
        	echo '<td>won by ' . $method . '</td>'; 
        }
        else if ($outcome == 'lost')
        {
        	echo '<td>lost by ' . $method . '</td>';
        }
        else 
        {
        	echo '<td></td>';
        }
        echo '<td>' . $difference . '</td></tr>';
      }
      echo '</table><br />';
  } // END OF SHOWTABLE FUNCTION

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
		<a href="../account.php?username=<?=$user_username;?>">Back to account</a>
		<span class="logOutButton"><a href="../login.php">Log out</a></span>
	</div>

	<div class="page">
		<div class="viewStatsButtons">
		    <a class="viewStatsButton" href="../X01/viewX01Stats.php?username=<?=$user_username;?>">X01 Stats</a>
		    <a class="viewStatsButton" href="../100DartsAt/view100DartsStats.php?username=<?=$user_username;?>">100 Darts Stats</a>
		    <a class="viewStatsButton" href="../roundTheWorld/viewWorldStats.php?username=<?=$user_username;?>">Round the world stats</a>
	    </div><!-- CLOSE DIV WITH ID VIEWSTATSBUTTON -->
		<h1>Cricket Stats</h1>
		<div class="viewStatsButtons">
			<a class="viewStatsButton" href="viewCricketStats.php?username=<?=$user_username;?>&stats=every&page=1">VIEW STATS</a>
		</div>

		<div id="viewStats">
			
			<?php

			if (isset($_GET['stats'])) 
			{
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
	                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'first')
		                	{
	                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY firstInnings DESC LIMIT $currentPage, $perPage";
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'second')
		                	{
	                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY secondInnings DESC LIMIT $currentPage, $perPage";
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'total')
		                	{
	                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY totalScored DESC LIMIT $currentPage, $perPage";
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                	else if ($_GET['order'] == 'difference')
		                	{
	                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY difference DESC LIMIT $currentPage, $perPage";
				                $statsQuery = mysqli_query($dbc, $getStats);
				                $numRows = mysqli_num_rows($statsQuery);
		                	}
		                }
		                else
		                {
                			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
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
		                        echo '<a class="pagination" href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=' . ($page - 1) . '"><< Previous</a>';
		                    }

		                    for($i = 1; $i <= $totalPages; $i++)
		                    {
		                        if ($page == $i) 
		                        {
		                          echo '<a class="pagination activePage" href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=' . $i . '">' . $i . '</a>';
		                        }
		                        else
		                        {
		                          echo '<a class="pagination" href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=' . $i . '">' . $i . '</a>';
		                        }
		                    }

		                    if ($page < $totalPages) 
		                    {
		                        echo '<a class="pagination" href="viewCricketStats.php?username=' . $user_username . '&stats=every&page=' . ($page + 1) . '">Next >></a>';
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
            			$getStats = "SELECT * FROM cricket WHERE username='$user_username' ORDER BY totalScored DESC LIMIT 1";
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

			?>

		</div><!-- CLOSE DIV WITH ID VIEW STATS-->

	</div><!-- CLOSE DIV WITH CLASS PAGE -->


<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

</body>
</html>