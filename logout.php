<html>
<head>
	<title>Touiteur - Se Connecter</title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
</head>
<body>
<?php

session_start();

	if(!isset($_SESSION['user']))
	{
		header('Location: login.php');
	}
	else 
	{
		if(isset($_POST['logout']))
		{
			$_SESSION['login']='';
			session_unset();
			session_destroy();

			header('Location: index.php');
		}
	}
?>
</body>
</html>