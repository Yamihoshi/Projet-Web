﻿<?php
header('content-type: application/json');
require_once('config/connexion.php');

$unknow=false;
$badLogin=false;

	if(!empty($_POST['login']) && !empty($_POST['password']))
	{
		$pseudo=$_POST['login'];
		$req=$bd->prepare("SELECT PWD FROM touitos WHERE pseudo=\"$pseudo\"");
		$req->execute();
		$tab=$req->fetch(PDO::FETCH_ASSOC);
		if(!empty($tab))
		{
			$pass=$tab['PWD'];

			if(md5($_POST['password'])==$pass)
			{
				$_SESSION['user']=$pseudo;
			}
			else
				$badLogin=true;
		}
		else
			$unknow=true;
	}
	$resultat  = array('reussit' => !($unknow || $badLogin ));
	echo json_encode($resultat);
?>