<?php
  require_once("classes/Touite.class.php");
  

class touiteHandler
{

  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }
  public function add(Touite $Touite)
  {
    if(strlen($Touite->gettexte()) <= 140){
      date_default_timezone_set("Europe/Paris");
      $q = $this->_db->prepare('INSERT INTO Touites VALUES(NULL,:dateT, :texte, :auteur)');
      $q->bindValue(':dateT', $Touite->getLaDate(), PDO::PARAM_STR);
      $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
      $q->bindValue(':auteur', $Touite->getIdAuteur(), PDO::PARAM_INT);
      $q->execute();
      $id = $this->_db->lastInsertId();
      $this->_db->query('INSERT INTO TouitesPublics VALUES('.$id.')');
      return $id;
    }
  }

  public function delete($id)
  {
    $q = $this->_db->prepare('DELETE FROM Touites WHERE idMsg = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

  }
  public function getMessagewithReponse($id){
      $list = $this->getListMessage($id);
      foreach($list as $key=>$touite){
        $touite->setReponse($this->getReponse($touite->getIdMessage()));
      }
      return $list;
    }
  public function getByAuteur($id)
  {
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as idMessage, texte, ladate FROM Touites WHERE idAuteur = :id ORDER BY ladate DESC');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new Touite($donnees);
  }

   public function getByID($id)
  {
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as IdMessage, texte, ladate FROM Touites WHERE idMsg = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new Touite($donnees);
  }

  public function getListMessage($id,$offset)
  {
    $Touites = [];
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as idMessage, texte, ladate FROM Touites WHERE idAuteur = :id ORDER BY ladate DESC LIMIT 10 OFFSET :offset');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':offset', $offset, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $Touites[] = new Touite($donnees);
    }
    return $Touites;
  }

  public function getReponse($id_message){
    $id = (int)$id_message;
    $Touites = [];
    $q = $this->_db->prepare('SELECT idMsgRep as idMessage FROM touitesreponses WHERE idMsgSource = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $Touites[] = $this->getByID($donnees['idMessage']);
    }
    return $Touites;
  }

  public function update(Touite $Touite)
  {
    $q = $this->_db->prepare('UPDATE Touites SET texte = :texte, ladate=NOW() WHERE idMsg = :id');
    $q->bindValue(':ladate', $Touite->getLaDate);
    $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
    $q->bindValue(':id', $Touite->getId(), PDO::PARAM_INT);
    $q->execute();
  }
  public function addReponse(Touite $touite, $idSource){
    $idMessage = $this->add($touite);
    print_r("hihi " . $idMessage. "heyou");
    print_r("hoho" . $idSource);
    $q = $this->_db->prepare('INSERT INTO TouitesReponses VALUES(:idR, :idS)');
    $q->bindValue(':idR', $idMessage, PDO::PARAM_INT);
    $q->bindValue(':idS', $idSource, PDO::PARAM_INT);
    print("\n" . $idMessage);
    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }

  public function getTouitesOfWhoIFollow($id,$offset)
  {
    $q = $this->_db->prepare('(SELECT idMsg,laDate,texte,idAuteur,1 as type FROM Touites NATURAL JOIN TouitesPublics,touitos,suivre WHERE idAuteur=id AND idDemandeur=:id AND idReceveur=idAuteur AND suivre.demande="V") UNION (SELECT idMsg,laDate,texte,idAuteur,2 as type FROM Touites NATURAL JOIN retouites,touitos,suivre WHERE idAuteur=id AND idDemandeur=:id AND idReceveur=idAuteur AND suivre.demande="V") ORDER BY ladate DESC LIMIT 10 OFFSET :offset');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':offset', $offset, PDO::PARAM_INT);
    $q->execute();
    $Touites=[];

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $Touites[] = $this->getByID($donnees['idMsg']);
    }
    return $Touites;
  }
}