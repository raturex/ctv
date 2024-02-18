<?php
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


  if (isset($_SESSION["role"]) && ($_SESSION["role"] == 2 || $_SESSION["role"] == 5 || $_SESSION["role"] == 1)) {
    // Initialize the session
    //session_start();

?>

    <?php
    // Include config file
    include("api/db_connect.php");

    global $conn;
    // Definition des variables et initialisation avec une valeur vide
    $immatriculation = $marque = $proprietaire = $type_tech = $num_serie = $id_energie = $nb_place = $ptac = $puiss_fisc = $id_genre = $date_mise_circul = $date_local = "";
    $immatriculation_err = $marque_err = $proprietaire_err = $type_tech_err = $num_serie_err = $id_energie_err = $nb_place_err = $ptac_err = $puiss_fisc_err = $id_genre_err = $date_mise_circul_err = $date_local_err = "";


    // Traitement des données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Validate immatriculation
      if (empty(trim($_POST["immatriculation"]))) {
        $immatriculation_err = "Entrez l'immatriculation.";
      } else {
        // Prepare a select statement
        $sql = "SELECT id FROM vehicule WHERE immatriculation = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_immatriculation);

          // Set parameters
          $param_immatriculation = trim($_POST["immatriculation"]);

          // Attempt to execute the prepared statement
          if (mysqli_stmt_execute($stmt)) {
            /* store result */
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
              $immatriculation_err = "Cette voiture est deja enregistré";
            } else {
              $immatriculation = trim($_POST["immatriculation"]);
            }
          } else {
            echo "Oops! Quelque chose ne va pas veuillez réessayer.";
          }

          // Close statement
          mysqli_stmt_close($stmt);
        }
      }
      /*
    // Validate nom
    if(empty(trim($_POST["nom"]))){
        $nom_err = "Entrez votre nom.";
    } else{
            $nom = trim($_POST["nom"]);
            // Set parameters
            $param_nom = trim($_POST["nom"]);
    }

    // Validate prenom
    if(empty(trim($_POST["prenoms"]))){
        $prenoms_err = "Entrez vos prenoms.";
    } else{
            $prenoms = trim($_POST["prenoms"]);
            // Set parameters
            $param_prenoms = trim($_POST["prenoms"]);
    }

    // Validate station
    if(empty(trim($_POST["station"]))){
        $station_err = "Selectionnez votre station.";
    } else{
            $station = trim($_POST["station"]);
            // Set parameters
            $param_station = trim($_POST["station"]);
    }

    // Validate role
    if(empty(trim($_POST["role"]))){
        $role_err = "Selectionnez votre role.";
    } else {
        $role = trim($_POST["role"]);
        // Set parameters
        $param_role = trim($_POST["role"]);
    }

    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer un mot de passe.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer le mot de passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Veuillez entrer le meme mot de passe.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($nom_err) && empty($prenoms_err) && empty($station_err) && empty($role_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password, nom, prenoms, role, id_station) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssii", $param_username, $param_password, $param_nom, $param_prenoms, $param_role, $param_station);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_nom = $nom;
            $param_prenoms = $prenoms;
            $param_role = $role;
            $param_station = $station;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later. 22";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    */
      // Close connection
      mysqli_close($conn);
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ACTIA SA</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- JQVMap -->
      <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
      <!-- summernote -->
      <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
      <!-- bs-stepper -->
      <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    </head>


    <body class="hold-transition sidebar-mini layout-fixed">

      <div class="wrapper">

        <?php
        // Include config file
        include("nav_bar.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Contrôle technique</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Visite technique</a></li>
                    <li class="breadcrumb-item active">Enregistrement véhicule</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">


              <div class="card">

                <div class="card-header">

                  <h4>
                    <p> Client</p>
                  </h4>

                </div>

                <form name="nClient">
                  <div class="card-body">

                    <!-- form start -->
                    <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- Détail fiscal -->

                        <div class="card-body">

                          <div class="form-group">
                            <label for="inputPid">Pièce d'identité</label>
                            <input type="text" name="id_pid" class="form-control" id="inputPid" placeholder="P id" disabled value="<?php
                                                                                                                                    echo $_GET['id_pid'];
                                                                                                                                    ?>">

                            <input type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php
                                                                                                                                      echo $_GET['id_client'];
                                                                                                                                      ?>">

                          </div>

                          <div class="form-group">
                            <label for="inputNom_client">Nom</label>
                            <input type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom" disabled value="<?php
                                                                                                                                              echo $_GET['nom_client'];
                                                                                                                                              ?>">
                          </div>
                        </div>

                        <!-- /.Détail fiscal -->
                      </div>


                      <div class="col-sm-6">
                        <!-- Info véhicule -->

                        <div class="card-body">

                          <div class="form-group">
                            <label for="inputNumPiece">Numéro de la pièce</label>
                            <input type="text" class="form-control" id="inputNumPiece" name="num_piece_client" placeholder="numero de la pièce" disabled value="<?php
                                                                                                                                                                echo $_GET['num_piece_client'];
                                                                                                                                                                ?>">
                          </div>

                          <div class="form-group">
                            <label for="inputPnom_client">Prénoms</label>
                            <input type="text" class="form-control" id="inputPnom_client" name="prenom_client" placeholder="Prénoms" disabled value="<?php
                                                                                                                                                      echo $_GET['prenom_client'];
                                                                                                                                                      ?>">
                          </div>

                        </div>

                        <!-- /.Info véhicule -->
                      </div>
                    </div>

                    <!-- /.form start -->
                  </div>

                </form>

              </div>



              <div class="card">

                <div class="card-header">
                  <h4>
                    <p> Véhicule</p>
                  </h4>
                </div>

                <form name="nVehicule" action="insert_vehic.php" method="post">
                  <div class="card-body">

                    <!-- form start -->
                    <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->


                    <div class="row">
                      <div class="col-sm-6">
                        <!-- Détail fiscal -->

                        <div class="form-group">
                          <div class="row">

                            <div class="form-check">
                              <div class="col-sm-6">
                                <input class="form-check-input" type="radio" name="id_genre" value=1 onchange=CalculVignette()>
                                <label class="form-check-label">Transport de marchandise</label>
                              </div>
                            </div>

                            <div class="form-check">
                              <div class="col-sm-6">
                                <input class="form-check-input" type="radio" name="id_genre" value=2 onchange=CalculVignette()>
                                <label class="form-check-label">Transport de personne</label>
                              </div>
                            </div>

                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputPuisFiscal">Puissance fiscale</label>
                          <input type="number" class="form-control" id="inputPuisFiscal" name="puiss_fisc" placeholder="Puissance Fiscale" step=1 min=0 onchange=CalculVignette() onkeyup=CalculVignette()>
                        </div>

                        <div class="form-group">
                          <label for="inputEnergie">Energie</label>
                          <select class="form-control" name="id_energie" id="inputEnergie">

                            <?php include("api/db_connect.php");

                            //requête
                            $sql = "SELECT * FROM energie";
                            // On prépare la requête
                            $request = $db_PDO->prepare($sql);
                            // On exécute la requête
                            $request->execute();
                            // On stocke le résultat dans un tableau associatif
                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $energie) { ?>
                              <option value="<?php echo $energie['id'] ?>"> <?= $energie['lib'] ?> </option>
                            <?php }  ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="inputDateMC">Date de 1ere mise en circulation</label>
                          <div class="row">
                            <div class="col-sm-6">
                              <input onchange=CalculVignette() onkeyup=CalculVignette() type="date" class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                            </div>
                            <div class="col-sm-6">
                              <h5>
                                <p id="anneeMC"></p>
                              </h5>

                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputPTAC">PTAC</label>
                          <input onchange=CalculVignette() type="number" class="form-control" id="inputPTAC" name="ptac" placeholder="Poids Total à charge" onkeyup=CalculVignette() onchange=CalculVignette() step=1 min=0>
                        </div>

                        <div class="form-group">
                          <label for="inputPA">Place assise</label>
                          <input onchange=CalculVignette() type="number" class="form-control" id="inputPA" name="nb_place" placeholder="Place Assise" onkeyup=CalculVignette() step=1 min=0>
                        </div>

                        <div class="form-group">
                          <label for="inputCateg">Catégorie</label>
                          <input onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup=CalculVignette() step=1 min=0 disabled>
                          <input onchange=CalculVignette() type="hidden" class="form-control" id="id_categ" name="id_categ" placeholder="id_categ" onkeyup=CalculVignette()>
                        </div>


                        <p id="CalVignette"></p>


                        <!-- /.Détail fiscal -->
                      </div>



                      <div class="col-sm-6">
                        <!-- Info véhicule -->

                        <div class="form-group">
                          <label for="inputImmatriculation">Immatriculation</label>
                          <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->

                          <input type="text" name="immatriculation" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $immatriculation; ?>">
                          <span class="invalid-feedback"><?php echo $immatriculation_err; ?></span>

                        </div>


                        <div class="form-group">
                          <label for="inputProprietaire">Proprietaire</label>
                          <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule">
                        </div>

                        <div class="form-group">
                          <label for="inputMarque">Marque du véhicule</label>
                          <input type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule">
                        </div>

                        <div class="form-group">
                          <label for="inputTypeTech">Type technique</label>
                          <input type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique">
                        </div>

                        <div class="form-group">
                          <label for="inputSerie">Numéro de série</label>
                          <input type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série">
                        </div>

                        <div class="form-group">
                          <label for="inputMiseCircu">Date immatriculation</label>
                          <input type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA">
                        </div>

                        <!-- /.Info véhicule -->
                      </div>
                    </div>

                    <input type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php
                                                                                                                              echo $_GET['id_client'];
                                                                                                                              ?>">

                    <input type="hidden" class="form-control" id="id_ctrl" name="id_ctrl" placeholder="id_ctrl" value="1">
                    <input type="hidden" class="form-control" id="action" name="action" value="1">
                    <input type="hidden" class="form-control" id="etat_fact" name="etat_fact" value="1">

                    <input type="hidden" class="form-control" id="prix_visite" name="prix_visite" value="">
                    <input type="hidden" class="form-control" id="prix_vignette" name="prix_vignette" value="">

                    <input type="hidden" class="form-control" id="age_vehic" name="age_vehic" value="">



                    <!-- /.form start -->
                  </div>
                  <div class="card-footer">
                    <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer véhicule</button>
                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                  </div>
                </form>


              </div>
            </div>
          </section>

        </div>

        <?php
        // Include config file
        include("footer.php");
        ?>

      </div>


      <script>
        function dateDiff(date1, date2) {
          var diff = {} // Initialisation du retour
          var tmp = date2 - date1;

          tmp = Math.floor(tmp / 1000); // Nombre de secondes entre les 2 dates
          diff.sec = tmp % 60; // Extraction du nombre de secondes

          tmp = Math.floor((tmp - diff.sec) / 60); // Nombre de minutes (partie entière)
          diff.min = tmp % 60; // Extraction du nombre de minutes

          tmp = Math.floor((tmp - diff.min) / 60); // Nombre d'heures (entières)
          diff.hour = tmp % 24; // Extraction du nombre d'heures

          tmp = Math.floor((tmp - diff.hour) / 24); // Nombre de jours restants
          diff.day = tmp % 365;

          tmp = Math.floor((tmp - diff.day) / 365); // Nombre d'année restants
          diff.year = tmp;

          //3,154e+10
          return diff;
        }
      </script>

      <script>
        function CalculVignette() {

          var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
          var type
          var rad = document.nVehicule.id_genre;
          var prev = null;

          var dateMC = Date.parse(document.getElementById("inputDateMC").value);
          var now = Date.now();

          var diff = dateDiff(dateMC, now);
          var ageVehic = diff.year + 1;
          document.getElementById("anneeMC").innerHTML = +ageVehic + " ans";

          document.getElementById("age_vehic").value = ageVehic;

          puisFisc = document.getElementById("inputPuisFiscal").value;
          ptac = document.getElementById("inputPTAC").value;
          pA = document.getElementById("inputPA").value;


          //Type transport de marchandise
          if (rad.value == 1) {
            document.getElementById("inputPA").value = 0;
            document.getElementById("inputPA").disabled = true;
            document.getElementById("inputPTAC").disabled = false;

            if (ptac == 0) {
              if (puisFisc == 0) {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que son PTAC";
                // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
              } else {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir le PTAC du véhicule";
              }
            } else if (ptac > 0 && ptac <= 3.5) {
              if (puisFisc == 0) {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule";
              } else if (puisFisc > 0 && puisFisc <= 7) {
                categ = "TP01";
                id_categ = 5;
                prixVisite = 13100;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

              } else if (puisFisc > 7) {
                categ = "TP02";
                id_categ = 6;
                prixVisite = 15500;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

              }
            } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
              categ = "TP03";
              id_categ = 7;
              prixVisite = 18000;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;

            } else if (ptac > 10 && puisFisc > 0) {
              categ = "TP04";
              id_categ = 8;
              prixVisite = 20450;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;
            }

          } //Type transport de personne
          else if (rad.value == 2) {
            document.getElementById("inputPA").disabled = false;
            document.getElementById("inputPTAC").value = 0;
            document.getElementById("inputPTAC").disabled = true;
            document.getElementById("CalVignette").innerHTML = rad.value;

            if (pA == 0) {
              if (puisFisc == 0) {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que le nombre de place";
                // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
              } else {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir le nombre de place du véhicule";

              }

            } else if (pA > 0 && pA <= 9) {
              if (puisFisc == 0) {
                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule";

              } else if (puisFisc > 0 && puisFisc <= 7) {
                categ = "VL01";
                id_categ = 1;
                prixVisite = 13100;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;


              } else if (puisFisc > 7) {
                categ = "VL02";
                id_categ = 2;
                prixVisite = 15500;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;


              }
            } else if (pA > 9 && puisFisc <= 7) {
              document.getElementById("CalVignette").innerHTML = "Veuillez ajuster la puissance fiscale du véhicule";

            } else if (pA > 9 && pA <= 25 && puisFisc > 7) {
              categ = "PL01";
              id_categ = 3;
              prixVisite = 18000;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;


            } else if (pA > 25 && puisFisc > 7) {
              categ = "PL02";
              id_categ = 4;
              prixVisite = 20450;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;


            }
          }

          if (ageVehic > 0 && ageVehic <= 4) {

            if (puisFisc >= 2 && puisFisc <= 4) {
              prixVignette = 19000;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
              prixVignette = 35000;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
              prixVignette = 49000;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
              prixVignette = 96000;

            }

          } else if (ageVehic > 4 && ageVehic <= 10) {

            if (puisFisc >= 2 && puisFisc <= 4) {
              prixVignette = 14250;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
              prixVignette = 26250;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
              prixVignette = 36750;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
              prixVignette = 72000;
            }

          } else if (ageVehic > 11) {

            if (puisFisc >= 2 && puisFisc <= 4) {
              prixVignette = 13500;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
              prixVignette = 25000;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
              prixVignette = 30000;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
              prixVignette = 40000;

            }
          }

          document.getElementById("CalVignette").innerHTML = "Visite Technique: " + prixVisite + " F CFA  //  Vignette: " + prixVignette + " F CFA";
          document.getElementById("prix_visite").value = prixVisite;
          document.getElementById("prix_vignette").value = prixVignette;

        }
      </script>


      <!-- jQuery -->
      <script src="plugins/jquery/jquery.min.js"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
        $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- ChartJS -->
      <script src="plugins/chart.js/Chart.min.js"></script>
      <!-- Sparkline -->
      <script src="plugins/sparklines/sparkline.js"></script>
      <!-- JQVMap -->
      <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
      <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
      <!-- jQuery Knob Chart -->
      <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
      <!-- daterangepicker -->
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.js"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- Summernote -->
      <script src="plugins/summernote/summernote-bs4.min.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/adminlte.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js"></script>
      <!-- overlayScrollbars -->
      <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
      <!-- bs-stepper -->
      <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>

      <!-- jquery-validation -->
      <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
      <script src="plugins/jquery-validation/additional-methods.min.js"></script>



    </body>

    </html>

<?php
  } else {
    header('Location: restriction.php');
  }
}
?>