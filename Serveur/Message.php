<?php

	class Message{
		protected $auteur;
		protected $date;
		protected $texte;
		protected $reponse;


	/**
	 * Class Constructor
	 * @param    $auteur   
	 * @param    $date   
	 * @param    $texte   
	 * @param    $reponse   
	 */
	public function __construct($auteur, $date, $texte, $reponse)
	{
		$this->auteur = $auteur;
		$this->date = $date;
		$this->texte = $texte;
		$this->reponse = $reponse;
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
     * Gets the value of auteur.
     *
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Sets the value of auteur.
     *
     * @param mixed $auteur the auteur
     *
     * @return self
     */
    private function _setAuteur($auteur)
    {
        $this->auteur = $auteur;

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
     * Gets the value of texte.
     *
     * @return mixed
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Sets the value of texte.
     *
     * @param mixed $texte the texte
     *
     * @return self
     */
    private function _setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Gets the value of reponse.
     *
     * @return mixed
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Sets the value of reponse.
     *
     * @param mixed $reponse the reponse
     *
     * @return self
     */
    private function _setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }
}