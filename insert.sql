-- INSERTIONS DANS LA BASE DE DONNÉES
------------------------------------------------------------------
-- Nous n'effectuons qu'un nombre limité d'insertions car elle ne 
-- serviront que dans un but de tests
------------------------------------------------------------------

-- Éditeurs
insert into editeur values (nextval('seq_editeur'), 'Megasoft', 'contact@megasoft.com', 'http://megasoft.com');
insert into editeur values (nextval('seq_editeur'), 'Blueberry', 'contact@blueberry.com', 'http://blueberry.com');
insert into editeur values (nextval('seq_editeur'), 'Gamesoft', 'contact@gamesoft.com', 'http://gamesoft.com');
insert into editeur values (nextval('seq_editeur'), 'Tender', 'contact@tender.com', 'http://tender.com');
insert into editeur values (nextval('seq_editeur'), 'AEGames', 'contact@ae-games.com', 'http://ae-games.com');
insert into editeur values (nextval('seq_editeur'), 'NF17 Swag', 'contact@nf17-swag.com', 'http://nf17.crzt.fr');
insert into editeur values (nextval('seq_editeur'), 'Facebouc', 'contact@facebouc.com', 'http://facebouc.com');

-- Clients
insert into client values ('matheyal', 'Mathey', 'Alexis', 'matheyal');
insert into client values ('sorinluc', 'Sorin', 'Lucas', 'sorinluc');
insert into client values ('pwachals', 'Wachalski', 'Pierre', 'pwachals');
insert into client values ('mihaliin', 'Mihali', 'Ina', 'mihaliin');
insert into client values ('kcarpent', 'Carpentier', 'Kévin', 'kcarpent');
insert into client values ('crozatst', 'Crozat', 'Stéphane', 'crozatst');

-- Cartes prépayées
insert into carte_prepayee values (nextval('seq_carte_prepayee'), 30, 30, '20-12-2015', 'matheyal');
insert into carte_prepayee values (nextval('seq_carte_prepayee'), 60, 60, '12-06-2015', 'sorinluc');
insert into carte_prepayee values (nextval('seq_carte_prepayee'), 100, 100, '30-07-2015', 'kcarpent');

-- Cartes bancaires
insert into carte_bancaire values (nextval('seq_carte_bancaire'), 5133498763541093, '01-10-2016', 673);
insert into carte_bancaire values (nextval('seq_carte_bancaire'), 7367219067848933, '01-06-2017', 349);
insert into carte_bancaire values (nextval('seq_carte_bancaire'), 5133897360192837, '01-02-2016', 530);
insert into carte_bancaire values (nextval('seq_carte_bancaire'), 6739398736104691, '01-07-2015', 442);

-- Produits
-- 		- Applications:
insert into produit values ('Tender', 'Trouvez lamour autour de vous !', NULL, 4);
insert into produit values ('Megasoft Office', 'Créez et éditez des documents texte de qualité.', NULL, 1, 9.99);
insert into produit values ('Megasoft PowerPoint', 'Créez et éditez des présentations de qualité.', NULL, 1, 9.99);
insert into produit values ('Megasoft Excel', 'Créez et éditez des tableurs de qualité.', NULL, 1, 9.99);
insert into produit values ('Blueberry Messenger', 'Envoyez des messages instantanés à tous vos amis !', NULL, 2, 0.99);
insert into produit values ('Clash of tribes', 'Développez votre forteresse pour combattre les autres tribus.', NULL, 3);
insert into produit values ('Affaires criminelles', 'Résolvez des crimes insolubles.', NULL, 3);
insert into produit values ('Bonbons Crush', 'Jeu de puzzle addictif !', NULL, 5);
insert into produit values ('Appel du devoir 3', 'FPS palpitant avec plein de DLC.', NULL, 5, 29.99);
insert into produit values ('Appel du devoir 4', 'Nouveau FPS palpitant avec plein de DLC.', NULL, 5, 29.99);
insert into produit values ('Appel du devoir 5', 'Encore plus nouveau FPS palpitant avec plein de DLC.', NULL, 5, 39.99);
insert into produit values ('BDD Manager', 'Créez et gérez des bases de données efficaces en quelques clics.', NULL, 6, 4.99);
insert into produit values ('UML Generator', 'Éditez de magnifiques diagrammes UML avec ce logiciel intuitif et design.', NULL, 6, 2.99);
insert into produit values ('Facebouc', 'Gardez le contact !', NULL, 7);
insert into produit values ('Facebouc Messenger', 'Chattez avec vos amis.', NULL, 7);
-- 		- Ressources:
insert into produit values ('MAJ 1.2.1 - Facebouc Messenger', 'Correction de bugs.', 'Facebouc Messenger', 7);
insert into produit values ('MAJ 2.0 - Facebouc Messenger', 'Nouveau design.', 'Facebouc Messenger', 7);
insert into produit values ('DLC1 - Appel du devoir 3', 'Accès au mode zombie', 'Appel du devoir 3', 5, 4.99);
insert into produit values ('DLC2 - Appel du devoir 3', 'Nouveau pistolet !', 'Appel du devoir 3', 5, 9.99);
insert into produit values ('DLC3 - Appel du devoir 3', 'Décorez vos armes avec un skin gold', 'Appel du devoir 3', 5, 49.99);

-- Achats
insert into achat values (nextval('seq_achat'), 'pwachals', 'pwachals' , 'Tender');
insert into achat values (nextval('seq_achat'), 'pwachals', 'sorinluc' , 'Megasoft Office');
insert into achat values (nextval('seq_achat'), 'mihaliin', 'mihaliin' , 'Bonbons Crush');
insert into achat values (nextval('seq_achat'), 'kcarpent', 'matheyal' , 'Bonbons Crush');
insert into achat values (nextval('seq_achat'), 'matheyal', 'crozatst' , 'Facebouc');
insert into achat values (nextval('seq_achat'), 'crozatst', 'crozatst' , 'Facebouc Messenger');
insert into achat values (nextval('seq_achat'), 'crozatst', 'crozatst' , 'MAJ 2.0 - Facebouc Messenger');

-- Avis
insert into avis values ('mihaliin', 'Bonbons Crush', 5, 'Très bonne appli !');

-- Abonnements
insert into abonnement values (3, 0, 3);
insert into abonnement values (5, 1, 2);

-- Systèmes d'exploitation
insert into systeme_exploitation values (nextval('seq_systeme_exploitation'), 'Microsoft', '7');
insert into systeme_exploitation values (nextval('seq_systeme_exploitation'), 'Google', 'lollipop');
insert into systeme_exploitation values (nextval('seq_systeme_exploitation'), 'Apple', 'ios7');
insert into systeme_exploitation values (nextval('seq_systeme_exploitation'), 'Cannonical', 'Ubuntu');

-- Modèles
insert into modele values (nextval('seq_modele'), 'Apple', 'Iphone6', 3);
insert into modele values (nextval('seq_modele'), 'Google', 'Nexus6', 2);
insert into modele values (nextval('seq_modele'), 'Samsung', 'Galaxy S6', 2);
insert into modele values (nextval('seq_modele'), 'Dell', 'Latitude E7440', 4);

-- Terminaux
insert into terminal values ('AX230VB', 4, 'matheyal');
insert into terminal values ('IP876IDHD', 1, 'pwachals');
insert into terminal values ('JKHD9876SLLS', 2, 'kcarpent');

-- Installés sur
insert into installe_sur values ();