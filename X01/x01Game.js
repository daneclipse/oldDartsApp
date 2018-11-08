// SETS PLAYERS.PLAYERS ARRAY TO ARRAY FOUND IN LOCAL STORAGE
if (localStorage['players']) 
{
	players.players = JSON.parse(localStorage.players);
}

// CREATES SCOREBOARD FOR PLAYER & ADDS IT TO THE PAGE
function createScoreboard( player ){
	var page = $('.page');
	var section = document.createElement('div');
	var nameSection = document.createElement('div');
	var firstDartSection = document.createElement('div');
	var secondDartSection = document.createElement('div');
	var thirdDartSection = document.createElement('div');
	var totalScoredSection = document.createElement('div');
	var targetLeftSection = document.createElement('div');
	
	$(section).addClass('playerBox');
	$(nameSection).addClass('scoreboardSection');
	$(firstDartSection).addClass('scoreboardSection');
	$(secondDartSection).addClass('scoreboardSection');
	$(thirdDartSection).addClass('scoreboardSection');
	$(totalScoredSection).addClass('scoreboardSection');
	$(targetLeftSection).addClass('scoreboardSection');

	nameSection.textContent = player.name;
	firstDartSection.textContent = '';
	secondDartSection.textContent = '';
	thirdDartSection.textContent = '';
	totalScoredSection.textContent = '';
	targetLeftSection.textContent = player.targetScore;

	player.section = section;
	player.nameSection = nameSection;
	player.firstDartSection = firstDartSection;
	player.secondDartSection = secondDartSection;
	player.thirdDartSection = thirdDartSection;
	player.totalScoredSection = totalScoredSection;
	player.targetLeftSection = targetLeftSection;

	section.append(nameSection);
	section.append(firstDartSection);
	section.append(secondDartSection);
	section.append(thirdDartSection);
	section.append(totalScoredSection);
	section.append(targetLeftSection);


	$('.game').append(section);
}

for (var i = 0; i < players.players.length; i++) 
{
	createScoreboard(players.players[i]);
}

/* ----- GAME ----- */

var dart = 0;
var doubleClicked = false;

var single = $('.single');
var double = $('.double');
var treble = $('.treble');
var board = $('.board');
var undo = $('#undoScore');
var friendly = $('#friendly');
var wire = $('#refwire');

var checkoutArea = $('#checkoutArea');

// MAKES DOUBLES, TREBLES & BULLSEYE BIGGER
friendly.on('click', function(evt)
{
	evt.stopPropagation();
	if ( $('.board').hasClass('scale') ) 
	{
		wire.attr({'y1': '16.20', 'x1': '2.566'});
	} 
	else 
	{
		wire.attr({'y1': '21.20', 'x1': '3.566'});
	}
	$('.board').toggleClass('scale');
});

var completeGameButton = document.createElement('button');
completeGameButton.textContent = 'complete game';
$(completeGameButton).addClass('completeGame greenButton');
var legWonBox = document.createElement('p');
$(legWonBox).addClass('legWonBox');
var playerThrowBox = document.createElement('p');
$(playerThrowBox).addClass('playerThrowBox');

// add something to tell everyone whos throw it is (at the start of each leg)
$(players.players[0].nameSection).prepend(playerThrowBox);

// CHECKS THE CHECKOUT FOR FIRST PLAYER
// IF THERE ARE 2 PLAYERS, DIM THE SECOND PLAYER
checkCheckout(0, players.players[0]);
if(players.players.length > 1)
{
	dimPlayer(players.players[players.players.length - 1]);
}

// FUNCITON TO CHECK THE CHECKOUT, IF YOU CAN CHECK IT OUT, SHOWS CHECKOUT IN A BOX & FLASHES SEGMENT TO YOU NEED
function checkCheckout( dartNum, player )
{
	var firstBox = $('.playerBox')[0];
	$(firstBox).css('margin-top', '0');
	if (player.targetLeft >= 111 && player.targetLeft <= 170) 
	{
		$(checkoutArea).show();
		var arr = threeDartCheckout;
		checkArray(arr, player);
	}
	else if(player.targetLeft > 50 && player.targetLeft <= 110)
	{
		$(checkoutArea).show();
		if ( dartNum == 1 )
		{
			var arr = twoDartCheckout;
			checkArray(arr, player);
		}
		else
		{
			var arr = threeDartCheckout;
			checkArray(arr, player);
		}
	}
	else if (player.targetLeft <= 50)
	{
		$(checkoutArea).show();
		if (dartNum == 2) 
		{
			var arr = oneDartCheckout;
			checkArray(arr, player);
		}
		else
		{
			var arr = twoDartCheckout;
			checkArray(arr, player);
		}
	}
	else
	{
		$(checkoutArea).hide();
		$(firstBox).css('margin-top', '300px');
	}
}

