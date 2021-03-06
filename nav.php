<!DOCTYPE html>
<html>
<head>
	<title>Touiteur </title>
	 <meta charset="utf-8">
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
	<script src="includes/js/script.js"></script>
	<link rel="icon" type="image/png" href="files/favicon.png" />
</head>
<body>

<?php
require_once('fonctions.php');

	echo '<nav>
		<ul>
		<li><a href="/"><span class="icon-home"></span> Accueil</a></li>';

			if(isset($_SESSION['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
				echo '<li><a href="profile.php?user='.htmlentities($_SESSION['user']).'">'.getPhoto($usr,"profile_picture_nav").'</a></li>';

				echo '<li><button id="touiter" type="button"><span class="icon-bubble"></span> Publier un touite</button></li>';
			}

				if(!isset($_SESSION['user']))
				{
					echo '<li><button id="inscription" type="button"><span class="icon-user-plus"></span> S\'inscrire</button>
					<button id="connexion" type="button">Se connecter</button></li>';
				}
				else
				{
					$nb=getNumberOfNotRead($bd);
					echo '<li><a href="discussion.php"><button type="button"><span class="icon-bubbles2"></span> Message privé';
					
					echo '<span id="notViewedCounter">';
					if($nb!=0)
					{
						echo " ($nb)";
					}
					echo '</span></button>';
					
					echo '</a></li>';
					echo '<li id="connectLink">';
					echo '<form action="logout.php" method="post" >
							<input id="disconnectButton" class="connectButton" type="submit" value="Se déconnecter">
						</form>';
					echo '</li>';
				}
				



		echo'
					<li><input type="search" placeholder="Chercher un Touitos" id="searchBar" name="search"></li>
		</ul>
	</nav>';
	if(!empty($_COOKIE['police']) AND !empty($_COOKIE['color'])){
		echo '<style>
			body{
				background-color:'. htmlentities($_COOKIE['color']) . ';
			}
			#discussionMessage{
			font-family:'. htmlentities($_COOKIE['police']) . ';
		}
		</style>';
	}
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

<?php

if(isConnected() AND !strpos($_SERVER['PHP_SELF'],"discussion"))
{
	echo '
	<div>
		<button id="openContactBox">Afficher les contacts</button>
	</div>';
}
?>
