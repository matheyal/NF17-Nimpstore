<?php

function fLogin($login, $mdp){
// renvoie 2 si connection ADMIN, si si connection, 0 si echec
    try {
    $queryString="SELECT * FROM client c WHERE c.login=$login AND c.mdp=$mdp";
    $query=pg_query($queryString);
    $res=pg_fetch_array($query) or die("ECHEC : erreur SQL </br>");
    
    if $res['login']="admin"
        return 2;
    else if $res
        return 1;
    else
        throw new Exeption('Echec de la tentative de connection : login/mot de passe incorrect(s)');
    }
    catch(Exeption $e){
        echo $e->getMessage();
    }
}

function fSignIn($login,$nom,$prenom,$mdp){
    try {$queryString="SELECT * FROM client WHERE $login IN client.login";
    $query=pg_query($queryString) or die('Erreur SQL </br>');
    $res=pg_fetch_array($query);
    if $res['login']
        throw new Exeption('Echec de l\'inscription : login déjà utilisé');
    
    $queryString="SELECT * FROM client c WHERE c.nom=$nom AND c.prenom=$prenom";
    $query=pg_query($queryString) or die('Erreur SQL </br>');
    $res=pg_fetch_array($query);
    if $res['login']
        throw new Exeption('Echec de l\'inscription : utilisateur déjà enregistré');
    else
        $queryString="INSERT INTO client (login,nom,prenom,mdp) VALUES ($login,$nom,$prenom,$mdp)";
        $query=pg_query($queryString) or die('Erreur SQL : échec de l\insertion </br>');
        
    
    }//fin du bloc try
    catch(Exeption $e){
        echo $e->getMessage();
    }
    
    
}



?>