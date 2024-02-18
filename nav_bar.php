<?php

/*
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

  require_once('api/db_connect.php');

  $sql = 'select * from role where role.id= $_SESSION["role"]';

  require_once("api/db_connect.php");
  //requête
  $sql = "SELECT * FROM role where role.id='" . $_SESSION["role"] . "'";
  // On prépare la requête
  $request = $db_PDO->prepare($sql);
  $request = $db_PDO->query($sql);
  // On exécute la requête
  $request->execute();
  // On stocke le résultat dans un tableau associatif
  $reset = $request->fetch();

  $nom_role = $reset["lib"];
  */



if ($_SESSION["role"] == 1) {
?>

 <!-- Preloader -->
 <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!--
          <li class="nav-item">
            <a href="nclient.php" class="nav-link">
              <p>Contrôle technique</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="comptabilite.php" class="nav-link">
              <p>Comptabilité</p>
            </a>
          </li>
          Nonauthorisé -->

          <li class="nav-item">
            <a href="statistiques.php" class="nav-link">
              <p>Statistiques</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <p>Aministration
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="gest_defauts.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des Défauts</p>
                </a>
              </li>

              <li class="nav-item"> 
                <a href="gest_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des utilisateurs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_vehicule.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des véhicules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_station.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des Station</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_service.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des Service</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="mes_stats.php" class="nav-link">
              <p>Mes statistiques</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<?php
} else if ($_SESSION["role"] == 2) {
  //////////////// OPERATEUR DE SAISIE////////////////////////////////////
?>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>

    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <p>Accueil</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="client.php" class="nav-link">
              <p>Identification</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<?php
} else if ($_SESSION["role"] == 3) {
?>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>
    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>



      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="nclient.php" class="nav-link">
              <p>Contrôle technique</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="comptabilite.php" class="nav-link">
              <p>Comptabilité</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="statistiques.php" class="nav-link">
              <p>Statistiques</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <p>Aministration
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="gest_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des observations</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="gest_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des utilisateurs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_vehicule.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des véhicules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_station.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des Station</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gest_service.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestion des Service</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="mes_stats.php" class="nav-link">
              <p>Mes statistiques</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


<?php
} else if ($_SESSION["role"] == 4) {
?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>

    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <p>Accueil</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="controle_cours.php" class="nav-link">
              <p>Contrôle technique</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


<?php
} else if ($_SESSION["role"] == 5) {
?>
 <!-- Preloader -->
 <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>
      

    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <p>Accueil</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="client.php" class="nav-link">
              <p>Nouvel Enregistrement</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pre_enreg.php" class="nav-link">
              <p>Caisse</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<?php
} else if ($_SESSION["role"] == 6 || $_SESSION["role"] == 7) {
?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../img/actiaIconxhdpi.png" alt="Actia Icon" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>

    </ul>


  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!--  
      <img src="img/ActiaLogo.png" alt="Actia SA Logo" class="brand-image img-square elevation-4" style="opacity: .9">
      -->
      <span class="brand-text font-weight-light">Actia SA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-sm-9">
          <div class="row">
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $_SESSION["prenoms"] . " " . $_SESSION["nom"]; ?>
              </a>
            </div>
            <br>
            <div class="info">
              <a href="#" class="d-block">
                <?php echo $nom_role; ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        -->
      <!-- /.SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <p>Accueil</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="controle_termine.php" class="nav-link">
              <p>Edition</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="re_edition.php" class="nav-link">
              <p>Re-edition</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <p> Se déconnecter</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


<?php
}
?>