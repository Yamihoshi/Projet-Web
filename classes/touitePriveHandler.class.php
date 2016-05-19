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

  public function getDiscussionMessage($user,$touitos)
  {
    $touites = [];
    $q = $this->_db->prepare('SELECT * FROM touitesprives NATURAL JOIN touites WHERE (idReceveur=:idUser AND idAuteur=:id) OR (idReceveur=:id AND idAuteur=:idUser) ORDER BY ladate DESC');
    $q->bindValue(':idUser', $user, PDO::PARAM_INT);
    $q->bindValue(':id', $touitos, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = new TouitePrive($donnees);
    }

    $q = $this->_db->prepare('UPDATE touitesprives NATURAL JOIN touites SET vu=1  WHERE idReceveur=:idUser AND idAuteur=:id');
    $q->bindValue(':idUser', $user, PDO::PARAM_INT);
    $q->bindValue(':id', $touitos, PDO::PARAM_INT);
    $q->execute();

    return $touites;
  }

  public function getNumberOfNotRead($idTouitos)
  {
    $touites = [];
    $q = $this->_db->prepare('SELECT COUNT(*) as nb FROM touitesprives NATURAL JOIN touites WHERE idReceveur=:id AND vu=0');
    $q->bindValue(':id', $idTouitos, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees['nb'];
  }

}