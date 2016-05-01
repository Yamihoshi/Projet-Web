<?php

include('nav.php');
?>

	<div id="pageDisplay">

	<?php		
		
			/*if(isset($_GET['id']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->get($_GET['id']);
				if($usr!=null)
					show_profile($usr);
			}*/

			if(isset($_GET['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getbyName($_GET['user']);
				if($usr!=null)
					show_profile($usr,$bd);
			}

	?>

	</div>

</body>
</html>