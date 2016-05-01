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
					echo '<a href="inscriptions.php">S\'inscrire</a>
						<a href="login.php">Se connecter</a>';
				}
				else
				{
					echo '<form action="logout.php" method="post" >
							<input id="disconnectButton" class="connectButton" type="submit" value="Se déconnecter">
						</form>';
				}

		echo'
			</li>
		</ul>
	</nav>';
?>