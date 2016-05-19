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
			echo '<div id="discussionList" class="discussionSection"><div class="boxHeader">Mes discussions</div>';
				getDiscussionList($bd);
			echo '</div>';

			echo '<div id="discussionDisplay" class="discussionSection"><div class="boxHeader">Discussions</div>';
				getDiscussionMessage($bd,1);
			echo '</div>';

						echo '<div id="contactList" class="discussionSection"><div class="boxHeader">Liste des contacts</div>';
				getContact($bd);
			echo '</div>';
		}

	?>

	</div>

</body>
</html>