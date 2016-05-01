
<?php

session_start();
	if(!isset($_SESSION['user']))
	{
		header('Location: index.php');
	}
	else 
	{
			$_SESSION['login']='';
			session_unset();
			session_destroy();

			header('Location: index.php');
	}
?>
