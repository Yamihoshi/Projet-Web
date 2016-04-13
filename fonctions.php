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

	function show_Photos($user)
	{
		echo '<div id="details_photo">';
		if($user->getPhoto()=='O')
			echo '<img src="files/pictures/'.$user->getNom().'.jpg">';
		else
			echo '<img src=includes/images/no_pic.jpg>';
		echo '</div>';
	}
?>