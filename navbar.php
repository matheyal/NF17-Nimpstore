

    <!-- NAVBAR -->
   <?php echo '<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Nimpstore</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form method="GET" class="navbar-form navbar-left" role="search" action="result.php">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="recherche">   <!-- RECHERCHE -->
        </div>
        <button type="submit" class="btn btn-default">Rechercher</button>
      </form>
      <ul class="nav navbar-nav navbar-right">' ?>
        <?php
        if (is_null($login)){
          echo '<button type="button" class="btn btn-default navbar-btn" onclick="self.location.href=\'inscription.php\'">S\'inscrire</button>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Connection<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <form method="post" action="connection.php">
                  <label for="inputLogin" class="sr-only">Login</label> <!-- permet d ecrire login sans mettre de valeur par defaut -->
                  <li><input type="text" name="login" placeholder="Login" REQUIRED AUTOFOCUS></li> <!-- Empeche les champs vides + autofocus -->
                  <label for="inputPassword" class="sr-only">Password</label>
                  <li><input type="password" name="pass" placeholder="Password" REQUIRED></li>
                  <li><input type="submit" name="submitLog" value="Connection" ></li>
                        </form>
                </ul>
                </li>';
          } //DEFINIR ACTION ONCLICK pour le bouton s'inscrire
        else{    // on affiche soit le bouton s'inscrire + connection, soit les options profil selon si l'utilisateur est connecté
            echo '<li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$_SESSION['login'].'<span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="mesApplications.php">Mes Applications</a></li>
                        <li><a href="mesTerminaux.php">Mes Terminaux</a></li>';
            if(isset($admin) && !is_null($admin))
              echo '<li><a href="admin.php">Vue administrateur</a></li>';
            echo '<li class="divider"></li>
                  <li><a href="#" onclick="self.location.href=\'deco.php\'" >Déconnection</a></li>
                  </ul>
                  </li>';
          }
          ?>
         
          
          
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
 <!-- FIN DE LA NAVBAR -->