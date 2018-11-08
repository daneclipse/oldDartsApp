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
	<style type="text/css">

	</style>
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
			echo '<div class="form"><form action="newGameSetup.php" method="get"><input type="text" name="username" placeholder="Name"><br /><input class="submitForm greenButton" type="submit" value="Enter name"></form></div>';
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
			</div><div id="gameSetup"></div>';
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
											$game = $_GET['game'];
											if ($game == 'cricket') 
											{
												if (isset($_GET['innings'])) 
												{
													$innings = $_GET['innings'];
													header('Location: cricket/cricketGame.php?username='.$user_username.'&opponent='.$oppUsername.'&innings='.$innings);
												}
											}
											else if ($game == 'ticTacToe')
											{
												if (isset($_GET['games'])) 
												{
													$games = $_GET['games'];
													header('Location: noughts&crosses/noughts&crosses.php?username='.$user_username.'&opponent='.$oppUsername.'&games='.$games);
												}
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

// WHEN YOU CHOSSE TO PLAY V GUEST (PERSON WITHOUT ACCOUNT)
// CREATES INPUT FOR THEIR NAME
var guestInput = document.createElement('input');
$(guestInput).attr('placeholder', 'Opponents Name');
var confirmInput = document.createElement('button');
confirmInput.textContent = 'enter name';
$(confirmInput).addClass('greenButton setupButton');

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
	'class': 'submitForm greenButton',
	'type': 'submit',
	'name': 'submit',
	'value': 'Log in'
})
$(form).append(inputName);
$(form).append(inputPassword);
$(form).append(submitInput);

// CREATE START BUTTON
var startButton = document.createElement('button');
startButton.textContent = 'start game';
$(startButton).addClass('greenButton setupButton');

