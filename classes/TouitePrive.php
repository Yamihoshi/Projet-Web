<?php 
require_once("classes/touite.class.php");
class touitePrive extends touite{
	protected $id_receveur;
	protected $id_message_depart;

	__construct($array){
		parent:__construct($array);
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
     * Gets the value of id_receveur.
     *
     * @return mixed
     */
    public function getIdReceveur()
    {
    	return $this->id_receveur;
    }

    /**
     * Sets the value of id_receveur.
     *
     * @param mixed $id_receveur the id receveur
     *
     * @return self
     */
    protected function setIdReceveur($id_receveur)
    {
    	$this->id_receveur = $id_receveur;

    	return $this;
    }

    /**
     * Gets the value of id_message_depart.
     *
     * @return mixed
     */
    public function getIdMessageDepart()
    {
    	return $this->id_message_depart;
    }

    /**
     * Sets the value of id_message_depart.
     *
     * @param mixed $id_message_depart the id message depart
     *
     * @return self
     */
    protected function setIdMessageDepart($id_message_depart)
    {
    	$this->id_message_depart = $id_message_depart;

    	return $this;
    }
}