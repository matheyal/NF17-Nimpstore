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
   <title>NimpStore</title>
   <meta charset='utf-8'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/css.css">
</head>
<body >
    
    
<?php // Personalisation de la page index si l'utilisateur est loggé
include("navbar.php");
include("idConnex.php");
require 'class/class.php';


try{ //récupération du nom de l'app par GET, test d'éventuels problèmes.
    $appName=$_GET["app"];
    if (is_null($appName))
        throw new Exception("Problème rencontré lors de l'affichage de l'application");
    
    else{
     $querystring="SELECT * FROM v_application va INNER JOIN editeur e ON va.editeur=e.id
                    WHERE va.titre='$appName'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
        
    //-----------------------AFFICHAGE DE L'APPLI----------------------------Un peu pourri pour l'instant
        ?>
    <img href="img/appDefault.png" alt="app cover" height='50' />
        <?php
        echo '<h1>'.$res["titre"].'</h1>';
        echo '<h3>'.$res["nom"].'</h3>';
    if (isset($login))
        echo "<form Method='POST' action='achat.php'> <input value='Achat' type='submit'><input name='nom' value='$appName' type='hidden'></form>";
    else
        echo "<p> Connectez vous pour pouvoir acheter cette application ! </p>";
        
        
        
        
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>