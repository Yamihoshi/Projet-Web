<html>
<head>
	<title>Touiteur - Se Connecter</title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
</head>
<body>
<?php

session_start();

require('config/connexion.php');

$unknow=false;
$badLogin=false;

	if(isset($_POST['login']))
	{
		$username=$_POST['login'];
		$req=$bd->prepare("SELECT PWD FROM touitos WHERE nom=\"$username\"");
		$req->execute();
		$tab=$req->fetch(PDO::FETCH_ASSOC);
		if(!empty($tab))
		{
			$pass=$tab['PWD'];

			if(md5($_POST['password'])==$pass)
			{
				$_SESSION['user']=$username;
			}
			else
				$badLogin=true;
		}
		else
			$unknow=true;
	}
	if(!isset($_SESSION['user']))
	{
		echo'<div id="pageDisplay">
			<div class="connectForm" id="loginForm">
				<form id="loginForm" action="login.php" method="post">
					<input type="text" id="login" name="login" placeholder="Login" required>';

		if($unknow==true)
			echo '<div>username non existant</div>';

		echo '<input type="password" id="pass" name="password" placeholder="Mot de passe" required>';

		if($badLogin==true)
			echo "<div>Mot de passe incorrect</div>";
		
		echo '<input class="connectButton" type="submit" value="Se Connecter">
				</form>
		</div>';
	}
	else 
	{
		/*echo 'CONNECTE EN TANT QUE '.$_SESSION['user'];
		echo '<input class="connectButton" type="button" value="Se déconnecter">';*/
		 header('Location: index.php');
	}
?>
</body>
</html>