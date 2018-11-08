var targetsUsed =[];
var sections = $('.targetText');
function newGame()
{
	targetsUsed = [];
	for (var i = 0; i < sections.length; i++) 
	{
		var randomTarget = possibleTargets[Math.floor(Math.random()*possibleTargets.length)].target;
		// CHECKT TO SEE IF RANDOM TARGET IS ALREADY IN TARGETSUSED ARRAY
		// IF IT IS - GET A NEW RANDOM NUMBER
		if ($.inArray(randomTarget, targetsUsed) > -1) 
		{
			var newRandomTarget = possibleTargets[Math.floor(Math.random()*possibleTargets.length)].target;
			targetsUsed.push(newRandomTarget);
			$(sections[i]).text(newRandomTarget);
		}
		else
		{
			targetsUsed.push(randomTarget);
			$(sections[i]).text(randomTarget);
		}
		$(sections[i]).removeClass('greenText');
		$(sections[i]).removeClass('redText');
		// $(sections[i]).css('font-size', '24px');
	}
}

var targetOne = $('#targetOne').text();
var targetTwo = $('#targetTwo').text();
var targetThree = $('#targetThree').text();
var targetFour = $('#targetFour').text();
var targetFive = $('#targetFive').text();
var targetSix = $('#targetSix').text();
var targetSeven = $('#targetSeven').text();
var targetEight = $('#targetEight').text();
var targetNine = $('#targetNine').text();

var topRow = $('.rowOne');
var middleRow = $('.rowTwo');
var bottomRow = $('.rowThree');
var leftCol = $('.colOne');
var middleCol = $('.colTwo');
var rightCol = $('.colThree');
var diagOne = $('.diagOne');
var diagTwo = $('.diagTwo');

var single = $('.single');
var double = $('.double');
var treble = $('.treble');
var board = $('.board');

var dart = 0;

var nameSection = $('#nandcName');
var firstSeciton = $('#nandcFirst');
var secondSection = $('#nandcSecond');
var thirdSection = $('#nandcThird');

newGame();
var resetButton = $('.reset');
var completeGameButton = document.createElement('button');
$(completeGameButton).text('complete game');
$(completeGameButton).addClass('button greenButton');

$(nameSection).text(players.players[0].name + ' - O');
$(nameSection).css('background-color', '#91c46b');
$(firstSeciton).text('');
$(secondSection).text('');
$(thirdSection).text('');

var friendly = $('#friendly');
var wire = $('#refwire');
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

single.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var hit = 's' + $(this).attr('data-value');
	scoreDart(hit, targetsUsed, currentPlayer);
})

double.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var hit = 'd' + $(this).attr('data-value');
	scoreDart(hit, targetsUsed, currentPlayer);
})

treble.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var hit = 't' + $(this).attr('data-value');
	scoreDart(hit, targetsUsed, currentPlayer);
})

function scoreDart(hit, array, player)
{
	if (hit == 'd25') 
	{
		hit = 'bull';
	}
	else if (hit == 's25') 
	{
		hit = 'outerbull';
	}

	if ($.inArray(hit, array) > -1) 
	{
		if ($.inArray(hit, player.targetsHit) > -1) 
		{
			hit = 'miss';
		}
		checkDart(player, hit);
	}
	else
	{
		hit = 'miss';
		checkDart(player, hit);	
	}
	player.scores.push(hit);
}

board.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var hit = 'miss';
	scoreDart(hit, targetsUsed, currentPlayer);
})

resetButton.on('click', function()
{
	newGame();
	players.current = 0;
	var currentPlayer = players.players[players.current];
	$(nameSection).text(currentPlayer.name + ' - O');
	resetStats(players.players[0]);
	resetStats(players.players[1]);
})

function resetStats(player)
{
	player.gamesWon = 0;
	player.dartsUsed = 0;
	player.dartsMissed = 0;
	player.targets = 0;
	player.targetsHit = [];
	player.scores = [];
}

function checkDart(player, score)
{
	dart++;
	if (dart < 3) 
	{
		player.dartsUsed++;
		if (dart == 1) 
		{
			$(firstSeciton).text(score);
		}
		else if (dart == 2)
		{
			$(secondSection).text(score);
		}
		checkArea(player, score);
	}
	else
	{
		if (dart == 3) 
		{
			$(thirdSection).text(score);
		}
		player.dartsUsed++;
		checkArea(player, score);
		playerGo();
		var newPlayer = players.players[players.current];
		dart = 0;
		if (newPlayer.marker == 'noughts') 
		{
			var marker = 'O';
		}
		else
		{
			var marker = 'X';
		}
		$(nameSection).text(newPlayer.name + ' - ' + marker );
		$(firstSeciton).text('');
		$(secondSection).text('');
		$(thirdSection).text('');
		if (newPlayer.marker == 'noughts') 
		{
			$(nameSection).css('background-color', '#91c46b');
		}
		else if (newPlayer.marker == 'crosses')
		{
			$(nameSection).css('background-color', '#d9534f');
		}
	}

}

