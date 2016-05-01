/*création des tables*/


CREATE TABLE Touitos 
(
	id INT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(50),
	pseudo VARCHAR(50) NOT NULL UNIQUE,
	mail VARCHAR(50) NOT NULL,
	PWD VARCHAR(20) NOT NULL,
	photo BOOLEAN,
	statut VARCHAR(100),
	PRIMARY KEY (id)
);

CREATE TABLE Suivre
(
	idDemandeur INT NOT NULL,
	idReceveur INT NOT NULL,
	demande VARCHAR(7) NOT NULL,
	PRIMARY KEY(idDemandeur, idReceveur),
	CHECK (demande='E' OR demande='V' OR demande='R'),
  	FOREIGN KEY (idDemandeur) REFERENCES Touitos (id),
	FOREIGN KEY (idReceveur) REFERENCES Touitos (id)    
);

CREATE TABLE Touites
(
	idMsg INT NOT NULL AUTO_INCREMENT,
	laDate DATE NOT NULL,
	texte VARCHAR(140) NOT NULL,
	PRIMARY KEY (idMsg)
);

CREATE TABLE TouitesPublics
(
	idMsg INT NOT NULL,
	idAuteur INT NOT NULL,
	PRIMARY KEY (idMsg),
	FOREIGN KEY (idMsg) REFERENCES Touites (idMsg)
	ON DELETE CASCADE,
	FOREIGN KEY (idAuteur) REFERENCES Touitos (id)
);

CREATE TABLE Hashtags
(
	idHashtag INT NOT NULL AUTO_INCREMENT,
	titre VARCHAR(140) NOT NULL,
	PRIMARY KEY (idHashtag)
);

CREATE TABLE Arobases
(
	idArobase INT NOT NULL AUTO_INCREMENT,
	Apseudonyme VARCHAR(21) NOT NULL,
	PRIMARY KEY (idArobase)
);

CREATE TABLE ContenuH
(
	idMsg INT NOT NULL,
	idHashtag INT NOT NULL,
	PRIMARY KEY (idMsg, idHashtag),
	FOREIGN KEY (idMsg) REFERENCES TouitesPublics (idMsg),
	FOREIGN KEY (idHashtag) REFERENCES Hashtags (idHashtag)
);

CREATE TABLE ContenuA
(
	idMsg INT NOT NULL,
	idArobase INT NOT NULL,
	PRIMARY KEY (idMsg, idArobase),
	FOREIGN KEY (idArobase) REFERENCES Arobases (idArobase),
	FOREIGN KEY (idMsg) REFERENCES TouitesPublics (idMsg)
);

CREATE TABLE TouitesNormaux
(
	idMsg INT NOT NULL,
	PRIMARY KEY (idMsg),
	FOREIGN KEY (idMsg) REFERENCES TouitesPublics (idMsg)
	ON DELETE CASCADE
);

CREATE TABLE TouitesReponses
(
	idMsgRep INT NOT NULL,
	idMsgSource INT NOT NULL,
	PRIMARY KEY (idMsgRep),
	FOREIGN KEY (idMsgRep) REFERENCES TouitesPublics(idMsg)
	ON DELETE CASCADE,
	FOREIGN KEY (idMsgSource) REFERENCES TouitesPublics (idMsg),
	CHECK(idMsgRep!=idMsgSource)
);

CREATE TABLE Retouites
(
	idMsgRet INT NOT NULL,
	idMsgSource INT NOT NULL,
	PRIMARY KEY (idMsgRet),
	FOREIGN KEY (idMsgRet) REFERENCES TouitesPublics (idMsg)
	ON DELETE CASCADE,
	FOREIGN KEY (idMsgSource) REFERENCES TouitesPublics (idMsg),
	CHECK (idMsgRet!=idMsgSource)	
);

CREATE TABLE TouitesPrives
(
	idMsg INT NOT NULL,
	idAuteur INT NOT NULL,
	idReceveur INT NOT NULL,
	idMsgSource INT,
	PRIMARY KEY (idMsg),
	FOREIGN KEY (idMsg) REFERENCES Touites (idMsg)
	ON DELETE CASCADE,
	FOREIGN KEY (idAuteur) REFERENCES Touitos (id),
	FOREIGN KEY (idReceveur) REFERENCES Touitos (id),
	FOREIGN KEY (idMsgSource) REFERENCES Touites (idMsg),
	CHECK (idMsg!=idMsgSource)	
);

