<?php

include('nav.php');
?>

	<div id="pageDisplay">

	<?php		
		
			if(isset($_GET['user']))
			{
				$th=new TouitosHandler($bd);
				$usr=$th->getByAttr("pseudo",$_GET['user'],PDO::PARAM_STR);
				if($usr!=null)
					show_profile($usr,$bd);
			}

	?>

	</div>

</body>
</html>