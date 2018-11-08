<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="css/general.css">
</head>
<body>

	<div class="navBar">
		<a href="index.php">Home</a>
		<a href="login.php">Log in</a>
		<a href="gameSetup.php">Quick Game</a>
	</div><!-- CLOSES DIV WITH CLASS NAVBAR -->

	<div class="page">
		<?php
			if (isset($_POST['submit'])) 
			{
				include('connection.php');

				$user_username = $_POST['username'];
				$email = $_POST['email'];
				$user_password = $_POST['password'];

				if (!empty($user_username) && !empty($email) && !empty($user_password)) 
				{
					$select = "SELECT * FROM users WHERE username='" . $user_username . "'";
					$selectQuery = mysqli_query($dbc, $select);
					$selectRows = mysqli_num_rows($selectQuery);

					if ($selectRows > 0) 
					{
						echo '<p class="redButton alertMessage">Username taken</p>';
					}
					else
					{
						$insert = "INSERT INTO users (username, email, password) VALUES ('$user_username', '$email', '$user_password')";
						$insertQuery = mysqli_query($dbc, $insert);
						$result = mysqli_affected_rows($dbc);

						if ($result > 0) 
						{
							$insertUserStats = "INSERT INTO userStats (username, legsPlayed, legsWon, highestOut, highestScore, totalScored, dartsThrown, average) VALUES ('$user_username', '0', '0', '0', '0', '0', '0', '0')";
							$insertUserStatsQuery = mysqli_query($dbc, $insertUserStats);
							$rows = mysqli_affected_rows($dbc);

							if ($rows > 0) 
							{
								header('Location: registered.php?username=' . $user_username);
							}
							else
							{
								echo 'not added to userStats';
							}
						}
						else
						{
							echo '<p class="redButton alertMessage">System error</p>';
						}
						
					}
				}
				else
				{
					echo '<p class="redButton alertMessage">Fill out all fields</p>';
				}
			}
		?>
		<h1>Register</h1>
		<div class="form">
			<form action="register.php" method="post">
				<input type="text" name="username" placeholder="Username"><br />
				<input type="email" name="email" placeholder="Email"><br />
				<input type="password" name="password" placeholder="Password"><br />
				<input class="submitForm greenButton" type="submit" name="submit" value="Register">
			</form>
		</div><!-- CLOSES DIV WITH CLASS FORM -->
	</div><!-- CLOSES DIV WITH CLASS PAGE -->

		<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">
	var alertMessage = $('.alertMessage');
	$(alertMessage).slideDown(1000, function(){
		setTimeout(function(){
			$(alertMessage).slideUp(500)
		}, 2000);
	})

</script>

</body>
</html>