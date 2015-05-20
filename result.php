<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php session_start();
include("idConnex.php");

if (isset($_GET['recherche']) && ($_GET['recherche'] != "0")) {

    $appName = $_GET['recherche'];
    try {
        $querystring = "SELECT titre,nom,contact,url,description FROM v_application a,editeur e WHERE a.editeur=e.id AND a.titre='$appName'";
        $query = pg_query($idConnex, $querystring);
        $res = pg_fetch_array($query);

        if (!is_null($res)) {
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
                <p>$description</p>
                <form Method='GET' action='achat.php'> <input value='Achat' type='submit'></form></div>
                ");

        }
        else throw new Exception("Application Introuvable");
    }

    catch (Exception $e) {
        echo $e->getMessage;
    }
}
else {
    $querystring = "SELECT DISTINCT  titre FROM v_application a, editeur e,produit_disponible_pour pr WHERE a.editeur = e.id AND pr.produit = a.titre";
    $query = pg_query($idConnex, $querystring);
    $res = pg_fetch_all($query);

    if (!is_null($res)) {

        echo("
            <p> Voici Différentes applications suceptibles de vous interesser !</p>
            <ul>");

        while ($res = pg_fetch_array($query)) {
            $appName = $res['titre'];
            echo("<li><a href='result.php?recherche=$appName'> $appName </a>");
        }
        echo("</ul>");
    }

}
    ?>

<h3>Recheche Avancée :</h3>

<p><form Method='GET' action='result.php'>
    <!-- ComboBox OS -->
<?php
    echo("<select name=OS>");

        $querystring = "SELECT count(*) as nb FROM systeme_exploitation"; // Query pour savoir de quelle taille est la boucle for
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        $nombreOS = $res['nb'];

        $querystring = "SELECT version FROM systeme_exploitation"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        for($i=0;$i<$nombreOS;$i++) { //Boucle for pour implémenter le bon nombre de choix
        $nom = $res['version'];
        echo("<option> $nom ");
            $res = pg_fetch_array($query);
            }
            echo("</select>"); // Fin de la Combobox
?>
    <!-- Fin Combobox OS -->

    <!-- Debut mise en place ComboBox editor -->

<?php // Implémentation d'une combobox editeur en PhP car le nombre d'éditeur varie selon notre BDD !

echo("<select name=editor> <!-- ComboBox editor -->");

$querystring = "SELECT count(*) as nb FROM editeur"; // Query pour savoir de quelle taille est la boucle for
$query = pg_query($idConnex,$querystring);
$res = pg_fetch_array($query) OR DIE ("BDD buggée !");

$nombreEdit = $res['nb'];

$querystring = "SELECT nom FROM editeur"; //Query pour prendre les noms des éditeurs
$query = pg_query($idConnex,$querystring);
$res = pg_fetch_array($query) OR DIE ("BDD buggée !");

for($i=0;$i<$nombreEdit;$i++) { //Boucle for pour implémenter le bon nombre de choix
    $nom = $res['nom'];
    echo("<option> $nom ");
    $res = pg_fetch_array($query);
}
echo("</select>"); // Fin de la Combobox
?>

    <!-- Fin Combobox editor -->

Nom de l'App : <input id='adSearch' type='text' name='recherche'> <input value='Rechercher' type='submit' onclick='ifEmpty()'> </p> </form>



<script src="js/ourFunction.js"></script>
</body>
</html>