function checkArray(arr, player)
{
	for (var i = 0; i <= arr.length - 1; i++) 
	{
		if (player.targetLeft == arr[i].score) 
		{
			$('#checkoutArea').text(arr[i].checkout);
			flashSegment();
		}
	}
}

/* --- FUNCTION TO FLASH THE SEGMENT WHEN ON A CHECKOUT 
- GETS ID OF SEGMENT NEEDED & FLASHES
- CHECKS ID AGAINST THE NUMBER NEEDED FROM THE CHECKOUT TABLE ARRAY SHOWN IN CHECKOUT AREA
- WHEN SEGMENT HAS BEEN HIT, STOPS FLASHING THAT SEGMENT
--- */

// ISSUE - CANT HAVE A CHECKOUT THAT NEEDS THE SAME SEGMENT CLICKED AFTER EACH OTHER - t20 t20 for example - ONCE SEGMENT HAS BEEN CLICKED IT STOPS THE FLASH
function flashSegment()
{
	var checkoutArea = $('#checkoutArea');
	var number = checkoutArea.text().split(' ', 1)[0];
	var segment = document.getElementById(number);
	var flash = setInterval(function(){
		$(segment).fadeOut(500, function(){
			$(segment).fadeIn(500);
		})
	}, 100)
	segment.onclick = function(){
		clearInterval(flash);
		$(this).fadeIn(100);
	}
	$('.single').click(function(){
		clearInterval(flash);
	})
	$('.double').click(function(){
		clearInterval(flash);
	})
	$('.treble').click(function(){
		clearInterval(flash);
	})
	$('.board').click(function(){
		clearInterval(flash);
	})
	$('#undoScore').click(function(){
		clearInterval(flash);
	})
}

single.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var score = Number($(this).attr('data-value'));
	var text = 's' + $(this).attr('data-value');
	doubleClicked = false;
	currentPlayer.scores.push(score);
	currentPlayer.scoresText.push(text);
	checkDart( score, text );
});

double.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var score = Number($(this).attr('data-value') * 2);
	var text = 'd' + $(this).attr('data-value');
	doubleClicked = true;
	currentPlayer.scores.push(score);
	currentPlayer.scoresText.push(text);
	checkDart( score, text );
});

treble.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var score = Number($(this).attr('data-value') * 3);
	var text = 't' + $(this).attr('data-value');
	doubleClicked = false;
	currentPlayer.scores.push(score);
	currentPlayer.scoresText.push(text);
	checkDart( score, text );
});

board.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var score = 0;
	var text = 'miss';
	doubleClicked = false;
	currentPlayer.scores.push(score);
	currentPlayer.scoresText.push(text);
	currentPlayer.dartsMissed++;
	checkDart( score, text );
});

// FUNCTION TO CHECK THE CURRENT DART THROWN, IF OVER 3, DART = 0
function checkDart( score, text )
{
	var currentPlayer = players.players[players.current];
	if ( dart >= 3 ) 
	{
		dart = 0;
		currentPlayer.firstDartSection.textContent = '';
		currentPlayer.secondDartSection.textContent = '';
		currentPlayer.thirdDartSection.textContent = '';
		currentPlayer.totalScoredSection.textContent = '';
	}
	dart++;
	scorer( currentPlayer, score, text );
}

function scoreFirstDart( player, score, text )
{
	player.numDarts++;
	player.totalScored = player.totalScored + score;
	player.firstDart = score;
	player.firstDartSection.textContent = text;
	player.turnScore = score;
	player.totalScoredSection.textContent = player.turnScore;
	if (player.targetLeft == 50 || player.targetLeft <= 40 ) 
	{
		if(player.targetLeft % 2 == 0)
		{
			player.dartsAtDouble++;	
		}
	}
	player.targetLeft = player.targetLeft - score;
	player.targetLeftSection.textContent = player.targetLeft;
	// CHECKOUT WITH TWO DARTS LEFT
	checkCheckout(1, player);
}

