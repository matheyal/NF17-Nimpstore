<html>
<?php
include("base.php");

$titre = $_POST['titre'];
$description = $_POST['description'];
$editeur = $_POST['editeur'];
$prix = $_POST['prix'];

//Récupération de l'id de l'éditeur à aprtir de son nom
$querystring = "SELECT id from editeur WHERE nom='$editeur'";
$query = pg_query($idConnex, $querystring);
$res = pg_fetch_array($query);
$id_editeur = $res['id'];

$querystring = "INSERT INTO produit VALUES ($1, $2, NULL, $3, $4)";
$query = pg_prepare($idConnex, "insert_query", $querystring);
$query = pg_execute($idConnex, "insert_query", array($titre, $description,$id_editeur,$prix));
//$query = pg_query($idConnex, $querystring) or die ("Erreur lors de l'insertion, contactez l'administrateur");

echo ("<p align='center'>Application ajoutée avec succès</p>");
header('Location: admin.php');
?>

<?php include("scriptJS.php");?>
</body>
</html>