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
            <!-- mapbox -->
            <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
            <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
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
                                    <h1 class="m-0">Gestion des stations</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                                        <li class="breadcrumb-item active">Gestion des stations</li>
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
                                    isset($_GET["id_station"]) && !empty($_GET["id_station"])
                                ) {
                                    $id_station = $_GET["id_station"];
                                    //requête
                                    $sql = "SELECT * FROM station where station.id='" . $id_station . "'";
                                    // On prépare la requête
                                    $request = $db_PDO->prepare($sql);
                                    $request = $db_PDO->query($sql);
                                    // On exécute la requête
                                    $request->execute();
                                    // On stocke le résultat dans un tableau associatif
                                    $reset = $request->fetch();

                                ?>
                                    <div class="col-sm-12">

                                        <div class="card card-danger">
                                            <form name="edit_station1" action="edit_adm.php" method="post">
                                                <input type="hidden" name="id_station" value="<?php echo $id_station ?>">

                                                <div class="card-header">
                                                    <h3 class="card-title">Station</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">

                                                        <select class="form-control col-6" name="type_station">

                                                            <?php include("api/db_connect.php");

                                                            //requête
                                                            $sql = "SELECT * FROM type_station order by id desc";
                                                            // On prépare la requête
                                                            $request = $db_PDO->prepare($sql);
                                                            // On exécute la requête
                                                            $request->execute();
                                                            // On stocke le résultat dans un tableau associatif
                                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($result as $typ_station) {
                                                                $tid = $typ_station['id'];

                                                                if ($tid == $reset['id_type']) {                                                     ?>
                                                                    <option value="<?php echo $typ_station['id'] ?>" selected> <?= $typ_station['lib'] ?> </option>
                                                                <?php } else {    ?>
                                                                    <option value="<?php echo $typ_station['id'] ?>"> <?= $typ_station['lib'] ?> </option>


                                                            <?php }
                                                            }  ?>
                                                        </select>

                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="Nom de la station" name="nom_station" value="<?php echo $reset['nom'] ?>">
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="détails" name="details_station" value="<?php echo $reset['details'] ?>">

                                                        </div>

                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="Ville" name="ville_station" value="<?php echo $reset['ville'] ?>">
                                                        </div>

                                                    </div>

                                                    <br>


                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button type="submit" name="modif_station" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                <?php } else if (!isset($_GET["id_station"])) { ?>

                                    <div class="col-sm-12">
                                        <form name="edit_station2" action="edit_adm.php" method="post">
                                            <div class="card card-danger">
                                                <div class="card-header">
                                                    <h3 class="card-title">Station</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">

                                                        <select class="form-control col-6" name="type_station">

                                                            <?php include("api/db_connect.php");

                                                            //requête
                                                            $sql = "SELECT * FROM type_station order by id ASC";
                                                            // On prépare la requête
                                                            $request = $db_PDO->prepare($sql);
                                                            // On exécute la requête
                                                            $request->execute();
                                                            // On stocke le résultat dans un tableau associatif
                                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($result as $typ_station) { ?>
                                                                <option value="<?php echo $typ_station['id'] ?>"> <?= $typ_station['lib'] ?> </option>
                                                            <?php }  ?>
                                                        </select>

                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="Nom de la station" name="nom_station" value="">
                                                        </div>

                                                    </div>

                                                    <br>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="détails" name="details_station" value="">
                                                        </div>

                                                        <div class="col-6">
                                                            <input type="text" class="form-control" placeholder="Ville" name="ville_station" value="">
                                                        </div>

                                                    </div>

                                                    <br>



                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button type="submit" name="new_station" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                </div>

                                            </div>
                                        </form>

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
                                            <h3 class="card-title">Liste des stations</h3>

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
                                                        <th>ville</th>
                                                        <th>Nom</th>
                                                        <th>détails</th>
                                                        <th>type</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    include("api/db_connect.php");

                                                    //requête
                                                    $sql = "SELECT station.id as id_station, nom, localisation, ville, details, id_type, type_station.lib as lib FROM station, type_station where id_type=type_station.id order by ville ASC";
                                                    // On prépare la requête
                                                    $request = $db_PDO->prepare($sql);
                                                    // On exécute la requête
                                                    $request->execute();
                                                    // On stocke le résultat dans un tableau associatif
                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($result as $categ) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $categ['id_station'] ?> </td>
                                                            <td><?php echo $categ['ville'] ?> </td>
                                                            <td><?php echo $categ['nom'] ?> </td>
                                                            <td><?php echo $categ['details'] ?> </td>
                                                            <td><?php echo $categ['lib'] ?> </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-info">Edition</button>
                                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <div class="dropdown-menu" role="menu">
                                                                        <a class="dropdown-item" href="gest_station.php?id_station=<?= $categ["id_station"]; ?>">Modifier</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="edit_adm.php?id_station=<?= $categ["id_station"]; ?>&supp_station=vrai">Supprimer</a>
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