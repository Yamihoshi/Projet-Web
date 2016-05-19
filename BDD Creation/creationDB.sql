/*création des tables*/


create table touitos 
(
	id int not null auto_increment,
	nom varchar(50),
	pseudo varchar(50) not null unique,
	mail varchar(50) not null,
	pwd varchar(20) not null,
	photo boolean,
	statut varchar(100),
	primary key (id)
);

create table suivre
(
	iddemandeur int not null,
	idreceveur int not null,
	demande varchar(7) not null,
	primary key(iddemandeur, idreceveur),
	check (demande='e' or demande='v' or demande='r'),
  	foreign key (iddemandeur) references touitos (id),
	foreign key (idreceveur) references touitos (id)
);

create table touites
(
	idmsg int not null auto_increment,
	ladate datetime not null,
	texte varchar(140) not null,
	idauteur int not null,
	primary key (idmsg),
	foreign key (idauteur) references touitos (id)
);

create table touitespublics
(
	idmsg int not null,
	primary key (idmsg),
	foreign key (idmsg) references touites (idmsg)
	on delete cascade
);

create table hashtags
(
	idhashtag int not null auto_increment,
	titre varchar(140) not null,
	primary key (idhashtag)
);

create table arobases
(
	idarobase int not null auto_increment,
	apseudonyme varchar(21) not null,
	primary key (idarobase)
);

create table contenuh
(
	idmsg int not null,
	idhashtag int not null,
	primary key (idmsg, idhashtag),
	foreign key (idmsg) references touitespublics (idmsg),
	foreign key (idhashtag) references hashtags (idhashtag)
);

create table contenua
(
	idmsg int not null,
	idarobase int not null,
	primary key (idmsg, idarobase),
	foreign key (idarobase) references arobases (idarobase),
	foreign key (idmsg) references touitespublics (idmsg)
);

create table touitesnormaux
(
	idmsg int not null,
	primary key (idmsg),
	foreign key (idmsg) references touitespublics (idmsg)
	on delete cascade
);

create table touitesreponses
(
	idmsgrep int not null,
	idmsgsource int not null,
	primary key (idmsgrep),
	foreign key (idmsgrep) references touitespublics(idmsg)
	on delete cascade,
	foreign key (idmsgsource) references touitespublics (idmsg),
	check(idmsgrep!=idmsgsource)
);

create table retouites
(
	idmsgret int not null,
	idmsgsource int not null,
	primary key (idmsgret),
	foreign key (idmsgret) references touitespublics (idmsg)
	on delete cascade,
	foreign key (idmsgsource) references touitespublics (idmsg),
	check (idmsgret!=idmsgsource)	
);

create table touitesprives
(
	idMsg int not null,
	idReceveur int not null,
	vu BOOLEAN NOT NULL,
	primary key (idmsg),
	foreign key (idmsg) references touites (idmsg)
	on delete cascade,
	foreign key (idreceveur) references touitos (id)
	
);

