<html>
<?php include("base.php"); ?>
    
    
<?php // Personalisation de la page index si l'utilisateur est loggé

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
   <div align="center">
    <img src="img/appDefault.png" alt="app cover" height='50'/>
   </div>
        <?php
        $editorName = $res['nom'];
        $editorContact = $res['contact'];
        $editorSite = $res['url'];
        $description = $res['description'];

        echo("
                <div align='center'>
                <h2> $appName </h2>
                <p> Nom de l'éditeur de l'application : $editorName
                <p>$editorContact</p>
                <p>$editorSite</p>
                </p>
                <p>$description</p>");
        
        $querystring1= "SELECT abonnement FROM produit p WHERE p.titre='$appName'";
        $query1= pg_query($idConnex, $querystring1);
        $res = pg_fetch_array($query1);
        $abo=$res["abonnement"]; // Si l'application fonctionne pas abonnement (boolean)
        

        $queryString = "SELECT id, abonnement, nb_mois
                        FROM (((produit_achete pa INNER JOIN produit p ON pa.produit=p.titre)R1
                            INNER JOIN (SELECT ac.id as Aid, ac.produit as ACproduit FROM achat ac)A1 ON R1.titre=A1.ACproduit)R2
                            INNER JOIN abonnement ab ON R2.Aid=ab.achat)
                        WHERE proprietaire='$login' AND produit='$appName';";
        $query = pg_query($idConnex, $queryString);
        $res = pg_fetch_array($query);

        /*Test pour savoir quoi afficher à l'utilisateur en fonction de la connection et de l'achat*/
    $bought=$res["id"];
        
    if (isset($login)){
        if ($abo=='true'){ // appli par abonnement
            if (!is_null($bought)){
                echo "<p>Vous êtes déjà abonné à cette application</p>";
            }else{
                echo "<p>Cette application requiert un abonnement</p>";
            }
                echo("<form Method='POST' action='abonnement.php'>
                      <input type='submit' value=".((!$bought)?'Abonnement':'Prolonger')." >
                      <input name='nom' value='$appName' type='hidden'></form></div>");
        
        }else{ // appli par achat
            if (!is_null($bought)) {
                echo("<p>Vous possédez cette application ! Vous pouvez l'offrir à un ami !</p>");
                $_SESSION['alreadyBought'] = 1;
                    echo("<form Method='POST' action='achat.php'> <input value='Achat pour un ami !' type='submit'>
                    <input name='nom' value='$appName' type='hidden'></form></div>");
            }
        else {
            $_SESSION['alreadyBought'] = 0;
                echo("<form Method='POST' action='achat.php'> <input value='Achat' type='submit'>
                <input name='nom' value='$appName' type='hidden'></form></div>");
        // on affiche un bouton différent selon si l'appli s'achète ou nécessite un abonnement
        }}
    }else{
    echo("<p> Connectez-vous pour pouvoir vous procurer cette applicaiton !</p>");
    }

        /* Insertion de la partie avis */

        // Interogation de la BDD

        $queryString = "
SELECT commentaire AS com,note AS mark, auteur ,app AS appli, moy
FROM avis a ,
  (SELECT AVG(note) AS moy,app AS appl
  FROM avis
  WHERE app='$appName'
  GROUP BY(appl)) AS R2
WHERE a.app='$appName'"; // #MEGAREQUETEDUTURFU!!!
        $query = pg_query($idConnex, $queryString);
        $res = pg_fetch_array($query);


if (!is_null($res['com'])) {
        $moy = round($res['moy'],1);
        echo("<div class='avisContainer'><div class='note' align='center'> Note Moyenne de l'application : ".$moy." / 5 </div><br/><br/>");

        while (!is_null($res['mark'])) {
            echo("<p align='center'>--------------</p><br/><div class='singleAvisDisplay' align='center'><p>Note délivrée par ".$res['auteur']." : ".$res['mark']."</p><p>Commentaire : ".$res['com']."</p></div> ");
            $res = pg_fetch_array($query);
        }
    }
        else {
            echo("<p align='center'>Aucun avis déposé pour cette application !</p>");
        }

        
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