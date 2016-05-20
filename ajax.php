<?php
require_once("config/connexion.php");
require_once('fonctions.php');
require_once('classes/touite.class.php');

	if(isset($_GET['search']) && ! isset($_GET['moreSearch']))
	{
		searchByName($_GET['search'],$bd);
	}

	else if(isset($_GET['moreSearch']))
	{
		moreSearchResult($_GET['search'],$bd,$_GET['offset']);
	}

	else if(!empty($_SESSION['id']) AND !empty($_GET['remove'])){
		delete_message($_GET['id'], $_SESSION['id'], $bd);
	}

	else if(!empty($_SESSION['id']) AND !empty($_GET['voirMessage'])){
		voir_message($_GET['id'], $bd);
	}


	/*else if(isset($_POST['editProfile']))
	{
		updatetouitos($bd,$_POST['touitos'],$_POST['editProfile']);
	}*/


	else if(!empty($_SESSION['id']) && !empty($_POST['discution'])){
		$touite = array("texte" => $_POST['message'], "idAuteur" => $_SESSION['id']);
		envoyer_reponse($_POST['id'], new Touite($touite), $bd);
	}
	else if(!empty($_POST['message']) && !isset($_POST['sendDiscussion'])){
			$touite = array("texte" => $_POST['message'], "idAuteur" => $_SESSION['id']);
			if(!empty($_POST['id_message'])){
				$touite['id_message'] = $_POST['id_message'];
				$message = new Touite($touite); 
				//réponse
			}else{
			$message = new Touite($touite);
			$message->setLadate (date("Y-m-d H:i:s"));
			addTouite($message, $bd);

			$th=new touitosHandler($bd);
			$user=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
			$tr=new TouiteRender($user,$bd);

			$tr->render($message,$user);
		}


	}

	else if(isset($_POST['follow']))
	{
		follow($bd,$_POST['suivi']);
	}

	else if(isset($_POST['unfollow']))
	{
		unfollow($bd,$_POST['suivi']);
	}

	else if(isset($_POST['unAcceptRequest']))
	{
		unAcceptRequest($bd,$_POST['suiveur']);
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
		$touitos = gettouitos($bd, $_SESSION['id']);
		show_timeline($touitos, $bd);
	}

	else if(isset($_POST['acceptRequest']))
	{
		$touitos = gettouitos($bd, $_POST['suiveur']);
		anwserRequest($bd,$touitos,$_POST['acceptRequest']);
	}

	else if(isset($_GET['moreNewsTouite']))
	{
		displayNews($bd,intval($_GET['offset']));
	}

	else if(isset($_GET['moreProfileTouite']))
	{
		getMoreProfileTouite($bd,intval($_GET['offset']),$_GET['id']);
	}

	else if(isset($_POST['deleteAccount']))
	{
		$th=new touitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);

		if($connectedUser->getPWD()!=md5($_POST['password']))
		{
			echo '<div>Mot de Passe incorrect</div>';
		}
		else
		{
			echo "OK";
			deleteAccount($bd);
		}
	}

	else if(isset($_GET['discussion']))
	{
		getDiscussionMessage($bd,$_GET['destinataire']);
	}

	else if(isset($_POST['sendDiscussion']))
	{
		sendPrivateMessage($bd,$_POST['destinataire'],$_POST['message']);
	}

	else if(isset($_GET['numberNewMessage']))
	{
		echo getNumberOfNotRead($bd);
	}

?>