function scoreSecondDart( player, score, text )
{
	player.numDarts++;
	player.totalScored = player.totalScored + score;
	player.secondDart = score;
	player.secondDartSection.textContent = text;
	player.turnScore = player.turnScore + score;
	player.totalScoredSection.textContent = player.turnScore;
	if (player.targetLeft == 50 || player.targetLeft <= 40 ) 
	{
		if(player.targetLeft % 2 == 0)
		{
			player.dartsAtDouble++;	
		}
	}
	player.targetLeft = player.targetLeft - score;
	player.targetLeftSection.textContent = player.targetLeft;
	// CHECKOUT WITH ONE DART LEFT
	checkCheckout(2, player);
}

function scoreThirdDart( player, score, text )
{
	player.numDarts++;
	player.totalScored = player.totalScored + score;
	player.thirdDart = score;
	player.thirdDartSection.textContent = text;
	player.turnScore = player.turnScore + score;
	if (player.turnScore > player.highScore) 
	{
		player.highScore = player.turnScore;
	}
	player.totalScoredSection.textContent = player.turnScore;
	if (player.targetLeft == 50 || player.targetLeft <= 40 ) 
	{
		if(player.targetLeft % 2 == 0)
		{
			player.dartsAtDouble++;	
		}
	}
	player.targetLeft = player.targetLeft - score;
	player.targetLeftSection.textContent = player.targetLeft;
	// CHECKOUT WITH THREE DARTS LEFT
}

var nextLegButton = document.createElement('button');
nextLegButton.textContent = 'Next leg';
$(nextLegButton).addClass('nextLegButton');

/* --- WHEN LEG HAS BEEN WON 
- ALERT PLAYERS NAME, ADDS BOX TO SHOW A LEG HAS BEEN WON
- CHANGES THE ORDER OF THROW & INERSTS/ UPDATES STATS IN DATABASE
- ALLOWS YOU TO VIEW THE STATS FROM THAT LEG FOR EACH PLAYER
- IF NEXT LEG BUTTON IS PRESSED - RESET STATS FOR BOTH PLAYERS
--- */
function legWinner( player )
{
	alert(player.name + ' won the leg');
	$(legWonBox).clone().appendTo(player.section);
	player.doublePercent = (1 / player.dartsAtDouble) * 100;
	$('#checkoutArea').empty();
	$('#checkoutArea').hide();
	$('#friendly').hide();
	$('#undoScore').css('margin-top', '50px');
	for (var i = 0; i < players.players.length; i++) 
	{
		changeOrder(i);
		localStorage.players = JSON.stringify(players.players);
	}
	var statsArea = document.createElement('div');
	$(statsArea).addClass('statsArea');
	$('.page').append(statsArea);
	for (var i = 0; i < players.players.length; i++) 
	{
		players.players[i].average = Number((players.players[i].totalScored / players.players[i].numDarts).toFixed(2));
		showLegStats(players.players[i]);
	}
	if (player.legsWon == player.legsToWin) 
	{
		gameWinner(player);
		for (var i = 0; i < players.players.length; i++) 
		{
			updateStats(players.players[i]);
		}
	}
	else
	{
		$('.page').append(nextLegButton);
		$(nextLegButton).addClass('button greenButton');
		$(nextLegButton).on('click', function()
		{
			$('.statsArea').empty();
			$('.statsArea').remove();
			$('.board').show();
			$('.game').show();
			$('#friendly').show();
			$('#undoScore').css('margin-top', '0');
			$(this).remove();
			for (var i = 0; i < players.players.length; i++) 
			{
				updateStats(players.players[i]);
				resetStats(players.players[i]);
			}
			var currentPlayer = players.players[players.current];
			checkCheckout(0, currentPlayer);
		})
	}

	dart = 0;
}

// ADDS SMALL BOX TO PLAYER WHO HAS WON THE LEG
function addWinnerBox( player )
{
	if (player.legsWon > 0) 
	{
		if (player.legsWon == 1) 
		{
			$(player.nameSection).append(legWonBox);
		}
		else if (player.legsWon == 2) 
		{
			
			
		}
	}
}

