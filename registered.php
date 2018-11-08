<?php 

$user_username = $_GET['username'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS FILES -->
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<style type="text/css">
		button 
		{
			font-size: 24px;
			padding: 10px 20px;
			margin: 20px;
		}

		button a 
		{
			color: #fff;
			text-decoration: none;
		}

		button:hover 
		{
			cursor: pointer;
			background-color: #719952;
		}
	</style>
</head>
<body>

	<div class="page">
		<h1>Registered as <?=$user_username;?>, please now log in</h1>
		<button class="greenButton"><a href="login.php">Log in</a></button>
	</div>

</body>
</html>