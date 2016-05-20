<?php
  require_once("classes/touite.class.php");
  

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
      $Touite->setLadate (date("Y-m-d H:i:s"));
      $q = $this->_db->prepare('INSERT INTO touites VALUES(NULL,:dateT, :texte, :auteur)');
      $q->bindValue(':dateT', $Touite->getLaDate(), PDO::PARAM_STR);
      $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
      $q->bindValue(':auteur', $Touite->getIdAuteur(), PDO::PARAM_INT);
      $q->execute();
      $id = $this->_db->lastInsertId();
      return $id;
    }
  }

  public function addPublic($id){
    $this->_db->query('INSERT INTO touitespublics VALUES('.$id.')');
  }

  public function addRetouite($id_message, $id_auteur){
    $id = $this->add(new Touite(['idAuteur' => $id_auteur, 'texte'=>"retouite"]));
    $this->addPublic($id);
    $this->_db->query('INSERT INTO retouites VALUES('.$$id.' ,' .$id_message.')');
  }

  public function addNormaux($id){
    $this->addPublic($id);
    $this->_db->query('INSERT INTO touitesnormaux VALUES('.$id.')');
  }

  public function delete($id)
  {
    $q = $this->_db->prepare('DELETE FROM touites WHERE idMsg = :id');
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
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as idMessage, texte, ladate FROM touites WHERE idAuteur = :id ORDER BY ladate DESC');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new Touite($donnees);
  }

   public function getByID($id)
  {
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as IdMessage, texte, ladate FROM touites WHERE idMsg = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new Touite($donnees);
  }

  public function getListMessage($id,$offset)
  {
    $touites = [];
    $id = (int) $id;
    $q = $this->_db->prepare('(SELECT idAuteur, idMsg as idMessage, texte, ladate, 1 as type FROM touites NATURAL JOIN touitesnormaux WHERE idAuteur = :id) UNION (SELECT idAuteur, idMsg as idMessage, texte, ladate, 2 as type FROM touites JOIN retouites ON idMsg= idMsgSource WHERE idauteur IN (SELECT idAuteur from Touites WHERE idMsg = idmsgret)) ORDER BY ladate DESC LIMIT 10 OFFSET :offset');
    
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':offset', $offset, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = new Touite($donnees);
    }
    return $touites;
  }

  public function getReponse($id_message){
    $id = (int)$id_message;
    $touites = [];
    $q = $this->_db->prepare('SELECT idMsgRep as idMessage FROM touitesreponses WHERE idMsgSource = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = $this->getByID($donnees['idMessage']);
    }
    return $touites;
  }

  public function update(Touite $Touite)
  {
    $q = $this->_db->prepare('UPDATE touites SET texte = :texte, ladate=NOW() WHERE idMsg = :id');
    $q->bindValue(':ladate', $Touite->getLaDate);
    $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
    $q->bindValue(':id', $Touite->getId(), PDO::PARAM_INT);
    $q->execute();
  }
  public function addReponse(Touite $touite, $idSource){
    $idMessage = $this->add($touite);
    $q = $this->_db->prepare('INSERT INTO touitesReponses VALUES(:idR, :idS)');
    $q->bindValue(':idR', $idMessage, PDO::PARAM_INT);
    $q->bindValue(':idS', $idSource, PDO::PARAM_INT);
    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }

  public function gettouitesOfWhoIFollow($id,$offset)
  {
    $q = $this->_db->prepare('(SELECT idMsg,laDate,texte,idAuteur,1 as type FROM touites NATURAL JOIN touitespublics,touitos,suivre WHERE idAuteur=id AND idDemandeur=:id AND idReceveur=idAuteur AND suivre.demande="V") UNION (SELECT idMsg,laDate,texte,idAuteur,2 as type FROM touites NATURAL JOIN retouites,touitos,suivre WHERE idAuteur=id AND idDemandeur=:id AND idReceveur=idAuteur AND suivre.demande="V") ORDER BY ladate DESC LIMIT 10 OFFSET :offset');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->bindValue(':offset', $offset, PDO::PARAM_INT);
    $q->execute();
    $touites=[];

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $touites[] = $this->getByID($donnees['idMsg']);
    }
    return $touites;
  }
}