// X01 GAME
var trad = $('#x01Game');
trad.on('click', function()
{
	// HIGHLIGHT & DIM RELEVANT GAMES
	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');

	// CHANGE TITLE TEXT & EMPTY GAMESETUP & OPPONENT DIVS
	$('#gameTitle').text('X01');
	$('#gameSetup').empty();
	$('.opponent').empty();

	// CREATE AREA TO SET UP X01 GAME
	var setupDiv = document.createElement('div');
	$(setupDiv).attr({'class' : 'gameSetupArea', 'id' : 'x01Setup'});

	// CREATE SETUP OPTIONS - OPPONENT, TARGET & LEGS
	// CREATE OPPONENT OPTIONS
	var oppDiv = document.createElement('div');
	$(oppDiv).attr({'class' : 'innerSetupArea', 'id' : 'x01Opp'});
	var oppTitle = document.createElement('h2');
	$(oppTitle).attr({'class' : 'setupHeader', 'id' : 'oppHeading'});
	$(oppTitle).text('choose opponent');
	var firstOpp = document.createElement('p');
	$(firstOpp).attr({'class' : 'option oppOption', 'data-value' : 'single'});
	$(firstOpp).text('single player');
	var secondOpp = document.createElement('p');
	$(secondOpp).attr({'class' : 'option oppOption', 'data-value' : 'guest'});
	$(secondOpp).text('v guest');
	var thirdOpp = document.createElement('p');
	$(thirdOpp).attr({'class' : 'option oppOption', 'data-value' : 'user'});
	$(thirdOpp).text('v other user');
	$(oppDiv).append(oppTitle);
	$(oppDiv).append(firstOpp);
	$(oppDiv).append(secondOpp);
	$(oppDiv).append(thirdOpp);

	$(setupDiv).append(oppDiv);

	// CREATE TARGET OPTIONS
	var targetDiv = document.createElement('div');
	$(targetDiv).attr({'class' : 'innerSetupArea', 'id' : 'x01Target'});
	var targetTitle = document.createElement('h2');
	$(targetTitle).attr({'class' : 'setupHeader', 'id' : 'targetHeading'});
	$(targetTitle).text('choose target');
	var firstTarget = document.createElement('p');
	$(firstTarget).attr({'class' : 'option targetOption', 'data-value' : '301'});
	$(firstTarget).text('301');
	var secondTarget = document.createElement('p');
	$(secondTarget).attr({'class' : 'option targetOption', 'data-value' : '501'});
	$(secondTarget).text('501');
	var thirdTarget = document.createElement('p');
	$(thirdTarget).attr({'class' : 'option targetOption', 'data-value' : '601'});
	$(thirdTarget).text('601');
	$(targetDiv).append(targetTitle);
	$(targetDiv).append(firstTarget);
	$(targetDiv).append(secondTarget);
	$(targetDiv).append(thirdTarget);

	$(setupDiv).append(targetDiv);

	// CREATE LEGS OPTIONS
	var legsDiv = document.createElement('div');
	$(legsDiv).attr({'class' : 'innerSetupArea', 'id' : 'x01Legs'});
	var legsTitle = document.createElement('h2');
	$(legsTitle).attr({'class' : 'setupHeader', 'id' : 'legsHeading'});
	$(legsTitle).text('choose legs');
	var firstLegs = document.createElement('p');
	$(firstLegs).attr({'class' : 'option legsOption', 'data-value' : '1'});
	$(firstLegs).text('1');
	var secondLegs = document.createElement('p');
	$(secondLegs).attr({'class' : 'option legsOption', 'data-value' : '2'});
	$(secondLegs).text('2');
	var thirdLegs = document.createElement('p');
	$(thirdLegs).attr({'class' : 'option legsOption', 'data-value' : '3'});
	$(thirdLegs).text('3');
	$(legsDiv).append(legsTitle);
	$(legsDiv).append(firstLegs);
	$(legsDiv).append(secondLegs);
	$(legsDiv).append(thirdLegs);

	$(setupDiv).append(legsDiv);

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append(setupDiv);
	}

	$('#oppHeading').css('opacity', '1');
	
	$('.oppOption').on('click', function()
	{
		// STOPS USER FROM CLICKING ON TARGET OR LEG BEFORE AN OPPONENT HAS BEEN SELECTED
		$('#targetHeading').show();
		$('.targetOption').show();
		$('#legsHeading').show();
		$('.legsOption').show();
		$(startButton).remove();

		// IF FORM IS SHOWING, NEED TO REMOVE IT & APPEND TARGET & LEGS DIV
		if ($('.innerSetupArea').length == 1)  
		{
			$(form).remove();
			$('.gameSetupArea').append(targetDiv);
			$('.gameSetupArea').append(legsDiv);
		}

		$('#oppHeading').css('opacity', '0.2');
		$('#targetHeading').css('opacity', '1');

		var oppSelected = $(this).attr('data-value');
		// IF SINGLE PLAYER SELECTED
		if (oppSelected == 'single')
		{
			$('.targetOption').css('opacity', '0.2');
			$('.legsOption').css('opacity', '0.2');
			$('.oppOption').css('opacity', '0.2');
			$(this).css('opacity', '1');
			$('.opponent').empty();
		}
		// IF GUEST SELECTED - ADDS INPUT & BUTTON TO ENTER GUEST NAME
		else if (oppSelected == 'guest')
		{
			$('#targetHeading').hide();
			$('.targetOption').hide();
			$('#legsHeading').hide();
			$('.legsOption').hide();
			$('.targetOption').css('opacity', '0.2');
			$('.legsOption').css('opacity', '0.2');
			$('.oppOption').css('opacity', '0.2');
			$(this).css('opacity', '1');
			$('.opponent').empty();
			$('.opponent').append(guestInput);
			$('.opponent').append(confirmInput);
			confirmInput.onclick = function()
			{
				var guestName = $(guestInput).val();
				if (guestName != '') 
				{
					$(this).remove();
					$(guestInput).remove();
					$('.opponent').append('<p id="guestName">' + guestName + '</p>');
					$('#targetHeading').show();
					$('.targetOption').show();
					$('#legsOption').show();
					$('.legsOption').show();
				}
			}
		}
		// IF OTHER USER SELECTED - ADD FORM FOR OTHER USER TO LOG IN
		else if (oppSelected == 'user') 
		{
			$('.innerSetupArea')[1].remove();
			$('.innerSetupArea')[1].remove();
			$('.oppOption').css('opacity', '0.2');
			$(this).css('opacity', '1');
			$('.opponent').empty();
			$('.gameSetupArea').append(form);
			$(form).css('height', '225px');
			$(form).css('float', 'left');
			$(form).css('margin', '30px 200px');
		}

		// TARGET OPTION INSIDE SELECT OPP TO GET THE OPPSELECTED
		$('.targetOption').on('click', function()
		{
			// STOPS USER FROM CLICKING LEGS BEFORE A TARGET HAS BEEN SELECTED
			$('.legsOption').off();
			$(startButton).remove();

			$('#targetHeading').css('opacity', '0.2');
			$('#legsHeading').css('opacity', '1');

			var targetSelected = Number($(this).attr('data-value'));
			$('.targetOption').css('opacity', '0.2');
			$(this).css('opacity', '1');

			// LEGS OPTION INSIDE TARGET TO GET TARGETSELECTED
			$('.legsOption').on('click', function()
			{
				var legsSelected = Number($(this).attr('data-value'));
				$('.legsOption').css('opacity', '0.2');
				$(this).css('opacity', '1');
				if (legsSelected != 0) 
				{
					console.log(oppSelected + ', ' + targetSelected + ', ' + legsSelected);
					$('.opponent').append(startButton);
				}
				$(startButton).on('click', function()
				{
					if (oppSelected == 'single' ) 
					{
						location.replace('X01/x01Game.php?username=<?=$user_username;?>&target=' + targetSelected + '&legs=' + legsSelected);
					}
					else if (oppSelected == 'guest') 
					{
						var opponent = $('#guestName').text();
						location.replace('X01/x01Game.php?username=<?=$user_username;?>&opponent=' + opponent + '&target=' + targetSelected + '&legs=' + legsSelected);
					}
				})
			})
		})
	})
})

