<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

	include('connection.php');

	$page = $_GET['page'];
	$perPage = 4;
	$userName = 'daniel';
	if ($page == '' || $page == 1) 
	{
		$currentPage = 0;
	}
	else
	{
		$currentPage = ($page * $perPage) - $perPage;
	}

	$query = mysqli_query($dbc, "SELECT * FROM legStats WHERE username='$userName' LIMIT $currentPage, $perPage");
	while ($row = mysqli_fetch_array($query)) 
	{
		echo $row['checkout'] . '<br />';
	}


	// getting number of pages

	// get total number of rows returned
	$query = mysqli_query($dbc, "SELECT * FROM legStats WHERE username='$userName'");
	$totalRows = mysqli_num_rows($query);
	echo $totalRows;
	// echo $totalRows . '<br />';

	// how many records per page we want
	// $perPage = 4;
	// work out total number of pages needed 
	// ceil gives you the next integar
	$totalPages = ceil($totalRows / $perPage);
	// echo $totalPages . '<br />';
	echo '<a href="pagination.php?page=' . ($page - 1) . '">Previous</a><br />';
	

	for($i = 1; $i <= $totalPages; $i++)
	{
		echo '<a href="pagination.php?page=' . $i . '">' . $i . ' ' . '</a>';
	}


	echo '<br /><a href="pagination.php?page=' . ($page + 1) . '">Next</a>';

	?>

</body>
</html>