// GAME SETUP SO YOU HAVE TO HIT EVERY NUMBER - EVEN IF YOU HIT DOUBLES & TREBLES
// PARTS COMMENTED OUT IN SCOREDART & CHECK UNDO CAN BE USED TO CHANGE THE GAME TO (if you hit double, miss next number etc hit d1 - miss 2, aim at 3)

var single = $('.single');
var double = $('.double');
var treble = $('.treble');
var board = $('.board');
var undo = $('#undoScore');
var friendly = $('#friendly');
var wire = $('#refwire');
var number = 1;

var aimSection = $('#aimAt');
var singleSection = $('#gameSingles');
var doubleSection = $('#gameDoubles');
var trebleSection = $('#gameTrebles');
var scoreSection = $('#gameScore');
var missedSection = $('#missed');
$(aimSection).text(players[0].targetNum);
$(singleSection).text(0);
$(doubleSection).text(0);
$(trebleSection).text(0);
$(scoreSection).text(0);
$(missedSection).text(0);

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
$(completeGameButton).addClass('button greenButton');


// CHECK FUNCTION
function changeColour(number)
{
	if (number >= 1)
	{
		var scorecard = $('.inner_half');
		for (var i = 0; i < scorecard.length; i++) 
		{	
			var inner_text = Number($(scorecard[i]).children().text());
			if (inner_text == number)
			{
				$(scorecard[i]).css('opacity', '1');
				$(scorecard[i]).css('background-color', '#333');
				$(scorecard[i]).css('color', '#fff');
			}
			else
			{
				$(scorecard[i]).css('background-color', '#f7f5fa');
				$(scorecard[i]).css('color', '#333');
				$(scorecard[i]).css('opacity', '0.2');
			}
		}
	}
	else
	{
		return;
	}
}

changeColour(number);


function markScore(num, numHit, score)
{
	if (num <= 20) 
	{
		players[0].numDarts++;
		if (numHit == num) 
		{
			if (num == 20) 
			{
				if (players[0].gameType == 'singles') 
				{
					scoreDart(score, numHit);
				}
				else if(players[0].gameType == 'doubles')
				{
					scoreDoubleGame(score, numHit);
				}
				else if(players[0].gameType == 'trebles')
				{
					scoreTrebleGame(score, numHit);
				}
				finishGame();
			}
			else
			{
				if (players[0].gameType == 'singles') 
				{
					scoreDart(score, numHit);
				}
				else if(players[0].gameType == 'doubles')
				{
					scoreDoubleGame(score, numHit);
				}
				else if(players[0].gameType == 'trebles')
				{
					scoreTrebleGame(score, numHit);
				}
			}
		changeColour(numHit + 1);
		}
		else
		{
			console.log('numHit: '+ numHit + ', numberNeeded: ' + num);
			players[0].dartsMissed++;
			$('#missed').text(players[0].dartsMissed);
			players[0].scores.push(score);
		}
	}
	else
	{
		finishGame();
	}
}

function scoreDart(score, numHit)
{
	var segment = document.getElementById('num' + numHit);
	if (score == 'single') 
	{
		players[0].singlesHit++;
		$(singleSection).text(players[0].singlesHit);
		players[0].scores.push(1);
		players[0].totalScored = players[0].totalScored + 1;
		$(scoreSection).text(players[0].totalScored);
		players[0].targetNum = players[0].targetNum + 1;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		$(segment).text('⧸');
		number = number + 1;
		$(aimSection).text(number);
		console.log(number);
	}
	else if (score == 'double') 
	{
		players[0].doublesHit++;
		$(doubleSection).text(players[0].doublesHit);
		players[0].scores.push(2);
		players[0].totalScored = players[0].totalScored + 2;
		$(scoreSection).text(players[0].totalScored);
		players[0].targetNum = players[0].targetNum + 1;
		// players[0].targetNum = players[0].targetNum + 2;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		$(segment).text('x');
		number = number + 1;
		// number = number + 2;
		console.log(number);
	}
	else if (score == 'treble') 
	{
		players[0].treblesHit++;
		$(trebleSection).text(players[0].treblesHit);
		players[0].scores.push(3);
		players[0].totalScored = players[0].totalScored + 3;
		$(scoreSection).text(players[0].totalScored);
		players[0].targetNum = players[0].targetNum + 1;
		// players[0].targetNum = players[0].targetNum + 3;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		$(segment).text('⦻');
		number = number + 1;
		// number = number + 3;
		console.log(number);
	}
}

single.on('click', function(e)
{
	e.stopPropagation();
	var segmentHit = Number($(this).attr('data-value'));
	var score = 'single';
	markScore(number, segmentHit, score);
})

double.on('click', function(e)
{
	e.stopPropagation();
	var segmentHit = Number($(this).attr('data-value'));
	var score = 'double';
	markScore(number, segmentHit, score);
})

treble.on('click', function(e)
{
	e.stopPropagation();
	var segmentHit = Number($(this).attr('data-value'));
	var score = 'treble';
	markScore(number, segmentHit, score);
})

