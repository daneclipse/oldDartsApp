<?php

include('connection.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="css/general.css">
</head>
<body>

	<div class="navBar">
		<a href="register.php">Register</a>
		<a href="login.php">Log in</a>
		<a href="newGameSetup.php">Quick Game</a>
	</div><!-- CLOSES DIV WITH CLASS NAVBAR -->

	<div class="page">
		<div class="gameOptions">
			<div class="gameOption">
				<h2>X01</h2>
				<p class="gameInfo hidden" id="x01Info">
					Traditional game of darts. Can select target score, number of players & number of legs.
				</p>
				<p class="showGameInfo fa fa-info-circle"></p>
			</div>

			<div class="gameOption">
				<h2>100 Darts</h2>
				<p class="gameInfo hidden" id="x01Info">
					Choose a target to throw 100 darts at, score the maximum points possible.
				</p>
				<p class="showGameInfo fa fa-info-circle"></p>
			</div>

			<div class="gameOption">
				<h2>Cricket</h2>
				<p class="gameInfo hidden" id="x01Info">
					Bowler needs to bowl the batsman out for the lowest score possible. Get a wicket by hitting the bullseye and score runs by scoring over 41.
				</p>
				<p class="showGameInfo fa fa-info-circle"></p>
			</div>

			<div class="gameOption">
				<h2>Round the world</h2>
				<p class="gameInfo hidden" id="x01Info">
					Hit every number on the board in the least darts possible.
				</p>
				<p class="showGameInfo fa fa-info-circle"></p>
			</div>

			<div class="gameOption">
				<h2>Tic Tac Toe</h2>
				<p class="gameInfo hidden" id="x01Info">
					Game of tic tac toe, using targets on the dartboard.
				</p>
				<p class="showGameInfo fa fa-info-circle"></p>
			</div>
		</div>
	</div>

			<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">

// var navHeight = $('.navBar').height();
// $('.navBar').children().css('line-height', navHeight + 'px');

$('.showGameInfo').on('click', function()
{
	$($(this).siblings('.gameInfo')[0]).toggleClass('hidden');
})

</script>
</body>
</html>