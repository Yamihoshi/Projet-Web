<?php
class touitosHandler
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }
  public function add(Touitos $perso)
  {
    $q = $this->_db->prepare('INSERT INTO touitos(nom,pseudo,mail,pwd,statut,photo) VALUES(:nom,:pseudo, :mail, :PWD, :statut, :photo)');
    $q->bindValue(':pseudo', $perso->getPseudo(), PDO::PARAM_STR);
    $q->bindValue(':nom', $perso->getPseudo(), PDO::PARAM_STR);
    $q->bindValue(':mail', $perso->getMail(), PDO::PARAM_STR);
    $q->bindValue(':PWD', md5($perso->getPWD()), PDO::PARAM_STR);
    $q->bindValue(':statut', $perso->getStatut(), PDO::PARAM_STR);
    $q->bindValue(':photo', $perso->getPhoto(), PDO::PARAM_STR);
    $q->execute();
    return $this->_db->lastInsertId();
  }

  public function delete(Touitos $perso)
  {
    $this->_db->exec('DELETE FROM touitos WHERE id = '.$perso->getId());
  }

  public function get($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM Touitos WHERE id = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    if(!empty($donnees))
      return new Touitos($donnees);
    else
      return null;
  }

  public function getbyPseudo($name)
  {
    $q = $this->_db->prepare('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM Touitos WHERE pseudo = :usr');
    $q->bindValue(':usr', $name, PDO::PARAM_STR);
     $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    if(!empty($donnees))
      return new Touitos($donnees);
    else
      return null;
  }

  //A TESTER
  public function getbyAttr($attrName,$val,$paramType)
  {
    $q = $this->_db->prepare('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM Touitos WHERE '.$attrName.' = :val');
    $q->bindValue(':val', $val, $paramType);
     $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);


    if(!empty($donnees))
      return new Touitos($donnees);
    else
      return null;
  }

  public function getList()
  {
    $persos = [];
    $q = $this->_db->query('SELECT id, nom, mail,pseudo, statut, photo, statut FROM Touitos ORDER BY nom');
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Touitos($donnees);
    }
    return $persos;
  }

  public function searchByName($name)
  {
    $persos = [];
    $q = $this->_db->prepare('SELECT id, nom, mail,pseudo, statut, photo, statut FROM Touitos WHERE nom LIKE :nom OR pseudo LIKE :nom ORDER BY nom');
    $q->bindValue(':nom',"%$name%", PDO::PARAM_STR);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Touitos($donnees);
    }
    return $persos;
  }

  public function update(Touitos $perso)
  {
    $q = $this->_db->prepare('UPDATE Touitos SET mail = :mail, pseudo=:pseudo,nom = :nom, statut = :statut, photo = :photo WHERE id = :id');

    $q->bindValue(':mail', $perso->getMail(), PDO::PARAM_STR);
    $q->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
    $q->bindValue(':statut', $perso->getStatut(), PDO::PARAM_STR);
    $q->bindValue(':photo', $perso->getPhoto(), PDO::PARAM_STR);
    $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
    $q->bindValue(':pseudo', $perso->getPseudo(), PDO::PARAM_INT);
    $q->execute();
  }

  public function follow(Touitos $current,Touitos $suivi)
  {
    $q = $this->_db->prepare('INSERT INTO suivre(idDemandeur,idReceveur,demande) VALUES(:demandeur,:receveur,"E")');
    $q->bindValue(':demandeur', $current->getId(), PDO::PARAM_INT);
    $q->bindValue(':receveur', $suivi->getId(), PDO::PARAM_INT);
    $q->execute();
  }

    public function unfollow(Touitos $current,Touitos $suivi)
  {
    $q = $this->_db->prepare('DELETE FROM suivre WHERE idDemandeur=:demandeur AND idReceveur=:receveur');
    $q->bindValue(':demandeur', $current->getId(), PDO::PARAM_INT);
    $q->bindValue(':receveur', $suivi->getId(), PDO::PARAM_INT);
    $q->execute();
  }

  public function getWhoIFollow(Touitos $current)
  {
      $followers = [];
      $q = $this->_db->prepare('SELECT * FROM Touitos JOIN suivre ON suivre.idReceveur=touitos.id WHERE idDemandeur=:id');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $followers[] = new Touitos($donnees);
      }
      return $followers;
  }

    public function getFollowedBy(Touitos $current)
  {
      $followers = [];
      $q = $this->_db->prepare('SELECT * FROM Touitos JOIN suivre ON suivre.idDemandeur=touitos.id WHERE idReceveur=:id');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $followers[] = new Touitos($donnees);
      }
      return $followers;
  }

  public function getFollowStatut($user,$profile)
  {
      $q = $this->_db->prepare('SELECT demande FROM suivre WHERE idDemandeur=:usr AND idReceveur=:suivi');
     $q->bindValue(':usr', $user->getId(), PDO::PARAM_INT);
     $q->bindValue(':suivi', $profile->getId(), PDO::PARAM_INT);
     $q->execute();
    $tab = $q->fetch(PDO::FETCH_ASSOC);

    if(empty($tab))
      return -1;

    return $tab['demande'];

  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}