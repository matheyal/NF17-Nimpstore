-- Création des tables

create table if not exists editeur (
	id integer PRIMARY KEY,
	nom varchar(20) NOT NULL,
	contact varchar(30) NOT NULL,
	url varchar(50) NOT NULL,
	UNIQUE (nom, contact, url)
);

create table if not exists client (
	login varchar(12) PRIMARY KEY,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	mdp varchar(15) NOT NULL,
	UNIQUE (nom,prenom)
);

create table if not exists carte_prepayee (
	numero integer PRIMARY KEY,
	montant_depart integer NOT NULL,
	montant_courant integer,
	date_expiration date,
	client varchar(12) references client(login)
);

create table if not exists carte_bancaire (
	id integer PRIMARY KEY,
	numero_carte integer NOT NULL,
	date_fin_validité date NOT NULL,
	cryptogramme integer NOT NULL,
	UNIQUE (numero_carte, date_fin_validité, cryptogramme),
	CHECK (cryptogramme between 100 and 999),
	CHECK (date_fin_validité > NOW())
);

/*
create table application (
	titre varchar (40) PRIMARY KEY,
	description varchar(300),
	editeur integer references editeur(id) NOT NULL
);

create table ressource (
	titre varchar (40) PRIMARY KEY,
	description varchar(300),
	app varchar(40) references application(titre) NOT NULL,
	editeur integer references editeur(id) NOT NULL
);
*/
create table if not exists produit (
	titre varchar (40) PRIMARY KEY,
	description varchar(300),
	ressource_pour varchar(40) references produit(titre),
	editeur integer references editeur(id) NOT NULL
);

create view v_application as
	select titre from produit where ressource_pour IS NULL;

create view v_ressource as 
	select titre from produit where ressource_pour IS NOT NULL;


create table if not exists achat (
	id integer PRIMARY KEY,
	duree int NOT NULL,
	acheteur varchar(12) references client(login) NOT NULL,
	destinataire varchar(12) references client(login) NOT NULL,
	produit varchar(40) references produit(titre)
);

create table if not exists avis (
	auteur varchar(12) references client(login),
	app varchar(40) references produit(titre),
	note integer,
	commentaire varchar(500),
	PRIMARY KEY (auteur, app),
	CHECK (note between 0 and 5)
);

create table if not exists abonnement (
	app varchar(40) references produit(titre),
	achat integer references achat(id),
	automatique integer,
	nb_mois integer,
	PRIMARY KEY (app, achat),
	CHECK (automatique between 0 and 1),
	CHECK (nb_mois > 0)
);

create table if not exists systeme_exploitation (
	id integer PRIMARY KEY,
	constructeur varchar(20) NOT NULL,
	version varchar(10) NOT NULL,
	UNIQUE (constructeur, version)
);

create table if not exists modele (
	id integer PRIMARY KEY,
	constructeur varchar(20) NOT NULL,
	designation varchar(30) NOT NULL,
	os integer references systeme_exploitation(id) NOT NULL,
	UNIQUE (constructeur, designation)
);

create table if not exists terminal (
	numero_serie varchar(20) PRIMARY KEY,
	modele integer references modele(id) NOT NULL,
	proprietaire varchar(12) references client(login) NOT NULL
);

create table if not exists produit_achete (
	id integer PRIMARY KEY,
	produit varchar(40) references produit(titre) NOT NULL,
	proprietaire varchar(12) references client NOT NULL
);

create table if not exists installe_sur(
	produit integer references produit_achete(id),
	terminal varchar(20) references terminal(numero_serie),
	PRIMARY KEY (produit, terminal)
);


/*
create table ressource_disponible_pour (
	res varchar (40) references ressource(titre),
	systeme integer references systeme_exploitation(id),
	PRIMARY KEY (res, systeme)
);

create table application_disponible_pour (
	app varchar(40) references application(titre),
	systeme integer references systeme_exploitation(id),
	PRIMARY KEY (app, systeme)	
);
*/

create table if not exists produit_disponible_pour (
	produit varchar (40) references produit(titre),
	systeme integer references systeme_exploitation(id),
	PRIMARY KEY (produit, systeme)
);

-- achat_simple_ressource et achat_simple_app (utilité à débattre)
/*
create table achat_simple_ressource (
	ressource varchar(40) references ressource(titre),
	achat integer references achat(id),
	date date,
	PRIMARY KEY (ressource, achat)
);

create table achat_simple_application (
	app varchar(40) references application(titre),
	achat integer references achat(id),
	date date,
	PRIMARY KEY (app, achat)
);
*/