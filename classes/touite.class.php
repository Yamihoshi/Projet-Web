<?php

	class Touite{

        protected $_id_message; // id
		protected $_ladate;
		protected $_texte;
        protected $_idAuteur;
        protected $_reponse;
	/**
	 * Class Constructor
	 * @param    $id_auteur   
	 * @param    $date   
	 * @param    $texte   
	 * @param    $reponse   
	 */

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
      print_r($donnees);
    }
    
    /**
     * Gets the value of _id_message.
     *
     * @return mixed
     */
    public function getIdMessage()
    {
        return $this->_id_message;
    }

    /**
     * Sets the value of _id_message.
     *
     * @param mixed $_id_message the id message
     *
     * @return self
     */
    protected function setIdMessage($id_message)
    {
        $this->_id_message = $id_message;

        return $this;
    }

    /**
     * Gets the value of _ladate.
     *
     * @return mixed
     */
    public function getLadate()
    {
        return $this->_ladate;
    }

    /**
     * Sets the value of _ladate.
     *
     * @param mixed $_ladate the ladate
     *
     * @return self
     */
    protected function setLadate($ladate)
    {
        $this->_ladate = $ladate;

        return $this;
    }

    /**
     * Gets the value of _texte.
     *
     * @return mixed
     */
    public function getTexte()
    {
        return $this->_texte;
    }

    /**
     * Sets the value of _texte.
     *
     * @param mixed $_texte the texte
     *
     * @return self
     */
    protected function setTexte($texte)
    {
        $this->_texte = $texte;

        return $this;
    }

    /**
     * Gets the value of _idAuteur.
     *
     * @return mixed
     */
    public function getIdAuteur()
    {
        return $this->_idAuteur;
    }

    /**
     * Sets the value of _idAuteur.
     *
     * @param mixed $_idAuteur the id auteur
     *
     * @return self
     */
    protected function setIdAuteur($idAuteur)
    {
        $this->_idAuteur = $idAuteur;

        return $this;
    }

    /**
     * Gets the value of _reponse.
     *
     * @return mixed
     */
    public function getReponse()
    {
        return $this->_reponse;
    }

    /**
     * Sets the value of _reponse.
     *
     * @param mixed $_reponse the reponse
     *
     * @return self
     */
    public function setReponse($reponse)
    {
        $this->_reponse = $reponse;

        return $this;
    }
}
    
