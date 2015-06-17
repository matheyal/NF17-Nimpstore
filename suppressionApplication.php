<html>
<?php
include("base.php");

$titre = $_POST['titre'];

$querystring = "SELECT titre from v_application where titre='$titre'";
$query = pg_query($idConnex, $querystring);
$res=pg_fetch_array($query);
if (is_null($res['titre'])){
    echo("<p align='center'><font color='red'>Application inexistante</font></p>");
}

$querystring = "DELETE FROM produit WHERE titre='$titre'";;
$query = pg_query($idConnex, $querystring)or die("Erreur lors de la suppression, contacter l'administrateur");
echo ("<p align='center'>Application supprimée avec succès</p>");

header('Location: admin.php');
?>

<?php include("scriptJS.php");?>
</body>
</html>