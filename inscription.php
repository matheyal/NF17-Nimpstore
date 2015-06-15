<?php session_start();
if (isset($_SESSION['login']))
    $login=$_SESSION['login'];
else{
    session_destroy();
    $login=NULL;
}
?>
<?php //Récupération de l'attribut en cas d'échec d'inscription
if (isset($_GET['err']))
    $err =  $_GET['err'];
else
    $err = NULL;
?>
<html>
<head>
    <title>Inscription</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
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
</body>
</html>