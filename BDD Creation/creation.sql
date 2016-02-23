CREATE TABLE touitos
(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nom VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	PWD VARCHAR(50) NOT NULL,
	photo VARCHAR(1) NOT NULL,
	statut VARCHAR(50)
);

CREATE TABLE suivre
(
	idDemandeur INTEGER,
	idReceveur INTEGER,
	demande VARCHAR(1) NOT NULL,
	PRIMARY KEY(idDemandeur,idReceveur),
	FOREIGN KEY (idDemandeur) REFERENCES touitos(id),
	FOREIGN KEY (idReceveur) REFERENCES touitos(id)
);



CREATE TABLE touites
(
	idMsg INTEGER PRIMARY KEY AUTO_INCREMENT,
	dateT DATE NOT NULL,
	texte VARCHAR(140) NOT NULL
	FOREIGN KEY (idAuteur) REFERENCES touitos(id)
);

CREATE TABLE hashtags
(
	idHashtag INTEGER PRIMARY KEY,
	titre VARCHAR(50) NOT NULL
);

CREATE TABLE arobases
(
	idArobase INTEGER PRIMARY KEY,
	apseudonyme VARCHAR(51) NOT NULL
);

CREATE TABLE contenuH
(
	idMsg INTEGER,
	idHashtag INTEGER,
	PRIMARY KEY(idMsg,idHashtag),
	FOREIGN KEY (idMsg) REFERENCES touites(idMsg),
	FOREIGN KEY (idHashtag) REFERENCES hashtags(idHashtag)
);

CREATE TABLE contenuA
(
	idMsg INTEGER,
	idArobase INTEGER,
	PRIMARY KEY(idMsg,idArobase),
	FOREIGN KEY (idMsg) REFERENCES touites(idMsg),
	FOREIGN KEY (idArobase) REFERENCES arobases(idArobase)
);

CREATE TABLE touitesNormaux
(
	idMsg INTEGER PRIMARY KEY,
	FOREIGN KEY (idMsg) REFERENCES touites(idMsg)
);

CREATE TABLE touitesReponses
(
	idMsgRep INTEGER PRIMARY KEY,
	idMsgSource INTEGER NOT NULL,
	FOREIGN KEY (idMsgRep) REFERENCES touites(idMsg),
	FOREIGN KEY (idMsgSource) REFERENCES touites(idMsg)
);

CREATE TABLE retouites
(
	idMsgRet INTEGER PRIMARY KEY,
	idMsgSource INTEGER NOT NULL,
	FOREIGN KEY (idMsgRet) REFERENCES touites(idMsg),
	FOREIGN KEY (idMsgSource) REFERENCES touites(idMsg)
);

CREATE TABLE touitesPrives
(
	idMsg INTEGER PRIMARY KEY,
	idAuteur INTEGER NOT NULL,
	idReceveur INTEGER NOT NULL,
	idMsgSource INTEGER,
	FOREIGN KEY (idMsg) REFERENCES touites(idMsg),
	FOREIGN KEY (idAuteur) REFERENCES touitos(id),
	FOREIGN KEY (idReceveur) REFERENCES touitos(id),
	FOREIGN KEY (idMsgSource) REFERENCES touites(idMsg)
);

DELIMITER $$

CREATE TRIGGER photoValue
BEFORE INSERT
   ON touitos FOR EACH ROW
BEGIN
	IF UPPER(NEW.photo)!='O'
		THEN SET NEW.photo='N';
	END IF;
   
END; $$


CREATE TRIGGER demandeValue
BEFORE INSERT
   ON suivre FOR EACH ROW
BEGIN
	IF (UPPER(NEW.demande)!='E' AND UPPER(NEW.demande)!='V' AND UPPER(NEW.demande)!='R')
		THEN signal sqlstate '45000' set message_text = 'demande prend comme valeur : E/V/R';
	END IF;
   
END; $$

CREATE TRIGGER touitesRepTrigger
BEFORE INSERT
   ON touitesReponses FOR EACH ROW
BEGIN
	IF NEW.idMsgRep=NEW.idMsgSource
		THEN signal sqlstate '45000' set message_text = 'idMsgRep doit être != de idMsgSource';
	ELSEIF (SELECT DATEDIFF((SELECT dateT FROM touites WHERE idMsg=NEW.idMsgSource),(SELECT dateT FROM touites WHERE idMsg=NEW.idMsgRep))>0)
		THEN signal sqlstate '45000' set message_text = 'date de idMsgSource doit être <= date de idMsgRep';
	END IF;
   
END; $$

CREATE TRIGGER touitesRetTrigger
BEFORE INSERT
   ON retouites FOR EACH ROW
BEGIN
	IF NEW.idMsgRet=NEW.idMsgSource
		THEN signal sqlstate '45000' set message_text = 'idMsgRep doit être != de idMsgSource';
	ELSEIF (SELECT DATEDIFF((SELECT dateT FROM touites WHERE idMsg=NEW.idMsgSource),(SELECT dateT FROM touites WHERE idMsg=NEW.idMsgRet))>0)
		THEN signal sqlstate '45000' set message_text = 'date de idMsgSource doit être <= date de idMsgRet';
	END IF;
   
END; $$



/*
--Trigger gérant les dates  et les id pour touitesPrives
--mis en commentaire car il bloque celui présant dans triggers.sql

CREATE TRIGGER touitesPrivesTrigger
BEFORE INSERT
   ON touitesPrives FOR EACH ROW
BEGIN
	IF NEW.idMsg=NEW.idMsgSource
		THEN signal sqlstate '45000' set message_text = 'idMsgRep doit être != de idMsgSource';
	ELSEIF (SELECT DATEDIFF((SELECT dateT FROM touites WHERE idMsg=NEW.idMsgSource),(SELECT dateT FROM touites WHERE idMsg=NEW.idMsg))>0)
		THEN signal sqlstate '45000' set message_text = 'date de idMsgSource doit être <= date de idMsgRet';
	END IF;
   
END; $$*/

DELIMITER ;