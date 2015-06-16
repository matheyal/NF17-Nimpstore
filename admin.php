<html>
<?php include("base.php"); ?>

<?php
if(isset($_POST['carte_prepayee'])){
    $login = $_POST['login'];
    $montant = $_POST['montant'];
    $mois = $_POST['mois'];
    $annee = $_POST['annee'];

//Vérification de l'existence du login entré
    $querystring="SELECT login FROM client WHERE login='$login'";
    $query=pg_query($idConnex,$querystring);
    $res=pg_fetch_array($query);
    if (is_null($res['login'])){
        echo("<p align='center'><font color='red'>Login inexistant</font></p>");
    }
    else{
        $querystring="INSERT INTO carte_prepayee VALUES (nextval('seq_carte_prepayee'), $montant, $montant, '01-$mois-$annee', '$login')";
		$query=pg_query($idConnex,$querystring) or die("Erreur lors de l'insertion, contacter l'administrateur");
    	
		$querystring="SELECT MAX(numero) FROM carte_prepayee";
		$query = pg_query($idConnex, $querystring) or die("Erreur lors de l'insertion, contacter l'administrateur");
    	$res = pg_fetch_array($query);
    	$numero = $res['max'];
    	echo("<p align='center'>Carte prépayée n°".$numero." accordée avec succès</p>");
    }

}

if (isset($_POST['supprimer_compte'])){
	$login = $_POST['login'];
	if ($login == "admin"){
		$err_suppr_admin = 1;
	}
	else{

	//Vérification de l'existence du login entré
		$querystring="SELECT login FROM client WHERE login='$login'";
	    $query=pg_query($idConnex,$querystring);
	    $res=pg_fetch_array($query);
	    if (is_null($res['login'])){
	        echo("<p align='center'><font color='red'>Login inexistant</font></p>");
	    }
	    else{
	    	$querystring="DELETE FROM client WHERE login='$login'";
			$query=pg_query($idConnex,$querystring) or die("Erreur lors de la suppression, contacter l'administrateur");
	    	echo("<p align='center'>Compte client supprimé avec succès</p>");
	    }
	}

}

if (isset($_POST['add_droits_admin'])){
	$login = $_POST['login'];
	if ($login == "admin"){
		$err_suppr_admin = 1;
	}
	else{

	//Vérification de l'existence du login entré
		$querystring="SELECT login FROM client WHERE login='$login'";
	    $query=pg_query($idConnex,$querystring);
	    $res=pg_fetch_array($query);
	    if (is_null($res['login'])){
	        echo("<p align='center'><font color='red'>Login inexistant</font></p>");
	    }
	    else{
	    	$querystring="UPDATE client SET status='admin' WHERE login='$login'";
			$query=pg_query($idConnex,$querystring) or die("Erreur lors de l'ajout', contacter l'administrateur");
	    	echo("<p align='center'>$login est maintenant administrateur</p>");
	    }
	}
}
if (isset($_POST['deld_droits_admin'])){
	$login = $_POST['login'];
	if ($login == "admin"){
		$err_suppr_admin = 1;
	}
	else{

	//Vérification de l'existence du login entré
		$querystring="SELECT login FROM client WHERE login='$login'";
	    $query=pg_query($idConnex,$querystring);
	    $res=pg_fetch_array($query);
	    if (is_null($res['login'])){
	        echo("<p align='center'><font color='red'>Login inexistant</font></p>");
	    }
	    else{
	    	$querystring="UPDATE client SET status='client' WHERE login='$login'";
			$query=pg_query($idConnex,$querystring) or die("Erreur lors de l'ajout', contacter l'administrateur");
	    	echo("<p align='center'>$login n'est plus administrateur</p>");
	    }
	}
}
?>
<h1 align = "center">Administration Nimpstore</h1>
<h2>Ajouter une application au catalogue</h2>
<form method='POST' action='ajoutApplication.php'>
	Titre : <input type='text' name='titre' REQUIRED> <br/>
	Description : <input type='text' name='description' REQUIRED><br/>
	Editeur : 
	<select name="editeur" required>
    <option disabled>Editeur</option>
    <option disabled>──────────</option>
    <?php //options
        $querystring = "SELECT nom FROM editeur"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        while(!is_null($res['nom'])) { //Boucle for pour implémenter le bon nombre de choix
            $nom = $res['nom'];
            echo("<option> $nom ");
            $res = pg_fetch_array($query);
        }?>
     </select><br/>
     <p> <h5> Choix OS :</h5>

