<?php

	class touitePrive{

        protected $_idMsg; // id
		protected $_ladate;
		protected $_texte;
        protected $_idAuteur;
        protected $_idDiscussion;
        protected $_discussionName;

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
     * Gets the value of _id_message.
     *
     * @return mixed
     */
    public function getIdMsg()
    {
        return $this->_idMsg;
    }

    /**
     * Sets the value of _id_message.
     *
     * @param mixed $_id_message the id message
     *
     * @return self
     */
    protected function setIdmsg($id_message)
    {
        $this->_idMsg = $id_message;
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
    public function setLadate($ladate)
    {
        $this->_ladate = $ladate;
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
    }

    public function getIdDiscussion()
    {
        return $this->_idDiscussion;
    }

    public function getDiscussionName()
    {
        return $this->_discussionName;
    }

    public function setIdDiscussion($id)
    {
         $this->_idDiscussion = $id;
    }

    public function setDiscussionName($name)
    {
         $this->_discussionName = $name;
    }

}
    
