<?php 

require("fonctions.php");
require('config/connexion.php');

	if(isset($_GET['search']))
	{
		searchByName($_GET['search'],$bd);
	}
?>