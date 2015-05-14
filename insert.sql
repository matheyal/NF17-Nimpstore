-- INSERTIONS DANS LA BASE DE DONNÉES
------------------------------------------------------------------
-- Nous n'effectuons qu'un nombre limité d'insertions car elle ne 
-- serviront que dans un but de tests
------------------------------------------------------------------

-- Éditeurs
insert into editeur values (seq_editeur.nextval, 'Megasoft', 'contact@megasoft.com', 'http://megasoft.com');
insert into editeur values (seq_editeur.nextval, 'Blueberry', 'contact@blueberry.com', 'http://blueberry.com');
insert into editeur values (seq_editeur.nextval, 'Gamesoft', 'contact@gamesoft.com', 'http://gamesoft.com');
insert into editeur values (seq_editeur.nextval, 'Tender', 'contact@tender.com', 'http://tender.com');
insert into editeur values (seq_editeur.nextval, 'AEGames', 'contact@ae-games.com', 'http://ae-games.com');
insert into editeur values (seq_editeur.nextval, 'NF17 Swag', 'contact@nf17-swag.com', 'http://nf17.crzt.fr');
insert into editeur values (seq_editeur.nextval, 'Facebouc', 'contact@facebouc.com', 'http://facebouc.com');

-- Clients
insert into client values ('matheyal', 'Mathey', 'Alexis', 'matheyal');
insert into client values ('sorinluc', 'Sorin', 'Lucas', 'sorinluc');
insert into client values ('pwachals', 'Wachalski', 'Pierre', 'pwachals');
insert into client values ('mihaliin', 'Mihali', 'Ina', 'mihaliin');
insert into client values ('kcarpent', 'Carpentier', 'Kévin', 'kcarpent');
insert into client values ('crozatst', 'Crozat', 'Stéphane', 'crozatst');

-- Cartes prépayées
insert into carte_prepayee values (seq_carte_prepayee.nextval, 30, 30, '20-12-2015', 'matheyal');
insert into carte_prepayee values (seq_carte_prepayee.nextval, 60, 60, '12-06-2015', 'sorinluc');
insert into carte_prepayee values (seq_carte_prepayee.nextval, 100, 100, '30-07-2015', 'kcarpent');

-- Cartes bancaires
insert into carte_bancaire values (seq_carte_bancaire.nextval, 5133498763541093, '01-10-2016', 673);
insert into carte_bancaire values (seq_carte_bancaire.nextval, 7367219067848933, '01-06-2017', 349);
insert into carte_bancaire values (seq_carte_bancaire.nextval, 5133897360192837, '01-02-2016', 530);
insert into carte_bancaire values (seq_carte_bancaire.nextval, 6739398736104691, '01-07-2015', 442);

-- Produits
insert into produit values ('Tender', 'Trouvez l\' amour autour de vous !', NULL, );
