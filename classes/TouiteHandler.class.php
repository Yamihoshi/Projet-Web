<?php
class TouiteHandler
{


  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }
  public function add(Touite $Touite)
  {
    $q = $this->_db->prepare('INSERT INTO Touites VALUES(NULL, NOW(), :texte, :auteur)');
    $q->bindValue(':texte', $Touite->getTexte(), PDO::PARAM_STR);
    $q->bindValue(':auteur', $Touite->getIdAuteur(), PDO::PARAM_INT);
    $q->execute();
  }

  public function delete(Touite $Touite)
  {
    $this->_db->exec('DELETE FROM Touite WHERE id = '.$Touite->getIdMessage());
  }

  public function getByAuteur($id)
  {
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg, texte, ladate FROM Touites WHERE auteurid = :id ORDER BY ladate');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    return new Touite($donnees);
  }

  public function getList($id)
  {
    $Touites = [];
    $id = (int) $id;
    $q = $this->_db->prepare('SELECT idAuteur, idMsg, texte, ladate FROM Touites WHERE auteurid = :id ORDER BY ladate');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $Touites[] = new Touite($donnees);
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