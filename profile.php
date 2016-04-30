<html>
<head>
	<title>Touiteur </title>
	<link rel="stylesheet" href="includes/css/style.css">
	<script src="includes/js/jquery-1.11.3.min.js"></script>
	<script src="includes/js/script.js"></script>
</head>
<body>

<?php

include('nav.php');
?>

<div id="pageDisplay">

<?php		
	
		if(isset($_GET['id']))
		{
			$th=new TouitosHandler($bd);
			$usr=$th->get($_GET['id']);
			if($usr!=null)
				show_profile($usr);
		}

		else if(isset($_GET['user']))
		{
			$th=new TouitosHandler($bd);
			$usr=$th->getbyName($_GET['user']);
			if($usr!=null)
				show_profile($usr);
		}

?>

</div>

</body>
</html>