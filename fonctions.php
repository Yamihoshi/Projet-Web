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
		echo '<div id="profile_name">'.$profile->getNom().'</div>';
		echo '<div id="profile_pseudo">@'.$profile->getPseudo().'</div>';
		echo '<div id="profile_statut">'.$profile->getStatut().'</div>';
		echo '<input type="hidden" id="touitos_pseudo" value='.$profile->getPseudo().'>';

		if(isConnected() AND isOwnProfile($profile->getPseudo()))
		{
			echo '<div id="editDiv">
				<button type="button" id="edit_profile">Editer les informations</button>
						</div>';

					
		}
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

	function show_timeline(Touitos $touitos, $bd)
	{
		$tr = new TouiteRender($touitos->getId(), $bd);
		if(isConnected() AND isOwnProfile($touitos->getPseudo())){
			echo'
			<div id="touite-box">
							<form id="touite">
									<textarea placeholder="Entrez votre message..." name="touite" maxlength="140" required></textarea>
									<input type="submit"></input>
							</form>
			</div>';
		}
		$tr->renderMessage();
	}
	function getPhoto($user,$id)
	{
		if($user->getPhoto()==1)
			return '<img id='.$id.' src="files/pictures/'.$user->getPseudo().'.jpg">';
		else
			return '<img id='.$id.' src="includes/img/no_pic.png">';
	}

	function getTouitos($bd, $id){
		$th = new TouitosHandler($bd);
		return $th->get($id);
	}

	function getTouitosVignette($bd,Touitos $touitos)
	{
		echo '<div class="touitosDiv"><a href="profile.php?user='.$touitos->getPseudo().'">';
			echo '<div class="result_photo">'.getPhoto($touitos,"search_result_profile_pic").'</div>';
			echo '<div class="result_details">';
				echo '<div class="result_name">'.$touitos->getNom().'</div>';
				echo '<div class="result_pseudo">@'.$touitos->getPseudo().'</div>';
				echo '<div class="result_statut">'.$touitos->getStatut().'</div>';
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
		$res=$th->searchByName($str);
		echo '<div id="searchResult">';
		foreach($res as $key=>$touitos)
		{
				getTouitosVignette($bd,$touitos);
		}
		echo '</div>';
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
	function updateTouitos($bd,$touitos,$form)
	{
		$th=new TouitosHandler($bd);
		$user=$th->getByAttr("pseudo",$touitos,PDO::PARAM_STR);
		$user->_setNom($form['nom']);
		$user->_setStatut($form['statut']);
		if($form['file']==1)
			$user->_setPhoto($form['file']);
		$th->update($user);
	}

	function addTouite($data, $bd){
		$t= new TouiteHandler($bd);
		$t->add($data);
	}


	function follow($bd,$user,$suivi)
	{
		$th=new TouitosHandler($bd);
		$demandeur=$th->getByAttr("pseudo",$user,PDO::PARAM_STR);
		$receveur=$th->getByAttr("id",$suivi,PDO::PARAM_INT);

		$th->follow($demandeur,$receveur);
	}

	function unfollow($bd,$user,$suivi)
	{
		$th=new TouitosHandler($bd);
		$demandeur=$th->getByAttr("pseudo",$user,PDO::PARAM_STR);
		$receveur=$th->getByAttr("id",$suivi,PDO::PARAM_INT);

		$th->unfollow($demandeur,$receveur);
	}

	function show_whoIFollow($bd)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$requestList=$th->getWhoIRequest($connectedUser);
		$list=$th->getWhoIFollow($connectedUser);

		echo '<div id="whoIFollowDiv">';
			echo '<div>Classer les Demandes ???</div>';

		if(empty($list) && empty($requestList))
		{
			echo '<div> Vous ne suivez personne</div>';
		}

		foreach($requestList as $key=>$data)
		{
			echo '<div>'.$data['pseudo'];

			if($data['demande']=='E')
			{
				echo '<span>En Attente</span>';
			}
			else
			{
				echo '<span>Refusée</span>';
			}

			echo '</div>';
		}

		foreach($list as $key=>$touitos)
		{
			echo  getTouitosVignette($bd,$touitos);
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
			echo '<div>'.$data["pseudo"];

			echo '<span>';

			if($data['demande']!='R')
				echo'<button>Refuser</button>';

			if($data['demande']!='V')
				echo '<button>Accepter</button>';

			echo '</span>';


			echo '</div>';
		}

		foreach($list as $key=>$touitos)
		{
			$t=new Touitos($touitos);
			echo  getTouitosVignette($bd,$t);
		}

		echo '</div>';
	}

	function anwserRequest($bd,$user,$accept)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$th->answerRequest($connectedUser,$user,$accept);
	}

	function delete_message($id, $idAuteur, $bd){
		$th=new TouiteHandler($bd);
		$idBDD = $th->getByID($id)->getIdAuteur();
		if($idBDD = $id){
			$th->delete($id);
		}

	}

	function voir_message($id, $bd){
		$th=new TouiteRender($id, $bd);
		$th->renderReponse($id, $bd);
	}
	function envoyer_reponse($id, Touite $message, $bd){
		$th=new TouiteHandler($bd);
		print_r($message);
		$th->addReponse($message, $id);
	}
?>