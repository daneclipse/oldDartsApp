<?php

include('../connection.php');
$user_username = $_GET['username'];
$targetNumber = $_GET['game'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="../css/general.css">
	<link rel="stylesheet" type="text/css" href="../css/game.css">
	<link rel="stylesheet" type="text/css" href="../css/hundred.css">
</head>
<body>

<!-- 	<div class="navBar">
		<h1 class="accountName"><?= $user_username;?></h1>
		<a href="../account.php?username=<?=$user_username;?>">Back to account</a>
		<a href="../index.php">Home</a>
	</div> -->

	<div class="page">
		<span class="quitGame">X</span>
		<!-- INSERT PLAYER INTO hundredDarts TABLE ON DATABASE TO KEEP STATS -->
		<div class="game" id="hundredGame">	
			<div class="scoreboard">
				<div class="inner_scoreboard typeHit">
					<div class="third_height">Singles Hit<p class="enterScore" id="singlesHit">0</p></div>
					<div class="third_height">Doubles Hit<p class="enterScore" id="doublesHit">0</p></div>
					<div class="third_height">Trebles Hit<p class="enterScore" id="treblesHit">0</p></div>
				</div>
				<div class="inner_scoreboard dartsLeft">
					<p class="numDartsLeft"></p>
					<p class="target"></p>
				</div>
				<div class="inner_scoreboard">
					<div class="third_height">Points Scored<p class="enterScore" id="pointsScored">0</p></div>
					<div class="third_height">Total Scored<p class="enterScore" id="totalScored">0</p></div>
					<div class="third_height">Darts Missed<p class="enterScore" id="dartsMissed">0</p></div>
				</div>
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
		<div class="gameButtons">
			<button class="button redButton" id="undoScore">undo</button>
			<button class="button greenButton" id="friendly">Friendly</button>
		</div>
	</div>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
	var players = [];

	function addPlayer( name )
	{
		var player = {
			name: name,
			targetNumber: Number('<?=$targetNumber;?>'),
			firstDart: 0,
			secondDart: 0,
			thirdDart: 0,
			scores: [],
			singlesHit: 0,
			doublesHit: 0,
			treblesHit: 0,
			points: [],
			pointsScored: 0,
			totalScored: 0,
			startDarts: 100,
			numDarts: 100,
			dartsMissed: 0,
			segments: []
		}
		players.push(player);
		localStorage.hundred = JSON.stringify(players);
	}

	function createScoreboard( player )
	{
		var section = document.createElement('div');
		var scoreSection = document.createElement('div');
		var nameSection = document.createElement('div');
		var firstDartSection = document.createElement('div');
		var secondDartSection = document.createElement('div');
		var thirdDartSection = document.createElement('div');
		
		$(section).addClass('playerBox');
		$(nameSection).addClass('section nameSection');
		$(scoreSection).addClass('section scoreSection');
		$(firstDartSection).addClass('section innerSection');
		$(secondDartSection).addClass('section innerSection');
		$(thirdDartSection).addClass('section innerSection');

		nameSection.textContent = player.name;
		firstDartSection.textContent = '';
		secondDartSection.textContent = '';
		thirdDartSection.textContent = '';

		player.section = section;
		player.nameSection = nameSection;
		player.scoreSection = scoreSection;
		player.firstDartSection = firstDartSection;
		player.secondDartSection = secondDartSection;
		player.thirdDartSection = thirdDartSection;

		scoreSection.append(firstDartSection);
		scoreSection.append(secondDartSection);
		scoreSection.append(thirdDartSection);

		section.append(nameSection);
		section.append(scoreSection);


		$('.game').append(section);
	}

	addPlayer('<?= $user_username; ?>');
	$('.numDartsLeft').text(players[0].numDarts);
	createScoreboard( players[0] );


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
<script type="text/javascript" src="100DartsAt.js"></script>

</body>
</html>