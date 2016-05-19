<?php
require_once('fonctions.php');

if(isset($_POST["editName"]))
{
		$th = new TouitosHandler($bd);
		$connectedUser=$th->getByAttr("pseudo",$_SESSION['user'],PDO::PARAM_STR);
		$connectedUser->_setNom($_POST['editName']);
		$connectedUser->_setStatut($_POST['editStatut']);

		if(!empty($_FILES['profile_pic_upload']['tmp_name']) )
		{
			$img = $_FILES['profile_pic_upload']['type'];
			$type = explode("/", $img);
			$extension = $type[1];

			$FileDir = 'files/pictures/'.$_SESSION['id'].'.'.$extension;

			$check = getimagesize($_FILES['profile_pic_upload']['tmp_name']);
	   		 if($check !== false) 
	   		 {
	   		 	foreach(glob("files/pictures/".$_SESSION['id'].".*") as $file)
			    {
			            unlink($file);
			    }

				if (move_uploaded_file($_FILES['profile_pic_upload']['tmp_name'], $FileDir))
				{
						$connectedUser->_setPhoto(true);
				}
			}
		}

		updateTouitos($bd,$connectedUser);
}

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