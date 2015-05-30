<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>

<?php session_start();
if (isset($_SESSION['login']))
    $login = $_SESSION['login'];
include("idConnex.php");
include("navbar.php");

if(isset($_SESSION['applicationRejetee'])) {
    $appName = $_SESSION['applicationRejetee'];
    unset($_SESSION['applicationRejetee']);
}
else
    $appName = $_POST['nom'];



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
                <p>$description<br/> --------------------------------- </p>
                ");

    }
    else throw new Exception("Application Introuvable : Veuillez passer par la recherche avancée !");
}

catch (Exception $e) {
    echo $e->getMessage();
}

?>
<?php
echo("
<p>Choix du mode de paiement :</p>
<p>
<select id='Liste' onChange='Lien()'>
    <option value='0'><em>---Choix----</em>
    <option value='CB.php?appName=$appName'>Carte Bancaire
    <option value='CP.php?appName=$appName'>Carte Prépayée
</select>

");
if(isset($_GET['err']))
    echo("Votre ami possède déjà l'application !");
    ?>

<script src="js/ourFunction.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>