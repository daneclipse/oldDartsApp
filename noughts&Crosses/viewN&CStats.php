<?php

include('../connection.php');

$user_username = $_GET['username'];
$stats = $_GET['stats'];

// <th><a href="viewStats.php?username=' . $user_username . '&stats=every">Date</a></th>

function showTable($row, $arr, $user_username)
  {
      echo
      '<table border = "1">
      <tr>
      <th><a href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=1&order=date" id="date">Game Date</a></th>
      <th>Opponent</th>
      <th>Marker</th>
      <th>Games Played</th>
      <th>Games Won</th>
      <th>Game Outcome</th>
      <th><a href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=1&order=score" id="score">Total Targets</a></th>
      <th><a href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=1&order=average" id="average">Average</a></th>
      </tr>';
      // $order = $_GET['order'];

      while ($row = mysqli_fetch_array($arr)) 
      {
        $date = $row['game_date'];
        $opponent = $row['opponent'];
        $marker = $row['marker'];
        $gamesPlayed = $row['games'];
        $gamesWon = $row['gamesWon'];
        $outcome = $row['gameOutcome'];
        $totalTargets = $row['targets'];
        $average = $row['average'];

        echo '<td class="date">' . $date . '</td>';
        echo '<td>' . $opponent . '</td>';
        echo '<td>' . $marker . '</td>';
        echo '<td>' . $gamesPlayed . '</td>';
        echo '<td>' . $gamesWon . '</td>';
        if ($outcome == 'win') 
        {
        	echo '<td class="greenButton">' . $outcome . '</td>';
        }
        else if ($outcome == 'lost')
        {
        	echo '<td class="redButton">' . $outcome . '</td>';
        }
        else
        {
        	echo '<td>' . $outcome . '</td>';
        }
        echo '<td class="score">' . $totalTargets . '</td>';
        echo '<td class="average">' . $average . '</td></tr>';
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
	<style type="text/css">
	    .viewStatsButton
	    {
	      margin: 50px 15%;
	    }
	</style>
</head>
<body>

	<div class="navBar">
	  <h1 class="accountName"><?= $user_username;?></h1>
	  <a href="../account.php?username=<?=$user_username;?>">Back to account</a>
	  <span class="logOutButton"><a href="login.php" >Log out</a></span>
	</div><!-- CLOSE DIV WITH CLASS NAVBAR -->

	<div class="page">
		<h1>Noughts & Crosses Stats</h1>
		<div class="viewStatsButtons">
			<a id="everyButton" class="viewStatsButton" href="viewN&CStats.php?username=<?=$user_username;?>&stats=every&page=1">EVERY GAME</a>
			<a id="bestButton" class="viewStatsButton" href="viewN&CStats.php?username=<?=$user_username;?>&stats=best">BEST GAME</a>
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
			                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
			                $statsQuery = mysqli_query($dbc, $getStats);
			                $numRows = mysqli_num_rows($statsQuery);
	                	}
	                	else if ($_GET['order'] == 'score')
	                	{
			                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY targets DESC LIMIT $currentPage, $perPage";
			                $statsQuery = mysqli_query($dbc, $getStats);
			                $numRows = mysqli_num_rows($statsQuery);
	                	}
	                	else if ($_GET['order'] == 'average')
	                	{
			                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY average DESC LIMIT $currentPage, $perPage";
			                $statsQuery = mysqli_query($dbc, $getStats);
			                $numRows = mysqli_num_rows($statsQuery);
	                	}
	                	else
	                	{
			                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
			                $statsQuery = mysqli_query($dbc, $getStats);
			                $numRows = mysqli_num_rows($statsQuery);
	                	}
	                }
	                else
	                {
		                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
		                $statsQuery = mysqli_query($dbc, $getStats);
		                $numRows = mysqli_num_rows($statsQuery);
		            }

	                if ($numRows > 0) 
	                {
	                	showTable($numRows, $statsQuery, $user_username);
	                    $query = mysqli_query($dbc, "SELECT * FROM ticTacToe WHERE username='$user_username'");
	                    $totalRows = mysqli_num_rows($query);
	                    // how many records per page we want
	                    // work out total number of pages needed 
	                    // ceil gives you the next integar
	                    $totalPages = ceil($totalRows / $perPage);

	                    if ($page > 1) 
	                    {
	                        echo '<a class="pagination" href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=' . ($page - 1) . '"><< Previous</a>';
	                    }

	                    for($i = 1; $i <= $totalPages; $i++)
	                    {
	                        if ($page == $i) 
	                        {
	                          echo '<a class="pagination activePage" href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=' . $i . '">' . $i . '</a>';
	                        }
	                        else
	                        {
	                          echo '<a class="pagination" href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=' . $i . '">' . $i . '</a>';
	                        }
	                    }

	                    if ($page < $totalPages) 
	                    {
	                        echo '<a class="pagination" href="viewN&CStats.php?username=' . $user_username . '&stats=every&page=' . ($page + 1) . '">Next >></a>';
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
	                $getStats = "SELECT * FROM ticTacToe WHERE username='$user_username' ORDER BY average DESC LIMIT 1";
	                $statsQuery = mysqli_query($dbc, $getStats);
	                $numRows = mysqli_num_rows($statsQuery);

	                if ($numRows > 0) 
	                {
	            	    echo
					    '<table border = "1">
					    <tr>
					    <th>Game Date</th>
					    <th>Opponent</th>
					    <th>Marker</th>
					    <th>Games Played</th>
					    <th>Games Won</th>
					    <th>Game Outcome</th>
					    <th>Total Targets</th>
					    <th>Average</th>
					    </tr>';
					    // $order = $_GET['order'];

					    while ($row = mysqli_fetch_array($statsQuery)) 
					    {
					        $date = $row['game_date'];
					        $opponent = $row['opponent'];
					        $marker = $row['marker'];
					        $gamesPlayed = $row['games'];
					        $gamesWon = $row['gamesWon'];
					        $outcome = $row['gameOutcome'];
					        $totalTargets = $row['targets'];
					        $average = $row['average'];

					        echo '<td>' . $date . '</td>';
					        echo '<td>' . $opponent . '</td>';
					        echo '<td>' . $marker . '</td>';
					        echo '<td>' . $gamesPlayed . '</td>';
					        echo '<td>' . $gamesWon . '</td>';
					        if ($outcome == 'win') 
					        {
					        	echo '<td class="greenButton">' . $outcome . '</td>';
					        }
					        else if ($outcome == 'lost')
					        {
					        	echo '<td class="redButton">' . $outcome . '</td>';
					        }
					        else
					        {
					        	echo '<td>' . $outcome . '</td>';
					        }
					        echo '<td>' . $totalTargets . '</td>';
					        echo '<td>' . $average . '</td></tr>';
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

		</div>

	</div>


<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <script type="text/javascript">
  	var type = location.search.split('&')[1].split('=')[1];
  	if (type == 'every') 
  	{
  		$('#everyButton').addClass('active');
  		$('#bestButton').removeClass('active');
  	}
  	else if (type == 'best') 
  	{
  		$('#bestButton').addClass('active');
  		$('#everyButton').removeClass('active');
  	}

      // ADDS ACTIVE FUNCTION TO TH & ALL DATA IN THIS COLUMN WHICH USER HAS ORDERED STATS BY
      // CHECKS TO SEE IF URL INCLUDES 'ORDER'
      // THEN GETS THE PART OF THE URL THAT FOLLOWS 'ORDER='
      if (location.search.includes('order')) 
      {
        if (location.search.split('order=')[1] == 'date') 
        {
          $('#date').parent().addClass('active');
          $('.date').addClass('active');
        }
        else if (location.search.split('order=')[1] == 'average') 
        {
          $('#average').parent().addClass('active');
          $('.average').addClass('active');
        }
        else if (location.search.split('order=')[1] == 'score') 
        {
          $('#score').parent().addClass('active');
          $('.score').addClass('active');
        }
      }
      else
      {
          $('#date').parent().addClass('active');
          $('.date').addClass('active');
      }

  </script>

</body>
</html>