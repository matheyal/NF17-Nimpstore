<!-- ORDONNER AVEC ORDER BY POUR REGLER LES BUGS OU UTILISER -->

<html>
<?php include("base.php"); ?>
<?php

if (isset($_GET['recherche']) && ($_GET['recherche'] != "0")) {

    $appName = $_GET['recherche'];
    try {
        $querystring = "SELECT titre,nom,contact,url,description FROM v_application a,editeur e WHERE a.editeur=e.id AND a.titre='$appName'";
        $query = pg_query($idConnex, $querystring);
        $res = pg_fetch_array($query);

        if (!is_null($res['nom'])) {
                header("Location: application.php?app=$appName");
        }
        else throw new Exception("Application Introuvable : Veuillez passer par la recherche avancée !");
    }

    catch (Exception $e) {
        echo $e->getMessage();
    }
}
else if (isset($_GET['OS']) && (($OS = $_GET['OS']) != '0') && ($_GET['editor'] == '0'))
{
    $querystring = "SELECT DISTINCT a.titre,e.nom,a.prix FROM v_application a, editeur e,produit_disponible_pour pr WHERE a.editeur = e.id AND pr.produit = a.titre AND pr.systeme=$OS";
    $query = pg_query($idConnex, $querystring);
    $res = pg_fetch_all($query);

    if (!is_null($res)) {

        echo("
            <div align='center'>
            <p> Voici Différentes applications suceptibles de vous interesser !</p>
            <ul>");

        while ($res = pg_fetch_array($query)) {
            $app = new application($res['titre'],$res['nom'],$res['prix']);
            $app->afficher();
        }
        echo("</ul></div>");
    }

}

else if (isset($_GET['editor']) && (($editor = $_GET['editor']) != '0')) {

    $querystring = "SELECT DISTINCT a.titre,e.nom,a.prix FROM v_application a, editeur e,produit_disponible_pour pr WHERE a.editeur = e.id AND pr.produit = a.titre AND a.editeur='$editor'";
    $query = pg_query($idConnex, $querystring);
    $res = pg_fetch_all($query);

    if (!is_null($res['titre'])) {

        echo("
            <div align='center'>
            <p> Voici Différentes applications suceptibles de vous interesser !</p>
            <ul>");

        while ($res = pg_fetch_array($query)) {
            $app = new application($res['titre'],$res['nom'],$res['prix']);
            $app->afficher();
        }
        echo("</ul></div>");
    }

}

else {



    $querystring = "SELECT DISTINCT a.titre,e.nom,a.prix FROM v_application a, editeur e,produit_disponible_pour pr WHERE a.editeur = e.id AND pr.produit = a.titre";
    $query = pg_query($idConnex, $querystring);
    $res = pg_fetch_all($query);

    if (!is_null($res)) {

        echo("
            <div align='center'>
            <p> Voici Différentes applications suceptibles de vous interesser !</p>
            <ul>");

        while ($res = pg_fetch_array($query)) {
           $app = new application($res['titre'],$res['nom'],$res['prix']);
            $app->afficher();
        }
        echo("</ul></div>");
    }

}
    ?>

<h3>Recheche Avancée :</h3>



<p><form Method='GET' action='result.php'>
    <!-- ComboBox OS -->
<?php
if (isset($_GET['OS']))
$OS = $_GET['OS'];
if (isset($_GET['editor']))
$editor = $_GET['editor'];

    echo("<select name=OS>
            <option value='0' ><em>None</em>
    ");

        $querystring = "SELECT count(*) as nb FROM systeme_exploitation"; // Query pour savoir de quelle taille est la boucle for
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        $nombreOS = $res['nb'];

        $querystring = "SELECT id,version FROM systeme_exploitation"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        for($i=0;$i<$nombreOS;$i++) { //Boucle for pour implémenter le bon nombre de choix
        $nom = $res['version'];
            $id = $res['id'];
        echo("<option value='$id' id='$nom'> $nom ");
            $res = pg_fetch_array($query);
            }
            echo("</select>"); // Fin de la Combobox
?>
    <!-- Fin Combobox OS -->

    <!-- Debut mise en place ComboBox editor -->

<?php // Implémentation d'une combobox editeur en PhP car le nombre d'éditeur varie selon notre BDD !

echo("<select name=editor> <!-- ComboBox editor -->
        <option value='0' ><em>None</em>
");

$querystring = "SELECT count(*) as nb FROM editeur"; // Query pour savoir de quelle taille est la boucle for
$query = pg_query($idConnex,$querystring);
$res = pg_fetch_array($query) OR DIE ("BDD buggée !");

$nombreEdit = $res['nb'];

$querystring = "SELECT id,nom FROM editeur"; //Query pour prendre les noms des éditeurs
$query = pg_query($idConnex,$querystring);
$res = pg_fetch_array($query) OR DIE ("BDD buggée !");

for($i=0;$i<$nombreEdit;$i++) { //Boucle for pour implémenter le bon nombre de choix
    $nom = $res['nom'];
    $id = $res['id'];
    echo("<option value='$id' id='$nom'> $nom ");
    $res = pg_fetch_array($query);
}
echo("</select>"); // Fin de la Combobox
?>

    <!-- Fin Combobox editor -->

Nom de l'App : <input id='adSearch' type='text' name='recherche'> <input value='Rechercher' type='submit' onclick='ifEmpty()'> </p> </form>



<script src="js/ourFunction.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>