// INSERT & UPDATE STATS IN DATABASE USING THE UPDATESTATS.PHP
function updateStats( player )
{
	if (players.players.length == 2) 
	{
		for (var i = 0; i < players.players.length - 1; i++) 
		{
			if (player.name == players.players[i].name) 
			{
				if (window.location.search.includes('guest')) 
				{
					var oppName = window.location.search.split("&")[1].split("guest=")[1];
				}
				else if (window.location.search.includes('opponent')) 
				{
					var checkName = window.location.search.split("&")[1].split("opponent=")[1];
					if (player.name == checkName) 
					{
						var oppName = window.location.search.split("?username=")[1].split('&')[0];
					}
					else
					{
						var oppName = window.location.search.split("&")[1].split("opponent=")[1];
					}
				}
				else if (window.location.search.includes('playerOne'))
				{
					if (window.location.search.includes('playerTwo')) 
					{
						var checkName = window.location.search.split("&")[1].split("playerTwo=")[1];
						if (player.name == checkName) 
						{
							var oppName = window.location.search.split("&")[1].split("playerOne=")[1];
						}
						else
						{
							var oppName = window.location.search.split("&")[1].split("playerTwo=")[1];
						}
					}
					else
					{
						var oppName = 'no opponent';
					}
				}
			}
			else
			{
				var oppName = players.players[i].name;
			}
		}
	}
	else
	{
		var oppName = 'no opponent';
	}

	if (player.targetLeft == 0) 
	{
		player.checkout = player.turnScore;
	}
	else
	{
		player.checkout = 0;
	}
	player.average = Number((player.totalScored / player.numDarts).toFixed(2));
	var xmlhttp;
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			$('#stats').innerHTML = this.responseText;
		}
	}
	xmlhttp.open('GET', '../updateStats.php?name='+player.name+
		'&game=X01'+
		'&target='+player.targetScore+
		'&scored='+player.totalScored+
		'&darts='+player.numDarts+
		'&average='+player.average+
		'&checkout='+player.checkout+
		'&doublePercent='+player.doublePercent+
		'&doubleHit='+player.doubleHit[player.doubleHit.length - 1]+
		'&highScore='+player.highScore+
		'&opponent='+oppName+
		'&dartsMissed='+player.dartsMissed, true);
	xmlhttp.send();
}

// RESETS STATS TO DEFAULT
function resetStats( player )
{
	player.firstDart = 0;
	player.secondDart = 0;
	player.thirdDart = 0;
	player.scores = [];
	player.scoresText = [];
	player.turnScore = 0;
	player.numDarts = 0;
	player.totalScored = 0;
	player.highScore = 0;
	player.timesBust = 0;
	player.dartsMissed = 0;
	player.dartsAtDouble = 0;
	player.targetLeft = player.targetScore;
	player.firstDartSection.textContent = '';
	player.secondDartSection.textContent = '';
	player.thirdDartSection.textContent = '';
	player.totalScoredSection.textContent = '';
	player.targetLeftSection.textContent = player.targetLeft;
}

// IF GAME HAS BEEN WON - LEGS WON === LEGS TO WIN
// ALERTS NAME, HIDES BOARD - IF COMPLETE GAME BUTTON IS CLICKED GO BACK TO USERS ACCOUNT
function gameWinner( player )
{
	alert(player.name + ' is the winner');
	$('.page').append(completeGameButton);
	$(board).hide();
	$('#undoScore').hide();
	$(completeGameButton).on('click', function()
	{
		var completeGame = confirm('Are you sure you want to complete the game?');
		if (completeGame) 
		{
			player.doublePercent = (1 / player.dartsAtDouble) * 100;
			var playerName = window.location.search.split("&")[0].split("username=")[1];
			location.replace('../account.php?username='+playerName);
		}
	})
}

