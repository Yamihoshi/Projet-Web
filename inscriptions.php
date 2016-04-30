<html>
<head>
	<title>Touiteur</title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
</head>
<body>
	<div id="pageDisplay">
		<?php

		require('fonctions.php');
		require('config/connexion.php');

		$userExists=false;

		if(isset($_POST['nom']))
		{
			if(addTouitos($_POST,$bd)==-1)
				$userExists=true;
			else
			{
				session_start();
				$_SESSION['user']=$_POST['nom'];
				header('Location: index.php');
			}
		}
			echo 
		'<div class="connectForm" id="subscribeForm">
			<form action="inscriptions.php" method="post">
				<input type="text" name="nom" id="username" placeholder="Nom d\'utilisateur" required>';

				if($userExists==true)
					echo '<div>Ce nom d\'utilisateur est déjà pris</div>';


			echo'	<input type="password" name="PWD" id="password" placeholder="Mot de passe" required>
				<input type="mail" name="mail" id="mail" placeholder="Adresse mail" required>
				<input class="connectButton" type="submit" value="S\'inscrire">
			</form>
		</div>
		';

		?>
	</div>
</body>
</html>