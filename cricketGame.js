var board = $('.board');
var single = $('.single');
var double = $('.double');
var treble = $('.treble');
var dart = 0;

var firstSection = $('#firstSection');
var secondSection = $('#secondSection');
var thirdSection = $('#thirdSection');
var totalSection = $('#totalSection');

var wicketSection = $('.bowlerScore');
var wicketScoreSection = $('.batterScore');

var gameInningsSection = $('#gameInnings');
var gameScoreSection = $('#gameScore');
var gameWicketsSection = $('#gameWickets');
var firstInningsSection = $('#firstInningsScore');
var oppScoreSection = $('#oppScore');

var friendly = $('#friendly');
var wire = $('#refwire');

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

single.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var numHit = $(this).attr('data-value');
	var score = Number(numHit);
	var text = 's' + numHit;
	var className = $(this).attr('class');
	if (currentPlayer.playerType == 'bowler') 
	{
		scoreBowler( currentPlayer, score, text, className);
	}
	else if (currentPlayer.playerType == 'batsman')
	{
		scoreBatsman( currentPlayer, score, text);
	}
})

double.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var numHit = $(this).attr('data-value');
	var score = Number(numHit * 2);
	var text = 'd' + numHit;
	var className = $(this).attr('class');
	if (currentPlayer.playerType == 'bowler') 
	{
		scoreBowler( currentPlayer, score, text, className );
	}
	else if (currentPlayer.playerType == 'batsman')
	{
		scoreBatsman( currentPlayer, score, text);
	}
})

treble.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var numHit = $(this).attr('data-value');
	var score = Number(numHit * 3);
	var text = 't' + numHit;
	var className = $(this).attr('class').split(' ')[1];
	console.log(className);
	if (currentPlayer.playerType == 'bowler') 
	{
		scoreBowler( currentPlayer, score, text, className );
	}
	else if (currentPlayer.playerType == 'batsman')
	{
		scoreBatsman( currentPlayer, score, text);
	}
})

