<html>
<head>
	<title>Touiteur</title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
</head>
<body>

	<?php

		require('fonctions.php');

		if(isset($_GET['id']))
		{
			$th=new TouitosHandler($bd);
			$usr=$th->get($_GET['id']);
			if($usr!=null)
				show_Touitos_details($usr);
		}

		else if(isset($_GET['usr']))
		{
			$th=new TouitosHandler($bd);
			$usr=$th->getbyName($_GET['usr']);
			if($usr!=null)
				show_Touitos_details($usr);
			else
				echo "NULL";
		}

	?>

</body>
</html>