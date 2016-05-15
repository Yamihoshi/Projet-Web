<?php

include('nav.php');
?>

	<div id="pageDisplay">

	<?php		
	
	if(isset($_POST["editName"]))
	{
		$th = new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$connectedUser->_setNom($_POST['editName']);
		$connectedUser->_setStatut($_POST['editStatut']);

		$FileDir = 'files/pictures/'.$connectedUser->getPseudo().'.jpg';

		if (!empty($_FILES['profile_pic_upload']['tmp_name']) AND move_uploaded_file($_FILES['profile_pic_upload']['tmp_name'], $FileDir)) {
			$connectedUser->_setPhoto(true);
		}

		updateTouitos($bd,$connectedUser);
	}


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