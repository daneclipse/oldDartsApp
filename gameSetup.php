<?php

$user_username = $_GET['username'];
$game = $_GET['game'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/account.css">
	<link rel="stylesheet" type="text/css" href="css/gameSetup.css">
</head>
<body>

	<div class="navBar">
		<h1 class="accountName"><?= $user_username; ?></h1>
		<a href="account.php?username=<?=$user_username;?>">Back to account</a>
		<span class="logOutButton"><a href="login.php" >Log out</a></span>
	</div>

	<div class="page">

		<?php

		if (!isset($_GET['username'])) 
		{
			echo '<div class="form"><form action="gameSetup.php" method="get"><input type="text" name="username" placeholder="Name"><br /><input class="submitForm" type="submit" value="Enter name"></form></div>';
			$name = $_GET['username'];
			header('gameSetup.php?username=' .$name);
		}
		else 
		{
			echo '
			<h1 id="gameTitle">Choose a game</h1>
			<div class="gameOptions">
				<div class="gameOption">
					<h2 id="x01Game">X01</h2>
					<div class="gameInfo hidden" id="x01Info">
						<p>Traditional game of darts. Can select target score, number of players & number of legs.</p>
					</div>
					<p class="showGameInfo fa fa-info-circle"></p>
				</div>

				<div class="gameOption">
					<h2 id="dartsAtGame">100 Darts</h2>
					<div class="gameInfo hidden" id="x01Info">
						<p>Choose a target to throw 100 darts at, score the maximum points possible.</p>
					</div>
					<p class="showGameInfo fa fa-info-circle"></p>
				</div>

				<div class="gameOption">
					<h2 id="cricketGame">Cricket</h2>
					<div class="gameInfo hidden" id="x01Info">
						<p>Bowler needs to bowl the batsman out for the lowest score possible. Get a wicket by hitting the bullseye and score runs by scoring over 41.</p>
					</div>
					<p class="showGameInfo fa fa-info-circle"></p>
				</div>

				<div class="gameOption">
					<h2 id="worldGame">Round the world</h2>
					<div class="gameInfo hidden" id="x01Info">
						<p>Hit every number on the board in the least darts possible.</p>
					</div>
					<p class="showGameInfo fa fa-info-circle"></p>
				</div>

				<div class="gameOption">
					<h2 id="ticGame">Tic Tac Toe</h2>
					<div class="gameInfo hidden" id="x01Info">
						<p>Game of tic tac toe, using targets on the dartboard.</p>
					</div>
					<p class="showGameInfo fa fa-info-circle"></p>
				</div>
			</div>
			<div class="gameSetup">
			<div id="gameSetup"></div>';
		}

		?>

		<div class="opponent">
			<?php

				if ($_SERVER['REQUEST_METHOD'] == 'POST') 
				{
					include('connection.php');

					$opponentUsername = $_POST['opponentUsername'];
					$opponentPassword = $_POST['opponentPassword'];

					if (!empty($opponentUsername) && !empty($opponentPassword)) 
					{
						$selectOpp = "SELECT * FROM users WHERE username='" . $opponentUsername . "'";
						$selectOppQuery = mysqli_query($dbc, $selectOpp);
						$numRows = mysqli_num_rows($selectOppQuery);

						if ($numRows > 0) {
							while($row = mysqli_fetch_array($selectOppQuery))
							{
								$oppUsername = $row['username'];
								$oppPassword = $row['password'];

								if ($opponentPassword === $oppPassword) 
								{
									if ($oppUsername === $user_username) 
									{
										echo '<p class="alertMessage redButton">User already logged in, choose another player</p>';
									}
									else
									{
										if (isset($_GET['game'])) 
										{
											if (isset($_GET['innings'])) 
											{
												$innings = $_GET['innings'];
												header('Location: cricket/cricketGame.php?username='.$user_username.'&opponent='.$oppUsername.'&innings='.$innings);
											}
										}
										else
										{
											header('Location: gameSetupUser.php?username='.$user_username.'&opponent='.$oppUsername);
										}
									}
								}
								else
								{
									echo '<p class="alertMessage redButton">Password incorrect</p>';
								}
							}
						}
						else
						{
							echo '<p class="alertMessage redButton">No user found</p>';
						}
					}
					else
					{
						echo 'Enter opponents account details';
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

$('.showGameInfo').on('click', function()
{
	$($(this).siblings('.gameInfo')[0]).toggleClass('hidden');
})


var startButton = document.createElement('button');
startButton.textContent = 'start game';
$(startButton).addClass('submitForm');

// X01 GAME
var trad = $('#x01Game');
trad.on('click', function()
{
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('X01');
	$('#gameSetup').empty();
	$('.opponent').empty();
	if ($('#gameSetup')[0].childElementCount == 0) 
	// {
	// 	$('#gameSetup').append('<h2>Set up your game</h2><select id="selectOpponent"><option>Choose an opponent</option><option value="0">Single Player</option><option value="1">Play v GUEST</option><option value="2">Play v OTHER USER</option><option value="3">Play v COMPUTER</option></select>');
	// }

	// var selectOpponent = $('#selectOpponent');
	{

	}

	// WHEN YOU CHOOSE TO PLAY V GUEST
	// CREATES INPUT TO PUT NAME & BUTTON TO CONFIRM NAME
	var guestInput = document.createElement('input');
	$(guestInput).attr('placeholder', 'Opponents Name');
	var confirmInput = document.createElement('button');
	confirmInput.textContent = 'enter name';
	$(confirmInput).addClass('submitForm');

	// WHEN YOU CHOOSE TO PLAY V USER (PERSON WITH ACCOUNT)
	// CREATES FORM FOR THEIR NAME & PASSWORD WITH SUBMIT BUTTON
	var form = document.createElement('form');
	$(form).addClass('form');
	var inputName = document.createElement('input');
	var inputPassword = document.createElement('input');
	var submitInput = document.createElement('input');
	$(form).attr({
		'class': 'form',
		'method': 'post',
		'action': 'gameSetup.php?username=<?=$user_username;?>'
	})
	$(inputName).attr({
		'type': 'text',
		'name': 'opponentUsername',
		'placeholder': 'Username'
	})
	$(inputPassword).attr({
		'type': 'password',
		'name': 'opponentPassword',
		'placeholder': 'Password'
	})
	$(submitInput).attr({
		'class': 'submitForm',
		'type': 'submit',
		'name': 'submit',
		'value': 'Log in'
	})
	$(form).append(inputName);
	$(form).append(inputPassword);
	$(form).append(submitInput);

	// WHEN YOU CHOOSE TO PLAY V COMPUTER
	// ADDS A NEW SELECT TO CHOOSE THE DIFFICULTY OF THE COMPUTER
		// var selectComp = document.createElement('select');
		// var compLevel = document.createElement('option');
		// var compHard = document.createElement('option');
		// var compMed = document.createElement('option');
		// var compEasy = document.createElement('option');
		// $(selectComp).append('<option value="0">Computer Difficulty</option>');
		// $(selectComp).append('<option value="1">Hard</option>');
		// $(selectComp).append('<option value="2">Medium</option>');
		// $(selectComp).append('<option value="3">Easy</option>');

	// WHEN A GAME HAS BEEN CHOSEN
	// ADDS A SELECT TO CHOOSE THE TARGET YOU WANT TO WIN
	var selectTarget = document.createElement('select');
	$(selectTarget).attr('id', 'selectTarget');
	var targetChoice = document.createElement('option');
	var firstTarget = document.createElement('option');
	var secondTarget = document.createElement('option');
	var thirdTarget = document.createElement('option');
	$(selectTarget).append('<option value="0">Select target</option>');
	$(selectTarget).append('<option value="101">101</option>');
	$(selectTarget).append('<option value="301">301</option>');
	$(selectTarget).append('<option value="501">501</option>');

	// WHEN A GAME HAS BEEN CHOSEN
	// ADDS A SELECT TO CHOOSE THE NUMBER OF LEGS NEEDED TO WIN
	var selectLegs = document.createElement('select');
	$(selectLegs).attr('id', 'selectLegs');
	var legsChoice = document.createElement('option');
	var firstChoice = document.createElement('option');
	var secondChoice = document.createElement('option');
	var thirdChoice = document.createElement('option');
	$(selectLegs).append('<option value="0">Select legs</option>');
	$(selectLegs).append('<option value="1">1</option>');
	$(selectLegs).append('<option value="2">2</option>');
	$(selectLegs).append('<option value="3">3</option>');


	selectOpponent.on('change', function()
	{
		$('.alertMessage').remove();
		var playerChosen = $('#selectOpponent :selected').val();
		// if (location.href != 'http://localhost:8888/PHP%20DARTS%20APP/gameSetup.php?username=<?=$user_username;?>') 
		// {
		// 	location.replace('gameSetup.php?username=<?=$user_username;?>');
		// }

		// IF YOU CHOOSE TO PLAY A SINGLE PLAYER GAME (NO OPPONENT)
		// EMPTY THE OPPONENT DIV, THEN APPEND THE TARGET & LEGS SELECT & START GAME BUTTON
		if (playerChosen == 0) 
		{
			$('.opponent').empty();
			$('.opponent').append(selectTarget);
			$('.opponent').append(selectLegs);
			$('.opponent').append(startButton);
			startButton.onclick = function()
				{
					var target = $('#selectTarget :selected').val();
					var legs = $('#selectLegs :selected').val();
					location.replace('X01/x01Game.php?username=<?=$user_username;?>&target=' + target + '&legs=' + legs);
				}
		}
		// IF YOU CHOOSE V A GUEST
		// EMPTY THE OPPONENT DIV, APPEND THE GUEST INPUT, CONFORM INPUT BUTTON & START GAME BUTTON
		else if (playerChosen == 1) 
		{
			$('.opponent').empty();
			$('.opponent').append(guestInput);
			$('.opponent').append(confirmInput);
			confirmInput.onclick = function()
			{
				var guestName = $(guestInput).val();
				// MAKE SURE THE GUEST HAS ENTERED A NAME
				if (guestName != '') 
				{
					$('.opponent').append(selectTarget);
					$('.opponent').append(selectLegs);
					$('.opponent').append(startButton);
					startButton.onclick = function()
					{
						var target = $('#selectTarget :selected').val();
						var legs = $('#selectLegs :selected').val();
						if (target == 0 || legs == 0) 
						{
							alert('Please set up game correctly');
						}
						else
						{
							location.replace('X01/x01Game.php?username=<?=$user_username;?>&guest=' + guestName + '&target=' + target + '&legs=' + legs);
						}
					}
				}
				else
				{
					alert('Please enter your opponents name');
				}
			}
		}
		// IF YOU CHOOSE TO PLAY V A USER (PERSON WITH AN ACCOUNT)
		// EMPTY OPPONENT DIV, APPEND THE FORM FOR THE USER TO LOG IN
		else if (playerChosen == 2) 
		{
			$('.opponent').empty();
			$('.opponent').append(form);
		}
		// IF YOU CHOOSE TO PLAY V COMPUTER
		// EMPTY OPPONENTS DIV, APPEND THE OPTION TO SELECT COMPUTERS DIFFICULTY, TARGET & LEGS WITH START GAME BUTTON
		// else if (playerChosen == 3)
		// {
		// 	$('.opponent').empty();
		// 	$('.opponent').append(selectComp);
		// 	$('.opponent').append(selectTarget);
		// 	$('.opponent').append(selectLegs);
		// 	$('.opponent').append(startButton);
		// }
		// IF CHOOSE THE FIRST OPTION IN THE SELECT (NO GAME SELECTED)
		// EMPTY OPPONENT DIV AND REMOVE START GAME BUTTON
		else
		{
			$('.opponent').empty();
			$(startButton).remove();
		}
	})
});

// 100 DARTS AT GAME
var dartsAt = $('#dartsAtGame');
dartsAt.on('click', function()
{
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('100 Darts');
	$('#gameSetup').empty();
	$('.opponent').empty();
	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append('<h2>Set up your game</h2><select id="selectNumber"><option value="0">Choose an number</option><option value="20">20</option><option value="19">19</option><option value="18">18</option><option value="17">17</option><option value="16">16</option><option value="15">15</option><option value="50">Bullseye</option></select>');
	}
	$('#selectNumber').on('change', function()
	{
		var targetNumber = $('#selectNumber :selected').val();
		if (targetNumber != 0) 
		{
			$('#gameSetup').append(startButton);
			startButton.onclick = function()
			{
				location.replace('100DartsAt/100DartsAt.php?username=<?=$user_username;?>&game=' + targetNumber);
			}
		}
		else
		{
			$(startButton).remove();
		}
	})
})

// ROUND THE WORLD GAME
var worldGame = $('#worldGame');
worldGame.on('click', function()
{
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('Round the world');
	$('#gameSetup').empty();
	$('.opponent').empty();
	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append('<h2>Set up your game</h2><select id="selectGameType"><option value="0">Choose game type</option><option value="1">Singles</option><option value="2">Doubles</option><option value="3">Trebles</option></select>');
	}
	$('#selectGameType').on('change', function()
	{
		var selectedGame = $('#selectGameType :selected').val();
		if (selectedGame != 0) 
		{
			$('#gameSetup').append(startButton);
			startButton.onclick = function()
			{
				if (selectedGame == 1) 
				{
					var game = 'singles';
				}
				else if (selectedGame == 2)
				{
					var game = 'doubles';
				}
				else if (selectedGame == 3)
				{
					var game = 'trebles';
				}
				location.replace('roundTheWorld/roundTheWorld.php?username=<?=$user_username;?>&game=' + game);
			}
		}
		else
		{
			$(startButton).remove();
		}
	})
})

// TIC TAC TOE GAME
var ticGame = $('#ticGame');
ticGame.on('click', function()
{
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('Tic Tac Toe');
	$('#gameSetup').empty();
	$('.opponent').empty();
	$('#gameSetup').append(startButton);
	startButton.onclick = function()
	{
		location.replace('ticTacToe/ticTacToe.php?username=<?=$user_username;?>');
	}
})

// CRICKET GAME
var cricketGame = $('#cricketGame');
cricketGame.on('click', function()
{
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('Cricket');
	$('#gameSetup').empty();
	$('.opponent').empty();
	var selectInnings = document.createElement('select');
	$(selectInnings).attr('id', 'chooseInnings');
	var selectNumber = document.createElement('option');
	var oneInnings = document.createElement('option');
	var twoInnings = document.createElement('option');
	$(selectNumber).attr('value', 0);
	$(oneInnings).attr('value', 1);
	$(twoInnings).attr('value', 2);
	selectNumber.textContent = 'number of innings';
	oneInnings.textContent = 'one innings';
	twoInnings.textContent = 'two innings';
	$(selectInnings).append(selectNumber);
	$(selectInnings).append(oneInnings);
	$(selectInnings).append(twoInnings);

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append('<h2>Set up your game</h2><select id="cricketOpponent"><option>Choose an opponent</option><option value="0">Play v GUEST</option><option value="1">Play v OTHER USER</option><option value="2">Play v COMPUTER</option></select>');
	}
	
	var cricketOpponent = $('#cricketOpponent');
	var chooseInnings = $('#chooseInnings');

	cricketOpponent.on('change', function()
	{
		var opponentChosen = $('#cricketOpponent :selected').val();

		// WHEN YOU CHOOSE TO PLAY V GUEST
		// CREATES INPUT TO PUT NAME & BUTTON TO CONFIRM NAME
		if (opponentChosen == 0) 
		{
			$('.opponent').empty();
			var guestInput = document.createElement('input');
			$(guestInput).attr('placeholder', 'Opponents Name');

			$('.opponent').empty();
			$('.opponent').append(guestInput);
			$('.opponent').append('<br />');
			$('#gameSetup').append(selectInnings);
			$('.opponent').append(startButton);
			startButton.onclick = function()
			{
				var guestName = $(guestInput).val();
				// MAKE SURE THE GUEST HAS ENTERED A NAME
				if (guestName != '') 
				{
					var innings = $('#chooseInnings :selected').val();
					if (innings != 0) 
					{
						location.replace('cricket/cricketGame.php?username=<?=$user_username;?>&guest=' + guestName + '&innings=' + innings);
					}
					else
					{
						alert('please choose a number of innings');
					}
					
				}
				else
				{
					alert('Please enter your opponents name');
				}
			}
		}
		// WHEN YOU CHOOSE TO PLAY V USER (PERSON WITH ACCOUNT)
		// CREATES FORM FOR THEIR NAME & PASSWORD WITH SUBMIT BUTTON
		else if (opponentChosen == 1)
		{
			$('.opponent').empty();
			var form = document.createElement('form');
			$(form).addClass('form');
			var inputName = document.createElement('input');
			var inputPassword = document.createElement('input');
			var submitInput = document.createElement('input');
			$(form).attr({
				'class': 'form',
				'method': 'post',
				'action': ''
			})
			$(inputName).attr({
				'type': 'text',
				'name': 'opponentUsername',
				'placeholder': 'Username'
			})
			$(inputPassword).attr({
				'type': 'password',
				'name': 'opponentPassword',
				'placeholder': 'Password'
			})
			$(submitInput).attr({
				'class': 'submitForm',
				'type': 'submit',
				'name': 'submit',
				'value': 'Log in'
			})
			$(form).append(inputName);
			$(form).append(inputPassword);
			$(form).append(submitInput);

			$('#gameSetup').append(selectInnings);
			
			$('#chooseInnings').on('change', function()
			{
				$('.opponent').empty();
				var innings = $('#chooseInnings :selected').val();
				if (innings != 0) 
				{
					$('.opponent').append(form);
					$(form).attr('action', 'gameSetup.php?username=<?=$user_username;?>&game=cricket&innings=' + innings);
				}
				else
				{
					$(form).remove();
				}

			})
		}
		else
		{
			$('.opponent').empty();
		}
	})
})

</script>


</body>
</html>