// hides the board & scoreboards
// adds a button to view each players stats from leg just played & start next leg button
// if next leg button is clicked, shows board & scoreboards - game continues
function showLegStats(player)
{
	$('.board').hide();
	$('.game').hide();
	var playerStatsArea = document.createElement('div');
	$(playerStatsArea).addClass('playerStatsArea');
	$(playerStatsArea).addClass(player.name);
	var viewLegStats = document.createElement('button');
	viewLegStats.textContent = 'View ' + player.name + 's leg stats';
	var hideStatsButton = document.createElement('button');
	$(viewLegStats).addClass('button greenButton');
	$(hideStatsButton).addClass('button redButton');
	hideStatsButton.textContent = 'Hide stats';
	$(playerStatsArea).append(viewLegStats)
	$('.statsArea').append(playerStatsArea);

	viewLegStats.onclick =  function()
	{
		var totalStat = player.totalScored;
		var highStat = player.highScore;
		var checkoutStat = player.checkout;
		var dartsAtDoubleStat = player.dartsAtDouble;
		var doublePercent = player.doublePercent;
		var checkoutPercentStat = doublePercent.toFixed(2);
		if (checkoutPercentStat != 0) 
		{
			var doubleHit = player.doubleHit[player.doubleHit.length - 1];
			if (doubleHit == 25) 
			{
				var doubleHit = 'bullseye';
			}
		}
		else
		{
			var doubleHit = 'N/A';
		}
		
		var averageStat = player.average * 3;
		var tda = averageStat.toFixed(2);
		$('.'+player.name).append(
			'<h2>'+player.name + ' stats</h2><table><tr><th>Total Scored</th><th>Highest Score</th><th>Checkout</th><th>Darts at double</th><th>Double %</th><th>Double hit</th><th>TDA</th></tr><tr><td>'+totalStat+'</td><td>'+highStat+'</td><td>'+checkoutStat+'</td><td>'+dartsAtDoubleStat+'</td><td>'+checkoutPercentStat+'</td><td>'+doubleHit+'<td>'+tda+'</td></tr></table>');
		$('.'+player.name).append(hideStatsButton);
		$(this).remove();
	}

	hideStatsButton.onclick = function()
	{
		$('.'+player.name).empty();
		$('.'+player.name).append(viewLegStats);
		$(this).remove();
	}

}

// dim out previous player - to clarify it is not their go
function dimPlayer( player )
{
	$(player.nameSection).css('opacity', '0.2');
	$(player.firstDartSection).css('opacity', '0.2');
	$(player.secondDartSection).css('opacity', '0.2');
	$(player.thirdDartSection).css('opacity', '0.2');
	$(player.totalScoredSection).css('opacity', '0.2');
	$(player.targetLeftSection).css('opacity', '0.2');
}

// makes scoreboard empty and highlights current player
function highlightPlayer( player )
{
	$(player.firstDartSection).text('');
	$(player.secondDartSection).text('');
	$(player.thirdDartSection).text('');
	$(player.totalScoredSection).text('');
	$(player.nameSection).css('opacity', '1');
	$(player.firstDartSection).css('opacity', '1');
	$(player.secondDartSection).css('opacity', '1');
	$(player.thirdDartSection).css('opacity', '1');
	$(player.totalScoredSection).css('opacity', '1');
	$(player.targetLeftSection).css('opacity', '1');
}

// WORKS OUT THE DART NUMBER THEN USES THE RELEVANT FUNCTION TO SCORE FOR THAT DART
// WORKS OUT IF BUST AND RUNS THE BUST FUNCTION
// IF DOUBLE IS CLICKED & SCORE = 0 THEN LEG HAS BEEN WON
function scorer( player, score, text )
{
	if ( dart == 1 )
	{
		if (player.targetLeft - score >= 2) 
		{
			scoreFirstDart( player, score, text );
		}
		else if (player.targetLeft - score === 0) 
		{
			if (doubleClicked) 

			{
				scoreFirstDart( player, score, text );
				var doubleHit = score / 2;
				player.doubleHit.push(doubleHit);
				player.legsWon++;
				legWinner( player );
			}
			else
			{
				alert('bust');
				bust(player, 1);
			}
		}
		else
		{
			alert('BUST!');
			bust(player, 1);
		}
	}
	else if ( dart == 2 ) 
	{
		if (player.targetLeft - score >= 2) 
		{
			scoreSecondDart( player, score, text );
		}
		else if (player.targetLeft - score === 0) 
		{
			if (doubleClicked) 
			{
				scoreSecondDart( player, score, text );
				var doubleHit = score / 2;
				player.doubleHit.push(doubleHit);
				player.legsWon++;
				legWinner( player );
			}
			else
			{			
				alert('bust');
				bust(player, 2);
			}
		}
		else
		{
			alert('BUST!');
			bust(player, 2);
		}
	}
	else if ( dart == 3 )
	{
		if (player.targetLeft - score >= 2 ) 
		{
			scoreThirdDart( player, score, text );
			playerGo();
			var nextPlayer = players.players[players.current];
			checkCheckout(0, nextPlayer);
			dimPlayer(player);
			highlightPlayer(nextPlayer);
		}
		else if (player.targetLeft - score === 0) 
		{
			if (doubleClicked) 
			{
				scoreThirdDart( player, score, text );
				var doubleHit = score / 2;
				player.doubleHit.push(doubleHit);
				player.legsWon++;
				legWinner( player );
			}
			else
			{			
				alert('bust');
				bust(player, 3);
			}
		}
		else
		{
			alert("BUST!");
			bust(player, 3);
		}
	}
}

