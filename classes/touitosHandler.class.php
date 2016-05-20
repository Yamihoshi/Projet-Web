<?php
class touitosHandler
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }
  public function add(touitos $perso)
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

  public function delete(touitos $perso)
  {
    $this->_db->exec('DELETE FROM touitos CASCADE WHERE id = '.$perso->getId());
  }

  public function get($id)
  {
    $id = (int) $id;
    $q = $this->_db->query('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM touitos WHERE id = '. $id);
    //$q->bindValue(':id', $id, PDO::PARAM_INT);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    if(!empty($donnees))
      return new touitos($donnees);
    else
      return null;
  }

  public function getbyPseudo($name)
  {
    $q = $this->_db->prepare('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM touitos WHERE pseudo = :usr');
    $q->bindValue(':usr', $name, PDO::PARAM_STR);
     $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    if(!empty($donnees))
      return new touitos($donnees);
    else
      return null;
  }

  //A TESTER
  public function getbyAttr($attrName,$val,$paramType)
  {
    $q = $this->_db->prepare('SELECT id, nom,pseudo, mail, PWD, photo, statut FROM touitos WHERE '.$attrName.' = :val');
    $q->bindValue(':val', $val, $paramType);
     $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);


    if(!empty($donnees))
      return new touitos($donnees);
    else
      return null;
  }

  public function getList()
  {
    $persos = [];
    $q = $this->_db->query('SELECT id, nom, mail,pseudo, statut, photo, statut FROM touitos ORDER BY nom');
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new touitos($donnees);
    }
    return $persos;
  }

  public function searchByName($name,$offset)
  {
    $persos = [];
    $q = $this->_db->prepare('SELECT id, nom, mail,pseudo, statut, photo, statut FROM touitos WHERE nom LIKE :nom OR pseudo LIKE :nom ORDER BY nom LIMIT 16 OFFSET :offset');
    $q->bindValue(':nom',"%$name%", PDO::PARAM_STR);
    $q->bindValue(':offset',$offset, PDO::PARAM_INT);
    $q->execute();
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new touitos($donnees);
    }
    return $persos;
  }

  public function update(touitos $perso)
  {
    $q = $this->_db->prepare('UPDATE touitos SET mail = :mail, pseudo=:pseudo,nom = :nom, statut = :statut, photo = :photo WHERE id = :id');

    $q->bindValue(':mail', $perso->getMail(), PDO::PARAM_STR);
    $q->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
    $q->bindValue(':statut', $perso->getStatut(), PDO::PARAM_STR);
    $q->bindValue(':photo', $perso->getPhoto(), PDO::PARAM_STR);
    $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
    $q->bindValue(':pseudo', $perso->getPseudo(), PDO::PARAM_INT);
    $q->execute();
  }

  public function follow($current,$suivi)
  {
    $q = $this->_db->prepare('INSERT INTO suivre(idDemandeur,idReceveur,demande) VALUES(:demandeur,:receveur,"E")');
    $q->bindValue(':demandeur', $current, PDO::PARAM_INT);
    $q->bindValue(':receveur', $suivi, PDO::PARAM_INT);
    $q->execute();
  }

    public function unfollow($current,$suivi)
  {
    $q = $this->_db->prepare('DELETE FROM suivre WHERE idDemandeur=:demandeur AND idReceveur=:receveur');
    $q->bindValue(':demandeur', $current, PDO::PARAM_INT);
    $q->bindValue(':receveur', $suivi, PDO::PARAM_INT);
    $q->execute();
  }

  public function unAcceptRequest($current,$suiveur)
  {
    $q = $this->_db->prepare('DELETE FROM suivre WHERE idDemandeur=:demandeur AND idReceveur=:receveur');
    $q->bindValue(':demandeur', $suiveur, PDO::PARAM_INT);
    $q->bindValue(':receveur',$current, PDO::PARAM_INT);
    $q->execute();
  }

  public function getWhoIFollow(touitos $current)
  {
      $followers = [];
      $q = $this->_db->prepare('SELECT * FROM touitos JOIN suivre ON suivre.idReceveur=touitos.id WHERE idDemandeur=:id AND demande="V"');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $followers[] = new touitos($donnees);
      }
      return $followers;
  }

    public function getFollowers(touitos $current)
  {
      $followers = [];
      $q = $this->_db->prepare('SELECT * FROM touitos JOIN suivre ON suivre.idDemandeur=touitos.id WHERE idReceveur=:id AND demande="V"');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $followers[] = new touitos($donnees);
      }
      return $followers;
  }

  public function getWhoIRequest(touitos $current,$demande)
  {
      $request = [];
      $q = $this->_db->prepare('SELECT * FROM touitos JOIN suivre ON suivre.idReceveur=touitos.id WHERE idDemandeur=:id AND demande=:demande');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->bindValue(':demande', $demande, PDO::PARAM_STR);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $request[] = $donnees;
      }
      return $request;
  }

  public function getFollowRequest(touitos $current,$demande)
  {
      $request = [];
      $q = $this->_db->prepare('SELECT * FROM touitos JOIN suivre ON suivre.idDemandeur=touitos.id WHERE idReceveur=:id AND demande=:demande');
      $q->bindValue(':id', $current->getId(), PDO::PARAM_INT);
      $q->bindValue(':demande', $demande, PDO::PARAM_STR);
      $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $request[] = $donnees;
      }
      return $request;
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

  public function getContact($user)
  {
      $contact = [];
      $q = $this->_db->prepare('SELECT * FROM touitos JOIN suivre ON suivre.idDemandeur=touitos.id WHERE idReceveur=:id AND demande="V" AND idDemandeur IN (SELECT idReceveur FROM suivre WHERE idDemandeur=:id AND demande="V") ORDER BY pseudo');
     $q->bindValue(':id', $user, PDO::PARAM_INT);
     $q->execute();
      while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
      {
        $contact[] = new touitos($donnees);
      }
      return $contact;

  }

  public function isContact($user,$user2)
  {
      $q = $this->_db->prepare('SELECT * FROM suivre WHERE idReceveur=:id AND idDemandeur=:id2 AND demande="V" AND idDemandeur IN (SELECT idReceveur FROM suivre WHERE idDemandeur=:id AND idReceveur=:id2 )');
     $q->bindValue(':id', $user, PDO::PARAM_INT);
     $q->bindValue(':id2', $user2, PDO::PARAM_INT);
     $q->execute();
    $donnees = $q->fetch(PDO::FETCH_ASSOC);
  
    if(empty($donnees))
      return false;

    return true;
  }

  function answerRequest($current,$suiveur,$rep)
  {
    $q = $this->_db->prepare('UPDATE suivre SET demande=:rep WHERE idDemandeur=:demandeur AND idReceveur=:receveur');
    $q->bindValue(':rep',$rep, PDO::PARAM_STR);
    $q->bindValue(':demandeur', $suiveur->getId(), PDO::PARAM_INT);
    $q->bindValue(':receveur', $current->getId(), PDO::PARAM_INT);
    $q->execute();
  }

  public function deleteAccount($id)
  {

    $q = $this->_db->prepare('DELETE FROM touitespublics WHERE idMsg IN (SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM retouites WHERE idMsgRet IN (SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM retouites WHERE idMsgSource IN (SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM touitesreponses WHERE idMsgRep IN (SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM touitesreponses WHERE idMsgSource IN (SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM touitesprives WHERE idReceveur=:id OR idMsg IN(SELECT idMsg FROM touites WHERE idAuteur=:id)');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $q = $this->_db->prepare('DELETE FROM touites WHERE idAuteur=:id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();


    $q = $this->_db->prepare('DELETE FROM touitos WHERE id=:id');
    $q->bindValue(':id', $id, PDO::PARAM_INT);
    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}