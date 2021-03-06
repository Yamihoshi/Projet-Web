<?php
	
	require_once("classes/touitos.class.php");
	require_once("classes/touitosHandler.class.php");
	require_once("classes/TouiteHandler.class.php");
	require_once("classes/Touite.render.class.php");
	require_once("classes/touitePrive.class.php");
	require_once("classes/touitePriveHandler.class.php");
	require_once("config/connexion.php");
	session_start();

	function isConnected()
	{
		return !empty($_SESSION['user']);
	}

	function isOwnProfile($profile)
	{
		return (isConnected() &&  strtoupper($_SESSION['user'])== strtoupper($profile));
	}

	function getFollowButton($handler,$user,$profile)

	{
		if(isConnected() && !isOwnProfile($profile->getPseudo()))
		{
			$statut=$handler->getFollowStatut($user,$profile);
			if ($statut==-1) // NON SUIVI
				return '<button type="button" idtouitos='.$profile->getId().' class="subscribe">Suivre</button>';
			else if($statut=='V') //VALIDE
				return '<button type="button" idtouitos='.$profile->getId().' class="unsubscribe followed">Abonné</button>';
			else if($statut=='R') //REFUSE
				return '<button title="Cet utilisateur a refusé votre demande" type="button" disabled>Suivre</button>';
			else if($statut=='E')
				return '<button title="En attente d\'une réponse" type="button" disabled>Suivre</button>';
		}
	}

	function show_profile(touitos $profile, $bd)
	{
		$th = new touitosHandler($bd);

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

		/*if(isset($_SESSION['id']) AND $th->isContact($profile->getId(),$_SESSION['id']))
			echo '<div><button id="sendPrivateMessage">Envoyer un Touite privé</button></div>';*/

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

	function getMoreProfileTouite($bd,$offset,$idtouitos)
	{
		$tr = new TouiteRender($idtouitos, $bd);
		$tr->renderMessage($offset*10);
	}

	function show_timeline(touitos $touitos, $bd)
	{
		$tr = new TouiteRender($touitos->getId(), $bd);
		if(isConnected() AND isOwnProfile($touitos->getPseudo())){
			echo'
			<div id="touite-box">
							<form id="touite">
									<textarea id="touiteArea" placeholder="Entrez votre message..." name="touite" maxlength="140" required></textarea>
									<input type="submit">
							</form>
			</div>';
		}
		echo '<div id="touiteList">';
		$touiteAffiche=$tr->renderMessage(0);
		echo '</div>';



		if($touiteAffiche)
		{
			echo '<div id="loadMoreTouiteDiv">
					<button id="loadMoreProfileTouite" next="1" idtouitos="'.$touitos->getId().'">+ de touites</button>

				</div>';
		}
		else
		{
			    if(isOwnProfile($touitos->getPseudo()))
                     echo '<div class="fond nothing"><h1>Commencez à écrire un message !</h1></div>';
                else
                    echo '<div class="fond nothing"><h1>Cet utilisateur n\'a pas encore écrit de message !</h1></div>';
     
		}
	}
	function getPhoto($user,$id)
	{
		if($user->getPhoto()==1)
		{
			foreach(glob("files/pictures/".$user->getId().".*") as $file)
		    {
		           return '<img id='.$id.' src="'.$file.'" alt="Photo de '. htmlentities($user->getNom()) . '">';
		    }	
		}
		else
			return '<img id='.$id.' src="includes/img/no_pic.png" alt="Photo de '. htmlentities($user->getNom()) . '">';
	}
	function getPhotMessage($user)
	{
		if($user->getPhoto()==1)
		{
			foreach(glob("files/pictures/".$user->getId().".*") as $file)
		    {
		           return '<img src="'.$file.'">';
		    }	
		}
		else
			return '<img src="includes/img/no_pic.png">';
	}
	function gettouitos($bd, $id){
		$th = new touitosHandler($bd);
		return $th->get($id);
	}

	function gettouitosVignette($bd,touitos $touitos)
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
		$th=new touitosHandler($bd);
		$res=$th->searchByName($str,0);
		echo '<div id="searchResult">';
		foreach($res as $key=>$touitos)
		{
			if(!isset($_SESSION['user']) || !isOwnProfile($touitos->getPseudo()))
				gettouitosVignette($bd,$touitos);
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

		$th=new touitosHandler($bd);
		$res=$th->searchByName($str,intval($offset)*16);
		foreach($res as $key=>$touitos)
		{
			gettouitosVignette($bd,$touitos);
		}
	}

	function attrExists($bd,$attrName,$val,$paramType)
	{
		$th=new touitosHandler($bd);
		$test=$th->getByAttr($attrName,$val,$paramType);
		return $test!=null;
	}

	function addtouitos($data,$bd)
	{
		//test si user existe
		$photo=array('photo' => 'N');
		$data=$data+$photo;
		$th=new touitosHandler($bd);
		$touitos=new touitos($data);

		return $th->add($touitos);
	}
	function updatetouitos($bd,$touitos)
	{
		$th=new touitosHandler($bd);
		$th->update($touitos);
	}

	function addTouite($data, $bd){
		$t= new TouiteHandler($bd);
		$id = $t->add($data);
		$t->addNormaux($id);
	}


	function follow($bd,$suivi)
	{
		$th=new touitosHandler($bd);
		$th->follow($_SESSION['id'],$suivi);
	}

	function unfollow($bd,$suivi)
	{
		$th=new touitosHandler($bd);
		$th->unfollow($_SESSION['id'],$suivi);
	}

	function unAcceptRequest($bd,$suiveur)
	{
		$th=new touitosHandler($bd);
		$th->unAcceptRequest($_SESSION['id'],$suiveur);
	}

	function show_whoIFollow($bd)
	{
		$th=new touitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$refusedRequestList=$th->getWhoIRequest($connectedUser,"R");
		$sendedRequestList=$th->getWhoIRequest($connectedUser,"E");
		$list=$th->getWhoIFollow($connectedUser);

		echo '<div id="whoIFollowDiv">';

		if(empty($list) && empty($refusedRequestList) && empty($sendedRequestList))
		{
			echo '<div> Vous ne suivez personne</div>';
		}

		else
		{
			echo '<div id="whoIFollowRequest">';
			if(empty($refusedRequestList) && empty($sendedRequestList))
				echo '<div class="boxHeader">Demandes en attente</div><div>Aucune demande en attente</div>';

			else
			{
				echo '<div id="refusedRequestList" class="requestDiv"><div class="boxHeader">Demandes refusées</div>';
				foreach($refusedRequestList as $key=>$data)
				{
					echo '<div id="requestLine">';

						echo '<span id="requestPseudo" class="requestInfo"><a href="profile.php?user='.htmlentities($data['pseudo']).'">@'.htmlentities($data['pseudo']).'</a></span>';

					echo '</div>';
				}
				echo '</div>';

				echo '<div id="sendedRequestList" class="requestDiv"><div class="boxHeader">Demandes en attente</div>';
				foreach($sendedRequestList as $key=>$data)
				{
					echo '<div id="requestLine">';

						echo '<span id="requestPseudo" class="requestInfo"><a href="profile.php?user='.htmlentities($data['pseudo']).'">@'.htmlentities($data['pseudo']).'</a></span>';

					echo '</div>';
				}
				echo '</div>';
			}




			echo '</div>';

			echo '<div id="whoIFollow"><div class="boxHeader">Touitos que vous suivez</div>';
			foreach($list as $key=>$touitos)
			{
				echo  gettouitosVignette($bd,$touitos);
			}
			echo '</div>';
		}

		echo '</div>';
	}

	function show_followers($bd)
	{
		$th=new touitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$refusedRequestList=$th->getFollowRequest($connectedUser,"R");
		$sendedRequestList=$th->getFollowRequest($connectedUser,"E");
		$list=$th->getFollowers($connectedUser);

		echo '<div id="followedByDiv">';

		if(empty($list) && empty($refusedRequestList) && empty($sendedRequestList))
		{
			echo '<div>Vous n\'êtes suivi par personne</div>';
		}

		else
		{
			echo '<div id="followedByRequest">';
			if(empty($refusedRequestList) && empty($sendedRequestList))
				echo '<div class="boxHeader">Demandes en attente</div><div>Aucune demande en attente</div>';

			else
			{
				echo '<div id="refusedRequestList" class="requestDiv"><div class="boxHeader">Demandes refusées</div>';
				foreach($refusedRequestList as $key=>$data)
				{
						echo '<div id="requestLine">';

							echo '<span id="requestPseudo" class="requestInfo"><a href="profile.php?user='.htmlentities($data['pseudo']).'">@'.htmlentities($data['pseudo']).'</a></span>';
							echo '<span id="requestButton">';
								echo '<button id="acceptRequest" touitosId="'.htmlentities($data['id']).'">Accepter</button>';
							echo '</span>';
						echo '</div>';
				}
					echo '</div>';

				echo '<div id="sendedRequestList" class="requestDiv"><div class="boxHeader">Demandes en attente</div>';
				foreach($sendedRequestList as $key=>$data)
				{
					echo '<div id="requestLine">';

						echo '<span id="requestPseudo" class="requestInfo"><a href="profile.php?user='.htmlentities($data['pseudo']).'">@'.htmlentities($data['pseudo']).'</a></span>';
						echo '<span id="requestButton">';
							echo'<button id="refuseRequest" touitosId="'.htmlentities($data['id']).'">Refuser</button>';
							echo '<button id="acceptRequest" touitosId="'.htmlentities($data['id']).'">Accepter</button>';
						echo '</span>';
					echo '</div>';
				}
			}
			echo '</div>';

			foreach($list as $key=>$touitos)
			{
				echo '<div><button title="Annuler le suivi" class="unAcceptRequest" idtouitos="'.$touitos->getId().'">X</button>';
				echo  gettouitosVignette($bd,$touitos);
				echo '</div>';
			}

			echo '</div>';
		}

		echo '</div>';
	}

	function anwserRequest($bd,$user,$accept)
	{
		$th=new touitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);

		if($accept=="true")
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
	function recordRetouite($id, $bd){
		$th=new TouiteHandler($bd);
		$th->addRetouite($id, $_SESSION['id']);
	}
	function envoyer_reponse($id, Touite $message, $bd){
		$th=new TouiteHandler($bd);
		$th->addReponse($message, $id);
	}


	function displayNews($bd,$offset)
	{
		$tth=new TouiteHandler($bd);
		$th=new touitosHandler($bd);
		$touiteList=$tth->gettouitesOfWhoIFollow($_SESSION['id'],$offset*10);
		
		foreach($touiteList as $key=>$touite)
		{
			$tr=new TouiteRender($_SESSION['id'],$bd);
			$auteur=$th->getByAttr("id",$touite->getIdAuteur(),PDO::PARAM_STR);
			$tr->render($touite,$auteur);
		}

		if(empty($touiteList))
			return false;

		return true;
	}

	function deleteAccount($bd)
	{
		$th=new touitosHandler($bd);
		$th->deleteAccount($_SESSION['id']);
	}

	/* Discussion*/
	function getContact($bd)
	{
		$th=new touitosHandler($bd);
		$tPh=new touitePriveHandler($bd);
		$list=$th->getContact($_SESSION['id']);
		foreach($list as $key=>$touitos)
		{
			echo '<div class="contactRow" idtouitos='.$touitos->getId().'>';
				echo '@'.htmlentities($touitos->getPseudo());

			$nb = $tPh->getNumberOfNotReadByTouitos($_SESSION['id'],$touitos->getId());
			if($nb!=0)
			{
				echo " <b>($nb)</b>";
			}

			echo '</div>';
		}
	}

	function renderDiscussionMessage(touitePrive $touite,touitos $auteur)
	{
			if($touite->getIdAuteur()==$_SESSION['id'])
				echo '<div class="discussionMessageRow myMessage">';
			else
				echo '<div class="discussionMessageRow messageFromOther">';

			if($touite->getIdAuteur()==$_SESSION['id'])
			echo getPhotMessage($auteur);

				echo '<span class="discussionMessageRowText">';	
					echo $touite->getTexte();
				echo '</span>';
			if($touite->getIdAuteur()!=$_SESSION['id'])
				echo getPhotMessage($auteur);

			echo '</div>';

			echo '<div class="spacer"></div>';
	}

	function loadPreviousDiscussion($bd,$dest,$offset)
	{
		$th=new touitePriveHandler($bd);
		$touitosHandler= new touitosHandler($bd);
		if($touitosHandler->isContact($_SESSION['id'],$dest))
		{
			$list=$th->getDiscussionMessage($_SESSION['id'],$dest,intval($offset)*10);
			echo '<div><button id="loadPreviousDiscussion" index="'.($offset+1).'">Charger les anciens messages</button></div>';

			$dateCourante;

			if(!empty($list))
			{
				$dateCourante=substr($list[0]->getLaDate(),0,4+3+3);

				echo '<div class="datePrivate">';
				
				echo date("d/m/Y", strtotime($dateCourante));

				echo '</div>';
			}


			foreach($list as $key=>$touite)
			{
				if(strtotime(substr($touite->getLaDate(),0,4+3+3)) > strtotime($dateCourante))
				{
					echo '<div class="datePrivate">';
						$dateCourante=substr($touite->getLaDate(),0,4+3+3);
						echo date("d/m/Y", strtotime($dateCourante));
					echo '</div>';
				}

				renderDiscussionMessage($touite,$touitosHandler->getByAttr("id",$touite->getIdAuteur(),PDO::PARAM_INT));
			}
			echo '</div>';
		}
	}

	function getDiscussionMessage($bd,$id)
	{
		$th=new touitePriveHandler($bd);
		$touitosHandler= new touitosHandler($bd);
		if($touitosHandler->isContact($_SESSION['id'],$id))
		{
			$list=$th->getDiscussionMessage($_SESSION['id'],$id,0);
			echo '<div id="discussionMessage" destinataire="'.$id.'">';
			echo '<div><button id="loadPreviousDiscussion" index="1">Charger les anciens messages</button></div>';

			$dateCourante;

			if(!empty($list))
			{
				$dateCourante=substr($list[0]->getLaDate(),0,4+3+3);

				echo '<div class="datePrivate">';
				
				echo date("d/m/Y", strtotime($dateCourante));

				echo '</div>';
			}


			foreach($list as $key=>$touite)
			{
				if(strtotime(substr($touite->getLaDate(),0,4+3+3)) > strtotime($dateCourante))
				{
					echo '<div class="datePrivate">';
						$dateCourante=substr($touite->getLaDate(),0,4+3+3);
						echo date("d/m/Y", strtotime($dateCourante));
					echo '</div>';
				}

				renderDiscussionMessage($touite,$touitosHandler->getByAttr("id",$touite->getIdAuteur(),PDO::PARAM_INT));
			}
			

			echo '<div id="discussionInput" class="fond"><br>';
				echo '<textarea placeholder="Votre Message..." name="discussionAnswer" id="discussionAnswer"></textarea>';
				echo '<button id="sendDiscussion" replyTo="'.$id.'">Envoyer</button>';
			echo '</div>';
			echo '</div>';
		}
	}

	function getNumberOfNotRead($bd)
	{
		$th=new touitePriveHandler($bd);
		$nb=$th->getNumberOfNotRead($_SESSION['id']);

		return $nb;
	}

	function sendPrivateMessage($bd,$destinataire,$message)
	{
		$th=new touitePriveHandler($bd);
		$touitosHandler= new touitosHandler($bd);

		if($touitosHandler->isContact($_SESSION['id'],$destinataire))
		{
			$id=$th->sendPrivateMessage($_SESSION['id'],$destinataire,$message);
			$touite=new touitePrive($th->getById($id));

			renderDiscussionMessage($touite,$touitosHandler->getByAttr("id",$_SESSION['id'],PDO::PARAM_INT));
		}
	}





?>