// CHECKS THE NUMBER HIT ON THE DARTBOARD IS ON THE TIC TAC TOE BOARD
// IF IT IS, CHANGE THE TEXT FOR THAT BOX TO THE MARKER DEPENDING ON THE PLAYER
// USE CHECKGAME FUNTION TO SEE IF THE GAME HAS BEEN WON BY THE PLAYER
function checkArea(player, score)
{
	if (score == 'miss') 
	{
		player.dartsMissed++;
	}
	else
	{
		for (var i = 0; i < sections.length; i++) 
		{
			var text = $(sections[i]).text();
			if (score == text) 
			{
				if (player.marker == 'noughts') 
				{
					player.targetsHit.push(text);
					player.targets++;
					$(sections[i]).text('O');
					$(sections[i]).addClass('greenText');
					// $(sections[i]).css('font-size', '40px');
					checkGame(player);
				}
				else if (player.marker == 'crosses')
				{
					player.targetsHit.push(text);
					player.targets++;
					$(sections[i]).text('X');
					$(sections[i]).addClass('redText');
					// $(sections[i]).css('font-size', '40px');
					checkGame(player);
				}
			}
		}
	}
	// NEED TO ADD SOMETHING THAT ADD ONE TO DARTSMISSED IF THE NUMBER HIT ISNT IN THE TIC TAC TOE BOARD
}

// CHECKS THE BOARD TO SEE IF THERE ARE 3 OF THE SAME MARKER
function checkBoard(area, player)
{
	var first = $(area[0]).text();
	var second = $(area[1]).text();
	var third = $(area[2]).text();

	if (first == second || first == third || second == third) 
	{
		if (second == third && third == first) 
		{
			player.gamesWon++;
			if (player.gamesWon == player.gamesToWin) 
			{
				alert(player.name + ', ' + player.marker + ' is the winner');
				// FUNCTION TO END GAME
				endGame(player);
			}
			else
			{
				if (player.marker == 'noughts') 
				{
					$('#nought').text(player.gamesWon);
				}
				else if (player.marker == 'crosses')
				{
					$('#cross').text(player.gamesWon);
				}
				newGame();
			}
			
		}
	}
}

var undo = $('#undoScore');
// UNDO FUNCTION WHEN UNDO BUTTON IS CLICKED
undo.on('click', function()
{
	var currentPlayer = players.players[players.current];
	// IF DART = 0, NEED TO CHANGE THE PLAYER TO PREVIOUS PLAYER & GET THEIR LAST SET OF SCORES
	if (dart == 0) 
	{
		// IF FIRST PLAYER HAS AN ITEM IN THE SCORES ARRAY - MEANING THE GAME HASNT JUST STARTED/ A DART HAS BEEN THROWN
		if ($(players.players[0].scores).length > 0) 
		{
			playerGo();
			var previousPlayer = players.players[players.current];
			if (previousPlayer.marker == 'noughts') 
			{
				var marker = 'O';
			}
			else if (previousPlayer.marker == 'crosses')
			{
				var marker = 'X';
			}
			$(nameSection).text(previousPlayer.name + ' - ' + marker);

			checkLastDart(previousPlayer);

			var lastThrow = previousPlayer.scores[previousPlayer.scores.length - 1];
			var secondLastThrow = previousPlayer.scores[previousPlayer.scores.length - 2];

			$(firstSeciton).text(secondLastThrow);
			$(secondSection).text(lastThrow);
			$(thirdSection).text('');

			dart = 2;
		}
		else
		{
			return;
		}
	}
	else if (dart == 1)
	{
		checkLastDart(currentPlayer);

		$(firstSeciton).text('');
		dart = 0;
	}
	else if (dart == 2)
	{
		checkLastDart(currentPlayer);

		$(secondSection).text('');
		dart = 1;
	}
})

