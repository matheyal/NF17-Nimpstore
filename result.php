<?php session_start();
if (isset($_SESSION['login']))
    $login=$_SESSION['login'];
else{
    session_destroy();
    $login=NULL;
}
?>
<!-- ORDONNER AVEC ORDER BY POUR REGLER LES BUGS OU UTILISER -->

<html>
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
<?php
include("idConnex.php");
include("navbar.php");
require("class/class.php");

if (isset($_GET['recherche']) && ($_GET['recherche'] != "0")) {

    $appName = $_GET['recherche'];
    try {
        $querystring = "SELECT titre,nom,contact,url,description FROM v_application a,editeur e WHERE a.editeur=e.id AND a.titre='$appName'";
        $query = pg_query($idConnex, $querystring);
        $res = pg_fetch_array($query);

        if (!is_null($res['nom'])) {
                $editorName = $res['nom'];
                $editorContact = $res['contact'];
                $editorSite = $res['url'];
                $description = $res['description'];

                echo("
                <div align='center'>
                <h2> $appName </h2>
                <p> Nom de l'éditeur de l'application : $editorName
                <ul>
                <li>$editorContact</li>
                <li>$editorSite</li>
                </ul>
                </p>
                <p>$description</p>");

            $queryString = "SELECT id FROM produit_achete pa WHERE proprietaire='$login' AND produit='$appName'";
            $query = pg_query($idConnex, $queryString);
            $res = pg_fetch_array($query);

            if (!is_null($res['id'])) {
                echo("Vous possédez cette application ! Vous pouvez l'offrir à un ami !");
                $_SESSION['alreadyBought'] = 1;
                echo("<form Method='POST' action='achat.php'> <input value='Achat pour un ami !' type='submit'><input name='nom' value='$appName' type='hidden'></form></div>");

            }
            else {
                $_SESSION['alreadyBought'] = 0;
                echo("<form Method='POST' action='achat.php'> <input value='Achat' type='submit'><input name='nom' value='$appName' type='hidden'></form></div>");
            }

        /* Insertion de la partie avis */

            // Interogation de la BDD

            $queryString = "
SELECT commentaire AS com,note AS mark, auteur ,app AS appli, moy
FROM avis a ,
  (SELECT AVG(note) AS moy,app AS appl
  FROM avis
  WHERE app='$appName'
  GROUP BY(appl)) AS R2
WHERE a.app='$appName'"; // #MEGAREQUETEDUTURFU!!!
            $query = pg_query($idConnex, $queryString);
            $res = pg_fetch_array($query);



            echo("<div class='avisContainer'>
                <div class='note' align='center'> Note Moyenne de l'application : ".$res['moy']." / 5 </div><br/><br/>
            ");

            while (!is_null($res['mark'])) {
                echo("<p align='center'>--------------</p><br/><div class='singleAvisDisplay' align='center'><p>Note délivrée par ".$res['auteur']." : ".$res['mark']."</p><p>Commentaire : ".$res['com']."</p></div> ");
                $res = pg_fetch_array($query);
            }

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