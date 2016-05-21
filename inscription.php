<?php

header('content-type: application/json');


	require_once('fonctions.php');
	require_once('config/connexion.php');

	if(isset($_POST['pseudo']))
	{
		$validMail=true;
		$validPseudo=true;

		if(attrExists($bd,"mail",$_POST['mail'],PDO::PARAM_STR))
			$validMail=false;
		if(attrExists($bd,"pseudo",$_POST['pseudo'],PDO::PARAM_STR))
			$validPseudo=false;

		if($validMail && $validPseudo)
		{
			//ADD
			$id=addTouitos($_POST,$bd);
			$_SESSION['user']=trim($_POST['pseudo']);
			$_SESSION['id']=$id;
		}

		$array = array('validPseudo' => $validPseudo,'validMail' => $validMail);
		echo json_encode($array);
	}

	else
	{

	}

?>