// 100 DARTS AT GAME
var dartsAt = $('#dartsAtGame');
dartsAt.on('click', function()
{
	var targetChosen = document.createElement('div');
	$(targetChosen).attr({'class' : 'gameSetupArea', 'id' : 'hundredSetup'});
	var targetsAvailable = document.createElement('div');
	$(targetsAvailable).attr({'class' : 'innerSetupArea'});
	var targetsTitle = document.createElement('h2');
	$(targetsTitle).attr({'class' : 'setupHeader', 'id' : 'hundredHeader'});
	$(targetsTitle).text('choose target');
	var firstOption = document.createElement('p');
	$(firstOption).attr({'class' : 'option hundredOption', 'data-value' : '20'});
	$(firstOption).text('20');
	var secondOption = document.createElement('p');
	$(secondOption).attr({'class' : 'option hundredOption', 'data-value' : '19'});
	$(secondOption).text('19');
	var thirdOption = document.createElement('p');
	$(thirdOption).attr({'class' : 'option hundredOption', 'data-value' : '18'});
	$(thirdOption).text('18');
	var fourthOption = document.createElement('p');
	$(fourthOption).attr({'class' : 'option hundredOption', 'data-value' : '17'});
	$(fourthOption).text('17');
	var fifthOption = document.createElement('p');
	$(fifthOption).attr({'class' : 'option hundredOption', 'data-value' : '16'});
	$(fifthOption).text('16');
	var sixthOption = document.createElement('p');
	$(sixthOption).attr({'class' : 'option hundredOption', 'data-value' : '15'});
	$(sixthOption).text('15');
	var seventhOption = document.createElement('p');
	$(seventhOption).attr({'class' : 'option hundredOption', 'data-value' : 'bullseye'});
	$(seventhOption).text('bullseye');

	$(targetsAvailable).append(targetsTitle);
	$(targetsAvailable).append(firstOption);
	$(targetsAvailable).append(secondOption);
	$(targetsAvailable).append(thirdOption);
	$(targetsAvailable).append(fourthOption);
	$(targetsAvailable).append(fifthOption);
	$(targetsAvailable).append(sixthOption);
	$(targetsAvailable).append(seventhOption);

	$(targetChosen).append(targetsAvailable);

	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('100 Darts');
	$('#gameSetup').empty();
	$('.opponent').empty();

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append(targetChosen);
		$(targetsTitle).css('opacity', '1');
	}

	$('.hundredOption').on('click', function()
	{
		$('.hundredOption').css('opacity', '0.2');
		$(this).css('opacity', '1');
		var targetNumber = $(this).attr('data-value');
		if (targetNumber != '') 
		{
			$('.opponent').append(startButton);
			startButton.onclick = function()
			{
				location.replace('100DartsAt/100DartsAt.php?username=<?=$user_username;?>&game=' + targetNumber);
			}
		}
	})
})

