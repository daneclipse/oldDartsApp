<?php

  include('../connection.php');
  $user_username = $_GET['username'];
  $stats = $_GET['stats'];
  $order = $_GET['order'];
  function showTable($row, $arr, $user_username)
  {
      echo
      '<table border = "1">
      <tr>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=date" id="date">Date</a></th>
      <th>Leg Target</th>
      <th>Total Scored</th>
      <th>Result</th>
      <th>Opponent</th>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=dartsUsed" id="darts">Darts Used</a></th>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=oneAverage" id="oda">One dart average</a></th>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=tda" id="tda">TDA</a></th>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=checkout" id="checkout">Checkout</a></th>
      <th><a href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=1&order=double" id="double">Double %</a></button></th>
      <th>Double hit</th>
      <th>Highest Score</th>
      <th>Missed darts</th>
      </tr>';
      // $order = $_GET['order'];

      while ($row = mysqli_fetch_array($arr)) 
      {
        $date = $row['game_date'];
        $legTarget = $row['legTarget'];
        $totalScored = $row['totalScored'];
        $legOutcome = $row['legOutcome'];
        $opponentName = $row['opponent'];
        $dartsUsed = $row['dartsUsed'];
        $average = $row['average'];
        $tda = $row['tda'];
        $checkout = $row['checkout'];
        $doublePercent = $row['doublePercent'];
        $doubleHit = $row['doubleHit'];
        $highScore = $row['highScore'];
        $missedDarts = $row['dartsMissed'];


        echo '<td class="date">' . $date . '</td>';
        echo '<td>' . $legTarget . '</td>';
        echo '<td>' . $totalScored . '</td>';
        if ($legOutcome == 'won') 
        {
          echo '<td class="greenButton">' . $legOutcome . '</td>';
        }
        else
        {
          echo '<td class="redButton">' . $legOutcome . '</td>';
        }
        $findOpp = mysqli_query($dbc, "SELECT * FROM users WHERE username='" . $opponentName . "'");
        $numRows = mysqli_num_rows($findOpp);
        if ($numRows > 0) 
        {
          $oppButton = '<td><button><a href="viewOppStats.php?username=' . $opponentName . '&account=' . $user_username . '">' . $opponentName . '</a></button></td>';
        }
        else
        {
          $oppButton = '<td>' . $opponentName . '</td>';
        }
        echo $oppButton;
        echo '<td class="darts">' . $dartsUsed . '</td>';
        echo '<td class="oda">' . $average . '</td>';
        echo '<td class="tda">' . $tda . '</td>';
        echo '<td class="checkout">' . $checkout . '</td>';
        echo '<td class="double">' . $doublePercent . '</td>';
        if ($doubleHit == '25') 
        {
          $doubleHit = 'bullseye';
        }
        echo '<td>' . $doubleHit . '</td>';
        echo '<td>' . $highScore . '</td>';
        echo '<td>' . $missedDarts . '</td></tr>';
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
  <span class="logOutButton"><a href="../login.php" >Log out</a></span>
</div><!-- CLOSE DIV WITH CLASS NAVBAR -->

<div class="page">
  <h1>X01 Stats</h1>
  <div class="viewStatsButtons">
    <a id="legButton" class="viewStatsButton" href="viewX01Stats.php?username=<?=$user_username;?>&stats=leg&page=1">LEG STATS</a>
    <a id="overallButton" class="viewStatsButton" href="viewX01Stats.php?username=<?=$user_username;?>&stats=overall">OVERALL STATS</a>
  </div><!-- CLOSE DIV WITH ID VIEWSTATSBUTTON -->

  <div id="viewStats">
    <?php

        if (isset($_GET['stats'])) 
        {
            if ($stats == 'leg') 
            {
                /* PAGINATION */
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
                /* END OF PAGINATION */

                /* ORDERING OF STATS */
                if (isset($_GET['order'])) 
                {
                  if ($_GET['order'] == 'dartsUsed') 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY dartsUsed ASC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                  else if ($_GET['order'] == 'oneAverage') 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY average DESC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                  else if ($_GET['order'] == 'tda') 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY tda DESC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                  else if ($_GET['order'] == 'checkout') 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY checkout DESC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                  else if ($_GET['order'] == 'double') 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY doublePercent DESC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                  else 
                  {
                    $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
                    $orderQuery = mysqli_query($dbc, $getStats);
                    $rows = mysqli_num_rows($orderQuery);
                  }
                }
                else
                {
                  $_GET['order'] = 'date';
                  $getStats = "SELECT * FROM legStats WHERE username='$user_username' ORDER BY game_date DESC LIMIT $currentPage, $perPage";
                  $orderQuery = mysqli_query($dbc, $getStats);
                  $rows = mysqli_num_rows($orderQuery);
                }
                /* END OF ORDERING OF STATS */

                if ($rows > 0) 
                {
                    showTable($rows, $orderQuery, $user_username);

                    // /* PAGINATION */
                    $query = mysqli_query($dbc, "SELECT * FROM legStats WHERE username='$user_username'");
                    $totalRows = mysqli_num_rows($query);;
                    // how many records per page we want
                    // work out total number of pages needed 
                    // ceil gives you the next integar
                    $totalPages = ceil($totalRows / $perPage);

                    if ($page > 1) 
                    {
                        echo '<a class="pagination" href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=' . ($page - 1) . '&order=' . $_GET['order'] . '"><< Previous</a>';
                    }

                    for($i = 1; $i <= $totalPages; $i++)
                    {
                        if ($page == $i) 
                        {
                          echo '<a class="pagination activePage" href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=' . $i . '&order=' . $_GET['order'] . '">' . $i . '</a>';
                        }
                        else
                        {
                          echo '<a class="pagination" href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=' . $i . '&order=' . $_GET['order'] . '">' . $i . '</a>';
                        }
                    }

                    if ($page < $totalPages) 
                    {
                        echo '<a class="pagination" href="viewX01Stats.php?username=' . $user_username . '&stats=leg&page=' . ($page + 1) . '&order=' . $_GET['order'] . '">Next >></a>';
                    }
                    /* END OF PAGINATION */

                } // END OF IF STATEMENT - IF ROWS > 0 FOR LEG STATS
                else
                {
                  echo '<p class="redButton alertMessage">NO STATS AVAILABLE</p>';
                  echo '<button class="logIn"><a href="../gameSetup.php?username=' . $user_username . '">Start a game</a></button>';
                } // END OF ELSE STATEMENT - IF ROWS > 0 FOR LEG STATS

            } // END OF IF STATEMENT - IF STATS = LEGS
            else if ($stats == 'overall')
            {
                $overallStats = "SELECT * FROM userStats WHERE username='" . $user_username . "'";
                $statsQuery = mysqli_query($dbc, $overallStats);
                $rows = mysqli_num_rows($statsQuery);

                if ($rows > 0) 
                {
                    echo
                    '<table border = "1">
                    <tr>
                    <th>Legs Played</th>
                    <th>Legs Won</th>
                    <th>Highest Checkout</th>
                    <th>Favourite Double</th>
                    <th>Highest Score</th>
                    <th>Total Scored</th>
                    <th>Darts Thrown</th>
                    <th>One Dart Average</th>
                    </tr>';

                    while ($row = mysqli_fetch_array($statsQuery)) 
                    {
                      $legsPlayed = $row['legsPlayed'];
                      $legsWon = $row['legsWon'];
                      $highOut = $row['highestOut'];
                      $favDouble = $row['favDouble'];
                      $highScore = $row['highestScore'];
                      $totalScored = $row['totalScored'];
                      $darts = $row['dartsThrown'];
                      $average = $row['average'];

                      echo '<td>' . $legsPlayed . '</td>';
                      echo '<td>' . $legsWon . '</td>';
                      echo '<td>' . $highOut . '</td>';
                      echo '<td>' . $favDouble . '</td>';
                      echo '<td>' . $highScore . '</td>';
                      echo '<td>' . $totalScored . '</td>';
                      echo '<td>' . $darts . '</td>';
                      echo '<td>' . $average . '</td></tr>';
                    }
                    echo '</table><br />';
                }
                else
                {
                  echo '<p class="redButton alertMessage">NO STATS AVAILABLE</p>';
                  echo '<button class="logIn"><a href="../gameSetup.php?username=' . $user_username . '">Start a game</a></button>';
                } // END OF ELSE STATEMENT - IF ROWS > 0 FOR OVERALL STATS
            }// END OF ELSE IF STATEMENT - IF STATS = OVERALL
            else
            {
                echo 'NO STATS FOR THIS TYPE';
            }// END OF ELSE STATEMENT - IF STATS DOESNT = LEGS OR OVERALL
        }// END OF IF STATEMENT - IF STATS IS SET 
      ?>
    </div><!-- CLOSE DIV WITH ID VIEWSTATS -->
</div><!-- CLOSE DIV WITH CLASS PAGE -->

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
      <script type="text/javascript">
          var type = location.search.split('&')[1].split('=')[1];
          if (type == 'leg') 
          {
            $('#legButton').addClass('active');
            $('#overallButton').removeClass('active');
          }
          else if (type == 'overall') 
          {
            $('#overallButton').addClass('active');
            $('#legButton').removeClass('active');
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
            else if (location.search.split('order=')[1] == 'dartsUsed') 
            {
              $('#darts').parent().addClass('active');
              $('.darts').addClass('active');
            }
            else if (location.search.split('order=')[1] == 'oneAverage') 
            {
              $('#oda').parent().addClass('active');
              $('.oda').addClass('active');
            }
            else if (location.search.split('order=')[1] == 'tda') 
            {
              $('#tda').parent().addClass('active');
              $('.tda').addClass('active');
            }
            else if (location.search.split('order=')[1] == 'checkout') 
            {
              $('#checkout').parent().addClass('active');
              $('.checkout').addClass('active');
            }
            else if (location.search.split('order=')[1] == 'double') 
            {
              $('#double').parent().addClass('active');
              $('.double').addClass('active');
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