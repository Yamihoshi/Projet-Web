PWD<?php
	/**
	* 
	*/
	class Touitos
	{
		private $nom;
		private $mail;
		private $mail;
		private $messagePublic;
		private $messagePrive;
		private $photo;
		private $statut;
		private $PWD;

	/**
	 * Class Constructor
	 * @param    $nom   
	 * @param    $mail   
	 * @param    $date   
	 * @param    $mail   
	 * @param    $messagePublic   
	 * @param    $messagePrive   
	 * @param    $photo   
	 * @param    $statut   
	 * @param    $PWD   
	 */
	public function __construct($nom, $mail, $date, $mail, $messagePublic, $messagePrive, $photo, $statut, $PWD)
	{
		$this->nom = $nom;
		$this->mail = $mail;
		$this->date = $date;
		$this->mail = $mail;
		$this->messagePublic = $messagePublic;
		$this->messagePrive = $messagePrive;
		$this->photo = $photo;
		$this->statut = $statut;
		$this->PWD = $PWD;
	}

	// Sans PWD
	public function __construct($nom, $mail, $date, $mail, $messagePublic, $messagePrive, $photo, $statut)
	{
		$this->nom = $nom;
		$this->mail = $mail;
		$this->date = $date;
		$this->mail = $mail;
		$this->messagePublic = $messagePublic;
		$this->messagePrive = $messagePrive;
		$this->photo = $photo;
		$this->statut = $statut;
	}

    public function __construct(array $donnees)
    {
      foreach ($donnees as $key => $value)
      {
        // On récupère le nom du setter correspondant à l'attribut.
        $method = 'set'.ucfirst($key);
        // Si le setter correspondant existe.
        if (method_exists($this, $method))
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
	        return $this->nom;
	    }

	    /**
	     * Sets the value of nom.
	     *
	     * @param mixed $nom the nom
	     *
	     * @return self
	     */
	    private function _setNom($nom)
	    {
	        $this->nom = $nom;
	        return $this;
	    }

	    /**
	     * Gets the value of mail.
	     *
	     * @return mixed
	     */
	    public function getMail()
	    {
	        return $this->mail;
	    }

	    /**
	     * Sets the value of mail.
	     *
	     * @param mixed $mail the mail
	     *
	     * @return self
	     */
	    private function _setMail($mail)
	    {
	        $this->mail = $mail;

	        return $this;
	    }

	    /**
	     * Gets the value of date.
	     *
	     * @return mixed
	     */
	    public function getDate()
	    {
	        return $this->date;
	    }

	    /**
	     * Sets the value of date.
	     *
	     * @param mixed $date the date
	     *
	     * @return self
	     */
	    private function _setDate($date)
	    {
	        $this->date = $date;

	        return $this;
	    }

	    /**
	     * Gets the value of mail.
	     *
	     * @return mixed
	     */
	    public function getMail()
	    {
	        return $this->mail;
	    }

	    /**
	     * Sets the value of mail.
	     *
	     * @param mixed $mail the mail
	     *
	     * @return self
	     */
	    private function _setMail($mail)
	    {
	        $this->mail = $mail;

	        return $this;
	    }

	    /**
	     * Gets the value of messagePublic.
	     *
	     * @return mixed
	     */
	    public function getMessagePublic()
	    {
	        return $this->messagePublic;
	    }

	    /**
	     * Sets the value of messagePublic.
	     *
	     * @param mixed $messagePublic the message public
	     *
	     * @return self
	     */
	    private function _setMessagePublic($messagePublic)
	    {
	        $this->messagePublic = $messagePublic;
	        return $this;
	    }

	    /**
	     * Gets the value of messagePrive.
	     *
	     * @return mixed
	     */
	    public function getMessagePrive()
	    {
	        return $this->messagePrive;
	    }

	    /**
	     * Sets the value of messagePrive.
	     *
	     * @param mixed $messagePrive the message prive
	     *
	     * @return self
	     */
	    private function _setMessagePrive($messagePrive)
	    {
	        $this->messagePrive = $messagePrive;
	        return $this;
	    }

	    /**
	     * Gets the value of photo.
	     *
	     * @return mixed
	     */
	    public function getPhoto()
	    {
	        return $this->photo;
	    }

	    /**
	     * Sets the value of photo.
	     *
	     * @param mixed $photo the photo
	     *
	     * @return self
	     */
	    private function _setPhoto($photo)
	    {
	        $this->photo = $photo;
	        return $this;
	    }

	    /**
	     * Gets the value of statut.
	     *
	     * @return mixed
	     */
	    public function getStatut()
	    {
	        return $this->statut;
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
	        $this->statut = $statut;
	        return $this;
	    }

	    /**
	     * Gets the value of PWD.
	     *
	     * @return mixed
	     */
	    public function getPWD()
	    {
	        return $this->PWD;
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
	        $this->PWD = $PWD;
	        return $this;
	    }
}