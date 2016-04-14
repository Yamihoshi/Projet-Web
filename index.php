<html>
<head>
	<title>Touiteur</title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
	<script src="includes/js/script.js"></script>
</head>
<body>
<?php 

require('fonctions.php');

session_start();
	echo '<nav>
		<ul>
			<li><input type="search" placeholder="Chercher un Touitos" id="searchBar" name="search"></li>';

			if(isset($_SESSION['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getbyName($_SESSION['user']);
				echo '<li>'.getPhoto($usr).'</li>';
			}

			echo '<li id="connectLink">';


				if(!isset($_SESSION['user']))
				{
					echo '<a href="inscriptions.php">S\'inscrire</a>
						<a href="login.php">Se connecter</a>';
				}
				else
				{
					echo '<form action="logout.php" method="post" >
							<input type="hidden" name="logout">
							<input class="connectButton" type="submit" value="Se déconnecter">
						</form>';
				}

		echo'
			</li>
		</ul>
	</nav>';
?>
	<div id="pageDisplay">
		<div id="nyan_nyan">
			<img src="nyan.jpg">
		</div>
	</div>

</body>
</html>