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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 /* || $_SESSION["role"] === 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

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
                                    <h1 class="m-0">Administration</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                        <li class="breadcrumb-item active"></li>
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

                                <!-- service column -->

                                <?php
                                require_once("api/db_connect.php");
                                if (
                                    isset($_GET["id_service"]) && !empty($_GET["id_service"])
                                ) {
                                    $id_service = $_GET["id_service"];
                                    //requête
                                    $sql = "SELECT * FROM type_ctrl where id='" . $id_service . "'";
                                    // On prépare la requête
                                    $request = $db_PDO->prepare($sql);
                                    $request = $db_PDO->query($sql);
                                    // On exécute la requête
                                    $request->execute();
                                    // On stocke le résultat dans un tableau associatif
                                    $reset = $request->fetch();

                                ?>
                                    <div class="col-md-12">

                                        <form name="edit_service" action="edit_adm.php" method="post">
                                            <input type="hidden" value="<?php echo $id_service ?>" name="id_service">

                                            <div class="card card-danger">

                                                <div class="card-header">
                                                    <h3 class="card-title">Service</h3>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" value="<?php echo $reset["lib"] ?>" placeholder="Nom" name="nom_service">
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="submit" name="modif_service" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                            </div>
                                        </form>

                                    </div>

                                <?php } else if (!isset($_GET["id_service"])) { ?>

                                    <div class="col-md-12">

                                        <form name="n_service" action="edit_adm.php" method="post">
                                            <div class="card card-danger">

                                                <div class="card-header">
                                                    <h3 class="card-title">Service</h3>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" placeholder="Nom" name="nom_service">
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="submit" name="new_service" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                            </div>
                                        </form>

                                    </div>

                                <?php } ?>

                                <br>

                                <div class="col-sm-12">

                                    <div class="card card-outline card-danger">
                                        <div class="card-header">
                                            <h3 class="card-title">Liste des services</h3>

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
                                                        <th>libellé</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    include("api/db_connect.php");

                                                    //requête
                                                    $sql = "SELECT * FROM type_ctrl order by id ASC";
                                                    // On prépare la requête
                                                    $request = $db_PDO->prepare($sql);
                                                    // On exécute la requête
                                                    $request->execute();
                                                    // On stocke le résultat dans un tableau associatif
                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($result as $service) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $service['id'] ?> </td>
                                                            <td><?php echo $service['lib'] ?> </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-info">Edition</button>
                                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <div class="dropdown-menu" role="menu">
                                                                        <a class="dropdown-item" href="gest_service.php?id_service=<?= $service["id"]; ?>">Modifier</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="edit_adm.php?id_service=<?= $service["id"]; ?>&supp_service=vrai">Supprimer</a>
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