<?php

	$db_name="Touiteur";

	try
	{
		$bd=new PDO("mysql:host=localhost;dbname=$db_name",'root', 'root');
		$bd->query("SET NAMES utf8");
		$bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		die("<p> La connexion a échoué.Erreur[".$e->getCode()."]:".$e->getMessage()."</p>");
	}
?>