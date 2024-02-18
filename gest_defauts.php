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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 /* || $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

        // Include config file
        include("api/db_connect.php");

        global $conn;
        // Define variables and initialize with empty values
        $res_code = $res_label = $res_categ = $res_max = $res_min = $res_unite = "";
        $res_code_err = $res_label_err = $res_categ_err = $res_max_err = $res_min_err = $res_unite_err = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate username
            if (empty(trim($_POST["res_code"]))) {
                $res_code_err = "Entrez un code.";
            } else {/*
                // Prepare a select statement
                $sql = "SELECT id FROM res_config WHERE code = ?";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_res_code);

                    // Set parameters
                    $param_res_code = trim($_POST["res_code"]);

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        /* store result 
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $res_code_err = "Ce code existe déja.";
                        } else {
                            $param_res_code = trim($_POST["res_code"]);
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }*/
                
                $res_label = trim($_POST["res_code"]);
                // Set parameters
                $param_res_label = trim($_POST["res_code"]);
            }

            // Validate label
            if (empty(trim($_POST["res_label"]))) {
                $res_label_err = "Entrez le nom de la mesure.";
            } else {
            }

            // Validate categ
            if (empty(trim($_POST["res_categ"]))) {
                $res_categ_err = "Entrez la categorie de la mesure";
            } else {
                $res_categ = trim($_POST["res_categ"]);
                // Set parameters
                $param_res_categ = trim($_POST["res_categ"]);
            }

            // Validate max
            if (empty(trim($_POST["res_max"]))) {
                $res_max_err = "Définissez la mesure maximale";
            } else {
                $res_max = trim($_POST["res_max"]);
                // Set parameters
                $param_res_max = trim($_POST["res_max"]);
            }

            // Validate role
            if (empty(trim($_POST["res_min"]))) {
                $res_min_err = "Définissez la mesure minimale";
            } else {
                $res_min = trim($_POST["res_min"]);
                // Set parameters
                $param_res_min = trim($_POST["res_min"]);
            }

            

            // Check input errors before inserting in database
            if (empty($res_code_err) && empty($res_label_err) && empty($res_categ_err) && empty($res_max_err) && empty($res_min_err)) {

                // Prepare an insert statement
                $sql = "INSERT INTO res_config (res_code, res_label, res_categ, res_max, res_min, unite) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "sssssi", $param_res_code, $param_res_label, $param_res_categ, $param_res_max, $param_res_min, $param_res_unite);

                    // Set parameters
                    $param_res_code = $res_code;
                    $param_res_label = $res_label;
                    $param_res_categ = $res_categ;
                    $param_res_max = $res_max;
                    $param_res_min = $res_min;
                    $param_res_unite = $res_unite;

                    // Attempt to execute the prepared steatement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        header("location: login.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again later. 22";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }

            // Close connection
            mysqli_close($conn);
        }
