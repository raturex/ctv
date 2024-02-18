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


if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 2 || $_SESSION["role"] == 5 || $_SESSION["role"] == 1) ) {
    // Initialize the session
//session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Advanced form elements</title>

  

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

    <!-- Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Advanced Form</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Advanced Form</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- /.row -->

          <div class="row">

            <div class="col-md-12">

              <div class="card card-primary ">
                <div class="card-header">
                  <h3 class="card-title">Information du client</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->

                <!-- Table -->
                <div class="card-body">
                  <form name="nClient">
                    <div class="card-body">

                      <!-- form start -->
                      <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                      <div class="row">
                        <div class="col-sm-6">
                          <!-- Détail fiscal -->
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
                          <!-- /.Détail fiscal -->
                        </div>


                        <div class="col-sm-6">
                          <!-- Info véhicule -->
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
                          <!-- /.Info véhicule -->
                        </div>

                      </div>

                      <!-- /.form start -->
                    </div>

                  </form>

                </div>
                <!-- /.card-body -->
              </div>
            </div>

            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Nouveau contrôle technique</h3>
                </div>

                <div class="card-body p-0">
                  <div class="bs-stepper linear" id="bs_step">
                    <div class="bs-stepper-header" role="tablist">
                      <!-- your steps here -->
                      <div class="step" data-target="#logins-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                          <span class="bs-stepper-circle">1</span>
                          <span class="bs-stepper-label">Véhicule</span>
                        </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                          <span class="bs-stepper-circle">2</span>
                          <span class="bs-stepper-label">Vignette</span>
                        </button>
                      </div>
                    </div>

                    <div class="bs-stepper-content">
                      <!-- your steps content here -->
                      <form name="nVehicule" action="insert_vehic.php" method="get">

                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                          <div class="row">
                            <div class="col-sm-6">
                              <!-- Détail fiscal -->

                              <div class="form-group">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="id_genre" value=1 onchange=CalculVignette()>
                                      <label class="form-check-label">Transport de marchandise</label>
                                    </div>
                                  </div>

                                  <div class="col-sm-6">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="id_genre" value=2 onchange=CalculVignette()>
                                      <label class="form-check-label">Transport de personne</label>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputPuisFiscal">Puissance fiscale</label>
                                    <input type="number" class="form-control" id="inputPuisFiscal" name="puiss_fisc" placeholder="Puissance Fiscale" step=1 min=0 onchange=CalculVignette() onkeyup=CalculVignette()>
                                  </div>
                                </div>

                                <div class="col-sm-6">
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
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                    <input onchange=CalculVignette() onkeyup=CalculVignette() type="date" class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputMiseCircu">Date immatriculation</label>
                                    <input type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA">
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <h5>
                                    <p id="anneeMC"> année</p>
                                  </h5>
                                </div>
                              </div>

                              <div class="row">

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputPTAC">PTAC</label>
                                    <input onchange=CalculVignette() type="number" class="form-control" id="inputPTAC" name="ptac" placeholder="Poids Total à charge" onkeyup=CalculVignette()  step=0.1 min=0>
                                  </div>
                                </div>

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputPA">Place assise</label>
                                    <input onchange=CalculVignette() type="number" class="form-control" id="inputPA" name="nb_place" placeholder="Place Assise" onkeyup=CalculVignette() step=1 min=0>
                                  </div>

                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputCateg">Catégorie</label>
                                <input onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup=CalculVignette() step=1 min=0 disabled>
                                <input onchange=CalculVignette() type="hidden" class="form-control" id="id_categ" name="id_categ" placeholder="id_categ" onkeyup=CalculVignette()>
                              </div>

                              <div>
                                <p id="CalVignette" name="CalVignette"> v/v</p>
                              </div>

                            </div><!-- /.Détail fiscal -->


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

                                let dateMC = Date.parse(document.getElementById("inputDateMC").value);
                                var now = Date.now();

                                var diff = dateDiff(dateMC, now);

                                var ageVehic = diff.year + 1;
                                document.getElementById("anneeMC").innerHTML = pA + " ans";

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

                                document.getElementById("CalVignette").innerHTML = "Visite Technique: " + prixVisite + " F CFA  //  Vignette: " + prixVignette + " F CFA";
                               
                              }
                            </script>




                            <div class="col-sm-6">
                              <!-- Info véhicule -->

                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputImmatriculation">Immatriculation</label>
                                    <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                    <input type="text" name="immatriculation" class="form-control " value="">
                                    <span class="invalid-feedback"><?php echo $immatriculation_err; ?></span>
                                  </div>
                                </div>


                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputSerie">Numéro de série</label>
                                    <input type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série">
                                  </div>
                                </div>

                              </div>

                              <div class="form-group">
                                <label for="inputProprietaire">Proprietaire</label>
                                <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule">
                              </div>

                              <div class="row">

                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputMarque">Marque du véhicule</label>
                                    <input type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule">
                                  </div>
                                </div>


                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="inputTypeTech">Type technique</label>
                                    <input type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique">
                                  </div>
                                </div>

                              </div>

                            </div><!-- /.Info véhicule -->

                          </div>

                          <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                        </div>

                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">


                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="inputDateVignette">Date de validité de la vignette</label>
                                <input type="date" class="form-control" name="date_vign" id="inputDateVignette" placeholder="JJ/MM/AAAA">
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <h5>
                                <p id="date_vign"></p>
                              </h5>
                            </div>
                          </div>

                          <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                          <button type="submit" class="btn btn-primary">valider</button>

                        </div>
                      </form>

                    </div>

                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.row -->
        </div>

        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <?php
    // Include footer file
    include("footer.php");
    ?>


  </div>
  <!-- ./wrapper -->



  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="plugins/dropzone/min/dropzone.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

  <!-- jquery-validation -->
  <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="plugins/jquery-validation/additional-methods.min.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- bs-custom-file-input -->
  <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

  <!-- Page specific script -->
  <script>
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
      window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
  </script>

</body>

</html>

<?php                 
}else {
    header('Location: restriction.php');
}
  }
?>