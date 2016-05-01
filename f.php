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
	function show_profile($user)
	{
		echo '<div id="touitos_profile_page">';
				echo '<div id="profile_left_infos">';
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
					echo '<div id="ongletDiv">
							<table id="ongletSelect">
									<tr>
											<td>Touites</td>
											<td>Suivi</td>
											<td>Suiveurs</td>
									</tr>
							</table>
					</div>';
					
				}
			echo '</div>'; // Close profil_left
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
	function searchByName($str,$bd)
	{
		$th=new TouitosHandler($bd);
		$res=$th->searchByName($str);
		echo '<div id="searchResult">';
			foreach($res as $key=>$touitos)
				{
					/*echo '<div class="resultLine">';
							echo '<span class="result_photo">'.getPhoto($touitos).'</span>';
							echo '<span class="result_name">'.$touitos->getPseudo().'</span>';
					echo '</div>';*/
					echo '<div class="touitosDiv"><a href="profile.php?user='.$touitos->getPseudo().'">';
							echo '<div class="result_photo">'.getPhoto($touitos).'</div>';
							echo '<div class="result_details">';
									echo '<div class="result_name">'.$touitos->getNom().'</div>';
									echo '<div class="result_pseudo">@'.$touitos->getPseudo().'</div>';
									echo '<div class="result_statut">'.$touitos->getStatut().'</div>';
							echo '</div>';
					echo '</a></div>';
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
?>