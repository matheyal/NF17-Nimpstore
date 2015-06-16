<html>

<?php

include("base.php");

//Récupération de l'attribut en cas d'échec d'inscription
if (isset($_GET['err']))
    $err =  $_GET['err'];
else
    $err = NULL;
?>

<form Method='POST' action='redirectInscript.php'> <p>
        Nom : <input type='text' name='nom' REQUIRED AUTOFOCUS> <br/>
        Prenom : <input type='text' name='prenom' REQUIRED> <br/>
        Login : <input type='text' name='login' REQUIRED> <br/>
        Mot de Passe : <input type='password' name='pass' REQUIRED> <br/>
        <input value='Confirmer'type='submit'>
    </p></form>

<?php //Info en cas de problème
if ($err == 1) {
    echo("
    <p><font color='red'>Problème d'inscription, veuillez réessayer !</font></p>
    ");
}
?>

<?php include("scriptJS.php"); ?>
</body>
</html>