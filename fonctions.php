<?php

	require("classes/touitos.class.php");
	require("classes/TouitosHandler.class.php");
	require("config/connexion.php");

	function show_Touitos_details($user)
	{
		echo '<div id="touitos_details_page">';
			echo '<div id="details_left_infos">';
				show_Photos($user);
				echo '<div id="details_statut">'.$user->getStatut().'</div>';
			echo '</div>';
			echo '<div id="details_username">'.$user->getNom().'</div>';
			echo '<div id="details_mail">'.$user->getMail().'</div>';
			
		echo '</div>';
	}

	function getPhoto($user)
	{
		if($user->getPhoto()=='O')
			return '<img src="files/pictures/'.$user->getNom().'.jpg">';
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
				echo '<div class="resultLine">';
					echo '<span class="result_photo">'.getPhoto($touitos).'</span>';
					echo '<span class="result_name">'.$touitos->getNom().'</span>';
				echo '</div>';
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
		$test=$th->getByMail($data['mail']);
		if($test!=null)
			return -1;
		else
		{
			$touitos=new Touitos($data);
			$th->add($touitos);
		}
	}
?>