<?php

header('content-type: application/json');


	require_once('fonctions.php');
	require_once('config/connexion.php');

	$reussit=false;

	if(isset($_POST['pseudo']))
	{
		$touitos = addTouitos($_POST,$bd);
		if($touitos==-1)
			$reussit=false;
		else
		{
				session_start();
				$_SESSION['user']=$_POST['pseudo'];
				$_SESSION['id'] = $touitos;
				$reussit = true;
		}
	}
	$array = array('reussit' => $reussit);
	echo json_encode($array);
?>
