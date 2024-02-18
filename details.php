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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 || $_SESSION["role"] == 4 || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

?>

        <?php
        require_once("api/db_connect.php");

        if (isset($_GET["id_vehic"]) && !empty($_GET["id_vehic"])) {

            $id_vehic = $_GET["id_vehic"];
            $query = "SELECT vehicule.id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, energie.lib, nb_place, ptac, puiss_fisc, id_genre, genre.lib, date_mise_circul, date_local 
from vehicule left join energie on vehicule.id_energie=energie.id left join genre on vehicule.id_genre=genre.id Where vehicule.id='" . $id_vehic . "'";
            $request = $db_PDO->prepare($query);
            $request = $db_PDO->query($query);
            $vehicule = $request->fetch();
        } else header('location:dashboard_sup.php');

        ?>


        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TUX AUTO</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
            <!-- summernote -->
            <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

        </head>


        <body class="hold-transition sidebar-mini layout-fixed" onload="observation()">

            <div class="wrapper">

                <!-- En tete -->
                <?php
                // Include nav_bar 
                include("nav_bar.php");
                ?>
                <!-- ./En tete -->

                <div class="content-wrapper">
                    <!-- Body -->
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">Véhicule <?php echo $vehicule["marque"] . " | " . $vehicule["immatriculation"] . " "; ?> <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="modifier" onclick="edit()"><i class="fa fa-edit"></i></button> </h1>

                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Visite technique</a></li>
                                        <li class="breadcrumb-item active">Véhicule</li>
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
                                <!-- form start -->
                                <form name="vehicule" action="insert_vehic.php" method="post">

                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Détail fiscal -->

                                                <div class="card-body">

                                                    <div class="form-group">

                                                        <div class="row">

                                                            <?php
                                                            if (isset($vehicule["id_genre"]) && !empty($vehicule["id_genre"]) && $vehicule["id_genre"] != null) {

                                                                if ($vehicule["id_genre"] == 1) {
                                                            ?>

                                                                    <div class="form-check">
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input" checked="true" type="radio" id="radio1" name="radio1" value=1 onchange=CalculVignette()>
                                                                            <label class="form-check-label">Transport de personne</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input" type="radio" id="radio2" name="radio1" value=2 onchange=CalculVignette()>
                                                                            <label class="form-check-label">Transport de marchandise</label>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                } else if ($vehicule["id_genre"] == 2) {
                                                                ?>
                                                                    <div class="form-check">
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input" type="radio" id="radio1" name="radio1" value=1 onchange=CalculVignette()>
                                                                            <label class="form-check-label">Transport de personne</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input" checked="true" type="radio" id="radio2" name="radio1" value=2 onchange=CalculVignette()>
                                                                            <label class="form-check-label">Transport de marchandise</label>
                                                                        </div>
                                                                    </div>

                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPuisFiscal">Puissance fiscale</label>
                                                        <input type="number" class="form-control" id="inputPuisFiscal" name="inputPuisFiscal" placeholder="Puissance Fiscale" step=1 min=0 onchange=CalculVignette() onkeyup=CalculVignette() value="<?php echo $vehicule["puiss_fisc"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <input onchange=CalculVignette() onkeyup=CalculVignette() type="date" class="form-control" name="inputDateMC" id="inputDateMC" name="inputDateMC" placeholder="JJ/MM/AAAA" value="<?php echo $vehicule["date_mise_circul"] ?>">
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
                                                        <input onchange=CalculVignette() type="number" class="form-control" id="inputPTAC" name="inputPTAC" placeholder="Poids Total à charge" onkeyup=CalculVignette() onchange=CalculVignette() step=1 min=0 value="<?php echo $vehicule["ptac"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPA">Place assise</label>
                                                        <input onchange=CalculVignette() type="number" class="form-control" id="inputPA" name="inputPA" placeholder="Place Assise" onkeyup=CalculVignette() step=1 min=0 value="<?php echo $vehicule["nb_place"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPA">Catégorie</label>
                                                        <input onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="inputCateg" placeholder="Categorie" onkeyup=CalculVignette() step=1 min=0 disabled>
                                                    </div>


                                                    <p id="CalVignette"></p>


                                                </div>

                                                <!-- /.Détail fiscal -->
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

                                                    var puisFisc, ptac, placeAssis, prixVignette, prixVisite, categ;
                                                    var type
                                                    var rad = document.nVehicule.radio1;
                                                    var prev = null;

                                                    var dateMC = Date.parse(document.getElementById("inputDateMC").value);
                                                    var now = Date.now();

                                                    var diff = dateDiff(dateMC, now);
                                                    document.getElementById("anneeMC").innerHTML = +diff.year + 1 + " ans";
                                                    puisFisc = document.getElementById("inputPuisFiscal").value;
                                                    ptac = document.getElementById("inputPTAC").value;

                                                    //Type transport de marchandise
                                                    if (rad.value == 1) {
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
                                                                categ = "TP1";
                                                                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13.700 FCFA  //  Vignette:  ";
                                                            } else if (puisFisc > 7) {
                                                                categ = "TP2";
                                                                document.getElementById("CalVignette").innerHTML = "Visite Technique: 16.100 FCFA  //  Vignette:  ";
                                                            }

                                                        }
                                                    } //Type transport de personne
                                                    else if (rad.value == 2) {
                                                        document.getElementById("inputPA").disabled = false;
                                                        document.getElementById("inputPTAC").disabled = true;
                                                        document.getElementById("CalVignette").innerHTML = rad.value;
                                                    }

                                                    /*for (var i = 0; i < rad.length; i++) {
                                                      rad[i].addEventListener('change', function() {
                                                          // (prev) ? console.log(prev.value): null;
                                                          if (this !== prev) {
                                                              prev = this;
                                                          }*/

                                                    //document.getElementById("CalVignette").innerHTML = x;

                                                    //console.log(this.value)
                                                    //});
                                                }
                                            </script>

                                            <script>
                                                function edit() {
                                                    document.getElementById("inputPA").disabled = false;
                                                    document.getElementById("inputPTAC").disabled = false;
                                                    document.getElementById("inputImmatriculation").disabled = false;
                                                    document.getElementById("inputMarque").disabled = false;
                                                    document.getElementById("inputTypeTech").disabled = false;
                                                    document.getElementById("inputSerie").disabled = false;
                                                    document.getElementById("inputMiseCircu").disabled = false;
                                                    document.getElementById("inputPuisFiscal").disabled = false;
                                                    document.getElementById("inputDateMC").disabled = false;
                                                    document.getElementById("inputProprietaire").disabled = false;

                                                    document.getElementById("radio1").disabled = false;
                                                    document.getElementById("radio2").disabled = false;
                                                    document.getElementById("radio3").disabled = false;
                                                    document.getElementById("radio4").disabled = false;
                                                }
                                            </script>

                                            <div class="col-sm-6">
                                                <!-- Info véhicule -->


                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <label for="inputImmatriculation">Immatriculation</label>
                                                        <input type="text" class="form-control" id="inputImmatriculation" name="inputImmatriculation" placeholder="Immatriculation" pattern="" value="<?php echo $vehicule["immatriculation"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputProprietaire">Proprietaire</label>
                                                        <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule" value="<?php echo $vehicule["proprietaire"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputMarque">Marque du véhicule</label>
                                                        <input type="text" class="form-control" id="inputMarque" name="inputMarque" placeholder="Marque du véhicule" value="<?php echo $vehicule["marque"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputTypeTech">Type technique</label>
                                                        <input type="text" class="form-control" id="inputTypeTech" name="inputTypeTech" placeholder="Type technique" value="<?php echo $vehicule["type_tech"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputSerie">Numéro de série</label>
                                                        <input type="text" class="form-control" id="inputSerie" name="inputSerie" placeholder="Numéro de série" value="<?php echo $vehicule["num_serie"] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputMiseCircu">Date de mise en circulation</label>
                                                        <input type="text" class="form-control" id="inputMiseCircu" name="inputMiseCircu" placeholder="Date de mise en circulation">
                                                    </div>

                                                </div>

                                                <!-- /.Info véhicule -->
                                            </div>

                                        </div>

                                        <!-- /.form start -->

                                        <input type="hidden" class="form-control" id="action" name="action" value="2">


                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer véhicule</button>
                                        <button type="reset" value="Reset" class="btn btn-danger" onclick="observation()">Annuler</button>
                                    </div>
                                </form>

                            </div>

                        </div>

                </div><!-- /.container-fluid -->
                <!-- /.main content -->



            </div>


            <!-- footer -->
            <?php
            // Include config file
            include("footer.php");
            ?>
            <!-- ./footer -->

            </div>



            <script>
                function observation() {
                    document.getElementById("inputPA").disabled = true;
                    document.getElementById("inputPTAC").disabled = true;
                    document.getElementById("inputImmatriculation").disabled = true;
                    document.getElementById("inputMarque").disabled = true;
                    document.getElementById("inputTypeTech").disabled = true;
                    document.getElementById("inputSerie").disabled = true;
                    document.getElementById("inputMiseCircu").disabled = true;
                    document.getElementById("inputPuisFiscal").disabled = true;
                    document.getElementById("inputDateMC").disabled = true;
                    document.getElementById("inputProprietaire").disabled = true;
                    document.getElementById("radio1").disabled = true;
                    document.getElementById("radio2").disabled = true;
                    document.getElementById("radio3").disabled = true;
                    document.getElementById("radio4").disabled = true;


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

        </body>


        </html>

<?php
    } else {
        header('Location: restriction.php');
    }
}
?>