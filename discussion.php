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
			echo '<div class="fond">';
			echo '<div id="discussionDisplay" class="discussionSection"><div class="boxHeader">Discussions</div>';
					echo 'Choisissez une discussion';
			echo '</div>';

			echo '<div id="contactList" class="discussionSection"><div class="boxHeader">Liste des contacts</div>';
				getContact($bd);
			echo '</div></div>';
		}

	?>

	</div>

</body>
</html>