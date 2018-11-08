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
		<a href="register.php">Register</a>
		<a href="gameSetup.php">Quick Game</a>
	</div><!-- CLOSES DIV WITH CLASS NAVBAR -->

	<div class="page">
		<?php 

			if (isset($_POST['submit'])) 
			{
				$user_username = $_POST['username'];
				$user_password = $_POST['password'];

				if (!empty($user_username) && !empty($user_password)) 
				{
					include('connection.php');

					$select = "SELECT * FROM users WHERE username='" . $user_username . "'";
					$selectQuery = mysqli_query($dbc, $select);
					$selectRows = mysqli_num_rows($selectQuery);

					if ($selectRows > 0) 
					{
						while ($row = mysqli_fetch_array($selectQuery)) 
						{
							$dbPassword = $row['password'];	
							if ($dbPassword === $user_password) 
							{
								header('Location: account.php?username=' . $user_username);
							}
							else
							{
								echo '<p class="redButton alertMessage">Incorrect password</p>';
							}
						}
					}
					else
					{
						echo '<p class="redButton alertMessage">Invalid username</p>';
					}
					
				}
				else
				{
					header('Location: login.php');
				}
			}

		?>
		<h1>Login</h1>
		<div class="form smallForm">
			<form action="login.php" method="post">
				<input type="text" name="username" placeholder="Username"><br />
				<input type="password" name="password" placeholder="Password"><br />
				<input class="submitForm greenButton" type="submit" name="submit" value="Log in">
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