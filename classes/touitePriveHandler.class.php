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

  public function getDiscussionMessage($user,$touitos,$offset)
  {
    $touites = [];
    $q = $this->_db->prepare('(SELECT * FROM touitesprives NATURAL JOIN touites WHERE (idReceveur=:idUser AND idAuteur=:id) OR (idReceveur=:id AND idAuteur=:idUser) ORDER BY ladate DESC LIMIT 10 OFFSET :offset) ORDER BY ladate');
    $q->bindValue(':idUser', $user, PDO::PARAM_INT);
    $q->bindValue(':id', $touitos, PDO::PARAM_INT);
    $q->bindValue(':offset', $offset, PDO::PARAM_INT);
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

  public function getById($id)
  {
    $q = $this->_db->prepare('SELECT * FROM touitesprives NATURAL JOIN touites WHERE idMsg=:id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees;
  }

  public function getNumberOfNotRead($idTouitos)
  {
    $q = $this->_db->prepare('SELECT COUNT(*) as nb FROM touitesprives NATURAL JOIN touites WHERE idReceveur=:id AND vu=0');
    $q->bindValue(':id', $idTouitos, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees['nb'];
  }

  public function sendPrivateMessage($expediteur,$destinataire,$message)
  {
    date_default_timezone_set("Europe/Paris");

    $q = $this->_db->prepare('INSERT INTO touites(laDate,texte,idAuteur) VALUES(:dateT,:texte,:id)');
    $q->bindValue(':id', $expediteur, PDO::PARAM_INT);
    $q->bindValue(':texte', $message, PDO::PARAM_STR);
    $q->bindValue(':dateT', date("Y-m-d H:i:s"), PDO::PARAM_INT);
    $q->execute();

    $id = $this->_db->lastInsertId();

    $q = $this->_db->prepare('INSERT INTO touitesprives VALUES(:id,:receveur,0)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':receveur', $destinataire, PDO::PARAM_INT);
    $q->execute();

    return $id;

  }

  public function getNumberOfNotReadByTouitos($id,$idAuteur)
  {
    $q = $this->_db->prepare('SELECT COUNT(*) as nb FROM touitesprives NATURAL JOIN touites WHERE idAuteur=:idAuteur AND idReceveur=:id AND vu=0');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':idAuteur', $idAuteur, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return $donnees['nb'];
  }

}