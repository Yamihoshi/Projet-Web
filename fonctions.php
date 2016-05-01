<?php

	require("classes/touitos.class.php");
	require("classes/TouitosHandler.class.php");
	require("config/connexion.php");

	function show_profile($user)
	{
		echo '<div id="touitos_profile_page">';

			echo '<div id="profile_left_infos">';
				echo '<div id="profile_photo">'.getPhoto($user).'</div>';
				echo '<div id="profile_name">'.$user->getNom().'</div>';
				echo '<div id="profile_pseudo">@'.$user->getPseudo().'</div>';
				echo '<div id="profile_statut">'.$user->getStatut().'</div>';
				echo '<input type="hidden" id="touitos_pseudo" value='.$user->getPseudo().'>';
			echo '</div>';
		
		if($_SESSION['user']==$_GET['user'])
		{

			echo '<div id="editDiv"><input id="edit_profile" class="connectButton" type="button" value="Editer les informations"></div>';

			echo '<div id="ongletDiv">
				<ul id="ongletSelect">
					<li>Touites</li>
					<li>Suivi</li>
					<li>Suiveurs</li>
				</ul>
			</div>';
			
		}


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
		$test=$th->getByName($data['mail']);
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