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
		<li><a href="index.php"><img src="includes/img/home.png"></a></li>
			<li><input type="search" placeholder="Chercher un Touitos" id="searchBar" name="search"></li>';

			if(isset($_SESSION['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getbyName($_SESSION['user']);
				echo '<li><a href="profile.php?user='.$_SESSION['user'].'">'.getPhoto($usr).'</a></li>';
			}

			echo '<li id="connectLink">';


				if(!isset($_SESSION['user']))
				{
					echo '<button id="inscription" type="button">S\'inscrire</button>
					<button id="connexion" type="button">Se connecter</button>';
				}
				else
				{
					echo '<form action="logout.php" method="post" >
							<input id="disconnectButton" class="connectButton" type="submit" value="Se déconnecter">
						</form>';
				}
				echo '</li>';
				if(isset($_SESSION['user']))
				{
					echo '<li><button id="touiter" type="button">Publier un touite</button></li>';
				}

		echo'
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

