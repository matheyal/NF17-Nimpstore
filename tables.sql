-- CRÉATION DES TABLES
------------------------------------------------------------------
-- Conventions d'écriture
------------------------------------------------------------------
-- 
-- Les noms des tables et attributs :
-- 		- tout en minuscule
-- 		- au singulier
-- 		- noms composés séparés par des _
--
-- /!\ respecter les noms choisis dans le MLD
------------------------------------------------------------------

create table editeur (
	id integer PRIMARY KEY,
	nom varchar(20) NOT NULL,
	contact varchar(30) NOT NULL,
	url varchar(50) NOT NULL,
	UNIQUE (nom, contact, url)
);

create sequence seq_editeur start 1;

create table client (
	login varchar(12) PRIMARY KEY,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	mdp varchar(15) NOT NULL,
	UNIQUE (nom,prenom)
);

create table carte_prepayee (
	numero integer PRIMARY KEY,
	montant_depart integer NOT NULL,
	montant_courant integer,
	date_expiration date,
	client varchar(12) references client(login),
	CHECK (date_expiration > CURRENT_DATE)
);

create sequence seq_carte_prepayee start 1;

create table carte_bancaire (
	id integer PRIMARY KEY,
	numero_carte varchar(16) NOT NULL,
	date_fin_validité date NOT NULL,
	cryptogramme integer NOT NULL,
	UNIQUE (numero_carte, date_fin_validité, cryptogramme),
	CHECK (cryptogramme between 100 and 999),
	CHECK (date_fin_validité > NOW())
);

create sequence seq_carte_bancaire start 1;

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

-- ajout d'un attribut prix
create table produit (
	titre varchar (40) PRIMARY KEY,
	description varchar(300),
	ressource_pour varchar(40) references produit(titre),
	editeur integer references editeur(id) NOT NULL,
	prix real NOT NULL,
	CHECK (prix > 0)
);

create view v_application as
	select * from produit where ressource_pour IS NULL;

create view v_ressource as 
	select * from produit where ressource_pour IS NOT NULL;


create table achat (
	id integer PRIMARY KEY,
	-- duree int NOT NULL,
	acheteur varchar(12) references client(login) NOT NULL,
	destinataire varchar(12) references client(login) NOT NULL, --destinataire = acheteur si achat pour soi-même
	produit varchar(40) references produit(titre) NOT NULL,
	date date NOT NULL DEFAULT CURRENT_DATE,
	UNIQUE (destinataire, produit) -- on ne peut pas posséder 2 fois la même appli
);

create sequence seq_achat start 1;
-- Vue permettant de voir les applis achetées et leurs propriétaires	
create view v_produit_achete as
	select id, produit, destinataire as propietaire from achat;

create table avis (
	auteur varchar(12) references client(login),
	app varchar(40) references produit(titre),
	note integer,
	commentaire varchar(500),
	PRIMARY KEY (auteur, app),
	CHECK (note between 0 and 5)
);

create table abonnement (
	--app varchar(40) references produit(titre), --> inutile car déjà présent dans la table achat
	achat integer references achat(id) PRIMARY KEY,
	automatique integer,
	nb_mois integer,
	CHECK (automatique between 0 and 1),
	CHECK (nb_mois > 0)
);

create table systeme_exploitation (
	id integer PRIMARY KEY,
	constructeur varchar(20) NOT NULL,
	version varchar(10) NOT NULL,
	UNIQUE (constructeur, version)
);

create sequence seq_systeme_exploitation start 1;

create table modele (
	id integer PRIMARY KEY,
	constructeur varchar(20) NOT NULL,
	designation varchar(30) NOT NULL,
	os integer references systeme_exploitation(id) NOT NULL,
	UNIQUE (constructeur, designation)
);

create sequence seq_modele start 1;

create table terminal (
	numero_serie varchar(20) PRIMARY KEY,
	modele integer references modele(id) NOT NULL,
	proprietaire varchar(12) references client(login) NOT NULL
);

create table produit_achete (
	id integer PRIMARY KEY,
	produit varchar(40) references produit(titre) NOT NULL,
	proprietaire varchar(12) references client NOT NULL
);

create sequence seq_produit_achete start 1;

create table installe_sur(
	produit integer references produit_achete(id),
	terminal varchar(20) references terminal(numero_serie),
	PRIMARY KEY (produit, terminal)
);
create table installe_sur2(
	produit integer references achat(produit),
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

create table produit_disponible_pour (
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