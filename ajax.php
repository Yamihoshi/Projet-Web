<?php
require_once("config/connexion.php");
require_once('fonctions.php');
require_once('classes/touite.class.php');

	if(isset($_GET['search']))
	{
		searchByName($_GET['search'],$bd);
	}

	else if(!empty($_SESSION['id']) AND !empty($_GET['remove'])){
		delete_message($_GET['id'], $_SESSION['id'], $bd);
	}

	else if(!empty($_SESSION['id']) AND !empty($_GET['voirMessage'])){
		voir_message($_GET['id'], $bd);
	}


	/*else if(isset($_POST['editProfile']))
	{
		updateTouitos($bd,$_POST['touitos'],$_POST['editProfile']);
	}*/


	else if(!empty($_SESSION['id']) && !empty($_POST['discution'])){
		$touite = array("texte" => $_POST['message'], "idAuteur" => $_SESSION['id']);
		envoyer_reponse($_POST['id'], new Touite($touite), $bd);
	}
	else if(!empty($_POST['message'])){
			$touite = array("texte" => $_POST['message'], "idAuteur" => $_SESSION['id']);
			if(!empty($_POST['id_message'])){
				$touite['id_message'] = $_POST['id_message'];
				$message = new Touite($touite); 
				//réponse
			}else{
			$message = new Touite($touite);
			addTouite($message, $bd);

			$th=new touitosHandler($bd);
			$user=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
			$tr=new TouiteRender($touite,$user);

			$tr->render($message,$user);
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

	else if(isset($_GET['getFollowers']))
	{
		show_followers($bd);
	}

	else if(isset($_GET['getSuivi']))
	{
		show_whoIFollow($bd);
	}

	else if(isset($_GET['getTimeline']))
	{
		$touitos = getTouitos($bd, $_SESSION['id']);
		show_timeline($touitos, $bd);
	}

	else if(isset($_POST['acceptRequest']))
	{
		$touitos = getTouitos($bd, $_POST['suiveur']);
		anwserRequest($bd,$touitos,$_POST['acceptRequest']);
	}

?>