// CRICKET GAME
var cricketGame = $('#cricketGame');
cricketGame.on('click', function()
{

	var cricketSetup = document.createElement('div');

	var cricketInnings = document.createElement('div');
	$(cricketInnings).attr({'class' : 'innerSetupArea'});
	var crickInningsTitle = document.createElement('h2');
	$(crickInningsTitle).attr({'class' : 'setupHeader', 'id' : 'cricketInningsHeader'});
	$(crickInningsTitle).text('choose innings');
	var crickInnOne = document.createElement('p');
	$(crickInnOne).attr({'class' : 'option crickInnOption', 'data-value' : '1'});
	$(crickInnOne).text('1');
	var crickInnTwo = document.createElement('p');
	$(crickInnTwo).attr({'class' : 'option crickInnOption', 'data-value' : '2'});
	$(crickInnTwo).text('2');

	$(cricketInnings).append(crickInningsTitle);
	$(cricketInnings).append(crickInnOne);
	$(cricketInnings).append(crickInnTwo);

	$(cricketSetup).append(cricketInnings);

	$(cricketSetup).attr({'class' : 'gameSetupArea', 'id' : 'cricketSetup'});
	var cricketOpp = document.createElement('div');
	$(cricketOpp).attr({'class' : 'innerSetupArea'});
	var crickOppTitle = document.createElement('h2');
	$(crickOppTitle).attr({'class' : 'setupHeader', 'id' : 'cricketOppHeader'});
	$(crickOppTitle).text('choose opponent');
	var crickOppOne = document.createElement('p');
	$(crickOppOne).attr({'class' : 'option crickOppOption', 'data-value' : 'guest'});
	$(crickOppOne).text('v guest');
	var crickOppTwo = document.createElement('p');
	$(crickOppTwo).attr({'class' : 'option crickOppOption', 'data-value' : 'user'});
	$(crickOppTwo).text('v other user');

	$(cricketOpp).append(crickOppTitle);
	$(cricketOpp).append(crickOppOne);
	$(cricketOpp).append(crickOppTwo);

	$(cricketSetup).append(cricketOpp);

	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('Cricket');
	$('#gameSetup').empty();
	$('.opponent').empty();

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append(cricketSetup);
		$(crickInningsTitle).css('opacity', '1');
		$('.crickOppOption').off();

		$('.crickInnOption').on('click', function()
		{
			var inningsSelected = $(this).attr('data-value');
			if (inningsSelected != '') 
			{
				$(crickInningsTitle).css('opacity', '0.2');
				$(crickOppTitle).css('opacity', '1');
				$('.crickInnOption').css('opacity', '0.2');
				$(this).css('opacity', '1');
			}
			// CHOOSE THE OPPONENT INSIDE SO WE CAN GET INNINGS SELECTED
			$('.crickOppOption').on('click', function()
			{
				$('.crickOppOption').css('opacity', '0.2');
				$(this).css('opacity', '1');
				var oppSelected = $(this).attr('data-value');
				if (oppSelected != '') 
				{
					if (oppSelected == 'guest') 
					{
						$('.opponent').empty();
						$('.opponent').append(guestInput);
						$('.opponent').append(confirmInput);
						confirmInput.onclick = function()
						{
							var guestName = $(guestInput).val();
							if (guestName != '') 
							{
								$(this).remove();
								$(guestInput).remove();
								$('.opponent').append('<p id="guestName">' + guestName + '</p>');
								$('.opponent').append(startButton);
								startButton.onclick = function()
								{
									location.replace('cricket/cricketGame.php?username=<?=$user_username;?>&guest='+ guestName + '&innings=' + inningsSelected);
								}
							}
							else
							{
								$('crickInnOption').off();
							}
						}
					}
					else if (oppSelected == 'user')
					{
						$('.opponent').empty();
						$('.opponent').append(form);
						$(form).attr('action', 'newGameSetup.php?username=<?=$user_username;?>&game=cricket&innings=' + inningsSelected);
						$(form).css('height', '225px');
					}
				}
			})
		})
	}
})

