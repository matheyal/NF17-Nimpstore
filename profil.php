<html>
<?php include("base.php"); ?>
<h1> Gestion du profil </h1>
<h2> Informations personnelles </h2>
    
<?php
$querystring="SELECT * FROM client c WHERE c.login='$login'";
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

echo "<p> <strong>Nom :</strong> ".$res['nom']."</p>";
echo "<p> <strong>Prenom :</strong> ".$res['prenom']."</p>";
echo "<p> <strong>Login : </strong> ".$login."</p>";


$queryS="SELECT a.produit as produit, v.titre as titre, a.date as date, v.description as desc, v.editeur as edi 
    From achat a, v_application v 
    WHERE a.acheteur='$login' AND a.produit=v.titre AND a.acheteur = a.destinataire";
$query=pg_query($idConnex,$queryS);

echo "<h2>Historique des achats</h2>";
echo "<ul>";
while($res=pg_fetch_array($query)){
    echo "<li>".$res['titre']." le ".$res['date']."</li>";
}
echo "</ul>";


$querySS="SELECT c.nom as nom, c.prenom as prenom, a.destinataire as dest, a.produit as produit, a.date as date, v.titre as titre, v.description as desc, v.editeur as edi
    From achat a, v_application v, client c
    WHERE a.acheteur='$login' AND a.produit=v.titre AND a.acheteur != a.destinataire AND a.destinataire = c.login";
$query=pg_query($idConnex,$querySS);

echo "<h2>Historique des cadeaux</h2>";
echo "<ul>";
while($res=pg_fetch_array($query)){
    echo "<li>".$res['titre']." pour ".$res['prenom']." ".$res['nom']." le ".$res['date']."</li>";
}
echo "</ul>";

$querySS="SELECT c.nom as nom, c.prenom as prenom, a.destinataire as dest, a.produit as produit, a.date as date, v.titre as titre, v.description as desc, v.editeur as edi 
    From achat a, v_application v, client c
    WHERE a.destinataire='$login' AND a.produit=v.titre AND a.acheteur != a.destinataire AND a.acheteur = c.login";
$query=pg_query($idConnex,$querySS);

echo "<h2>Historique des cadeaux reçus</h2>";
echo "<ul>";
while($res=pg_fetch_array($query)){
    echo "<li>".$res['titre']." de ".$res['prenom']." ".$res['nom']." le ".$res['date']."</li>";
}
echo "</ul>";
?>
    
    
    
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>
