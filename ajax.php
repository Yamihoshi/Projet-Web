<?php
require_once("config/connexion.php");
require_once('fonctions.php');
require_once('classes/touite.class.php');

	if(isset($_GET['search']))
	{
		searchByName($_GET['search'],$bd);
	}

	else if(isset($_POST['editProfile']))
	{
		updateTouitos($bd,$_POST['touitos'],$_POST['editProfile']);
	}

	else if(!empty($_POST['message'])){
			$touite = array("texte" => $_POST['message'], "idAuteur" => $_SESSION['id']);

			print_r($_SESSION);
			if(!empty($_POST['id_message'])){
				$touite['id_message'] = $_POST['id_message'];
				$message = new Touite($touite);
			}else{
			$message = new Touite($touite);
				addTouite($message, $bd);
		}
	}

	else if(isset($_POST['follow']))
	{
		follow($bd,$_SESSION['user'],$_POST['suivi']);
	}

	else if(isset($_POST['unfollow']))
	{
		unfollow($bd,$_SESSION['user'],$_POST['suivi']);
	}

?>