<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php session_start();
include("idConnex.php");

$appName = $_GET['recherche'];
try {
    $querystring = "SELECT titre,nom,contact,url,description FROM application a,editeur e WHERE a.editeur=e.id AND a.titre='$appName'";
    $query = pg_query($idConnex,$querystring);
    $res = pg_fetch_array($query) OR DIE ("Application introuvable");

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
        ");
    }
    else throw new Exception("Application Introuvable");
}
catch (Exception $e) {
   echo $e->getMessage;
}
?>

<form Method='GET' action='achat.php'> <input value='Achat' type='submit'></form></div>

<h3>Recheche Avancée :</h3>
<!-- Double Combo-box pour choisir editeur & Os -->
<form Method='GET' action='result.php'> <p>Nom de l'App : <input type='text' name='recherche'> <br/> <input value='Rechercher' type='submit'</p> </form>


</body>
</html>