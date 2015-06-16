<?php


function fLogin($login, $mdp,$idConnex){
// renvoie 2 si connection ADMIN, 1 si connection, 0 si echec
    try {
    $queryString="SELECT * FROM client c WHERE c.login='$login' AND c.mdp='$mdp'";
    $query=pg_query($idConnex,$queryString);
    $res=pg_fetch_array($query) or die("ECHEC : erreur SQL </br>");
    
    if ($res['status']=='admin')
        return 2;
    else if (!is_null($res))
        return 1;
    else
        throw new Exception('Echec de la tentative de connection : login/mot de passe incorrect(s)');
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

}

function fSignIn($login,$nom,$prenom,$mdp,$idConnex){
    try {$queryString="SELECT * FROM client WHERE '$login' = client.login";
    $query=pg_query($idConnex,$queryString);
    $res=pg_fetch_array($query);
    if ($res['login'])
        throw new Exception('Echec de l\'inscription : login déjà utilisé');
    
    $queryString="SELECT * FROM client c WHERE c.nom='$nom' AND c.prenom='$prenom'";
    $query=pg_query($idConnex,$queryString);
    $res=pg_fetch_array($query);
    if ($res['login'])
        throw new Exception('Echec de l\'inscription : utilisateur déjà enregistré');
    else
        $queryString="INSERT INTO client (login,nom,prenom,mdp) VALUES ('$login','$nom','$prenom','$mdp')";
        $query=pg_query($idConnex,$queryString) or die('Erreur SQL : échec de l\insertion </br>');
        
    
    }//fin du bloc try
    catch(Exception $e){
        echo $e->getMessage();
        return 1; //1 signifie que l'inscription s'est mal passée
    }
   return 0; //Tout s'est bien passé
    
}
?>