<!DOCTYPE html> 
<html>
<head>
	<title>Touiteur </title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
	<script src="includes/js/script.js"></script>
</head>
<body>

<?php
require('fonctions.php');

	echo '<nav>
		<ul>
		<li><a href="index.php"><span class="icon-home"></span> Accueil</a></li>';

			if(isset($_SESSION['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);;
				echo '<li><a href="profile.php?user='.$_SESSION['user'].'">'.getPhoto($usr,"profile_picture_nav").'</a></li>';
			}
			if(isset($_SESSION['user']))
			{
				echo '<li><button id="touiter" type="button"><span class="icon-bubbles2"></span> Publier un touite</button></li>';
			}
			echo '<li id="connectLink">';


				if(!isset($_SESSION['user']))
				{
					echo '<li><button id="inscription" type="button"><span class="icon-user-plus"></span> S\'inscrire</button>
					<button id="connexion" type="button">Se connecter</button></li>';
				}
				else
				{
					echo '<form action="logout.php" method="post" >
							<input id="disconnectButton" class="connectButton" type="submit" value="Se déconnecter">
						</form>';
				}
				echo '</li>';

		echo'
					<li><input type="search" placeholder="Chercher un Touitos" id="searchBar" name="search"></li>
		</ul>
	</nav>';
?>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">×</span>
      <h2></h2>
    </div>
    <div class="modal-body">
    </div>
    <div class="modal-footer"></div>
  </div>

</div>

