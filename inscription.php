<?php

header('content-type: application/json');


	require_once('fonctions.php');
	require_once('config/connexion.php');

	$reussit=false;

	if(isset($_POST['pseudo']))
	{
		if(addTouitos($_POST,$bd)==-1)
			$reussit=false;
		else
		{
			$status = session_status();
			if($status == PHP_SESSION_NONE){
			    //There is no active session
			    session_start();
			}else
			if($status == PHP_SESSION_DISABLED){
			    //Sessions are not available
			}else
			if($status == PHP_SESSION_ACTIVE){
			    //Destroy current and start new one
			    session_destroy();
			    session_start();
			}
				$_SESSION['user']=$_POST['pseudo'];
				$reussit = true;
		}
	}
	$array = array('reussit' => $reussit);
	echo json_encode($array);
?>
