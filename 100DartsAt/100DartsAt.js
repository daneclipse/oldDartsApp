var numDartsSection = $('.numDartsLeft');
var targetText = $('.target');

var single = $('.single');
var double = $('.double');
var treble = $('.treble');
var board = $('.board');
var undo = $('#undoScore');
var dart = 0;
var targetNumber = players[0].targetNumber;

$(targetText).text('darts left at ' + targetNumber);

var singlesHitArea = $('#singlesHit');
var doublesHitArea = $('#doublesHit');
var treblesHitArea = $('#treblesHit');
var pointsScoredArea = $('#pointsScored');
var totalScoredArea = $('#totalScored');
var dartsMissedArea = $('#dartsMissed');

var completeGameButton = document.createElement('button');
completeGameButton.textContent = 'complete game';
$(completeGameButton).addClass('button completeGame greenButton');

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

single.on('click', function()
{
	var numHit = $(this).attr('data-value');
	players[0].numDarts--;
	$(numDartsSection).text(players[0].numDarts);
	if (numHit == targetNumber) 
	{
		var text = 'single';
		var pointsScored = 1;
		var totalScored = Number(numHit);
		players[0].singlesHit++;
		$(singlesHitArea).text(players[0].singlesHit);
	}
	else
	{
		var text = 'miss';
		var pointsScored = 0;
		var totalScored = 0;
		players[0].dartsMissed++;
		$(dartsMissedArea).text(players[0].dartsMissed);
	}
	checkDart(players[0], text, pointsScored, totalScored);
})

double.on('click', function()
{
	var numHit = $(this).attr('data-value');
	players[0].numDarts--;
	$(numDartsSection).text(players[0].numDarts);
	if (numHit == targetNumber) 
	{
		var text = 'double';
		var pointsScored = 2;
		var totalScored = Number(numHit * 2);
		players[0].doublesHit++;
		$(doublesHitArea).text(players[0].doublesHit);
	}
	else
	{
		var text = 'miss';
		var pointsScored = 0;
		var totalScored = 0;
		players[0].dartsMissed++;
		$(dartsMissedArea).text(players[0].dartsMissed);
	}
	checkDart(players[0], text, pointsScored, totalScored);
})

treble.on('click', function()
{
	var numHit = $(this).attr('data-value');
	players[0].numDarts--;
	$(numDartsSection).text(players[0].numDarts);
	if (numHit == targetNumber) 
	{
		var text = 'treble';
		var pointsScored = 3;
		var totalScored = Number(numHit * 3);
		players[0].treblesHit++;
		$(treblesHitArea).text(players[0].treblesHit);
	}
	else
	{
		var text = 'miss';
		var pointsScored = 0;
		var totalScored = 0;
		players[0].dartsMissed++;
		$(dartsMissedArea).text(players[0].dartsMissed);
	}
	checkDart(players[0], text, pointsScored, totalScored);
	
})

$(players[0].firstDartSection).css('opacity', '1');
$(players[0].secondDartSection).css('opacity', '0.2');
$(players[0].thirdDartSection).css('opacity', '0.2');

function checkDart( player, text, pointsScored, score )
{
	if ( dart >= 3 ) 
	{
		dart = 0;
		$(player.firstDartSection).text('');
		$(player.secondDartSection).text('');
		$(player.thirdDartSection).text('');
		$(player.firstDartSection).css('opacity', '1');
		$(player.secondDartSection).css('opacity', '0.2');
		$(player.thirdDartSection).css('opacity', '0.2');
	}
	dart++;
	if (dart == 1) 
	{
		if (player.numDarts > 0) 
		{
			$(player.firstDartSection).css('opacity', '0.2');
			$(player.secondDartSection).css('opacity', '1');
			$(player.thirdDartSection).css('opacity', '0.2');
			scoreFirstDart(player, text, pointsScored, score);
		}
		else
		{
			scoreFirstDart(player, text, pointsScored, score);
			finishGame();

		}
	}
	else if (dart == 2)
	{
		if (player.numDarts > 0) 
		{
			$(player.firstDartSection).css('opacity', '0.2');
			$(player.secondDartSection).css('opacity', '0.2');
			$(player.thirdDartSection).css('opacity', '1');
			scoreSecondDart(player, text, pointsScored, score);
		}
		else
		{
			scoreSecondDart(player, text, pointsScored, score);
			finishGame();
		}
	}
	else
	{
		if (player.numDarts > 0) 
		{
			scoreThirdDart(player, text, pointsScored, score);
		}
		else
		{
			scoreThirdDart(player, text, pointsScored, score);
			finishGame();
		}
	}
}


function scoreFirstDart( player, text, pointsScored, score )
{
	$(player.firstDartSection).text(text);
	$(player.secondDartSection).text('');
	$(player.thirdDartSection).text('');
	player.pointsScored = player.pointsScored + pointsScored;
	player.totalScored = player.totalScored + score;
	$(pointsScoredArea).text(player.pointsScored);
	$(totalScoredArea).text(player.totalScored);
	player.segments.push( text );
	player.points.push( pointsScored );
	player.scores.push( score );
}

function scoreSecondDart( player, text, pointsScored, score )
{
	$(player.secondDartSection).text(text);
	$(player.thirdDartSection).text('');
	player.pointsScored = player.pointsScored + pointsScored;
	player.totalScored = player.totalScored + score;
	$(pointsScoredArea).text(player.pointsScored);
	$(totalScoredArea).text(player.totalScored);
	player.segments.push( text );
	player.points.push( pointsScored );
	player.scores.push( score );
}