<?php	$querystring = "SELECT id,version FROM systeme_exploitation";
		$query = pg_query($idConnex,$querystring);
		

		while ($res = pg_fetch_array($query)) {
			echo("<input type=checkbox value='".$res['id']."' name='".$res['id']."''> ".$res['version']."<br/>");
		}

?>
</p>
     Prix: <input type='number' name='prix' min='0' value='0' step='0.01' REQUIRED> <br/>
	<input type='submit' value='Ajouter application'>
</form>

<!-- Suppression d'application du catalogue -->
<h2>Supprimer une application du catalogue</h2>
<form method='POST' action='suppressionApplication.php'>
<select name="titre" required>
    <option disabled>Titre de l'application</option>
    <option disabled>──────────</option>
    <?php //options
        $querystring = "SELECT titre FROM v_application"; //Query pour prendre les noms des éditeurs
        $query = pg_query($idConnex,$querystring);
        $res = pg_fetch_array($query) OR DIE ("BDD buggée !");

        while(!is_null($res['titre'])) { //Boucle for pour implémenter le bon nombre de choix
            $titre = $res['titre'];
            echo("<option> $titre </option>");
            $res = pg_fetch_array($query);
        }?>
     </select><br/>
     <input type='submit' value='Supprimer application'>
</form>

<!-- Ajout de carte prépayée -->
<h2>Accorder carte prépayée</h2>
<form method='POST' action='admin.php'>
    Login : <input type='text' name='login' REQUIRED> <br/>
    Montant : <input type='number' name='montant' min='0' value='0' REQUIRED> <br/>
    Date d'expiration :
    <!-- Combobox mois -->
	<select name='mois' id='mois' REQUIRED>
	    <option value='0' selected='selected' disabled="disabled">--</option>
	        <?php
	        for ($i = 1;$i <13; $i++)
	            echo("<option value='$i'>$i</option>");
	        ?>
	</select>

	<!-- Combobox année -->
	<select name='annee' id='annee' REQUIRED>
	    <option value='0' selected='selected' disabled="disabled">--</option>
	        <?php
	        $currentYear = 2015;
	        for ($i = $currentYear;$i < ($currentYear + 5); $i++)
	            echo("<option value='$i'>$i</option>");
	        ?>
	</select>
    <input type='submit' value='Valider' name='carte_prepayee'>
</form>

<!-- Supprimer le compte d'un client -->
<h2>Supprimer un compte</h2>
<p>Supprimer un compte utilisateur</p>
<?php
    if(isset($err_suppr_admin)){ //Tentative de suppression du compte admin
        	echo("<p><font color = 'red'>Impossible de supprimer le compte administrateur</font></p>");
    }
?>
<form method='POST' action='admin.php'>
    Login : <input type='text' name='login' REQUIRED> <br/>
    <input type='submit' value='Supprimer le compte' name='supprimer_compte'>
</form>

<!-- Ajout des droits admin -->
<h2>Gestion des droits administrateurs</h2>
<p>Accorder ou retirer des droits administrateurs à un utilisateur.</p>
<form method='POST' action='admin.php'>
    Login : <input type='text' name='login' REQUIRED> <br/>
    <input type='submit' value='Accorder' name='add_droits_admin'>
    <input type='submit' value='Retirer' name='del_droits_admin'>
</form>
<?php include("scriptJS.php");?>
</body>
</html>