// ROUND THE WORLD GAME
var wordlGame = $('#worldGame');
wordlGame.on('click', function()
{
	var sectionChosen = document.createElement('div');
	$(sectionChosen).attr({'class' : 'gameSetupArea', 'id' : 'worldSetup'});
	var sectionsAvailable = document.createElement('div');
	$(sectionsAvailable).attr({'class' : 'innerSetupArea'});
	var sectionTitle = document.createElement('h2');
	$(sectionTitle).attr({'class' : 'setupHeader', 'id' : 'worldHeader'});
	$(sectionTitle).text('choose target');
	var singleSection = document.createElement('p');
	$(singleSection).attr({'class' : 'option worldOption', 'data-value' : 'singles'});
	$(singleSection).text('singles');
	var doubleSection = document.createElement('p');
	$(doubleSection).attr({'class' : 'option worldOption', 'data-value' : 'doubles'});
	$(doubleSection).text('doubles');
	var trebleSection = document.createElement('p');
	$(trebleSection).attr({'class' : 'option worldOption', 'data-value' : 'trebles'});
	$(trebleSection).text('trebles');

	$(sectionsAvailable).append(sectionTitle);
	$(sectionsAvailable).append(singleSection);
	$(sectionsAvailable).append(doubleSection);
	$(sectionsAvailable).append(trebleSection);

	$(sectionChosen).append(sectionsAvailable);

	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('100 Darts');
	$('#gameSetup').empty();
	$('.opponent').empty();

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append(sectionChosen);
		$(sectionTitle).css('opacity', '1');
	}

	$('.worldOption').on('click', function()
	{
		$('.worldOption').css('opacity', '0.2');
		$(this).css('opacity', '1');
		var targetSection = $(this).attr('data-value');
		if (targetSection != '') 
		{
			$('.opponent').append(startButton);
			startButton.onclick = function()
			{
				location.replace('roundTheWorld/roundTheWorld.php?username=<?=$user_username;?>&game=' + targetSection);
			}
		}
	})
})

