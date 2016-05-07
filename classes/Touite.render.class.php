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
				 	echo '<article class = "message">';
				 		$this->renderPic($auteur);
                        echo '<div class="containeur">';
                            echo '<header class= "info">';
                                echo '<div class="pseudo">' . $auteur->getPseudo() .'</div>';
        				 		echo '<div class="date">'. $touite->getLaDate() . '</div>';
                        echo '</header>';
				 		$this->echo_message($touite);
                         $this->renderFooter($touite);
				 	  echo '</div>';
                    echo '</article>';
		 	}
		 }
		 }
		 public function echo_message(Touite $message){
		 	echo '<div class="contenu_message">' . $message->getTexte() .'</div>';
		 }

		 public function renderPic($auteur){
		 	echo '
		 			<picture>
						<source src="http://'. $_SERVER['SERVER_NAME']. '/projet-web/files/pictures/Megumin.jpg">
						<img src="http://'. $_SERVER['SERVER_NAME']. '/projet-web/files/pictures/Megumin.jpg">
					</picture>
            ';
		 }
         public function renderFooter($message){
            echo '<footer>';
                echo '<div class="btn-retouite"></div>';
            echo '</footer';
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