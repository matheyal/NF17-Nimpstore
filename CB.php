<?php session_start();
if (isset($_SESSION['login']))
    $login=$_SESSION['login'];
else{
    session_destroy();
    $login=NULL;
}
?>

<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>

<?php
if (isset($_SESSION['login']))
    $login = $_SESSION['login'];
include("idConnex.php");
include("navbar.php");

$appName = $_GET['appName'];

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
<form Method='POST' action='banque.php' onsubmit='fCheckForm(".json_encode($login).")' >
<p>Choix du mode de paiement :</p>
<p>
<select id='Liste' onChange='Lien()'>
    <option value='CB.php?appName=$appName' selected='selected'>Carte Bancaire
    <option value='CP.php?appName=$appName'>Carte Prépayée
</select>
</p>
");
?>

Numéro de Carte : <input type='text' name='num' autofocus='autofocus' REQUIRED><br/>

Date de Fin de Validité :  <!-- Double Combobox pour date de validité -->

<!-- Combobox mois -->

<select name='mois' id='mois' REQUIRED>
    <option value='0' selected='selected' disabled="disabled">--
        <?php
        for ($i = 1;$i <13; $i++)
            echo("<option value='$i'>$i");
        ?>
</select>

<!-- Combobox année -->

<select name='annee' id='annee' REQUIRED>
    <option value='0' selected='selected' disabled="disabled">--
        <?php
        $currentYear = 2015;
        for ($i = $currentYear;$i < ($currentYear + 5); $i++)
            echo("<option value='$i'>$i");
        ?>
</select>

<!-- Fin Double Combobox -->
<br/>

Cryptogramme : <input type='text' name='crpt' REQUIRED><br/>

<br/>
<?php
echo("<input type='hidden' name='appName' value='$appName'>");
if ($_SESSION['alreadyBought'])
    echo("<input type='checkbox' id='friend' checked='checked' disabled='disabled'> Pour un ami ? <br/>
    Son Login : <input type='text' id='loginFriend' name='loginFriend' > <br/>
");
else
echo("<input type='checkbox' id='friend' onclick='fDisabInput()'> Pour un ami ? <br/>
    Son Login : <input type='text' id='loginFriend' name='loginFriend' disabled='disabled'>
<br/>
");
?>

<?php
if (isset($_GET['err'])) {
    if ($_GET['err'] == 1)
        echo("<p><font color='red'>Veuillez rentrer un login si vous voulez offrir cette app !</font></p>");
    if ($_GET['err'] == 2)
        echo("<p><font color='red'>Vous voulez l'offrir à un ami, pas à vous même !</font></p>");
}
?>
<br/>
  <?php      echo("<input type='hidden' value='$appName' name='appName'>"); ?>
        <input type='submit' value='Finalisez votre achat'></form>

<script src="js/ourFunction.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>