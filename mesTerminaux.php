<html>
<?php include("base.php");?>

<?php
if (isset($_POST['ajout'])){
    $num=$_POST['num_serie'];
    $modele=$_POST['modele'];
    
    $querystring="SELECT numero_serie FROM terminal t WHERE t.numero_serie='$num'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    if (!is_null($res['numero_serie'])){
    }
    else{
    
    $querystring="SELECT m.id as mid,os.id as osid FROM modele m INNER JOIN systeme_exploitation os ON m.os=os.id
                    WHERE m.designation='$modele'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    $mid=$res['mid'];
    
    $query=pg_query("INSERT INTO terminal VALUES ('$num','$mid','$login')")
            or die("erreur lors de l'insertion, contacter l'administrateur");

    header("Location:index.php");
    }
    
}
if (isset($_POST['suppression'])){
    $num=$_POST['modele_num'];
    
    $querystring="SELECT numero_serie FROM terminal t WHERE t.numero_serie='$num' AND t.proprietaire='$login'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    if (!is_null($res['numero_serie'])){        
        $query=pg_query("DELETE FROM terminal t WHERE t.numero_serie = '".$res['numero_serie']."'")
                or die("Erreur lors de la suppression, contacter l'administrateur");

        //header("Location:mesTerminaux.php");
    }
}
?>

<h1>Vos Terminaux <?php echo $login; ?></h1>

<?php 
$querystring="SELECT R1.numero_serie,m.designation,m.os FROM (client c INNER JOIN terminal t ON c.login=t.proprietaire)R1
                INNER JOIN modele m ON R1.modele=m.id
                WHERE R1.login='$login'";//Requete du turfu by LeLu #checkdisout
$query=pg_query($idConnex,$querystring);
$res=pg_fetch_array($query);

if (is_null($res['designation'])){
echo "<p>Vous n'avez pas encore renseigné d'informations concernant vos appareils! Vous pouvez le faire via le formulaire ci-dessous.</p>";
}else{
    while(!is_null($res['designation'])){
        echo "<p>Modèle : ".$res['designation']."</p>";
        echo "<p>N° Série : ".$res['numero_serie']."</p>";
        echo "</br>";
        /*$ter = new terminal($res['designation'],$res['os'],$res['numero_serie']); 
        $ter->afficher();*/
        $res=pg_fetch_array($query);
    }
}
?>

<h1>Ajouter un terminal</h1>
<p>Remplissez le formulaire ci-dessous pour ajouter un nouveau terminal. Vous pourrez ainsi télécharger et installer vos applications favorites sur celui-ci !</p>
<form method="post" action="mesTerminaux.php">
    <input type="text" name="num_serie" placeholder="N° Serie" required>
    <select name="modele" required>
    <option disabled>Modèle</option>
    <option disabled>──────────</option>
    <?php //options
        $querystring = "SELECT designation FROM modele"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        while(!is_null($res['designation'])) { //Boucle for pour implémenter le bon nombre de choix
            $nom = $res['designation'];
            echo("<option> $nom ");
            $res = pg_fetch_array($query);
        }?>
     </select>
    <input type="submit" value="Ajouter" name="ajout">
</form>

<h1>Supprimer un terminal</h1>
<form method="post" action="mesTerminaux.php">
    <select name="modele_num" required>
    <option disabled>Terminal</option>
    <option disabled>──────────</option>
    <?php //options
        $querystring="SELECT R1.numero_serie,m.designation FROM (client c INNER JOIN terminal t ON c.login=t.proprietaire)R1
                INNER JOIN modele m ON R1.modele=m.id
                WHERE R1.login='$login'"; //Query pour prendre les infos des terminaux
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        while(!is_null($res['designation'])) { //Boucle for pour implémenter le bon nombre de choix
            $nom = $res['designation'];
            echo("<option disabled> ".$res['designation']." : </option>");
            echo("<option>".$res['numero_serie']."</option>");
            $res = pg_fetch_array($query);
        }?>
     </select>
    <input type="submit" value="Supprimer" name="suppression">
</form>
    
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.localscroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/bootstrap.min.js"></script>  
</body>
</html>