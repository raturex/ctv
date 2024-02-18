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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 5  /*|| $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

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
                                    <h1 class="m-0">Visite</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Visite technique</a></li>
                                        <li class="breadcrumb-item active">Enregistrement client</li>
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
                                        <p> Facture</p>
                                    </h4>

                                </div>

                                <form name="nfacture" action="insert_facture.php" method="post">
                                    <div class="card-body">

                                        <!-- form start -->
                                        <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Détail fiscal -->

                                                <div class="card-body">



                                                    <div class="form-group">
                                                        <label for="inputNom_client">Prix </label>

                                                        <input type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom">

                                                    </div>

                                                    <div class="">N° d’odre : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Marque : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Immatriculation : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">N° Série :<div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Date mise circ : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Vignette N° :<div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">NCC: <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">N° certicat : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Type :<div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Puiss.Fis.(cv) : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Date : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>

                                                    <div class="">Montants encaissés par prestation : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Visite Technique : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Sécurisation : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Timbre Fiscal : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Complément Vignette :<div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Total payé :<div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>


                                                    <div class="">Station : <div><?php echo $_SESSION["id_station"]; ?> </div>
                                                    </div>
                                                    <div class="">Contrôleur :<?php echo $_SESSION["id_station"]; ?> </div>
                                                </div>
                                                <div class="">Responsable: <?php echo $_SESSION["id_station"]; ?></div>
                                            </div>
                                            <div class="">Total payé : <?php //echo " ".$vehicule["marque"] 
                                                                        ?></div>
                                            <div class="">Validité : : <?php //echo " ".$vehicule["marque"] 
                                                                        ?></div>

                                        </div>

                                        <!-- /.Détail fiscal -->
                                    </div>


                                    <div class="col-sm-6">
                                        <!-- Info véhicule -->

                                        <div class="card-body">



                                        </div>

                                        <!-- /.Info véhicule -->
                                    </div>
                            </div>


                            <!-- /.form start -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer client</button>
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