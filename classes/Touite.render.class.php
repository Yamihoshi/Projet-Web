<?php
	 private $id;
	 public function __construct($id){
	 	$this->id = $id);
	 }

	 function renderMessage($id){
	 	$db_touite = new TouiteHandler($db);
	 	$message = $db_touite->getMessagewithReponse($id);
	 }
	 function echo_message(Touite $message){
	 	echo 
	 	'<div class="contenu_message">';
	 	echo $message->getTexte();
	 	echo 
	 	'</div>';
	 }

	 function renderAuteur($id){
	 	$db_touitos = new TouiteHandler($db);
	 	$auteur = $db_touitos->get($id);
	 	echo '<div class="auteur">
	 			<div class="pseudo"></div>
	 			<picture>
					<source src="{{touitos.photo}}">
				</picture>
	 		</div>';
	 }
?>