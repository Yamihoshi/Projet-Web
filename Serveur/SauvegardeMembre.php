<?php
class GestionSauvegarde
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }
  public function add(Touitos $perso)
  {
    $q = $this->_db->prepare('INSERT INTO touitos VALUES(NULL, :nom, :mail, :PWD, :statut, :photo)');
    $q->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
    $q->bindValue(':mail', $perso->getMail(), PDO::PARAM_STR);
    $q->bindValue(':PWD', $perso->getPWD(), PDO::PARAM_STR);
    $q->bindValue(':statut', $perso->getStatut(), PDO::PARAM_STR);
    $q->bindValue(':photo', $perso->getPhoto(), PDO::PARAM_STR);
    $q->execute();
  }

  public function delete(Touitos $perso)
  {
    $this->_db->exec('DELETE FROM touitos WHERE id = '.$perso->getId();
  }

  public function get($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id, nom, mail, PWD, photo FROM Touitos WHERE id = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return new Touitos($donnees);
  }

  public function getList()
  {
    $persos = [];
    $q = $this->_db->query('SELECT id, nom, mail, statut, photo FROM Touitos ORDER BY nom');
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Touitos($donnees);
    }
    return $persos;
  }

  public function update(Touitos $perso)
  {
    $q = $this->_db->prepare('UPDATE Touitos SET mail = :mail, nom = :nom, statut = :statut, photo = :photo WHERE id = :id');

    $q->bindValue(':mail', $perso->getMail(), PDO::PARAM_STR);
    $q->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
    $q->bindValue(':statut', $perso->getStatut(), PDO::PARAM_STR);
    $q->bindValue(':photo', $perso->getPhoto(), PDO::PARAM_STR);
    $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}