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

?>