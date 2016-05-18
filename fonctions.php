<?php
	
	require_once("classes/touitos.class.php");
	require_once("classes/TouitosHandler.class.php");
	require_once("classes/TouiteHandler.class.php");
	require_once("classes/Touite.render.class.php");
	require_once("config/connexion.php");
	session_start();

	function isConnected()
	{
		return !empty($_SESSION['user']);
	}

	function isOwnProfile($profile)
	{
		return (isConnected() && $_SESSION['user']==$profile);
	}

	function getFollowButton($handler,$user,$profile)

	{
		if(isConnected() && !isOwnProfile($profile->getPseudo()))
		{
			$statut=$handler->getFollowStatut($user,$profile);
			if ($statut==-1) // NON SUIVI
				return '<button type="button" idTouitos='.$profile->getId().' class="subscribe">Suivre</button>';
			else if($statut=='V') //VALIDE
				return '<button type="button" idTouitos='.$profile->getId().' class="unsubscribe followed">Abonné</button>';
			else if($statut=='R') //REFUSE
				return '<button title="Cet utilisateur a refusé votre demande" type="button" disabled>Suivre</button>';
			else if($statut=='E')
				return '<button title="En attente d\'une réponse" type="button" disabled>Suivre</button>';
		}
	}

	function show_profile(Touitos $profile, $bd)
	{
		$th = new TouitosHandler($bd);

		echo '<div id="touitos_profile_page">';
				echo '<div id="profile_left_infos">';
			
		if(isConnected())
		{
			$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);

			if(!isOwnProfile($profile->getPseudo()))
			{
					echo '<div class="subscribeDiv">'.
						getFollowButton($th,$connectedUser,$profile)
					.'</div>';
			}	
		}

		echo '<div id="profile_photo">'.getPhoto($profile,"profile_picture_IMG").'</div>';
		echo '<div id="profile_name">'.htmlentities($profile->getNom()).'</div>';
		echo '<div id="profile_pseudo">@'.htmlentities($profile->getPseudo()).'</div>';
		echo '<div id="profile_statut">'.htmlentities($profile->getStatut()).'</div>';
		echo '<input type="hidden" id="touitos_pseudo" value='.htmlentities($profile->getPseudo()).'>';

		echo '</div>'; // Close profil_left

		if(isConnected() AND isOwnProfile($profile->getPseudo())){
			echo 	'<div id="ongletDiv">
						<table id="ongletSelect">
							<tr>
								<td>Touites</td>
								<td>Suivi</td>
								<td>Suiveurs</td>
								<td><span class="icon-wrench"></span></td>
							</tr>
						</table>
					</div>';
		}
		echo '<div id="timeline">';
			show_timeline($profile, $bd);
		echo '</div>';
		echo '</div>';
	}

	function getMoreProfileTouite($bd,$offset,$idTouitos)
	{
		$tr = new TouiteRender($idTouitos, $bd);
		$tr->renderMessage($offset*10);
	}

	function show_timeline(Touitos $touitos, $bd)
	{
		$tr = new TouiteRender($touitos->getId(), $bd);
		if(isConnected() AND isOwnProfile($touitos->getPseudo())){
			echo'
			<div id="touite-box">
							<form id="touite">
									<textarea id="touiteArea" placeholder="Entrez votre message..." name="touite" maxlength="140" required></textarea>
									<input type="submit"></input>
							</form>
			</div>';
		}
		echo '<div id="touiteList">';
		$touiteAffiche=$tr->renderMessage(0);
		echo '</div>';

		if($touiteAffiche)
		{
			echo '<div id="loadMoreTouiteDiv">
					<button id="loadMoreProfileTouite" next="1" idTouitos="'.$touitos->getId().'">+ de Touites</button>

				</div>';
		}
	}
	function getPhoto($user,$id)
	{
		if($user->getPhoto()==1)
			return '<img id='.$id.' src="files/pictures/'.$user->getId().'.jpg">';
		else
			return '<img id='.$id.' src="includes/img/no_pic.png">';
	}

	function getTouitos($bd, $id){
		$th = new TouitosHandler($bd);
		return $th->get($id);
	}

	function getTouitosVignette($bd,Touitos $touitos)
	{
		echo '<div class="touitosDiv"><a href="profile.php?user='.htmlentities($touitos->getPseudo()).'">';
			echo '<div class="result_photo">'.getPhoto($touitos,"search_result_profile_pic").'</div>';
			echo '<div class="result_details">';
				echo '<div class="result_name">'.htmlentities($touitos->getNom()).'</div>';
				echo '<div class="result_pseudo">@'.htmlentities($touitos->getPseudo()).'</div>';
				echo '<div class="result_statut">'.htmlentities($touitos->getStatut()).'</div>';
			echo '</div>';
			echo '</a>';
			if(isset($_SESSION['user']))
			{
				$th=new touitosHandler($bd);
				$connectedUSer=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
				echo '<div class="subscribeDiv">'.getFollowButton($th,$connectedUSer,$touitos).'</div>';
			}
		echo '</div>';
	}

	function searchByName($str,$bd)
	{
		$th=new TouitosHandler($bd);
		$res=$th->searchByName($str,0);
		echo '<div id="searchResult">';
		foreach($res as $key=>$touitos)
		{
			if(!isset($_SESSION['user']) || !isOwnProfile($touitos->getPseudo()))
				getTouitosVignette($bd,$touitos);
		}
		echo '</div>';

		if(!empty($res))
		{
			echo '<div id="moreSearchResultDiv">
				<button id="moreSearchResult" next="1">Afficher + de touitos</button>
			</div>';
		}
	}

	function moreSearchResult($str,$bd,$offset)
	{	

		$th=new TouitosHandler($bd);
		$res=$th->searchByName($str,intval($offset)*16);
		foreach($res as $key=>$touitos)
		{
			getTouitosVignette($bd,$touitos);
		}
	}

	function attrExists($bd,$attrName,$val,$paramType)
	{
		$th=new TouitosHandler($bd);
		$test=$th->getByAttr($attrName,$val,$paramType);
		return $test!=null;
	}

	function addTouitos($data,$bd)
	{
		//test si user existe
		$photo=array('photo' => 'N');
		$data=$data+$photo;
		$th=new TouitosHandler($bd);
		$touitos=new Touitos($data);

		return $th->add($touitos);
	}
	function updateTouitos($bd,$touitos)
	{
		$th=new TouitosHandler($bd);
		$th->update($touitos);
	}

	function addTouite($data, $bd){
		$t= new TouiteHandler($bd);
		$t->add($data);
	}


	function follow($bd,$suivi)
	{
		$th=new TouitosHandler($bd);
		$th->follow($_SESSION['id'],$suivi);
	}

	function unfollow($bd,$suivi)
	{
		$th=new TouitosHandler($bd);
		$th->unfollow($_SESSION['id'],$suivi);
	}

	function unAcceptRequest($bd,$suiveur)
	{
		$th=new TouitosHandler($bd);
		$th->unAcceptRequest($_SESSION['id'],$suiveur);
	}

	function show_whoIFollow($bd)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$requestList=$th->getWhoIRequest($connectedUser);
		$list=$th->getWhoIFollow($connectedUser);

		echo '<div id="whoIFollowDiv">';

		if(empty($list) && empty($requestList))
		{
			echo '<div> Vous ne suivez personne</div>';
		}

		else
		{
			echo '<div id="whoIFollowRequest"><div class="boxHeader">Demandes en attente</div>';
			if(empty($requestList))
				echo '<div>Aucune demande en attente</div>';

			foreach($requestList as $key=>$data)
			{
				echo '<div id="requestLine">';

				echo '<div id="requestPseudo" class="requestInfo"><a href="profile.php?user='.htmlentities($data['pseudo']).'">@'.htmlentities($data['pseudo']).'</a></div>';

				if($data['demande']=='E')
				{
					echo '<div class="requestInfo">En Attente</div>';
				}
				else
				{
					echo '<div class="requestInfo">Refusée</div>';
				}

				echo '</div>';
			}
			echo '</div>';

			echo '<div id="whoIFollow"><div class="boxHeader">Touitos que vous suivez</div>';
			foreach($list as $key=>$touitos)
			{
				echo  getTouitosVignette($bd,$touitos);
			}
			echo '</div>';
		}

		echo '</div>';
	}

	function show_followers($bd)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$requestList=$th->getFollowRequest($connectedUser);
		$list=$th->getFollowers($connectedUser);

		echo '<div id="followedByDiv">';

		if(empty($list) && empty($requestList))
		{
			echo '<div> Vous n\'êtes suivi par personne</div>';
		}

		foreach($requestList as $key=>$data)
		{
			echo 'Une demande vous a été envoyé par :';
			echo '<div>'.htmlentities($data["pseudo"]);

			echo '<span id="requestButton">';

			if($data['demande']!='R')
				echo'<button id="refuseRequest" touitosId="'.htmlentities($data['id']).'">Refuser</button>';

			if($data['demande']!='V')
				echo '<button id="acceptRequest" touitosId="'.htmlentities($data['id']).'">Accepter</button>';

			echo '</span>';


			echo '</div>';
		}

		foreach($list as $key=>$touitos)
		{
			echo '<div><button title="Annuler le suivi" class="unAcceptRequest" idtouitos="'.$touitos->getId().'">X</button>';
			echo  getTouitosVignette($bd,$touitos);
			echo '</div>';
		}

		echo '</div>';
	}

	function anwserRequest($bd,$user,$accept)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);

		if($accept==true)
			$th->answerRequest($connectedUser,$user,"V");
		else
			$th->answerRequest($connectedUser,$user,"R");
	}

	function delete_message($id, $idAuteur, $bd){
		$th=new TouiteHandler($bd);
		$id = (int)$id;
		$idBDD = $th->getByID($id);
		$idBDD = $idBDD->getIdAuteur();
		if((int)$idBDD == $idAuteur){
			$th->delete($id);
		}

	}

	function voir_message($id, $bd){
		$th=new TouiteRender($id, $bd);
		$th->renderReponse($id, $bd);
	}
	function envoyer_reponse($id, Touite $message, $bd){
		$th=new TouiteHandler($bd);
		$th->addReponse($message, $id);
	}


	function displayNews($bd,$offset)
	{
		$tth=new TouiteHandler($bd);
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$touiteList=$tth->getTouitesOfWhoIFollow($connectedUser->getId(),$offset*10);

		
		foreach($touiteList as $key=>$touite)
		{
			$tr=new TouiteRender($connectedUser->getId(),$bd);
			$auteur=$th->getByAttr("id",$touite->getIdAuteur(),PDO::PARAM_STR);
			$tr->render($touite,$auteur);
		}

		if(empty($touiteList))
			return false;

		return true;
	}


?>