board.on('click', function()
{
	// players[0].numDarts++;
	// players[0].dartsMissed++;
	var segmentHit = 0;
	var score = 0;
	markScore(number, segmentHit, score);
})

undo.on('click', function()
{
	players[0].numDarts--;
	if ($('.board').is(':hidden')) 
	{
		$('.board').show();
		$(completeGameButton).remove();
		var lastScore = players[0].scores[players[0].scores.length - 1];
		if (lastScore == 3) 
		{
			players[0].treblesHit--;
			players[0].totalScored = players[0].totalScored - 3;
			$(scoreSection).text(players[0].totalScored);
		}
		else if (lastScore == 2) 
		{
			players[0].doublesHit--;
			players[0].totalScored = players[0].totalScored - 2;
			$(scoreSection).text(players[0].totalScored);
		}
		else if (lastScore == 1) 
		{
			players[0].singlesHit--;
			players[0].totalScored = players[0].totalScored - 1;
			$(scoreSection).text(players[0].totalScored);
		}
		else if (lastScore == 0) 
		{
			players[0].dartsMissed--;
			$(missedSection).text(players[0].dartsMissed);
		}
		else if(lastScore == -1)
		{
			players[0].singlesHit--;
			players[0].totalScored = players[0].totalScored + 1;
			$(scoreSection).text(totalScored);
		}
		else if(lastScore == -2)
		{
			players[0].doublesHit--;
			players[0].totalScored = players[0].totalScored + 2;
			$(scoreSection).text(totalScored);
		}
		else if(lastScore == -3)
		{
			players[0].treblesHit--;
			players[0].totalScored = players[0].totalScored + 3;
			$(scoreSection).text(totalScored);
		}
		var segment = document.getElementById(players[0].targetNum);
		$(segment).empty();
		players[0].targetNum = 20;
		number = 20;
		$(aimSection).text(players[0].targetNum);
	}
	else
	{
		if (players[0].numDarts < 0) 
		{
			players[0].numDarts = 0;
			players[0].dartsMissed = 0;
			$(missedSection).text(0);
		}
		if (players[0].scores[players[0].scores.length - 1] != 0) 
		{
			changeColour(number - 1);
			if (players[0].scores[players[0].scores.length - 1] == 3 || players[0].scores[players[0].scores.length - 1] == -3) 
			{
				players[0].treblesHit--;
				$(trebleSection).text(players[0].treblesHit)
				if (players[0].scores[players[0].scores.length - 1] == 3) 
				{
					checkUndo(players[0], 3);
				}
				else
				{
					checkUndoMinus(players[0], -3);
				}
				
			}
			else if (players[0].scores[players[0].scores.length - 1] == 2 || players[0].scores[players[0].scores.length - 1] == -2) 
			{
				players[0].doublesHit--;
				$(doubleSection).text(players[0].doublesHit)
				if (players[0].scores[players[0].scores.length - 1] == 2) 
				{
					checkUndo(players[0], 2);
				}
				else
				{
					checkUndoMinus(players[0], -2);
				}
			}
			else if (players[0].scores[players[0].scores.length - 1] == 1 || players[0].scores[players[0].scores.length - 1] == -1) 
			{
				players[0].singlesHit--;
				$(singleSection).text(players[0].singlesHit)
				if (players[0].scores[players[0].scores.length - 1] == 1) 
				{
					checkUndo(players[0], 1);
				}
				else
				{
					checkUndoMinus(players[0], -1);
				}
			}
		}
		else
		{
			players[0].dartsMissed--;
			$(missedSection).text(players[0].dartsMissed)
		}
	}
	players[0].scores.pop();
})

function checkUndo(player, num)
{
	// if (player.target - num <= 0)
	if (player.targetNum - 1 <= 0 ) 
	{
		player.targetNum = 1;
		number = player.targetNum;
		$(aimSection).text(players[0].targetNum);
		player.totalScored = 0;
		$(scoreSection).text(player.totalScored);
		var segment = document.getElementById('num' + players[0].targetNum);
		$(segment).text('');
	}
	else
	{
		// player.targetNum = player.targetNum - num;
		player.targetNum = player.targetNum - 1;
		number = player.targetNum;
		var segment = document.getElementById('num' + players[0].targetNum);
		$(segment).text('');
		$(aimSection).text(players[0].targetNum);
		player.totalScored = player.totalScored - num;
		$(scoreSection).text(players[0].totalScored);
	}
}

function checkUndoMinus(player, num)
{
	player.totalScored = player.totalScored - num;
	$(scoreSection).text(players[0].totalScored);
	// if (player.target - num <= 0)
	if (player.targetNum - 1 <= 0 ) 
	{
		player.targetNum = 1;
		number = player.targetNum;
		player.totalScored = 0;
		$(aimSection).text(players[0].targetNum);
		$(scoreSection).text(players[0].totalScored);
		var segment = document.getElementById(players[0].targetNum);
		$(segment).empty();
	}
	else
	{
		var segment = document.getElementById(players[0].targetNum - 1);
		$(segment).empty();
		// player.targetNum = player.targetNum - num;
		player.targetNum = player.targetNum;
		number = player.targetNum;
		$(aimSection).text(players[0].targetNum);
	}
}

