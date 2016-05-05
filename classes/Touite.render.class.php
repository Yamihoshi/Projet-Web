<?php

	require_once("config/connexion.php");

	class TouiteRender
	{
		 private $id; //ID touitos
		 private $bd;

		 public function __construct($id, $bd){
		 	$this->_setId($id);
		 	$this->_setBd($bd);
		 }

		public function renderMessage(){
		 	$db_touite = new TouiteHandler($this->getBd());
		 	$db_touitos = new TouitosHandler($this->getBd());
		 	$auteur = $db_touitos->get($this->id);
		 	$message = $db_touite->getMessagewithReponse($this->id);
		 	if(!empty($message)){
				foreach($message as $key=>$touite){
				 	echo '<div class = "message">';
				 		$this->renderAuteur($auteur);
				 		echo '<div class="date">'. $touite->getLaDate() . '</div>';
				 		$this->echo_message($touite);
				 	echo '</div>';
		 	}
		 }
		 }
		 public function echo_message(Touite $message){
		 	echo '<div class="contenu_message">' . $message->getTexte() .'</div>';
		 }

		 public function renderAuteur($auteur){
		 	echo '<div class="auteur">
		 			<div class="pseudo">' . $auteur->getPseudo() .'</div>
		 			<picture>
						<source src="{{touitos.photo}}">
					</picture>
		 		</div>';
		 }
	
    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function _setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of bd.
     *
     * @return mixed
     */
    public function getBd()
    {
        return $this->bd;
    }

    /**
     * Sets the value of bd.
     *
     * @param mixed $bd the bd
     *
     * @return self
     */
    public function _setBd($bd)
    {
        $this->bd = $bd;

        return $this;
    }
}
?>