// TIC TAC TOE GAME
var ticGame = $('#ticGame');
ticGame.on('click', function()
{

	var ticSetup = document.createElement('div');
	$(ticSetup).attr({'class' : 'gameSetupArea', 'id' : 'ticSetup'});
	var ticGames = document.createElement('div');
	$(ticGames).attr({'class' : 'innerSetupArea', 'id' : 'ticGameSetup'});
	var ticGamesTitle = document.createElement('h2');
	$(ticGamesTitle).attr({'class' : 'setupHeader', 'id' : 'ticGamesHeader'});
	$(ticGamesTitle).text('num of games');
	var gamesOne = document.createElement('p');
	$(gamesOne).attr({'class' : 'option ticGameOption', 'data-value' : '1'});
	$(gamesOne).text('1');
	var gamesTwo = document.createElement('p');
	$(gamesTwo).attr({'class' : 'option ticGameOption', 'data-value' : '2'});
	$(gamesTwo).text('2');
	var gamesThree = document.createElement('p');
	$(gamesThree).attr({'class' : 'option ticGameOption', 'data-value' : '3'});
	$(gamesThree).text('3');

	$(ticGames).append(ticGamesTitle);
	$(ticGames).append(gamesOne);
	$(ticGames).append(gamesTwo);
	$(ticGames).append(gamesThree);

	$(ticSetup).append(ticGames);

	var ticOpp = document.createElement('div');
	$(ticOpp).attr({'class' : 'innerSetupArea', 'id' : 'ticOpponent'});
	var ticOppTitle = document.createElement('h2');
	$(ticOppTitle).attr({'class' : 'setupHeader', 'id' : 'ticOppHeader'});
	$(ticOppTitle).text('choose opponent');
	var ticOppOne = document.createElement('p');
	$(ticOppOne).attr({'class' : 'option ticOppOption', 'data-value' : 'guest'});
	$(ticOppOne).text('v guest');
	var ticOppTwo = document.createElement('p');
	$(ticOppTwo).attr({'class' : 'option ticOppOption', 'data-value' : 'user'});
	$(ticOppTwo).text('v other user');

	$(ticOpp).append(ticOppTitle);
	$(ticOpp).append(ticOppOne);
	$(ticOpp).append(ticOppTwo);

	$(ticSetup).append(ticOpp);

	$('.gameOption').css('opacity', '0.2');
	$(this).parent().css('opacity', '1');
	$('#gameTitle').text('Cricket');
	$('#gameSetup').empty();
	$('.opponent').empty();

	if ($('#gameSetup')[0].childElementCount == 0) 
	{
		$('#gameSetup').append(ticSetup);
		$(ticGamesTitle).css('opacity', '1');
		$('.ticOppOption').off();

		$('.ticGameOption').on('click', function()
		{
			var gamesSelected = $(this).attr('data-value');
			if (gamesSelected != '') 
			{
				$(ticGamesTitle).css('opacity', '0.2');
				$(ticOppTitle).css('opacity', '1');
				$('.ticGameOption').css('opacity', '0.2');
				$(this).css('opacity', '1');
			}
			// CHOOSE THE OPPONENT INSIDE SO WE CAN GET GAMES SELECTED
			$('.ticOppOption').on('click', function()
			{
				$('.ticOppOption').css('opacity', '0.2');
				$(this).css('opacity', '1');
				var oppSelected = $(this).attr('data-value');
				if (oppSelected != '') 
				{
					if (oppSelected == 'guest') 
					{
						$('.opponent').empty();
						$('.opponent').append(guestInput);
						$('.opponent').append(confirmInput);
						confirmInput.onclick = function()
						{
							var guestName = $(guestInput).val();
							if (guestName != '') 
							{
								$(this).remove();
								$(guestInput).remove();
								$('.opponent').append('<p id="guestName">' + guestName + '</p>');
								$('.opponent').append(startButton);
								startButton.onclick = function()
								{
									location.replace('noughts&crosses/noughts&crosses.php?username=<?=$user_username;?>&guest='+ guestName + '&games=' + gamesSelected);
								}
							}
							else
							{
								$('ticGameOption').off();
							}
						}
					}
					else if (oppSelected == 'user')
					{
						$('.opponent').empty();
						$('.opponent').append(form);
						$(form).attr('action', 'newGameSetup.php?username=<?=$user_username;?>&game=ticTacToe&games=' + gamesSelected);
						$(form).css('height', '225px');
					}
				}
			})
		})
	}
})

</script>


</body>
</html>