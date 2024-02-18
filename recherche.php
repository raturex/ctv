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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 5 || $_SESSION["role"] == 7 || $_SESSION["role"] == 3 || $_SESSION["role"] == 1)) {
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
            <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        </head>


        <body class="hold-transition sidebar-mini layout-fixed">

            <div class="wrapper">

                <?php
                // Include nav bar
                include("nav_bar.php");
                ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">Recherche</h1>
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
                                <form name="recherche" action="recherche_vehic.php" method="POST">
                                    <div class="card-body">

                                        <!-- form start -->
                                        <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                                        <div class="row">
                                            <!-- Détail fiscal -->
                                            <div class="col-sm-6">
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <label for="marque_vehic">Marque</label>
                                                        <select class="form-control" name="marque_vehic" id="marque_vehic">
                                                            <option value=""> </option>

                                                            <?php include("api/db_connect.php");

                                                            //requête
                                                            $sql = "SELECT marque FROM vehicule group by marque order by marque ASC";
                                                            // On prépare la requête
                                                            $request = $db_PDO->prepare($sql);
                                                            // On exécute la requête
                                                            $request->execute();
                                                            // On stocke le résultat dans un tableau associatif
                                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($result as $marque_vehic) { ?>
                                                                <option value="<?php echo $marque_vehic['marque'] ?>"> <?= $marque_vehic['marque'] ?> </option>
                                                            <?php }  ?>
                                                        </select>
                                                    </div>



                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label for="categ_vehic">Catégorie</label>
                                                                <select class="form-control" name="categ_vehic" id="categ_vehic">
                                                                    <option value=""> </option>

                                                                    <?php include("api/db_connect.php");

                                                                    //requête
                                                                    $sql = "SELECT * FROM categ";
                                                                    // On prépare la requête
                                                                    $request = $db_PDO->prepare($sql);
                                                                    // On exécute la requête
                                                                    $request->execute();
                                                                    // On stocke le résultat dans un tableau associatif
                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($result as $categ) { ?>
                                                                        <option value="<?php echo $categ['id'] ?>"> <?= $categ['categorie'] ?> </option>
                                                                    <?php }  ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ctrl_vehic">Contrôle</label>
                                                                <select class="form-control" name="ctrl_vehic" id="ctrl_vehic" disabled>
                                                                    <option value=""> </option>

                                                                    <?php include("api/db_connect.php");

                                                                    //requête
                                                                    $sql = "SELECT * FROM type_ctrl";
                                                                    // On prépare la requête
                                                                    $request = $db_PDO->prepare($sql);
                                                                    // On exécute la requête
                                                                    $request->execute();
                                                                    // On stocke le résultat dans un tableau associatif
                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($result as $ctrl_vehic) { ?>
                                                                        <option value="<?php echo $ctrl_vehic['id'] ?>"> <?= $ctrl_vehic['lib'] ?> </option>
                                                                    <?php }  ?>
                                                                </select>


                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="form-group">

                                                    </div>



                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label for="date_debut">Date debut</label>
                                                                <input type="date" class="form-control" name="date_debut" id="date_debut" placeholder="JJ/MM/AAAA">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="date_fin">Date fin</label>
                                                                <input type="date" class="form-control" name="date_fin" id="date_fin" placeholder="JJ/MM/AAAA">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="col-sm-6">
                                                <div class="card-body">


                                                    <div class="form-group">
                                                        <label for="immat_vehic">Immatriculation</label>
                                                        <input type="text" name="immat_vehic" class="form-control" id="immat_vehic" value="">
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="id_energie">Energie</label>
                                                        <select class="form-control" name="id_energie" id="id_energie">
                                                            <option value=""></option>

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
                                                        <label for="age_vehic">Age</label>
                                                        <input type="number" name="age_vehic" class="form-control" id="age_vehic" min="0" value="">
                                                    </div>

                                                </div>
                                            </div>


                                            <!-- /.Détail fiscal -->
                                        </div>

                                    </div>

                                    <!-- /.form start -->
                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Rechercher</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </form>
                            </div>



                        </div>

                        <!-- /.form start -->
                </div>

                </section>
            </div>
            </div>



            <?php
            // Include footer
            include("footer.php");
            ?>

            </div>


            <!-- Date Ranger -->
            <script type="text/javascript">
                $(function() {

                    var start = moment().subtract(29, 'days');
                    var end = moment();

                    function cb(start, end) {
                        $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                    }

                    $('#reportrange').daterangepicker({
                        startDate: start,
                        endDate: end,
                        ranges: {
                            'Aujourd\'hui': [moment(), moment()],
                            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                            '30 dernier jours': [moment().subtract(29, 'days'), moment()],
                            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                            'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);

                    cb(start, end);

                });
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