<?php
  require_once("classes/touite.class.php");
  

class touitePriveHandler
{

  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }

  public function getDiscussionList($idTouitos)
  {
  	$touites = [];
    $q = $this->_db->prepare('SELECT * FROM discussion NATURAL JOIN touitesprives NATURAL JOIN touites WHERE idAuteur = :id OR idReceveur=:id ORDER BY ladate DESC');
    $q->bindValue(':id', $idTouitos, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = new TouitePrive($donnees);
    }
    return $touites;
  }

  public function getDiscussionMessage($idDiscussion)
  {
    $touites = [];
    $q = $this->_db->prepare('SELECT * FROM discussion NATURAL JOIN touitesprives NATURAL JOIN touites WHERE idDiscussion=:id ORDER BY ladate DESC');
    $q->bindValue(':id', $idDiscussion, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = new TouitePrive($donnees);
    }
    return $touites;
  }

}