function finishGame()
{
	$('.board').hide();
	$('.page').append(completeGameButton);
	num = 20;
	players[0].targetNum = 20;
	$(aimSection).text(players[0].targetNum);
	$(completeGameButton).on('click', function()
	{
		var completeGame = confirm('Are you sure you want to complete the game?');
		if (completeGame) 
		{
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function()
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					$('#stats').innerHTML = this.responseText;
				}
			}
			xmlhttp.open('GET', '../updateStats.php?name='+players[0].name+
				'&game=world'+
				'&gameType='+players[0].gameType+
				'&singles='+players[0].singlesHit+
				'&doubles='+players[0].doublesHit+
				'&trebles='+players[0].treblesHit+
				'&score='+players[0].totalScored+
				'&missed='+players[0].dartsMissed+
				'&darts='+players[0].numDarts, true);
			xmlhttp.send();
			location.replace('../account.php?username='+players[0].name);
		}
	})
}

// FUNCTION FOR DOUBLES GAME
function scoreDoubleGame(score, numHit)
{
	var segment = document.getElementById(numHit);
	if (score == 'single') 
	{
		players[0].singlesHit++;
		$(singleSection).text(players[0].singlesHit);
		// players[0].scores.push(1);
		players[0].scores.push(-1);
		// players[0].totalScored = players[0].totalScored + 1;
		players[0].totalScored = players[0].totalScored - 1;
		$(scoreSection).text(players[0].totalScored);
		// players[0].targetNum = players[0].targetNum + 1;
		players[0].targetNum = players[0].targetNum;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		// $(segment).text('⧸');
		// number = number + 1;
		number = number;
		$(aimSection).text(number);
		console.log(number);
	}
	else if (score == 'double') 
	{
		players[0].doublesHit++;
		$(doubleSection).text(players[0].doublesHit);
		players[0].scores.push(2);
		players[0].totalScored = players[0].totalScored + 2;
		$(scoreSection).text(players[0].totalScored);
		players[0].targetNum = players[0].targetNum + 1;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		$(segment).text('x');
		number = number + 1;
		console.log(number);
	}
	else if (score == 'treble') 
	{
		players[0].treblesHit++;
		$(trebleSection).text(players[0].treblesHit);
		// players[0].scores.push(3);
		players[0].scores.push(-3);
		// players[0].totalScored = players[0].totalScored + 3;
		players[0].totalScored = players[0].totalScored - 3;
		$(scoreSection).text(players[0].totalScored);
		// players[0].targetNum = players[0].targetNum + 1;
		players[0].targetNum = players[0].targetNum;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		// $(segment).text('⦻');
		// number = number + 1;
		number = number;
		console.log(number);
	}
}

// FUNCTION FOR TREBLES GAME
function scoreTrebleGame(score, numHit)
{
	var segment = document.getElementById(numHit);
	if (score == 'single') 
	{
		players[0].singlesHit++;
		$(singleSection).text(players[0].singlesHit);
		// players[0].scores.push(1);
		players[0].scores.push(-1);
		// players[0].totalScored = players[0].totalScored + 1;
		players[0].totalScored = players[0].totalScored - 1;
		$(scoreSection).text(players[0].totalScored);
		// players[0].targetNum = players[0].targetNum + 1;
		players[0].targetNum = players[0].targetNum;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		// $(segment).text('⧸');
		// number = number + 1;
		number = number;
		$(aimSection).text(number);
		console.log(number);
	}
	else if (score == 'double') 
	{
		players[0].doublesHit++;
		$(doubleSection).text(players[0].doublesHit);
		// players[0].scores.push(2);
		players[0].scores.push(-2);
		// players[0].totalScored = players[0].totalScored + 2;
		players[0].totalScored = players[0].totalScored - 2;
		$(scoreSection).text(players[0].totalScored);
		// players[0].targetNum = players[0].targetNum + 1;
		players[0].targetNum = players[0].targetNum;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		// $(segment).text('x');
		// number = number + 1;
		number = number;
		$(aimSection).text(number);
		console.log(number);
	}
	else if (score == 'treble') 
	{
		players[0].treblesHit++;
		$(trebleSection).text(players[0].treblesHit);
		players[0].scores.push(3);
		players[0].totalScored = players[0].totalScored + 3;
		$(scoreSection).text(players[0].totalScored);
		players[0].targetNum = players[0].targetNum + 1;
		$(aimSection).text(players[0].targetNum);
		if (players[0].targetNum > 20) 
		{
			players[0].targetNum = 20;
			number = 20;
		}
		$(segment).text('⦻');
		number = number + 1;
		console.log(number);
	}
}

