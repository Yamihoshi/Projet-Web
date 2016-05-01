<?php

require('fonctions.php');

	if(isset($_GET['search']))
	{
		searchByName($_GET['search'],$bd);
	}

	else if(isset($_POST['editProfile']))
	{
		updateTouitos($bd,$_POST['touitos'],$_POST['editProfile']);
	}

	else if(isset($_POST['follow']))
	{
		follow($bd,$_POST['demandeur'],$_POST['suivi']);
	}

	else if(isset($_POST['unfollow']))
	{
		unfollow($bd,$_POST['demandeur'],$_POST['suivi']);
	}

?>