// CHECKS LAST DART TO SEE IF WAS A TARGET ON THE TIC TAC TOE BOARD
// IF SO - REMOVE MARKER AND REPLACE WITH ORIGINAL TARGET
// TAKE AWAY CLASSES AND RETURN TO NORMAL FONT SIZE
// TAKE AWAY TARGET FROM TARGETSHIT ARRAY & TAKE ONE FROM TARGETS
// IF NOT - TAKE ONE FROM DARTS MISSED
// TAKE ONE FROM DARTS USED
// REMOVE LAST SCORE FROM SCORES ARRAY
function checkLastDart(player)
{
	var latestScore = player.scores[player.scores.length - 1];
	for (var i = 0; i < targetsUsed.length; i++) 
	{
		if (latestScore == targetsUsed[i]) 
		{
			console.log('target hit, ' + targetsUsed[i]);
			for (var j = 0; j < sections.length; j++) 
			{
				var text = $(sections[j]).textContent;
				if ($.inArray(text, targetsUsed) > -1) 
				{
					console.log('in array');
				}
				else
				{
					$(sections[i]).text(targetsUsed[i]);
					$(sections[i]).removeClass('greenText redText');
				}
			}
			player.targetsHit.pop();
			player.targets--;
		}
		else
		{
			console.log('last dart missed');
		}
	}
	if (latestScore == 'miss') 
	{
		player.dartsMissed--;
	}
	player.dartsUsed--;
	player.scores.pop();
}

function endGame(player)
{
	$('#topButtons').hide();
	$('.game').hide();
	$('.board').hide();
	$('.page').append(player.name + ' won');
	showStats(player);
	$('.page').append(completeGameButton);
	completeGameButton.onclick = function()
	{
		// UPDATE STATS & GO BACK TO ACCOUNT
		for (var i = 0; i < players.players.length; i++) 
		{
			updateStats(players.players[i]);
		}
		var user_username = location.search.split('?username=')[1];
		location.replace('../account.php?username=' + user_username);
	}
}

// SHOWS GAME STATS OF PLAYER
function showStats(player)
{
	var average = Number((player.targets / player.dartsUsed) * 100);
	player.average = average;
	var table = '<table>';
	table += '<tr><th>Darts Used</th><th>Total Targets</th><th>Targets Hit</th><th>Average</th></tr>';
	table += '<tr><td>' + player.dartsUsed + '</td>';
	table += '<td>' + player.targets + '</td>';
	table += '<td>' + player.targetsHit + '</td>';
	table += '<td>' + average + '%</tr>';
	table += '</table>';
	$('.page').append(table);
}

// UPDATE STATS
function updateStats( player )
{
	if (players.players.length == 2) 
	{
		for (var i = 0; i < players.players.length - 1; i++) 
		{
			if (player.name == players.players[i].name) 
			{
				// IF PLAYING A GUEST
				if (window.location.search.includes('guest')) 
				{
					// IF PLAYER NAME IS EQUAL TO GUEST NAME IN URL THEN OPPONENT NAME IS THE USERNAME IN URL
					var checkName = window.location.search.split("&")[1].split("guest=")[1];;
					if (player.name == checkName) 
					{
						var oppName = window.location.search.split("?username=")[1].split('&')[0];
					}
					else
					{
						var oppName = window.location.search.split("&")[1].split("guest=")[1];;
					}
				}
				// IF PLAYING OPPONENT
				else if (window.location.search.includes('opponent')) 
				{
					// IF PLAYER NAME IS EQUAL TO OPPONENT NAME IN URL THEN OPPONENT IS THE USERNAME IN URL
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

	var firstTarget = player.targetsHit[0];
	var secondTarget = player.targetsHit[1];
	var thirdTarget = player.targetsHit[2];
	if (player.targetsHit.length > 2) 
	{
		var fourthTarget = player.targetsHit[3];
		var fifthTarget = player.targetsHit[4];
		var sixthTarget = player.targetsHit[5];
	}
	else
	{
		var fourthTarget = '';
		var fifthTarget = '';
		var sixthTarget = '';
	}
	if (player.gamesWon == player.gamesToWin) 
	{
		player.gameOutcome = 'win';
	}
	else
	{
		player.gameOutcome = 'lost';
	}
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
		'&game=ticTacToe'+
		'&marker='+player.marker+
		'&opponent='+oppName+
		'&games='+player.gamesToWin+
		'&gamesWon='+player.gamesWon+
		'&outcome='+player.gameOutcome+
		'&targets='+player.targets+
		'&targetOne='+firstTarget+
		'&targetTwo='+secondTarget+
		'&targetThree='+thirdTarget+
		'&targetFour='+fourthTarget+
		'&targetFive='+fifthTarget+
		'&targetSix='+sixthTarget+
		'&darts='+player.dartsUsed+
		'&average='+player.average, true);
	xmlhttp.send();
}

// CHECK ALL POSSIBILITES OF WINNING THE GAME
function checkGame(player)
{
	checkBoard(topRow, player);
	checkBoard(middleRow, player);
	checkBoard(bottomRow, player);
	checkBoard(leftCol, player);
	checkBoard(middleCol, player);
	checkBoard(rightCol, player);
	checkBoard(diagOne, player);
	checkBoard(diagTwo, player);
}

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

