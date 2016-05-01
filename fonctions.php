<?php
	
	require_once("classes/touitos.class.php");
	require_once("classes/TouitosHandler.class.php");
	require_once("config/connexion.php");
	$status = session_status();
	if($status == PHP_SESSION_NONE){
	//There is no active session
	session_start();
	}else
	if($status == PHP_SESSION_DISABLED){
	//Sessions are not available
	}else
	if($status == PHP_SESSION_ACTIVE){
	//Destroy current and start new one
	session_destroy();
	session_start();
	}

	function getFollowButton($handler,$user,$profile)
	{
		$statut=$handler->getFollowStatut($user,$profile);
		if ($statut==-1) // NON SUIVI
			return '<button type="button" idTouitos='.$user->getId().' class="subscribe">Suivre</button>';
		else if($statut=='V') //VALIDE
			return '<button type="button" idTouitos='.$user->getId().' class="unsubscribe">Ne plus suivre</button>';
		else if($statut=='R') //REFUSE
			return '<button title="Cet utilisateur a refusé votre demande" type="button" disabled>Suivre</button>';
		else if($statut=='E')
			return '<button title="En attente d\'une réponse" type="button" disabled>Suivre</button>';
	}

	function show_profile($user,$bd)
	{
		$th = new TouitosHandler($bd);			

		echo '<div id="touitos_profile_page">';
				echo '<div id="profile_left_infos">';
			
		if(isset($_SESSION['user']))
		{
			$connected=$th->getByName($_SESSION['user']);

			if($user->getId()!=$connected->getId())
			{
					echo '<div id="subscribeDiv">'.
						getFollowButton($th,$connected,$user)
					.'</div>';
			}	
		}					

						echo '<div id="profile_photo">'.getPhoto($user).'</div>';
						echo '<div id="profile_name">'.$user->getNom().'</div>';
						echo '<div id="profile_pseudo">@'.$user->getPseudo().'</div>';
						echo '<div id="profile_statut">'.$user->getStatut().'</div>';
						echo '<input type="hidden" id="touitos_pseudo" value='.$user->getPseudo().'>';

		if(isset($_SESSION['user']) AND $_SESSION['user']==$_GET['user'])
		{
			echo '<div id="editDiv">
				<button type="button" id="edit_profile">Editer les informations</button>
						</div>';

					
		}
			echo '</div>'; // Close profil_left

			if($_SESSION['user']==$_GET['user'])
			{
			echo 	'<div id="ongletDiv">
						<table id="ongletSelect">
							<tr>
								<td>Touites</td>
								<td>Suivi</td>
								<td>Suiveurs</td>
							</tr>
						</table>
					</div>';
			}


			echo '<div id="timeline">
						<div id="touite-box">
								<form method="post">
										<textarea name="touite"></textarea>
										<input type="submit" value="Touiter">
								</form>
								<div id="compteurCaractere">140</div>
						</div>
				</div>';
		echo '</div>';
	}

	function getPhoto($user)
	{
		if($user->getPhoto()=='O')
			return '<img src="files/pictures/'.$user->getPseudo().'.jpg">';
		else
			return '<img src="includes/img/no_pic.png">';
	}
	function show_Photos($user)
	{
		echo '<div id="details_photo">';
				echo getPhoto($user);
		echo '</div>';
	}

	function getTouitosVignette($touitos)
	{
		echo '<div class="touitosDiv"><a href="profile.php?user='.$touitos->getPseudo().'">';
			echo '<div class="result_photo">'.getPhoto($touitos).'</div>';
			echo '<div class="result_details">';
				echo '<div class="result_name">'.$touitos->getNom().'</div>';
				echo '<div class="result_pseudo">@'.$touitos->getPseudo().'</div>';
				echo '<div class="result_statut">'.$touitos->getStatut().'</div>';
			echo '</div>';
		echo '</a></div>';
	}


	function searchByName($str,$bd)
	{
		$th=new TouitosHandler($bd);
		$res=$th->searchByName($str);
		echo '<div id="searchResult">';
			foreach($res as $key=>$touitos)
				{

					getTouitosVignette($touitos);
				}
		echo '</div>';
	}
	function addTouitos($data,$bd)
	{
		//test si user existe
		$photo=array('photo' => 'N');
		$data=$data+$photo;
		$th=new TouitosHandler($bd);
		//$test=$th->getByName($data['nom']);
		$test=$th->getByName($data['pseudo']);
		if($test!=null)
			return -1;
		else
		{
			$touitos=new Touitos($data);
			$th->add($touitos);
		}
	}
	function updateTouitos($bd,$touitos,$form)
	{
		$th=new TouitosHandler($bd);
		$user=$th->getByName($touitos);
		$user->_setNom($form['nom']);
		$user->_setStatut($form['statut']);
		$th->update($user);
	}

	function follow($bd,$user,$suivi)
	{
		$th=new TouitosHandler($bd);
		$demandeur=$th->getByName($user);
		$receveur=$th->getByName($suivi);

		$th->follow($demandeur,$receveur);
	}

	function unfollow($bd,$user,$suivi)
	{
		$th=new TouitosHandler($bd);
		$demandeur=$th->getByName($user);
		$receveur=$th->getByName($suivi);

		$th->unfollow($demandeur,$receveur);
	}

	function show_followers($bd,$user)
	{
		$th=new TouitosHandler($bd);
		$connectedUser=$th->getByName($user);

		echo '<div id="followersDiv">';

		echo '</div>';
	}

	function show_followedBy($bd,$user)
	{

	}

?>