/* --- BUST FUNCTION --- */
function bust( player, dartNum )
{
	player.numDarts++;
	player.timesBust++;
	if (player.targetLeft <= 40 && player.targetLeft % 2 == 0) 
	{
		player.dartsAtDouble++;
	}
	player.firstDart = 0;
	player.secondDart = 0;
	player.thirdDart = 0;
	if (dartNum == 1) 
	{
		player.scores.pop();
		player.scoresText.pop();
		resetBustedScores( player );
	}
	else if (dartNum == 2) 
	{
		player.scores.splice(-2, 2);
		player.scoresText.splice(-2, 2);
		resetBustedScores( player );
	}
	else if (dartNum == 3)
	{
		player.scores.splice(-3, 3);
		player.scoresText.splice(-3, 3);
		resetBustedScores( player );
	}
	if (player.targetLeft >= player.targetScore) 
	{
		player.targetLeft = player.targetScore;
		player.totalScored = 0;
	}
	player.turnScore = 0;
	player.firstDartSection.textContent = '';
	player.secondDartSection.textContent = '';
	player.thirdDartSection.textContent = '';
	player.totalScoredSection.textContent = '';
	player.targetLeftSection.textContent = player.targetLeft;
	dart = 0;
	changePlayer( player );
}

function resetBustedScores( player )
{
	player.totalScored = 0;
	for (var i = 0; i < player.scores.length; i++) 
	{
		player.totalScored += player.scores[i];
	}
	player.targetLeft = player.targetScore - player.totalScored;
}

/* --- FUNCTION TO CHANGE PLAYER
- DIMS CURRENT PLAYER - PLAYER WHO JUST THREW
- USE PLAYERGO FUNCTION TO CHANGE PLAYER
- CHECK CHECKOUT & HIGHLIGHTS NEXT PLAYER
--- */
function changePlayer( currentPlayer )
{
	dimPlayer(currentPlayer);
	playerGo();
	var nextPlayer = players.players[players.current];
	checkCheckout(0, nextPlayer);
	highlightPlayer(nextPlayer);
}