?>

        <!DOCTYPE html>
        <html lang="fr">


        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ACTIA SA | Tableau de bord supervision</title>

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
            <!-- DataTables -->
            <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        </head>

        <body class="hold-transition sidebar-mini layout-fixed">
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
                                    <h1 class="m-0">Gestion des Mesures Automatiques</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="index.php">Administration</a></li>
                                        <li class="breadcrumb-item active">Gestion des Mesures</li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->


                    <!-- StatGen -->
                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <!-- Station column -->

                                <?php
                                require_once("api/db_connect.php");
                                if (
                                    isset($_GET["id_def"]) && !empty($_GET["id_def"])
                                ) {
                                    $id_def = $_GET["id_def"];
                                    //requête
                                    $sql = "SELECT * FROM res_config where id='" . $id_def . "'";
                                    // On prépare la requête
                                    $request = $db_PDO->prepare($sql);
                                    $request = $db_PDO->query($sql);
                                    // On exécute la requête
                                    $request->execute();
                                    // On stocke le résultat dans un tableau associatif
                                    $reset = $request->fetch();

                                ?>

                                    <div class="col-sm-12">

                                        <input type="hidden" name="id_def" value="<?php echo $reset["id"] ?>">
                                        <div class="card card-danger">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                                <div class="card-header">
                                                    <h3 class="card-title">MESURES</h3>
                                                </div>
                                                <div class="card-body">
                                                    <p>Paramétrage des mésures automatiques</p>

                                                    <div class="form-group">
                                                        <label>CODE</label>
                                                        <input type="text" name="res_code" class="form-control <?php echo (!empty($res_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["res_code"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_code_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>DESCRIPTION</label>
                                                        <input type="text" name="res_label" class="form-control <?php echo (!empty($res_desc_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["res_label"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_label_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>CATEGORIE</label>
                                                        <input type="text" name="res_categ" class="form-control <?php echo (!empty($res_categ_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["res_categ"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_categ_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>MESURE (max)</label>
                                                        <input type="text" name="res_max" class="form-control <?php echo (!empty($res_max_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["res_max"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_max_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>MESURE (min)</label>
                                                        <input type="text" name="res_min" class="form-control <?php echo (!empty($res_min_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["res_min"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_min_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>UNITE</label>
                                                        <input type="text" name="res_unite" class="form-control <?php echo (!empty($res_unite_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["unite"]; ?>">
                                                        <span class="invalid-feedback"><?php echo $res_unite_err; ?></span>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <button type="submit" name="param_mesur" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>

                                <?php } else if (!isset($_GET["id_def"])) { ?>

                                    <div class="col-sm-12">

                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                            <div class="card-header">
                                                <h3 class="card-title">MESURES</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>Paramétrage des mésures automatiques</p>

                                                <div class="form-group">
                                                    <label>CODE</label>
                                                    <input type="text" name="res_code" class="form-control <?php echo (!empty($res_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_code; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_code_err; ?></span>
                                                </div>

                                                <div class="form-group">
                                                    <label>DESCRIPTION</label>
                                                    <input type="text" name="res_label" class="form-control <?php echo (!empty($res_label_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_label; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_label_err; ?></span>
                                                </div>

                                                <div class="form-group">
                                                    <label>CATEGORIE</label>
                                                    <input type="text" name="res_categ" class="form-control <?php echo (!empty($res_categ_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_categ; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_categ_err; ?></span>
                                                </div>


                                                <div class="form-group">
                                                    <label>MESURE (max)</label>
                                                    <input type="text" name="res_max" class="form-control <?php echo (!empty($res_max_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_max; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_max_err; ?></span>
                                                </div>

                                                <div class="form-group">
                                                    <label>MESURE (min)</label>
                                                    <input type="text" name="res_min" class="form-control <?php echo (!empty($res_min_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_min; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_min_err; ?></span>
                                                </div>

                                                <div class="form-group">
                                                    <label>UNITE</label>
                                                    <input type="text" name="res_unite" class="form-control <?php echo (!empty($res_unite_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $res_unite; ?>">
                                                    <span class="invalid-feedback"><?php echo $res_unite_err; ?></span>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <button type="submit" name="param_mesur" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                            </div>
                                        </form>

                                    </div>
                                    <!-- /.card-body -->

                            </div>
                        <?php }  ?>




                        <!--
                <div class="col-sm-12">
                     mapbox 
                    <div id='map' style='width: 1000px; height: 500px;'></div>
                    <script>
                        mapboxgl.accessToken = 'pk.eyJ1IjoibWFudWVsYmxhY2siLCJhIjoiY2sxN3lkNjIyMGlnZzNubGxkZmxkNjI3ciJ9.KAaRnKJO5y2OCMcU4WxVcA';
                        var map = new mapboxgl.Map({
                            container: 'map',
                            style: 'mapbox://styles/mapbox/streets-v11'
                        });
                    </script>
                </div>
                -->

                        <div class="col-sm-12">

                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Liste des codes
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->

                                <!-- Table -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Code</th>
                                                <th>Label</th>
                                                <th>Categorie</th>
                                                <th>Min</th>
                                                <th>Max</th>
                                                <th>unite</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            include("api/db_connect.php");

                                            //requête
                                            $sql = "SELECT id, res_code, res_label, res_categ, res_max, res_min, unite as res_unite FROM res_config";
                                            // On prépare la requête
                                            $request = $db_PDO->prepare($sql);
                                            // On exécute la requête
                                            $request->execute();
                                            // On stocke le résultat dans un tableau associatif
                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($result as $config) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $config['id'] ?> </td>
                                                    <td><?php echo $config['res_code'] ?> </td>
                                                    <td><?php echo $config['res_label'] ?> </td>
                                                    <td><?php echo $config['res_categ'] ?> </td>
                                                    <td><?php echo $config['res_max'] ?> </td>
                                                    <td><?php echo $config['res_min'] ?> </td>
                                                    <td><?php echo $config['res_unite'] ?> </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info">Edition</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a class="dropdown-item" href="gest_defauts.php?id_def=<?= $config["id"]; ?>">Modifier</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="edit_adm.php?id_user=<?= $config["id"]; ?>&supp_user=vrai">Supprimer</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }  ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>


                        </div>
                </div>


            </div><!-- /.container-fluid -->
            </section>
            </div>


            <!-- footer -->
            <?php
            // Include config file
            include("footer.php");
            ?>
            <!-- ./footer -->

            </div>

            <!-- jQuery -->
            <script src="plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
        </body>


        </html>

<?php
    } else {
        header('Location: restriction.php');
    }
}
?>