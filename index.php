<html>
<?php include("base.php");?>

<?php // Personalisation de la page index si l'utilisateur est loggé
echo("<h1 align='center'> Bienvenue sur le NimpStore $login ! </h1>");
?>
    <p align='center'> Vous trouverez toute sorte d'application utile au quotidien ici !</p>
    
<div name='presentation' class="container">
<p><font color='red'> Brand new Apps' !</font></p>
<?php // défilé des 5 dernières applications ajoutée => serait plus pertinent de mettre les plus téléchargées quand dispo

$querystring="SELECT * FROM v_application va INNER JOIN editeur e ON va.editeur=e.id";
$query=pg_query($querystring);

$i=0;
for ($i=0;$i<5;$i++){
    $res=pg_fetch_array($query);
 if (!is_null($res)){  //création d'un objet app puis affichage
        $app = new application($res['titre'],$res['nom'],$res['prix']);
        $app->afficher();
 }
}

?>
</div>

<?php //    GESTION DES ERREURS DANS LE CAS OU IL Y A UN PROBLEME DE LOG !
if (isset($_GET['err']))
    if ($_GET['err'] == 1)
        echo("<p><font color='red'>Erreur de log</font></p>"); //Petite info au cas ou
?>

    
    
<?php include("scriptJS.php");?>
</body>
</html>