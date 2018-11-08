<?php

include('../connection.php');
$user_username = $_GET['username'];
$opponent = $_GET['opponent'];
$guest = $_GET['guest'];
$innings = $_GET['innings'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/game.css">
	<link rel="stylesheet" type="text/css" href="../css/cricket.css">
</head>
<body>

<!-- 	<div class="navBar">
		<h1 class="accountName"><?= $user_username;?></h1>
		<a href="../account.php?username=<?=$user_username;?>">Back to account</a>
		<a href="../index.php">Home</a>
	</div> -->

	<div class="page">
		<span class="quitGame">X</span>

		<div class="playerOrder">
			<p>Top player is the bowler and throws first</p>
			<div class="playersToOrder"></div>
		</div>

		<div class="game">

			<div class="gameScoreboard">
				<h3 class="inner_gameScoreboard" id="gameInnings">First Innings</p>
				<h3 class="inner_gameScoreboard half_inner">Total <p class="enterScore" id="gameScore"></p></h3>
				<h3 class="inner_gameScoreboard half_inner">Wickets <p class="enterScore" id="gameWickets"></p></h3>
				<h3 class="inner_gameScoreboard clear">First Innings <p class="enterScore" id="firstInningsScore"></p></h3>
				<h3 class="inner_gameScoreboard clear">Opponent Score <p class="enterScore" id="oppScore"></p></h3>
			</div>
			<div class="half_scoreboard bowlerArea">
				<div class="inner_half"><p class="bowlerScore" id="bowlerOne">1</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerTwo">2</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerThree">3</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerFour">4</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerFive">5</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerSix">6</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerSeven">7</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerEight">8</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerNine">9</div>
				<div class="inner_half"><p class="bowlerScore" id="bowlerTen">10</div>
			</div>
			<div class="half_scoreboard batterArea">
				<div class="inner_half"><p class="batterScore" id="1"></p></div>
				<div class="inner_half"><p class="batterScore" id="2"></p></div>
				<div class="inner_half"><p class="batterScore" id="3"></p></div>
				<div class="inner_half"><p class="batterScore" id="4"></p></div>
				<div class="inner_half"><p class="batterScore" id="5"></p></div>
				<div class="inner_half"><p class="batterScore" id="6"></p></div>
				<div class="inner_half"><p class="batterScore" id="7"></p></div>
				<div class="inner_half"><p class="batterScore" id="8"></p></div>
				<div class="inner_half"><p class="batterScore" id="9"></p></div>
				<div class="inner_half"><p class="batterScore" id="10"></p></div>
			</div>
			<div class="scoreboard" id="cricketScoreboard">
				<div class="inner_scoreboard"><p id="nameSection"></p></div>
				<div class="inner_scoreboard"><p id="playerTypeSection"></p></div>
				<div class="inner_scoreboard"><p id="firstSection"></p></div>
				<div class="inner_scoreboard"><p id="secondSection"></p></div>
				<div class="inner_scoreboard"><p id="thirdSection"></p></div>
				<div class="inner_scoreboard"><p id="totalSection"></p></div>
			</div>
		</div>
		<div class="board" id="board">
				<svg height="100%" version="1.1" viewBox="-225 -225 450 450" width="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

				  <defs>
				    <line id="refwire" stroke="Silver" stroke-width="1" x1="2.566" x2="26.52" y1="16.20" y2="167.4"/>
				    <path d="M 0 0 L 15.64 98.77 A 100 100 0 0 1 -15.64 98.77 Z" id="SLICE" stroke-width="0"/>
				    <use id="double" transform="scale(1.695)" xlink:href="#SLICE"/>
				    <use id="outer" transform="scale(1.605)" xlink:href="#SLICE"/>
				    <use id="triple" transform="scale(1.065)" xlink:href="#SLICE"/>
				    <use id="inner" transform="scale(0.975)" xlink:href="#SLICE"/>
				  </defs>

				  <g transform="scale(1,-1)">
				    <circle class="black" r="226"/>
				    <g id="dartboard">
				      <g>
				        <use class="red double scalable" data-value="20" xlink:href="#double" id="d20"/>
				        <use class="black single" data-value="20" xlink:href="#outer" id="s20"/>
				        <use class="red treble scalable" data-value="20" xlink:href="#triple" id="t20"/>
				        <use class="black single" data-value="20" xlink:href="#inner" id="s20"/>
				      </g><!-- 20 AREA -->
				      <g transform="rotate(18)">
				        <use class="green double scalable" data-value="5" xlink:href="#double" id="d5"/>
				        <use class="white single" data-value="5" xlink:href="#outer" id="s5"/>
				        <use class="green treble scalable" data-value="5" xlink:href="#triple" id="t5"/>
				        <use class="white single" data-value="5" xlink:href="#inner"/>
				      </g><!-- 5 AREA -->
				      <g transform="rotate(36)">
				        <use class="red double scalable" data-value="12" xlink:href="#double" id="d12"/>
				        <use class="black single" data-value="12" xlink:href="#outer" id="s12"/>
				        <use class="red treble scalable" data-value="12" xlink:href="#triple" id="t12"/>
				        <use class="black single" data-value="12" xlink:href="#inner"/>
				      </g><!-- 12 AREA -->
				      <g transform="rotate(54)">
				        <use class="green double scalable" data-value="9" xlink:href="#double" id="d9"/>
				        <use class="white single" data-value="9" xlink:href="#outer" id="s9"/>
				        <use class="green treble scalable" data-value="9" xlink:href="#triple" id="t9"/>
				        <use class="white single" data-value="9" xlink:href="#inner"/>
				      </g><!-- 9 AREA -->
				      <g transform="rotate(72)">
				        <use class="red double scalable" data-value="14" xlink:href="#double" id="d14"/>
				        <use class="black single" data-value="14" xlink:href="#outer" id="s14"/>
				        <use class="red treble scalable" data-value="14" xlink:href="#triple" id="t14"/>
				        <use class="black single" data-value="14" xlink:href="#inner"/>
				      </g><!-- 14 AREA -->
				      <g transform="rotate(90)">
				        <use class="green double scalable" data-value="11" xlink:href="#double" id="d11"/>
				        <use class="white single" data-value="11" xlink:href="#outer" id="s11"/>
				        <use class="green treble scalable" data-value="11" xlink:href="#triple" id="t11"/>
				        <use class="white single" data-value="11" xlink:href="#inner"/>
				      </g><!-- 11 AREA -->
				      <g transform="rotate(108)">
				        <use class="red double scalable" data-value="8" xlink:href="#double" id="d8"/>
				        <use class="black single" data-value="8" xlink:href="#outer" id="s8"/>
				        <use class="red treble scalable" data-value="8" xlink:href="#triple" id="t8"/>
				        <use class="black single" data-value="8" xlink:href="#inner"/>
				      </g><!-- 8 AREA -->
				      <g transform="rotate(126)">
				        <use class="green double scalable" data-value="16" xlink:href="#double" id="d16"/>
				        <use class="white single" data-value="16" xlink:href="#outer" id="s16"/>
				        <use class="green treble scalable" data-value="16" xlink:href="#triple" id="t16"/>
				        <use class="white single" data-value="16" xlink:href="#inner"/>
				      </g><!-- 16 AREA -->
				      <g transform="rotate(144)">
				        <use class="red double scalable" data-value="7" xlink:href="#double" id="d7"/>
				        <use class="black single" data-value="7" xlink:href="#outer" id="s7"/>
				        <use class="red treble scalable" data-value="7" xlink:href="#triple" id="t7"/>
				        <use class="black single" data-value="7" xlink:href="#inner"/>
				      </g><!-- 7 AREA -->
				      <g transform="rotate(162)">
				        <use class="green double scalable" data-value="19" xlink:href="#double" id="d19"/>
				        <use class="white single" data-value="19" xlink:href="#outer" id="s19"/>
				        <use class="green treble scalable" data-value="19" xlink:href="#triple" id="t19"/>
				        <use class="white single" data-value="19" xlink:href="#inner"/>
				      </g><!-- 19 AREA -->
				      <g transform="rotate(180)">
				        <use class="red double scalable" data-value="3" xlink:href="#double" id="d3"/>
				        <use class="black single" data-value="3" xlink:href="#outer" id="s3"/>
				        <use class="red treble scalable" data-value="3" xlink:href="#triple" id="t3"/>
				        <use class="black single" data-value="3" xlink:href="#inner"/>
				      </g><!-- 3 AREA -->
				      <g transform="rotate(198)">
				        <use class="green double scalable" data-value="17" xlink:href="#double" id="d17"/>
				        <use class="white single" data-value="17" xlink:href="#outer" id="s17"/>
				        <use class="green treble scalable" data-value="17" xlink:href="#triple" id="t17"/>
				        <use class="white single" data-value="17" xlink:href="#inner"/>
				      </g><!-- 17 AREA -->
				      <g transform="rotate(216)">
				        <use class="red double scalable" data-value="2" xlink:href="#double" id="d2"/>
				        <use class="black single" data-value="2" xlink:href="#outer" id="s2"/>
				        <use class="red treble scalable" data-value="2" xlink:href="#triple" id="t2"/>
				        <use class="black single" data-value="2" xlink:href="#inner"/>
				      </g><!-- 2 AREA -->
				      <g transform="rotate(234)">
				        <use class="green double scalable" data-value="15" xlink:href="#double" id="d15"/>
				        <use class="white single" data-value="15" xlink:href="#outer" id="s15"/>
				        <use class="green treble scalable" data-value="15" xlink:href="#triple" id="t15"/>
				        <use class="white single" data-value="15" xlink:href="#inner"/>
				      </g><!-- 15 AREA -->
				      <g transform="rotate(252)">
				        <use class="red double scalable" data-value="10" xlink:href="#double" id="d10"/>
				        <use class="black single" data-value="10" xlink:href="#outer" id="s10"/>
				        <use class="red treble scalable" data-value="10" xlink:href="#triple" id="t10"/>
				        <use class="black single" data-value="10" xlink:href="#inner"/>
				      </g><!-- 10 AREA -->
				      <g transform="rotate(270)">
				        <use class="green double scalable" data-value="6" xlink:href="#double" id="d6"/>
				        <use class="white single" data-value="6" xlink:href="#outer" id="s6"/>
				        <use class="green treble scalable" data-value="6" xlink:href="#triple" id="t6"/>
				        <use class="white single" data-value="6" xlink:href="#inner"/>
				      </g><!-- 6 AREA -->
				      <g transform="rotate(288)">
				        <use class="red double scalable" data-value="13" xlink:href="#double" id="d13"/>
				        <use class="black single" data-value="13" xlink:href="#outer" id="s13"/>
				        <use class="red treble scalable" data-value="13" xlink:href="#triple" id="t13"/>
				        <use class="black single" data-value="13" xlink:href="#inner"/>
				      </g><!-- 13 AREA -->
				      <g transform="rotate(306)">
				        <use class="green double scalable" data-value="4" xlink:href="#double" id="d4"/>
				        <use class="white single" data-value="4" xlink:href="#outer" id="s4"/>
				        <use class="green treble scalable" data-value="4" xlink:href="#triple" id="t4"/>
				        <use class="white single" data-value="4" xlink:href="#inner"/>
				      </g><!-- 4 AREA -->
				      <g transform="rotate(324)">
				        <use class="red double scalable" data-value="18" xlink:href="#double" id="d18"/>
				        <use class="black single" data-value="18" xlink:href="#outer" id="s18"/>
				        <use class="red treble scalable" data-value="18" xlink:href="#triple" id="t18"/>
				        <use class="black single" data-value="18" xlink:href="#inner"/>
				      </g><!-- 18 AREA -->
				      <g transform="rotate(342)">
				        <use class="green double scalable" data-value="1" xlink:href="#double" id="d1"/>
				        <use class="white single" data-value="1" xlink:href="#outer" id="s1"/>
				        <use class="green treble scalable" data-value="1" xlink:href="#triple" id="t1"/>
				        <use class="white single" data-value="1" xlink:href="#inner"/>
				      </g><!-- 1 AREA -->
				      <g class="scalable">
					      <circle class="green single scaleTwo" data-value="25" r="16.4" stroke-width="0" id="s25"/>
					      <circle class="red double scaleTwo" data-value="25" r="6.85" stroke-width="0" id="bullseye"/>
					  </g><!-- BULLSEYE AREA -->
				      <g class="scalable" id="grid">
				        <use xlink:href="#refwire"/>
				        <use transform="rotate(18)" xlink:href="#refwire"/>
				        <use transform="rotate(36)" xlink:href="#refwire"/>
				        <use transform="rotate(54)" xlink:href="#refwire"/>
				        <use transform="rotate(72)" xlink:href="#refwire"/>
				        <use transform="rotate(90)" xlink:href="#refwire"/>
				        <use transform="rotate(108)" xlink:href="#refwire"/>
				        <use transform="rotate(126)" xlink:href="#refwire"/>
				        <use transform="rotate(144)" xlink:href="#refwire"/>
				        <use transform="rotate(162)" xlink:href="#refwire"/>
				        <use transform="rotate(180)" xlink:href="#refwire"/>
				        <use transform="rotate(198)" xlink:href="#refwire"/>
				        <use transform="rotate(216)" xlink:href="#refwire"/>
				        <use transform="rotate(234)" xlink:href="#refwire"/>
				        <use transform="rotate(252)" xlink:href="#refwire"/>
				        <use transform="rotate(270)" xlink:href="#refwire"/>
				        <use transform="rotate(288)" xlink:href="#refwire"/>
				        <use transform="rotate(306)" xlink:href="#refwire"/>
				        <use transform="rotate(324)" xlink:href="#refwire"/>
				        <use transform="rotate(342)" xlink:href="#refwire"/>
				        <!-- from here down some bytes could be saved with CSS -->
				        <circle fill="none" r="169.5" stroke="Silver" stroke-width="1"/>
				        <circle class="dontScale" fill="none" r="160.5" stroke="Silver" stroke-width="1"/>
				        <circle fill="none" r="106.5" stroke="Silver" stroke-width="1"/>
				        <circle class="dontScale" fill="none" r="97.5" stroke="Silver" stroke-width="1"/>
				        <circle class="scaleTwo" fill="none" r="16.4" stroke="Silver" stroke-width="1"/>
				        <circle class="scaleTwo" fill="none" r="6.85" stroke="Silver" stroke-width="1"/>
				      </g><!-- WIRES/ OUTER RINGS -->
				    </g><!-- CLOSE G WITH ID DARTBOARD -->
				  </g><!-- CLOSE G WITH TRANSFORM SCALE -->

				  <g id="numbers">
				    <!-- alignment-baseline:middle; doesn't do what i expected it too, therefore i've changed y="200" to y="220" as a ugly hack -->
				    <!-- the characters should be about the same thickness as the wiring, cause in reality they're made from wiring -->
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-270)" y="-204">6</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-288)" y="-204">13</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-306)" y="-204">4</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-324)" y="-204">18</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-342)" y="-204">1</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" y="-204">20</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-18)" y="-204">5</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-36)" y="-204">12</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-54)" y="-204">9</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-72)" y="-204">14</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-90)" y="-204">11</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(72)" y="208">8</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(54)" y="208">16</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(36)" y="208">7</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(18)" y="208">19</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" y="208">3</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-18)" y="208">17</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-36)" y="208">2</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-54)" y="208">15</text>
				    <text fill="Silver" font-size="30" style="text-anchor:middle;font-weight:200;alignment-baseline:middle;" transform="rotate(-72)" y="208">10</text>
				  </g><!-- CLOSE G WITH ID NUMBERS -->

				</svg><!-- CLOSE SVG/ DARTBOARD -->
			</div><!-- CLOSE DIV WITH CLASS BOARD -->

			<div class="gameButtons" id="cricketButtons">
				<button class="button redButton" id="undoScore">undo</button>
				<button class="button greenButton" id="friendly">Friendly</button>
			</div>
	</div>
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="cricketGame.js"></script>

  <script type="text/javascript">
  	players = 
  	{
  		current: 0,
  		players: []
  	}

  	function createPlayer( name )
  	{
		var player = 
		{
			name: name,
			playerType: '',
			bowled: 0,
			batted: 0,
			inningsSelected: Number('<?=$innings;?>'),
			innings: 0,
			wickets: 10,
			firstDart: 0,
			secondDart: 0,
			thirdDart: 0,
			scores: [],
			textScores: [],
			runsScored: [],
			wicketsTaken: [],
			turnScores: [],
			O41: 0,
			U41: 0,
			outerBulls: 0,
			bullseyes: 0,
			trebles: 0,
			runOuts: 0,
			wides: 0,
			turnScore: 0,
			totalScored: 0,
			dartsMissed: 0,
			currentDarts: 0,
			numDarts: [],
			inningsScore: [],
			winMethod: '',
			difference: 0,
			gamesPlayed: 0,
			gameOutcome: 0,
			gamesWon: 0,
			gamesDrawn: 0
		}
		players.players.push(player);
  	}

	$('.board').hide();
	$('.gameButtons').hide();
	$('.gameScoreboard').hide();
	$('.half_scoreboard').hide();
	$('.scoreboard').hide();
	$('#bowlerTitle').hide();

	var user = '<?=$user_username;?>';
	var opponent = '<?=$opponent;?>';
	var guest = '<?=$guest;?>';

	if(user != '')
	{
		createPlayer(user);
	}

	var playerOrder = $('.playerOrder');
	var playersToOrder = $('.playersToOrder');
	var submitOrder = document.createElement('button');
	$(submitOrder).addClass('button greenButton');
	$(submitOrder).css('margin-bottom', '20px');

	if (opponent != '') 
	{
		createPlayer(opponent);
		orderSelection();
	}
	else if (guest != '') 
	{
		createPlayer(guest);
		orderSelection();
	}
	else
	{
		$(playerOrder).hide();
	}


	// FUNCTION TO MOVE AN ITEM IN THE ARRAY TO ANOTHER INDEX
	function arraymove(arr, fromIndex, toIndex) {
	    var element = arr[fromIndex];
	    arr.splice(fromIndex, 1);
	    arr.splice(toIndex, 0, element);
	}

	function orderSelection()
	{
		submitOrder.textContent = 'submit order';
		$(submitOrder).addClass('startGameButton greenButton');
		playerOrder.prepend(submitOrder);
		for (var i = 0; i < players.players.length; i++) 
		{
			createOrder(players.players[i], i);
		}
		submitOrder.onclick = function()
		{
			var x = confirm('are you happy with the order of throw?');
			if (x) 
			{
				$('.board').show();
				$('.gameScoreboard').show();
				$('.half_scoreboard').show();
				$('.scoreboard').show();
				$('#bowlerTitle').show();
				$('#bowlerName').text(players.players[0].name);
				players.players[0].playerType = 'bowler';
				players.players[1].playerType = 'batsman';
				playerOrder.remove();
				$(this).remove();
				$('#nameSection').text(players.players[0].name);
				$('#playerTypeSection').text(players.players[0].playerType);
				$('.gameButtons').show()
			}
		}
	}

	// FUNCTION TO LISTS PLAYERS WITH OWN SECTION AND BUTTONS
	function createOrder( player, index ){
		var section = document.createElement('li');
		var moveUp = document.createElement('button');
		var moveDown = document.createElement('button');
		var buttons = document.createElement('div');
		$(moveUp).addClass('greenButton fa fa-angle-up');
		$(moveDown).addClass('redButton fa fa-angle-down');
		$(buttons).addClass('right');
		section.textContent = player.name;
		if (index == 0) 
		{
			$(buttons).append(moveDown);
		}
		else
		{
			$(buttons).append(moveUp)
		}
		section.append(buttons);

		playersToOrder.append(section);

		moveUp.onclick = function(){
			var current = $(this).closest('li');
			var previous = current.prev('li');
			if (index > 0) 
			{
				newIndex = index - 1;
			} 
			else 
			{
				newIndex = 0;
			}
			arraymove(players.players, index, newIndex );
			// var index = $(this).index();
			if (previous.length !== 0) 
			{
				current.insertBefore(previous);
				$(current).children().empty();
				$(current).children().append(moveDown);
				$(previous).children().empty();
				$(previous).children().append(moveUp);
			}
			return false;
		}

		moveDown.onclick = function(){
			var current = $(this).closest('li');
			var next = current.next('li');
			if (index < players.players.length) 
			{
				newIndex = index + 1;
			} 
			else 
			{
				newIndex = players.players.length - 1;
			}
			arraymove(players.players, index, newIndex );
			// var index = $(this).index();
			if (next.length !== 0) 
			{
				current.insertAfter(next);
				$(current).children().empty();
				$(current).children().append(moveUp);
				$(next).children().empty();
				$(next).children().append(moveDown);
			}
			return false;
		}
	}

	var quitButton = $('.quitGame');
	$(quitButton).on('click', function()
	{
		var quit = confirm('are you sure you want to quit the game?');
		if (quit) 
		{
			location.replace('../account.php?username=<?=$user_username;?>');
		}
	})


  </script>

</body>
</html>