<html>
<?php include("base.php");?>

<h1>Vos applications <?php echo $login; ?></h1>

<?php
if (isset($_GET['err']) && $_GET['err']==1) echo("<p><font color='red'>La note rentrée n'est pas comprise entre 0 et 5 !</font></p>");


$querystring="SELECT titre,editName,prix,commentaire,auteur FROM (SELECT titre,prix,editName FROM (((client c INNER JOIN produit_achete pa ON c.login=pa.proprietaire)R1
                            INNER JOIN v_application va ON R1.produit=va.titre) R2
                            INNER JOIN (SELECT nom AS editName,id FROM editeur e) AS e  ON e.id = R2.editeur ) R
                            WHERE R.login='$login') AS Rt   
                            LEFT JOIN avis a ON Rt.titre = a.app"; //Requete du turfu by LeLu #checkdisout
$query=pg_query($querystring);
$res=pg_fetch_array($query);

if (is_null($res['titre'])){
    echo "<p> Vous ne possédez pas encore d'application! Trouvez dès maintenant celle de vos rêves grâce à l'outil recherche !</p>";
}else{
    while(!is_null($res['titre'])){
      echo("<p>");
        $app = new application($res['titre'],$res['editname'],$res['prix']);
        $app->afficher();
        
        if(is_null($res['commentaire']) || $res['auteur'] != $login) 
            echo("<form method='POST' action='avis.php'>
                <input type='hidden' value='".$app->getTitre()."' name='appName'>
                Votre note sur 5 : <input type='text' name='note'> <br/>
                Votre commentaire sur l'application : <input type='text' name='com'><br/>
                <input type='submit' class='comButton' value='Envoyer votre avis'>
                </form></p>");


        else echo("<br/>Vous avez déjà déposé un avis sur cette app !</p>");
        $res = pg_fetch_array($query);
    }
}
?>

    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/ourFunction.js"></script> 
</body>
</html>