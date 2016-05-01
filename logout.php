
<?php

session_start();
	if(!isset($_SESSION['user']))
	{
		header('Location: login.php');
	}
	else 
	{
			$_SESSION['login']='';
			session_unset();
			session_destroy();

			header('Location: index.php');
	}
?>
