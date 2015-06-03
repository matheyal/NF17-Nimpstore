<?php session_start();
$login=$_SESSION['login'];
?>
<html>
<head>
    <title>NimpStore - Profil</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"
</head>
<body>
<?php include("navbar.php"); ?>
<h1> Gestion du profil </h1>
<h2> Informations personnelles </h2>
    
<?php
include("idConnex.php");
$querystring="SELECT * FROM client c WHERE c.login='$login'";
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

echo "<p> Nom : ".$res['nom']."</p>";
echo "<p> Prenom : ".$res['prenom']."</p>";


$queryS="SELECT a.produit as produit, v.titre as titre, a.date as date, v.description as desc, v.editeur as edi 
	From achat a, v_application v 
	WHERE a.acheteur='$login' AND a.produit=v.titre AND a.acheteur = a.destinataire";
$query=pg_query($idConnex,$queryS);

while($res=pg_fetch_array($query)){
echo "Historique des achats";
echo "<p> Produit acheté :".$res['titre']."</p>";
echo "<p> Achat fait le : ".$res['date']."</p>";
echo "<p>  Description: ".$res['desc']."</p>";
echo "<p> Editeur : ".$res['edi']."</p>";
}


$querySS="SELECT c.nom as nom, c.prenom as prenom, a.destinataire as dest, a.produit as produit, a.date as date, v.titre as titre, v.description as desc, v.editeur as edi 
	From achat a, v_application v, client c
	WHERE a.acheteur='$login' AND a.produit=v.titre AND a.acheteur != a.destinataire AND a.destinataire = c.login";
$query=pg_query($idConnex,$querySS);

while($res=pg_fetch_array($query)){
echo "Historique des cadeaux";
echo "<p> Achat pour : ".$res['prenom'] . $res['nom']."</p>";
echo "<p> Cadeau fait le : ".$res['date']."</p>";
echo "<p> Produit acheté :".$res['titre']."</p>";
echo "<p>  Description: ".$res['desc']."</p>";
echo "<p> Editeur : ".$res['edi']."</p>";

}

$querySS="SELECT c.nom as nom, c.prenom as prenom, a.destinataire as dest, a.produit as produit, a.date as date, v.titre as titre, v.description as desc, v.editeur as edi 
	From achat a, v_application v, client c
	WHERE a.destinataire='$login' AND a.produit=v.titre AND a.acheteur != a.destinataire AND a.acheteur = c.login";
$query=pg_query($idConnex,$querySS);

while($res=pg_fetch_array($query)){
echo "Historique des cadeaux pris";
echo "<p> Cadeau de : ".$res['prenom'] . $res['nom']."</p>";
echo "<p> Cadeau reçu le : ".$res['date']."</p>";
echo "<p> Produit  :".$res['titre']."</p>";
echo "<p>  Description: ".$res['desc']."</p>";
echo "<p> Editeur : ".$res['edi']."</p>";

}
?>
    
    
    
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>
