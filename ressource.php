<?php session_start();
if (isset($_SESSION['login'])) {
    $login=$_SESSION['login'];
    $admin=$_SESSION['admin']; }
else{
    session_destroy();
    $login=NULL;
}
?>
<html>
<head>
    <title>NimpStore - Mes Applications</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
<?php include("navbar.php");
      include("idConnex.php");
    require("class/class.php");
?>

<?php

$appName = $_GET['appName'];

$queryString="SELECT * FROM (SELECT login, rtitre, rdescription, rprix FROM (((produit_achete pa INNER JOIN client c ON pa.proprietaire = c.login) R1 
INNER JOIN v_application app ON R1.produit = app.titre)R2 -- Retour des produits achetés par un user
INNER JOIN v_ressource res ON R2.titre=res.ressource_pour) --Retour des ressources disponibles pour les app possédées par l'user
WHERE titre='$appName' AND login = '$login') R LEFT JOIN produit_achete pa ON (R.rtitre = pa.produit AND R.login = pa.proprietaire) WHERE produit IS NULL";
$query = pg_query($idConnex,$queryString);
$res = pg_fetch_array($query);

echo"Voici les ressources disponible pour cette application :";

while (!is_null($res['login'])) {
    echo"<p><form action='achat.php' method='POST'>
    <input type='hidden' value='".$res['rtitre']."' name='nom'>
    ".$res['rtitre']."<br/>
    ".$res['rdescription']."<br/>
    <input type='submit' value='Acheter !'>
    </form></p>";
    $res = pg_fetch_array($query);
}

?>


    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/ourFunction.js"></script> 
</body>
</html>