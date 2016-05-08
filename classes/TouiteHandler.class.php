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
      $date = date("Y-m-d H:i:s");
      $q = $this->_db->prepare('INSERT INTO Touites VALUES(NULL,"'. $date. '", :texte, :auteur)');
      $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
      $q->bindValue(':auteur', $Touite->getIdAuteur(), PDO::PARAM_INT);
      $q->execute();
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

  public function getListMessage($id)
  {
    $Touites = [];
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg as idMessage, texte, ladate FROM Touites WHERE idAuteur = :id ORDER BY ladate DESC');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
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
    $q = $this->_db->prepare('SELECT idMsgRep FROM touitesreponses WHERE idMsgSource = :id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $Touites[] = new Touite($this->getByID($donnees['id']));
      $lastElement = count($Touites) -1;
      $Touites[$lastElement]->setReponse($this->getReponse($Touites[$lastElement]->getId()));
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

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}