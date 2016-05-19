<?php
require_once('fonctions.php');
include('nav.php');
?>

	<div id="pageDisplay">

	<?php		

		if(!isset($_SESSION['user']))
			header('Location: index.php');
		else
		{
			echo '<div>MAIL';
			echo '</div>';

						echo '<div id="contactList"><div class="boxHeader">Liste des contacts</div>';
				getContact($bd);
			echo '</div>';
		}

	?>

	</div>

</body>
</html>