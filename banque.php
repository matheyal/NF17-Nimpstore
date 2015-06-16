<html>

<?php
session_start();
include("idConnex.php");
$login = $_SESSION['login'];
$appName = $_POST['appName'];
$achat = false;

    /* Dans le cas où l'on demande à offrir à un ami, on vérifie que l'ami en question n'a pas déjà l'application */

if (isset($_POST['loginFriend'])) {
    $loginFriend = $_POST['loginFriend'];
    $queryString = "SELECT id FROM produit_achete pa WHERE proprietaire='$loginFriend' AND produit='$appName'";
    $query = pg_query($idConnex, $queryString);
    $res = pg_fetch_array($query);

    if (!is_null($res['id'])) {
        $_SESSION['applicationRejetee'] = $appName;
        $err = 1;
        header("Location: achat.php?err=$err");
    }
}
if (!isset($err)) {
    /* On Check la façon de payer de la personne */

    $num = $_POST['num'];
    $moisValid = $_POST['mois'];
    $anneeValid = $_POST['annee'];

    /* Construction du string pour la date de validité */

    if ($moisValid < 10)
        $dateValid = $anneeValid . "-0" . $moisValid . "-01";
    else
        $dateValid = $anneeValid . "-" . $moisValid . "-01";

    /* Fin Construction */

    if (isset($_POST['crpt'])) { // Nous sommes dans le cas où il a payé par CB

        /* On décharge les bonnes variables en conséquences */

        $crypto = $_POST['crpt'];

        /* Vérification de l'utilisateur à la base de donnée */

        $queryString = "SELECT id FROM carte_bancaire cb WHERE cb.numero_carte='$num' AND cb.date_fin_validite='$dateValid' AND cb.cryptogramme='$crypto' ";
        $query = pg_query($idConnex, $queryString);
        $res = pg_fetch_array($query);

        if (!is_null($res['id'])) {//Résultat

            echo("
        <p> PAIMENT ACCEPTE </p>
        ");
            $achat = true;
        } else
            echo("
        <p> PAIMENT REFUSE </p>
        ");
    } else {  // Nous sommes dans le cas où il a payé par Carte Prépayée

        $queryString = "SELECT numero,montant_courant AS solde FROM carte_prepayee cp WHERE cp.numero='$num' AND cp.date_expiration='$dateValid' AND cp.client='$login' ";
        $query = pg_query($idConnex, $queryString);
        $res = pg_fetch_array($query);

        $queryString = "SELECT prix FROM produit p WHERE p.titre='$appName'";
        $query = pg_query($idConnex, $queryString);
        $res2 = pg_fetch_array($query);

        if (!is_null($res['numero'])) {//Résultat
            $num = $res['numero'];
            if (($newSolde = ($res['solde'] - $res2['prix'])) > 0) {
                echo("$newSolde");
                $achat = true;

                // Déduction du solde sur la carte prépayee

                $queryString = "UPDATE carte_prepayee SET montant_courant=$newSolde WHERE numero ='$num' ";
                $query = pg_query($idConnex, $queryString);

                // Affichage de la réponse

                echo("
        <p> PAIMENT ACCEPTE </p>
        ");

            } else

                echo("
        <p> PAIMENT REFUSE </p>
        ");


        } else
            echo("
        <p> PAIMENT REFUSE </p>
        ");
    }


    if ($achat) {

        if (isset($_POST['loginFriend']))
            $login = $_POST['loginFriend'];
        $queryString = "INSERT INTO produit_achete VALUES (nextval('seq_produit_achete'),'$appName','$login') ";
        $query = pg_query($idConnex, $queryString);

        header("refresh : 2; mesApplications.php");
    }
}
?>

</html>