undo.on('click', function()
{
	var currentPlayer = players.players[players.current];
	// IF BOARD IS HIDDEN (LEG HAD BEEN WON)
	if ($(board).is(':hidden')) 
	{
		$(board).show();
		$('.game').show();
		$('#checkoutArea').show();
		$('#friendly').show();
		$('.statsArea').remove();
		$('.nextLegButton').remove();
		$(completeGameButton).remove();
		if (players.players.length > 1) 
		{
			for (var i = 0; i < players.players.length; i++) 
			{
				changeOrder(i);
			}
			var prevPlayer = players.players[players.current];
			prevPlayer.average = 0;
			prevPlayer.checkout = 0;
			prevPlayer.dartsAtDouble--;
			prevPlayer.doubleHit.pop();
			prevPlayer.doublePercent = 0;
			prevPlayer.highScore = 0;
			prevPlayer.legsWon--;
			prevPlayer.numDarts--;
			prevPlayer.targetLeft = prevPlayer.targetLeft + prevPlayer.thirdDart;
			prevPlayer.totalScored = prevPlayer.totalScored - prevPlayer.thirdDart;
			prevPlayer.turnScore = prevPlayer.turnScore - prevPlayer.thirdDart;
			prevPlayer.scores.pop();
			prevPlayer.scoresText.pop();
			prevPlayer.thirdDart = 0;
			var lastThrow = prevPlayer.scoresText[prevPlayer.scoresText.length - 1];
			var secondLastThrow = prevPlayer.scoresText[prevPlayer.scoresText.length - 2];

			$(prevPlayer.firstDartSection).text(secondLastThrow);
			$(prevPlayer.secondDartSection).text(lastThrow);
			$(prevPlayer.totalScoredSection).text(prevPlayer.totalScored);
			$(prevPlayer.targetLeftSection).text(prevPlayer.targetLeft);
			checkCheckout(2, prevPlayer);
		}
		dart = 2;
		$('.legWonBox')[$('.legWonBox').length - 1].remove();
	}
	else 
	{
		if (dart == 1) 
		{
			if ( currentPlayer.legsWon == currentPlayer.legsToWin ) 
			{
				currentPlayer.legsWon--;
				$(completeGameButton).remove();
			}
			currentPlayer.numDarts--;
			currentPlayer.targetLeft = currentPlayer.targetLeft + currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.turnScore = currentPlayer.turnScore - currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.totalScored = currentPlayer.totalScored - currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.scores.pop();
			currentPlayer.scoresText.pop();
			currentPlayer.firstDart = 0;
			currentPlayer.firstDartSection.textContent = '';
			currentPlayer.totalScoredSection.textContent = '';
			currentPlayer.targetLeftSection.textContent = currentPlayer.targetLeft;
			checkCheckout(0, currentPlayer);
			dart = 3;
		}
		else if (dart == 2)
		{
			if ( currentPlayer.legsWon == currentPlayer.legsToWin ) 
			{
				currentPlayer.legsWon--;
				$(completeGameButton).remove();
			}
			currentPlayer.numDarts--;
			currentPlayer.targetLeft = currentPlayer.targetLeft + currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.turnScore = currentPlayer.turnScore - currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.totalScored = currentPlayer.totalScored - currentPlayer.scores[currentPlayer.scores.length - 1];
			currentPlayer.scores.pop();
			currentPlayer.scoresText.pop();
			currentPlayer.secondDart = 0;
			currentPlayer.secondDartSection.textContent = '';
			currentPlayer.totalScoredSection.textContent = currentPlayer.totalScored;
			currentPlayer.targetLeftSection.textContent = currentPlayer.targetLeft;
			checkCheckout(1, currentPlayer);
			dart = 1;
		}
		else
		{
			if (players.players[0].targetLeft == players.players[0].targetScore && players.players[0].scores.length == 0) 
			{
				dart = 0;
				return;
			}
			if ( currentPlayer.legsWon == currentPlayer.legsToWin ) 
			{
				currentPlayer.legsWon--;
				$(completeGameButton).remove();
			}
			dimPlayer( currentPlayer)
			playerGo();
			var prevPlayer = players.players[players.current];
			highlightPlayer(prevPlayer);
			prevPlayer.numDarts--;
			prevPlayer.targetLeft = prevPlayer.targetLeft + prevPlayer.scores[prevPlayer.scores.length - 1];
			prevPlayer.turnScore = prevPlayer.turnScore - prevPlayer.scores[prevPlayer.scores.length - 1];
			prevPlayer.totalScored = prevPlayer.totalScored - prevPlayer.scores[prevPlayer.scores.length - 1];
			prevPlayer.scores.pop();
			prevPlayer.scoresText.pop();
			prevPlayer.thirdDart = 0;
			prevPlayer.thirdDartSection.textContent = '';
			prevPlayer.firstDartSection.textContent = prevPlayer.scores[prevPlayer.scores.length - 2];
			prevPlayer.secondDartSection.textContent = prevPlayer.scores[prevPlayer.scores.length - 1];
			prevPlayer.totalScoredSection.textContent = prevPlayer.totalScored;
			prevPlayer.targetLeftSection.textContent = prevPlayer.targetLeft;
			checkCheckout(2, prevPlayer);
			dart = 2;
		}
	}
	
})

function playerGo() 
{
	if ( players.current >= ( players.players.length - 1 ) ) 
	{
		players.current = 0;
	} 
	else 
	{
		players.current++;
	}
};

// USED IN changeOrder funtion TO MOVE ITEMS IN AN ARRAY
function arraymove(arr, fromIndex, toIndex) 
{
    var element = arr[fromIndex];
    arr.splice(fromIndex, 1);
    arr.splice(toIndex, 0, element);
}

// CHANGES THE INDEX OF PLAYERS ALLOWING THE ORDER OF THROW TO BE CHANGED
function changeOrder(index)
{
	if (index > 0) 
	{
		newIndex = index - 1;
	} 
	else 
	{
		newIndex = 0;
	}
	if (index < players.players.length) 
	{
		newIndex = index + 1;
	} 
	else 
	{
		newIndex = players.players.length - 1;
	}
	dimPlayer(players.players[players.current]);
	arraymove(players.players, index, newIndex );
	players.current = 0;
	$(players.players[players.current].nameSection).prepend(playerThrowBox);
	highlightPlayer(players.players[players.current]);
}






