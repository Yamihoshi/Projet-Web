<?php
	/**
	* 
	*/
	class Touitos
	{
		private $_nom;
		private $_mail;
		private $_photo;
		private $_statut;
		private $_PWD;

	/**
	 * Class Constructor
	 * @param    $nom   
	 * @param    $mail   
	 * @param    $date   
	 * @param    $mail    
	 * @param    $photo   
	 * @param    $statut   
	 * @param    $PWD   
	 */
	

	/*

 Tu peux pas créer plusieurs constructeurs wesh !!! go stop l'Angular Loski


	public function __construct($nom, $mail, $date, $mail, $photo, $statut, $PWD)
	{
		$this->_nom = $nom;
		$this->_mail = $mail;
		$this->_date = $date;
		$this->_mail = $mail;
		$this->_photo = $photo;
		$this->_statut = $statut;
		$this->_PWD = $PWD;
	}




	// Sans PWD
	public function __construct($nom, $mail, $date, $mail, $photo, $statut)
	{
		$this->_nom = $nom;
		$this->_mail = $mail;
		$this->_date = $date;
		$this->_mail = $mail;
		$this->_messagePublic = $messagePublic;
		$this->_messagePrive = $messagePrive;
		$this->_photo = $photo;
		$this->_statut = $statut;
	}*/

    public function __construct(array $donnees)
    {

      foreach ($donnees as $key => $value)
      {
        // On récupère le nom du setter correspondant à l'attribut.
        $method = '_set'.ucfirst($key);
        // Si le setter correspondant existe.
        //if (method_exists($this, $method))
       	if(in_array($method,get_class_methods($this)))
        {
          // On appelle le setter.
          $this->$method($value);
        }
      }
    }


	    /**
	     * Gets the value of nom.
	     *
	     * @return mixed
	     */
	    public function getNom()
	    {
	        return $this->_nom;
	    }

	    /**
	     * Sets the value of nom.
	     *
	     * @param mixed $nom the nom
	     */
	    private function _setNom($nom)
	    {
	        $this->_nom = $nom;
	    }

	    /**
	     * Gets the value of mail.
	     *
	     * @return mixed
	     */
	    public function getMail()
	    {
	        return $this->_mail;
	    }

	    /**
	     * Sets the value of mail.
	     *
	     * @param mixed $mail the mail
	     *
	     */
	    private function _setMail($mail)
	    {
	        $this->_mail = $mail;

	    }

	    /**
	     * Gets the value of photo.
	     *
	     * @return mixed
	     */
	    public function getPhoto()
	    {
	        return $this->_photo;
	    }

	    /**
	     * Sets the value of photo.
	     *
	     * @param mixed $photo the photo
	     *
	     */
	    private function _setPhoto($photo)
	    {
	        $this->_photo = $photo;
	    }

	    /**
	     * Gets the value of statut.
	     *
	     * @return mixed
	     */
	    public function getStatut()
	    {
	        return $this->_statut;
	    }

	    /**
	     * Sets the value of statut.
	     *
	     * @param mixed $statut the statut
	     *
	     * @return self
	     */
	    private function _setStatut($statut)
	    {
	        $this->_statut = $statut;
	    }

	    /**
	     * Gets the value of PWD.
	     *
	     * @return mixed
	     */
	    public function getPWD()
	    {
	        return $this->_PWD;
	    }

	    /**
	     * Sets the value of PWD.
	     *
	     * @param mixed $PWD the PWD
	     *
	     * @return self
	     */
	    private function _setPWD($PWD)
	    {
	        $this->_PWD = $PWD;
	    }
}