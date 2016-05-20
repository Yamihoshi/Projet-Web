<?php

date_default_timezone_set("Europe/Paris");

    require_once("fonctions.php");

	class TouiteRender
	{
		 private $id; //ID touitos
		 private $bd;

		 public function __construct($id, $bd){
		 	$this->_setId($id);
		 	$this->_setBd($bd);
		 }

		public function renderMessage($offset){
		 	$db_touite = new TouiteHandler($this->getBd());
		 	$db_touitos = new touitosHandler($this->getBd());
		 	$auteur = $db_touitos->get($this->id);
		 	$message = $db_touite->getListMessage($this->id,$offset);
		 	if(!empty($message)){
				foreach($message as $key=>$touite){
                    if($touite->getType() == 1){
				 	  $this->render($touite, $auteur);
                 }
                 else{
                    $this->renderRetouite($touite);
                 }
		 	    }
                return true;
		      }

            return false;
		 }
         public function renderReponse(){
            $db_touite = new TouiteHandler($this->getBd());
            $db_touitos = new touitosHandler($this->getBd());
            //$auteur = $db_touitos->get($this->id);
            $message = $db_touite->getReponse($this->id);
            if(!empty($message)){
                foreach($message as $key=>$touite){
                    $auteur = $db_touitos->get($touite->getIdAuteur());
                    $this->render($touite, $auteur);
                }
              }
         }

         public function render($touite, $auteur){
            echo '<article class = "message" id="'. $touite->getIdMessage() .'">';
                        $this->renderPic($auteur);
                        echo '<div class="containeur">';
                            echo '<header class= "info">';
                                echo '<div class="pseudo"><a href="profile.php?user='.$auteur->getPseudo().'">@' . htmlentities($auteur->getPseudo()) .'</a></div>';
                                echo '<div class="date">'. $newDate = date("d/m/Y", strtotime($touite->getLaDate())) . '</div>';
                        echo '</header>';
                        $this->echo_message($touite);
                        $this->renderFooter($touite);
                      echo '</div>';
            echo '</article>';
         }

		 public function echo_message(Touite $message){
		 	echo '<div class="contenu_message">' . htmlentities($message->getTexte()) .'</div>';
		 }
         public function renderRetouite(Touitos $touitos, touitosHandler $db){
            $auteur = $db_touitos->get($this->id);
            echo '<article class = "message" id="'. $touite->getIdMessage() .'">';
            echo '<div> this is a retouite</div>';
            $this->renderPic($auteur);
            echo '<div class="containeur">';
                echo '<header class= "info">';
                    echo '<div class="pseudo"><a href="profile.php?user='.$auteur->getPseudo().'">@' . htmlentities($auteur->getPseudo()) .'</a></div>';
                    echo '<div class="date">'. $newDate = date("d/m/Y", strtotime($touite->getLaDate())) . '</div>';
            echo '</header>';
            $this->echo_message($touite);
            $this->renderFooter($touite);
          echo '</div>';
            echo '</article>';
         }
		 public function renderPic(Touitos $auteur){

		 	echo '<a href="profile.php?user='.$auteur->getPseudo().'">';
		 			echo getPhotMessage($auteur);
             echo  '</a>';
		 }
         public function renderFooter($message){
            echo '<footer>';
                echo '<span class="icon-undo2" title="Voir les réponses"></span>';
                //echo '<span class="icon-star-full"></span>';
                if(!empty($_SESSION['id'])){
                    if($_SESSION['id'] == $message->getIdAuteur())
                        echo '<span class="icon-bin2" title="Supprimer le message"></span>';
                    else{
                        echo '<span class="icon-star-empty" title="Retouite"></span>';
                        echo '<span class="icon-bubble" title="Répondre"></span>';
                    }
                }
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