<html>
<?php include("base.php");?>
    
<?php
    $appName=$_POST["nom"];
    $querystring="SELECT prix FROM produit p WHERE p.titre='$appName'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    $prix1Mois=$res["prix"];
?>
<form action="abonnement.php" id="formAbonnement">
    
    <?php
    echo "<p>Abonnement à ".$appName;
    echo "<input type='hidden' id='prix1Mois' value='$prix1Mois'>";
    echo "<p> Durée de l'abonnement </p>";
    echo '<select name="nbMois" form="formAbonnement" id=aboCombo  onChange="updatePrix(this.value)">';
        $i=0;
        for($i=1;$i<=12;$i++)
            echo "<option value=".$i.">".$i." mois"."</option>"; 
    ?>
    </select>
    <p id="prix">Prix : </p>
    <input type="submit" name="aboSubmit" value="S'abonner">
    
</form>
    <script type="text/javascript">
    function updatePrix(cbValue){ // met à jour l'affichage du prix total en fonction du nombre de mois d'abonnement
        var prix=document.getElementById("prix1Mois").getAttribute("value");
        var prixTotal=prix*cbValue;
        document.getElementById("prix").innerHTML="Prix : "+prixTotal.toFixed(2);
        return;
    }
    </script>
<?php include("scriptJS.php");?>
</body>
</html>