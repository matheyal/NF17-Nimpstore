<html>
<?php include("base.php");?>

<?php

if(isset($_SESSION['applicationRejetee'])) {
    $appName = $_SESSION['applicationRejetee'];
    unset($_SESSION['applicationRejetee']);
}
else
    $appName = $_POST['nom'];



try {
    $querystring = "SELECT titre,nom,contact,url,description FROM produit p,editeur e WHERE p.editeur=e.id AND p.titre='$appName'";
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
</p>

");
if(isset($_GET['err']))
    echo("<p>Votre ami possède déjà l'application !</p>");
    ?>

<script src="js/ourFunction.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>