board.on('click', function(e)
{
	var currentPlayer = players.players[players.current];
	e.stopPropagation();
	var score = 0;
	var text = 'miss';
	var className = $(this).attr('class');
	if (currentPlayer.playerType == 'bowler') 
	{
		scoreBowler( currentPlayer, score, text, className );
	}
	else if (currentPlayer.playerType == 'batsman')
	{
		scoreBatsman( currentPlayer, score, text);
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
	$('#nameSection').text(players.players[players.current].name);
	$('#playerTypeSection').text(players.players[players.current].playerType);
};


function scoreBatsman( player, score, text )
{
	player.currentDarts++;
	dart++;
	if (dart == 1) 
	{
		if(checkBully(player, score))
		{
			if (score == 25) 
			{
				text = 'WICKET!';
				player.runOuts++;
			}
			else if (score == 50)
			{
				text = '2 WICKETS!';
				player.runOuts = player.runOuts + 2;
			}
			wicketTaken(player);
			score = 0;
		}
		player.firstDart = score;	
		player.turnScore = score;
		player.scores.push(score);
		player.textScores.push(text);
		firstSection.text(text);
		$(secondSection).text('');
		$(thirdSection).text('');
		$(totalSection).text('');
	}
	else if (dart == 2)
	{
		if(checkBully(player, score))
		{
			if (score == 25) 
			{
				text = 'WICKET!';
				player.runOuts++;
			}
			else if (score == 50)
			{
				text = '2 WICKETS!';
				player.runOuts = player.runOuts + 2;
			}
			wicketTaken(player);
			score = 0;
		}
		player.secondDart = score;
		player.turnScore = player.turnScore + score;
		player.scores.push(score);
		player.textScores.push(text);
		secondSection.text(text);
		$(totalSection).text('');
	}
	else if (dart == 3)
	{
		if(checkBully(player, score))
		{
			if (score == 25) 
			{
				text = 'WICKET!';
				player.runOuts++;
			}
			else if (score == 50)
			{
				text = '2 WICKETS!';
				player.runOuts = player.runOuts + 2;
			}
			wicketTaken(player);
			score = 0;
		}
		player.thirdDart = score;
		player.turnScore = player.turnScore + score;
		player.scores.push(score);
		player.textScores.push(text);
		thirdSection.text(text);
		if (player.turnScore > 41) 
		{
			var turnRuns = player.turnScore - 41;
			player.runsScored.push(turnRuns);
			player.O41++;
			totalSection.text(turnRuns);
			player.totalScored = player.totalScored + turnRuns;
			checkScores(player);
			gameScoreSection.text(player.totalScored);
			$('#gameWickets').text(10 - player.wickets);
			for (var i = 0; i < wicketScoreSection.length; i++) 
			{
				if ($(wicketScoreSection[i]).attr('id') == 11 - player.wickets) 
				{
					$(wicketScoreSection[i]).text(players.players[1].totalScored);
					if ($(wicketScoreSection[i - 1]).text().length == 0) 
					{
						$(wicketScoreSection[i - 1]).text(players.players[1].totalScored);
					}
				}
			}
		}
		else
		{
			var turnRuns = 0;
			player.runsScored.push(turnRuns);
			player.U41++;
			totalSection.text(turnRuns);
			player.totalScored = player.totalScored + turnRuns;
			gameScoreSection.text(player.totalScored);
			for (var i = 0; i < wicketScoreSection.length; i++) 
			{
				if ($(wicketScoreSection[i]).attr('id') == 11 - player.wickets) 
				{
					$(wicketScoreSection[i]).text(players.players[1].totalScored);
					if ($(wicketScoreSection[i - 1]).text().length == 0) 
					{
						$(wicketScoreSection[i - 1]).text(players.players[1].totalScored);
					}
				}
			}
		}
		player.turnScores.push(turnRuns);
		dart = 0;
		playerGo();
		// $(firstSection).text('');
		// $(secondSection).text('');
		// $(thirdSection).text('');
		// $(totalSection).text('');
	}
}

function checkBully(player, score)
{
	if (score == 25 || score == 50)
	{
		if (score == 25) 
		{
			player.outerBulls++;
			for (var i = 0; i < players.players.length; i++) 
			{
				players.players[i].wickets--;
			}
			return true;
		}
		else 
		{
			player.bullseyes++;
			for (var i = 0; i < players.players.length; i++) 
			{
				players.players[i].wickets = players.players[i].wickets - 2;
			}
			return true;
		}
	}
}

var total = 0;
function scoreBowler( player, score, text, className )
{
	player.currentDarts++;
	dart++;
	if (checkBully(player, score)) 
	{
		if (score == 50) 
		{
			text = '2 WICKETS!';
			var numWicket = 2;
		}
		else
		{
			text = 'WICKET!';
			var numWicket = 1;
		}
		wicketTaken(player);
	}
	else if (className == 'treble')
	{
		// var scoreToAdd = score - 41;
		player.trebles++;
		player.wides++;
		players.players[1].runsScored.push(score);
		players.players[1].totalScored = players.players[1].totalScored + score;
		$(gameScoreSection).text(players.players[1].totalScored);
		var text = 'added ' + score + ' runs';
		var numWicket = 0;
	}
	else
	{
		score = 0;
		text = 'miss';
		var numWicket = 0;
		player.dartsMissed++;
	}

	if (dart == 1) 
	{
		player.scores.push(score);
		player.textScores.push(text);
		firstSection.text(text);
		$(secondSection).text('');
		$(thirdSection).text('');
		total = numWicket;
		if (total > 0) 
		{
			if (total > 1) 
			{
				$(totalSection).text(total + ' wickets');
			}
			else
			{
				$(totalSection).text(total + ' wicket');
			}
		}
		else
		{
			$(totalSection).text('0 wickets');
		}
	}
	else if (dart == 2)
	{
		player.scores.push(score);
		player.textScores.push(text);
		secondSection.text(text);
		total = total + numWicket;
		if (total > 0) 
		{
			if (total > 1) 
			{
				$(totalSection).text(total + ' wickets');
			}
			else
			{
				$(totalSection).text(total + ' wicket');
			}
		}
		else
		{
			$(totalSection).text('0 wickets');
		}
	}
	else if (dart == 3)
	{
		player.scores.push(score);
		player.textScores.push(text);
		thirdSection.text(text);
		total = total + numWicket;
		if (total > 0) 
		{
			if (total > 1) 
			{
				$(totalSection).text(total + ' wickets');
			}
			else
			{
				$(totalSection).text(total + ' wicket');
			}
		}
		else
		{
			$(totalSection).text('0 wickets');
		}
		player.turnScores.push(total + ' wickets');
		playerGo();
		dart = 0;
		total = 0;
		// $(firstSection).text('');
		// $(secondSection).text('');
		// $(thirdSection).text('');
	}

}

function checkScores(player)
{
	if($(players.players[0].inningsScore).length != 0)
	{
		var firstPlayerTotal = players.players[0].inningsScore[0];
		var currentScore = player.totalScored;

		if (currentScore > firstPlayerTotal)
		{
			players.players[0].bowled++;
			players.players[1].batted++;
			endOfGame(player);
		}
	}
	else
	{
		return;
	}
}

function wicketTaken(player)
{
	// DIM THE NUMBER OF WICKETS THAT HAVE BEEN TAKEN
	for (var i = 0; i < wicketSection.length; i++) 
	{
		if (wicketSection[i].textContent == 10 - player.wickets) 
		{
			$(wicketSection[i]).css('opacity', '0.2');
			if ($(wicketSection[i]).css('opacity') == '0.2')
			{
				$(wicketSection[i - 1]).css('opacity', '0.2');
			}
			$(gameWicketsSection).text( 10 - player.wickets );
			$(gameScoreSection).text(players.players[1].totalScored);
		}
	}
	// ADD THE TOTAL SCORE WHEN THE WICKET IS TAKEN
	for (var i = 0; i < wicketScoreSection.length; i++) 
	{
		if ($(wicketScoreSection[i]).attr('id') == 10 - player.wickets) 
		{
			$(wicketScoreSection[i]).text(players.players[1].totalScored);
			$(wicketScoreSection[i]).css('opacity', '0.2');
			if ($(wicketScoreSection[i - 1]).text().length == 0) 
			{
				$(wicketScoreSection[i - 1]).text(players.players[1].totalScored);
			}
			if ($(wicketScoreSection[i - 1]).css('opacity') != '0.2' || $(wicketScoreSection[i - 1]).css('opacity') == undefined) 
			{
				$(wicketScoreSection[i - 1]).css('opacity', '0.2');
			}
		}
	}
	// CREATE AN OBJECT TO SAY WHAT THE SCORE WAS WHEN EACH WICKET WAS TAKEN
	for (var i = 0; i < players.players.length; i++) 
	{
		var wicketObj = {};
		wicketObj['wicket'] = 10 - player.wickets;
		wicketObj['score'] = players.players[1].totalScored;
		players.players[i].wicketsTaken.push(wicketObj);
	}
	// IF PLAYERS WICKETS IS LESS OR EQUAL TO 0 - END OF INNINGS
	if (player.wickets <= 0) 
	{
		players.players[0].bowled++;
		players.players[1].batted++;
		endOfGame(player);
	}
}

function finishGame( player )
{
	if (player == 'DRAW') 
	{
		alert('game is a draw');
		players.players[0].gamesPlayed++;
		players.players[1].gamesPlayed++;
		players.players[0].gamesDrawn++;
		players.players[1].gamesDrawn++;
		players.players[0].gameOutcome = 'draw';
		players.players[1].gameOutcome = 'draw';
	}
	else 
	{
		alert(player.name + ', is the winner');
		player.gamesPlayed++;
		player.gamesWon++;
		player.gameOutcome = 'won';
	}
	var completeGame = document.createElement('button');
	completeGame.textContent = 'complete game';
	$(completeGame).addClass('button greenButton endGameScore');
	$('.page').append(completeGame);
	completeGame.onclick = function()
	{
		for (var i = 0; i < players.players.length; i++) 
		{
			if (players.players[i].gameOutcome == '') 
			{
				players.players[i].gameOutcome = 'lost';
			}
			updateStats( players.players[i] );
		}
		location.replace('../account.php?username=<?=$user_username;?>');
	}
}

// END OF TURN - USED WHEN 10 WICKETS HAVE BEEN HIT OR WHEN SECOND PLAYER SCORE IS HIGHER THAN FIRST PLAYER
function endOfGame(player)
{
	if (player.wickets <= 0) 
	{
		player.wickets = 0;
	}
	$('.board').hide();
	$('.game').hide();
	$('#friendly').hide();
	players.players[1].inningsScore.push(players.players[1].totalScored);
	/* PARAGRAPH TO SAY THE SCORE AFTER (120 - 10 FOR EXAMPLE)*/
	// var endGameScore = document.createElement('p');
	// endGameScore.textContent = players.players[1].totalScored + ' for ' + Number(10 - player.wickets);
	// $(endGameScore).addClass('endGameScore');
	// $('.page').append(endGameScore);
	var gameOutcome = document.createElement('p');
	var completeScoring = document.createElement('button');
	$(completeScoring).addClass('button greenButton endGameScore');
	$(gameOutcome).addClass('endGameScore');
	// IF BOTH PLAYERS HAVE BAT & BOWLED - END OF FIRST INNINGS - START NEW INNINGS - POSSIBLY UPDATE STATS FOR EVERY INNINGS? - THEN RESET STATS FOR NEW INNINGS
	if (players.players[0].bowled == 1 && players.players[0].batted == 1) 
	{
		players.players[0].innings = 1;
		players.players[1].innings = 1;
		// IF ONE INNINGS HAS BEEN SELECTED - FINISH GAME
		if (players.players[0].inningsSelected == 1) 
		{
			var firstPlayerScore = players.players[0].inningsScore[0];
			var secondPlayerScore = players.players[1].inningsScore[0];
			if (firstPlayerScore > secondPlayerScore) 
			{
				var runDifference = firstPlayerScore - secondPlayerScore;
				players.players[0].winMethod = 'runs';
				players.players[0].difference = runDifference;
				players.players[1].winMethod = 'runs';
				players.players[1].difference = '-'+runDifference;
				$(gameOutcome).text(players.players[0].name + ' won by ' + runDifference + ' runs');
				$('.page').append(gameOutcome);
				finishGame(players.players[0]);
			}
			else if ( firstPlayerScore < secondPlayerScore)
			{
				var runDifference = secondPlayerScore - firstPlayerScore;
				players.players[1].winMethod = 'runs';
				players.players[1].difference = runDifference;
				players.players[0].winMethod = 'runs';
				players.players[0].difference = '-'+runDifference;
				$(gameOutcome).text(players.players[1].name + ' won by ' + runDifference + ' runs');
				$('.page').append(gameOutcome);
				finishGame(players.players[1]);
			}
			else
			{
				players.players[0].winMethod = 'draw';
				players.players[1].winMethod = 'draw';
				finishGame('DRAW');
			}
		}
		else
		{
			completeScoring.textContent = 'next innings';
			$('.page').append(completeScoring);
			$(gameInningsSection).text('Second Innings');
		}

	}
	// IF FIRST PLAYER HAS BOWLED TWICE - CHECK THEIR SCORE TO SEE IF THEY HAVE WON THE GAME
	else if (players.players[0].bowled == 2 && players.players[0].batted == 1)
	{
		var firstPlayerScore = players.players[0].inningsScore[0];
		var secondFirstScore = players.players[1].inningsScore[0];
		var secondSecondScore = players.players[1].inningsScore[1];
		var secondPlayerScore = secondFirstScore + secondSecondScore;
		if (firstPlayerScore > secondPlayerScore) 
		{
			var runDifference = firstPlayerScore - secondPlayerScore;
			players.players[0].winMethod = 'innings';
			players.players[0].difference = runDifference;
			players.players[1].winMethod = 'innings';
			players.players[1].difference = '-'+runDifference;
			alert('winner');
			finishGame(players.players[0]);
		}
		else 
		{
			completeScoring.textContent = 'change order';
			$('.page').append(completeScoring);
			$(gameInningsSection).text('Second Innings');
		}
	}
	// IF BOTH PLAYERS HAVE BATTED & BOWLED TWICE - END OF GAME
	else if (players.players[0].bowled == 2 && players.players[0].batted == 2)
	{
		players.players[0].innings = 2;
		players.players[1].innings = 2;
		var firstPlayerScore = players.players[0].inningsScore[0] + players.players[0].inningsScore[1];
		var secondPlayerScore = players.players[1].inningsScore[0] + players.players[1].inningsScore[1];
		if (firstPlayerScore > secondPlayerScore) 
		{
			var runDifference = firstPlayerScore - secondPlayerScore;
			players.players[0].winMethod = 'runs';
			players.players[0].difference = runDifference;
			players.players[1].winMethod = 'runs';
			players.players[1].difference = '-'+runDifference;
			finishGame(players.players[0]);
		}
		else if ( firstPlayerScore < secondPlayerScore)
		{
			var runDifference = secondPlayerScore - firstPlayerScore;
			players.players[1].winMethod = 'runs';
			players.players[1].difference = runDifference;
			players.players[0].winMethod = 'runs';
			players.players[0].difference = '-'+runDifference;
			finishGame(players.players[1]);
		}
		else
		{
			players.players[0].winMethod = 'draw';
			players.players[1].winMethod = 'draw';
			finishGame('DRAW');
		}	
	}
	else
	{
		completeScoring.textContent = 'change order';
		$('.page').append(completeScoring);
	}
	// ADD BUTTONS TO VIEW STATS OF THE GAME
	for (var i = 0; i < players.players.length; i++) 
	{
		showStats(players.players[i]);
	}
	$('.gameButtons').css('float', 'none');
	nextInnings(completeScoring);
}

function showStats(player)
{
	var playerStatsArea = document.createElement('div');
	$(playerStatsArea).addClass('playerStatsArea');
	$(playerStatsArea).addClass(player.name);
	var viewLegStats = document.createElement('button');
	$(viewLegStats).addClass('button greenButton');
	var hideStatsButton = document.createElement('button');
	hideStatsButton.textContent = 'Hide stats';
	$(hideStatsButton).addClass('button redButton');
	$(playerStatsArea).append(viewLegStats)
	$('.page').append(playerStatsArea);

	if (player.playerType == 'bowler') 
	{	
		viewLegStats.textContent = 'Bowlers stats';
		viewLegStats.onclick =  function()
		{
			var bullseye = player.bullseyes;
			var outer = player.outerBulls;
			var totalWickets = bullseye + outer;
			var numDarts = player.currentDarts;
			var ave = Number(totalWickets / numDarts) * 100;
			var average = ave.toFixed(2);
			var aveBulls = Number(bullseye / numDarts) * 100;
			var averageBulls = aveBulls.toFixed(2);
			var aveOuter = Number(outer / numDarts) * 100;
			var averageOuter = aveOuter.toFixed(2);
			var wicketsTaken = 10 - player.wickets;
			var runsConceded = players.players[1].totalScored;
			$('.'+player.name).append(
				'<h2>Bowler - '+player.name + '</h2><table><tr><th>Wickets Taken</th><th>Num Darts</th><th>Percentage</th><th>Bullseyes Hit</th><th>Bulleyes %</th><th>Outerbulls Hit</th><th>Outerbulls %</th><th>Runs Conceded</th></tr><tr><td>'+wicketsTaken+'</td><td>'+numDarts+'</td><td>'+average+'</td><td>'+bullseye+'</td><td>'+averageBulls+'</td><td>'+outer+'<td>'+averageOuter+'</td><td>'+runsConceded+'</td></tr></table>');
			$('.'+player.name).append(hideStatsButton);
			$(this).remove();
		}
	}
	else if (player.playerType == 'batsman') 
	{
		viewLegStats.textContent = 'Batsmans stats';
		viewLegStats.onclick =  function()
		{
			var runsScored = player.totalScored;
			var wicketsFallen = 10 - player.wickets;
			var numDarts = player.currentDarts;
			var ave = Number(runsScored / numDarts);
			var average = ave.toFixed(2);
			var aveWicket = Number(runsScored / wicketsFallen);
			var averageWicket = aveWicket.toFixed(2);
			var over = player.O41;
			var under = player.U41;
			$('.'+player.name).append(
				'<h2>Batsman - '+player.name + '</h2><table><tr><th>Wickets Fallen</th><th>Runs Scored</th><th>Num Darts</th><th>Average Runs Per Dart</th><th>Average Runs Per Wicket</th><th>Over 41</th><th>41 or Under</th></tr><tr><td>'+wicketsFallen+'</td><td>'+runsScored+'</td><td>'+numDarts+'</td><td>'+average+'</td><td>'+averageWicket+'</td><td>'+over+'<td>'+under+'</td></tr></table>');
			$('.'+player.name).append(hideStatsButton);
			$(this).remove();
		}
	}

	hideStatsButton.onclick = function()
	{
		$('.'+player.name).empty();
		$('.'+player.name).append(viewLegStats);
		$(this).remove();
	}
}

// SETS UP THE GAME FOR NEXT TURN OR NEXT INNINGS
function nextInnings(button)
{
	button.onclick = function()
	{
		for (var i = 0; i < players.players.length; i++) 
		{
			changeOrder(i);
			resetStats( players.players[i] );
			dart = 0;
		}
		$('.board').show();
		$('.game').show();
		$('#friendly').show();
		$('.gameButtons').css('float', 'right');
		$('.playerStatsArea').remove();
		$(firstSection).text('');
		$(secondSection).text('');
		$(thirdSection).text('');
		$(totalSection).text('');
		for (var i = 0; i < wicketSection.length; i++) 
		{
			$(wicketSection[i]).css('opacity', '1');
		}
		for (var i = 0; i < wicketScoreSection.length; i++) 
		{
			$(wicketScoreSection[i]).text('');
		}
		$('.endGameScore').remove();
		$('#bowlerName').text(players.players[0].name);
		$('#nameSection').text(players.players[0].name);
		$(gameScoreSection).text('0');
		$('#gameWickets').text('0');
		if ($(players.players[1].inningsScore).length != 0 ) 
		{
			$(firstInningsSection).text(players.players[1].inningsScore[0]);
		}
		if ($(players.players[0].inningsScore).length == 2) 
		{
			var totalOppScore = players.players[0].inningsScore[0] + players.players[0].inningsScore[1];
		}
		else
		{
			var totalOppScore = players.players[0].inningsScore[0];
		}
		$(oppScoreSection).text(totalOppScore);
	}
}

function resetStats( player )
{
	player.numDarts.push(player.currentDarts);
	player.wickets = 10;
	player.firstDart = 0;
	player.secondDart = 0;
	player.thirdDart = 0;
	player.scores = [];
	player.runsScored = [];
	// player.O41 = 0;
	// player.U41 = 0;
	// player.outerBulls = 0;
	// player.bullseyes = 0;
	player.trebles = 0;
	player.turnScore = 0;
	player.totalScored = 0;
	// player.dartsMissed = 0;
	player.currentDarts = 0;
}


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
	arraymove(players.players, index, newIndex );
	players.current = 0;
	players.players[0].playerType = 'bowler';
	players.players[1].playerType = 'batsman';
}

// complete game - update stats - go back to account
function updateStats( player )
{
	if (players.players.length == 2) 
	{
		if (window.location.search.includes('guest')) 
		{
			var checkName = window.location.search.split("&")[1].split("guest=")[1];
			if (player.name == checkName) 
			{
				var oppName = window.location.search.split("&")[0].split("username=")[1];
			}
			else
			{
				var oppName = window.location.search.split("&")[1].split("guest=")[1];
			}
		}
		else if (window.location.search.includes('opponent')) 
		{
			var checkName = window.location.search.split("&")[1].split("opponent=")[1];
			if (player.name == checkName) 
			{
				var oppName = window.location.search.split("&")[0].split("username=")[1];
			}
			else
			{
				var oppName = window.location.search.split("&")[1].split("opponent=")[1];
			}
		}
	}
	else
	{
		var oppName = 'no opponent';
	}
	var firstScore = player.inningsScore[0];
	if ($(player.inningsScore).length == 2) 
	{	
		var secondScore = player.inningsScore[1];
		var totalScored = firstScore + secondScore;
		var numDarts = player.numDarts[0] + player.numDarts[1];
	}
	else
	{
		var totalScored = firstScore;
		var numDarts = player.numDarts[0];
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
		'&game=cricket'+
		'&innings='+player.inningsSelected+
		'&opponent='+oppName+
		'&first='+firstScore+
		'&second='+secondScore+
		'&total='+totalScored+
		'&over='+player.O41+
		'&under='+player.U41+
		'&outerBulls='+player.outerBulls+
		'&bullseyes='+player.bullseyes+
		'&trebles='+player.trebles+
		'&wides='+player.wides+
		'&runOuts='+player.runOuts+
		'&numDarts='+player.numDarts+
		'&gameOutcome='+player.gameOutcome+
		'&winMethod='+player.winMethod+
		'&difference='+player.difference, true);
	xmlhttp.send();
}

var undo = $('#undoScore');
undo.on('click', function()
{
	var currentPlayer = players.players[players.current];
	if ($('.board').is(':hidden')) 
	{
		$('.board').show();
		$('.game').show();
		$('.endGameScore').remove();
		$('.playerStatsArea').remove();
		if (currentPlayer.playerType == 'bowler') 
		{
			currentPlayer.bowled--;
			players.players[1].batted--;
			currentPlayer.gamesPlayed--;
			currentPlayer.gamesWon--;
			var lastText = currentPlayer.textScores[currentPlayer.textScores.length - 1];
			var lastTotal = currentPlayer.turnScores[currentPlayer.turnScores.length - 1];
			total = lastTotal;
			var lastTook = Number(players.players[0].turnScores[0].split(' ')[0]);
		}
		else
		{
			playerGo();
			var prevPlayer = players.players[players.current];
			prevPlayer.batted--;
			players.players[0].bowled--;
			prevPlayer.gamesPlayed--;
			prevPlayer.gamesWon--;
			prevPlayer.inningsScore.pop();
			var runs = prevPlayer.runsScored[prevPlayer.runsScored.length - 1];
			prevPlayer.totalScored = runs;
			prevPlayer.runsScored.pop();
			var lastText = prevPlayer.textScores[prevPlayer.textScores.length - 1];
			var lastTotal = prevPlayer.turnScores[prevPlayer.turnScores.length - 1];
		}
		$(thirdSection).text(lastText);
		$(totalSection).text(lastTotal);
		dart = 3;
	}
	else
	{
		if ($(players.players[0].scores).length > 0) 
		{
			if (dart == 0) 
			{
				playerGo();
				var prevPlayer = players.players[players.current];
				var lastText = prevPlayer.textScores[prevPlayer.textScores.length - 1];
				var secondText = prevPlayer.textScores[prevPlayer.textScores.length - 2];
				var thirdText = prevPlayer.textScores[prevPlayer.textScores.length - 3];
				var lastTotal = prevPlayer.turnScores[prevPlayer.turnScores.length - 1];
				$(totalSection).text(lastTotal);
				$(thirdSection).text(lastText);
				$(secondSection).text(secondText);
				$(firstSection).text(thirdText);
				dart = 3;
			}
			else
			{
				currentPlayer.currentDarts--;
				if (currentPlayer.playerType == 'batsman') 
				{
					if (dart == 3) 
					{
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						var secondLast = currentPlayer.scores[currentPlayer.scores.length - 2];
						var thirdLast = currentPlayer.scores[currentPlayer.scores.length - 3];
						currentPlayer.turnScores.pop();
						$(totalSection).text('');
						currentPlayer.turnScore = lastThrow + secondLast + thirdLast;
						undoBatsman(currentPlayer, lastThrow);
						if (currentPlayer.turnScore > 41)
						{
							currentPlayer.O41--;
							if (currentPlayer.O41 <= 0) 
							{
								currentPlayer.O41 = 0;
							}
							if (currentPlayer.runsScored.length == 0) 
							{
								var runs = currentPlayer.totalScored;
							}
							else
							{
								var runs = currentPlayer.runsScored[currentPlayer.runsScored.length - 1];
							}
							currentPlayer.totalScored = currentPlayer.totalScored - runs;
						}
						else 
						{
							currentPlayer.U41--;
							if (currentPlayer.U41 <= 0) 
							{
								currentPlayer.U41 = 0
							}
						}
						currentPlayer.thirdDart = 0;
						$(thirdSection).text('');
						currentPlayer.turnScore = secondLast + thirdLast;
						$('#gameScore').text(currentPlayer.totalScored);
						$(wicketScoreSection[10 - currentPlayer.wickets]).text('');
						$(wicketScoreSection[10 - currentPlayer.wickets]).css('opacity', '1');
						dart = 2;
					}
					else if (dart == 2)
					{
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						var secondLast = currentPlayer.scores[currentPlayer.scores.length - 2];
						undoBatsman(currentPlayer, lastThrow);
						currentPlayer.secondDart = 0;
						$(secondSection).text('');
						currentPlayer.turnScore = secondLast;
						dart = 1;
					}
					else if (dart == 1)
					{
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						undoBatsman(currentPlayer, lastThrow);
						currentPlayer.firstDart = 0;
						$(firstSection).text('');
						currentPlayer.turnScore = 0;
						dart = 0;
					}
				}
				else if (currentPlayer.playerType == 'bowler')
				{
					if (dart == 3)
					{
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						var secondLast = currentPlayer.scores[currentPlayer.scores.length - 2];
						var thirdLast = currentPlayer.scores[currentPlayer.scores.length - 3];
						var lastTook = Number(players.players[0].turnScores[0].split(' ')[0]);
						total = lastTook;
						currentPlayer.turnScores.pop();
						if (lastTook > 0) 
						{
							if (lastThrow == 25) 
							{
								total = total - 1;
							}
							else if (lastThrow == 50)
							{
								total = total - 2;
							}
						}
						$(totalSection).text(total + ' wickets');
						undoBowler(currentPlayer, lastThrow);
						currentPlayer.thirdDart = 0;
						$(thirdSection).text('');
						dart = 2;
					}
					else if (dart == 2)
					{
						var lastTook = Number($('#totalSection').text().split(' ')[0]);
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						var secondLast = currentPlayer.scores[currentPlayer.scores.length - 2];
						if (lastTook > 0) 
						{
							if (lastThrow == 25) 
							{
								total = lastTook - 1;
							}
							else if (lastThrow == 50)
							{
								total = lastTook - 2;
							}
						}
						$(totalSection).text(total + ' wickets');
						undoBowler(currentPlayer, lastThrow);
						currentPlayer.secondDart = 0;
						$(secondSection).text('');
						dart = 1;
					}
					else if (dart == 1)
					{
						var lastThrow = currentPlayer.scores[currentPlayer.scores.length - 1];
						var lastTook = Number($('#totalSection').text().split(' ')[0]);
						if (lastTook > 0) 
						{
							if (lastThrow == 25) 
							{
								total = lastTook - 1;
							}
							else if (lastThrow == 50)
							{
								total = lastTook - 2;
							}
						}
						$(totalSection).text(' ');
						undoBowler(currentPlayer, lastThrow);
						currentPlayer.firstDart = 0;
						$(firstSection).text('');
						dart = 0;
					}
				}
			}
		}
		else
		{
			console.log('no scores');
			return;
		}
	}
})

function undoBatsman(player, lastThrow)
{
	$(totalSection).text('');
	if (lastThrow == 50 || lastThrow == 25) 
	{
		if (lastThrow == 50) 
		{
			player.runOuts = player.runOuts - 2;
		}
		else
		{
			player.runOuts--;
		}
	}
	undoBulls(player, lastThrow);
}

function undoBowler(player, lastThrow)
{
	if (lastThrow == 0) 
	{
		player.dartsMissed++;
	}
	if (player.textScores.length > 0) 
	{
		var lastText = player.textScores[player.textScores.length - 1];
		if (lastText.includes('added')) 
		{
			var score = Number(lastText.split(' ')[1]);
			player.trebles--;
			player.wides--;
			players.players[1].totalScored = players.players[1].totalScored - score;
			$('#gameScore').text(players.players[1].totalScored);
		}
	}
	undoBulls(player, lastThrow);
}

function undoBulls(player, lastThrow)
{
	if (lastThrow == 50 || lastThrow == 25) 
	{
		if (lastThrow == 50) 
		{
			for (var i = 0; i < wicketSection.length; i++) 
			{
				if (wicketSection[i].textContent == 10 - player.wickets) 
				{
					$(wicketSection[i]).css('opacity', '1');
					$(wicketSection[i - 1]).css('opacity', '1');
					for (var j = 0; j < wicketScoreSection.length; j++) 
					{
						if (i == j) 
						{
							$(wicketScoreSection[j]).css('opacity', '1');
							$(wicketScoreSection[j - 1]).css('opacity', '1');
							$(wicketScoreSection[j]).text('');
							$(wicketScoreSection[j - 1]).text('');
						}
					}
				}
			}
			player.bullseyes--;
			players.players[0].wickets = players.players[0].wickets + 2;
			players.players[1].wickets = players.players[1].wickets + 2;
		}
		else
		{
			for (var i = 0; i < wicketSection.length; i++) 
			{
				if (wicketSection[i].textContent == 10 - player.wickets) 
				{
					$(wicketSection[i]).css('opacity', '1');
					for (var j = 0; j < wicketScoreSection.length; j++) 
					{
						if (i == j) 
						{
							$(wicketScoreSection[j]).css('opacity', '1');
							$(wicketScoreSection[j]).text('');
						}
					}
				}
			}
			player.outerBulls--;
			players.players[0].wickets++;
			players.players[1].wickets++;
		}
	}
	player.scores.pop();
	player.textScores.pop();
	players.players[0].wicketsTaken.pop();
	players.players[1].wicketsTaken.pop();
	$('#gameWickets').text(10 - player.wickets);
}




