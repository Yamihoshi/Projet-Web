<?php
class TouiteRender
{
	 private $id;


	 public function __construct($id){
	 	$this->id = $id;
	 }

	 function renderMessage($id){
	 	$db_touite = new TouiteHandler($db);
	 	$auteur = $db_touitos->get($id);
	 	$message = $db_touite->getMessagewithReponse($auteur->getId());
	 	echo '<div class = "message">';
	 		renderAuteur($auteur);
	 		echo '<div class="date">'. $message->getLaDate() . '</div>';
	 		echo_message($message);
	 	echo '</div>';
	 }
	 function echo_message(Touite $message){
	 	echo 
	 		'<div class="contenu_message">' .
	 			$message->getTexte() .
	 		 '</div>';
	 }

	 function renderAuteur($auteur){
	 	echo '<div class="auteur">
	 			<div class="pseudo">' . $auteur->getPseudo() .'</div>
	 			<picture>
					<source src="{{touitos.photo}}">
				</picture>
	 		</div>';
	 }
}
?>