function scoreThirdDart( player, text, pointsScored, score )
{
	$(player.thirdDartSection).text(text);
	player.pointsScored = player.pointsScored + pointsScored;
	player.totalScored = player.totalScored + score;
	$(pointsScoredArea).text(player.pointsScored);
	$(totalScoredArea).text(player.totalScored);
	player.segments.push( text );
	player.points.push( pointsScored );
	player.scores.push( score );
	$(player.firstDartSection).css('opacity', '1');
	$(player.secondDartSection).css('opacity', '0.2');
	$(player.thirdDartSection).css('opacity', '0.2');
	$(player.firstDartSection).text('');
	$(player.secondDartSection).text('');
	$(player.thirdDartSection).text('');
	dart = 0;
}

undo.on('click', function()
{
	var player = players[0];
	
	if($('.board').is(':hidden'))
	{
		$('.board').show();
		$('.game').show();
		$(completeGameButton).remove();
		var firstScore = player.segments[player.segments.length - 1];
		$(player.firstDartSection).text(firstScore);
		dart = 1;
	}
	else if (dart == 3)
	{
		undoHit( player );
		$(player.thirdDartSection).text('');
		var secondScore = player.segments[player.segments - 1];
		var firstScore = player.segments[player.segments - 2];
		$(player.secondDartSection).text(secondScore);
		$(player.firstDartSection).text(firstScore);
		dart = 2;
		$(player.firstDartSection).css('opacity', '0.2');
		$(player.secondDartSection).css('opacity', '0.2');
		$(player.thirdDartSection).css('opacity', '1');
	}
	else if (dart == 2)
	{
		undoHit( player );
		$(player.thirdDartSection).text('');
		$(player.secondDartSection).text('');
		var firstScore = player.segments[player.segments - 1];
		$(player.firstDartSection).text(firstScore);
		dart = 1;
		$(player.firstDartSection).css('opacity', '0.2');
		$(player.secondDartSection).css('opacity', '1');
		$(player.thirdDartSection).css('opacity', '0.2');
	}
	else if (dart == 1)
	{
		undoHit( player );
		$(player.firstDartSection).text('');
		dart = 0;
		$(player.firstDartSection).css('opacity', '1');
		$(player.secondDartSection).css('opacity', '0.2');
		$(player.thirdDartSection).css('opacity', '0.2');

	}
	else
	{
		if (player.numDarts == player.startDarts) 
		{
			$(player.thirdDartSection).text('');
			$(player.secondDartSection).text('');
			$(player.firstDartSection).text('');
			dart = 0;
			return;
		}
		else
		{
			var thirdScore = player.segments[player.segments.length - 1]
			var secondScore = player.segments[player.segments.length - 2];
			var firstScore = player.segments[player.segments.length - 3];
			$(player.thirdDartSection).text(thirdScore);
			$(player.secondDartSection).text(secondScore);
			$(player.firstDartSection).text(firstScore);
			$(player.firstDartSection).css('opacity', '0.2');
			$(player.secondDartSection).css('opacity', '0.2');
			$(player.thirdDartSection).css('opacity', '1');
			dart = 3;

			// undoHit( player );
			// var secondScore = player.segments[player.segments.length - 1];
			// var firstScore = player.segments[player.segments.length - 2];
			// $(player.secondDartSection).text(secondScore);
			// $(player.firstDartSection).text(firstScore);
			// $(player.firstDartSection).css('opacity', '0.2');
			// $(player.secondDartSection).css('opacity', '0.2');
			// $(player.thirdDartSection).css('opacity', '1');
			// dart = 2;
		}
	}

})


function undoHit( player )
{
	player.numDarts = player.numDarts + 1;
	var text = player.segments[player.segments.length - 1];
	var points = player.points[player.points.length - 1];
	var scored = player.scores[player.scores.length - 1];
	if (text == 'treble') 
	{
		player.treblesHit = player.treblesHit - 1;
	}
	else if (text == 'double') 
	{
		player.doublesHit = player.doublesHit - 1;
	}
	else if (text == 'single')
	{
		player.singlesHit = player.singlesHit - 1;
	}
	else
	{
		player.dartsMissed = player.dartsMissed - 1;
	}
	$(treblesHitArea).text(player.treblesHit);
	$(doublesHitArea).text(player.doublesHit);
	$(singlesHitArea).text(player.singlesHit);
	player.pointsScored = player.pointsScored - points;
	player.totalScored = player.totalScored - scored;
	$(numDartsSection).text(player.numDarts);
	$(pointsScoredArea).text(player.pointsScored);
	$(totalScoredArea).text(player.totalScored);
	$(dartsMissedArea).text(player.dartsMissed);
	player.segments.pop();
	player.points.pop();
	player.scores.pop();
}

// complete game - update stats - go back to account
function finishGame()
{
	$('.game').hide();
	$('.board').hide();
	$('.page').append(completeGameButton);

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
				'&game=100'+
				'&targetNumber='+players[0].targetNumber+
				'&singles='+players[0].singlesHit+
				'&doubles='+players[0].doublesHit+
				'&trebles='+players[0].treblesHit+
				'&points='+players[0].pointsScored+
				'&score='+players[0].totalScored+
				'&missed='+players[0].dartsMissed, true);
			xmlhttp.send();
			location.replace('../account.php?username='+players[0].name);
		}
	})
}








