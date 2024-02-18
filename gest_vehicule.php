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

                            <div class="col-12 col-sm-12">
                                <div class="card card-danger card-tabs">
                                    <div class="card-header p-0 pt-1">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Catégories</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Energies</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">genres</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">

                                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                                <!-- categories column -->
                                                <div class="col-sm-12">

                                                    <?php
                                                    require_once("api/db_connect.php");
                                                    if (
                                                        isset($_GET["id_categ"]) && !empty($_GET["id_categ"])
                                                    ) {
                                                        $id_categ = $_GET["id_categ"];
                                                        //requête
                                                        $sql = "SELECT * FROM categ where categ.id='" . $id_categ . "'";
                                                        // On prépare la requête
                                                        $request = $db_PDO->prepare($sql);
                                                        $request = $db_PDO->query($sql);
                                                        // On exécute la requête
                                                        $request->execute();
                                                        // On stocke le résultat dans un tableau associatif
                                                        $reset = $request->fetch();

                                                    ?>
                                                        <form name="e_categ" action="edit_adm.php" method="post">
                                                            <input type="hidden" name="id_categ" value="<?php echo $id_categ ?>">

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <input value="<?php echo $reset['categorie'] ?>" type="text" class="form-control" placeholder="Nom" name="nom_categ">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input value="<?php echo $reset['prix_visite'] ?>" type="number" class="form-control" placeholder="prix visite" name="prix_visite" min="0" step="5">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input value="<?php echo $reset['prix_revisite'] ?>" type="number" class="form-control" placeholder="prix revisite" name="prix_revisite" min="0" step="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->

                                                            <div class="card-footer">
                                                                <button type="submit" name="modif_categ" value="Submit" class="btn btn-info float-right" name="formcateg">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>
                                                        </form>
                                                    <?php } else if (!isset($_GET["id_categ"])) { ?>

                                                        <form name="n_categ" action="edit_adm.php" method="post">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <input type="text" class="form-control" placeholder="Nom" name="nom_categ">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" class="form-control" placeholder="prix visite" name="prix_visite" min="0" step="5">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <input type="number" class="form-control" placeholder="prix revisite" name="prix_revisite" min="0" step="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->


                                                            <div class="card-footer">
                                                                <button type="submit" name="new_categ" value="Submit" class="btn btn-info float-right" name="formcateg">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>
                                                        </form>


                                                    <?php } ?>

                                                    <br>

                                                    <div class="col-sm-12">

                                                        <div class="card card-outline card-danger">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Liste des catégories</h3>

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
                                                                            <th>Nom</th>
                                                                            <th>Prix visite</th>
                                                                            <th>Prix revisite</th>
                                                                            <th style="width: 25px">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        include("api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT * FROM categ ORDER BY id ASC";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $categ) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $categ['id'] ?> </td>
                                                                                <td><?php echo $categ['categorie'] ?> </td>
                                                                                <td><?php echo $categ['prix_visite'] ?> </td>
                                                                                <td><?php echo $categ['prix_revisite'] ?> </td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info">Edition</button>
                                                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                                        </button>
                                                                                        <div class="dropdown-menu" role="menu">
                                                                                            <a class="dropdown-item" href="gest_vehicule.php?id_categ=<?= $categ["id"]; ?>#custom-tabs-one-home-tab">Modifier</a>
                                                                                            <div class="dropdown-divider"></div>
                                                                                            <a class="dropdown-item" href="edit_adm.php?id_categ=<?= $categ["id"]; ?>&supp_categ=vrai">Supprimer</a>

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


                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                                                <!-- energies column -->
                                                <div class="col-md-12">

                                                    <?php
                                                    require_once("api/db_connect.php");
                                                    if (
                                                        isset($_GET["id_energie"]) && !empty($_GET["id_energie"])
                                                    ) {
                                                        $id_energie = $_GET["id_energie"];
                                                        //requête
                                                        $sql = "SELECT * FROM energie where energie.id='" . $id_energie . "'";
                                                        // On prépare la requête
                                                        $request = $db_PDO->prepare($sql);
                                                        $request = $db_PDO->query($sql);
                                                        // On exécute la requête
                                                        $request->execute();
                                                        // On stocke le résultat dans un tableau associatif
                                                        $reset = $request->fetch();
                                                    ?>

                                                        <form name="e_energie" action="edit_adm.php" method="post">
                                                            <input type="hidden" name="id_energie" value="<?php echo $id_energie ?>">


                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input value="<?php echo $reset['lib'] ?>" type="text" class="form-control" placeholder="Nom" name="nom_energie">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" name="modif_energie" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>
                                                        </form>

                                                    <?php } else if (!isset($_GET["id_energie"])) { ?>

                                                        <form name="n_energie" action="edit_adm.php" method="post">

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input type="text" class="form-control" placeholder="Nom" name="nom_energie">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" name="new_energie" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>
                                                        </form>

                                                    <?php } ?>

                                                    <br>

                                                    <div class="col-sm-12">

                                                        <div class="card card-outline card-danger">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Liste des énergies</h3>

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
                                                                            <th>Nom</th>
                                                                            <th style="width: 25px">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        include("api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT * FROM energie ORDER BY id ASC";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $energie) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $energie['id'] ?> </td>
                                                                                <td><?php echo $energie['lib'] ?> </td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info">Edition</button>
                                                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                                        </button>
                                                                                        <div class="dropdown-menu" role="menu">
                                                                                            <a class="dropdown-item" href="gest_vehicule.php?id_energie=<?= $energie['id']; ?>">Modifier</a>
                                                                                            <div class="dropdown-divider"></div>
                                                                                            <a class="dropdown-item" href="edit_adm.php?id_energie=<?= $energie['id']; ?>&supp_energie=vrai">Supprimer</a>
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
                                                <!-- /.card-body -->

                                            </div>

                                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">

                                                <!-- genres column -->
                                                <div class="col-md-12">

                                                    <?php
                                                    require_once("api/db_connect.php");
                                                    if (
                                                        isset($_GET["id_genre"]) && !empty($_GET["id_genre"])
                                                    ) {
                                                        $id_genre = $_GET["id_genre"];
                                                        //requête
                                                        $sql = "SELECT * FROM genre where genre.id='" . $id_genre . "'";
                                                        // On prépare la requête
                                                        $request = $db_PDO->prepare($sql);
                                                        $request = $db_PDO->query($sql);
                                                        // On exécute la requête
                                                        $request->execute();
                                                        // On stocke le résultat dans un tableau associatif
                                                        $reset = $request->fetch();
                                                    ?>

                                                        <form name="e_genre" action="edit_adm.php" method="post">
                                                            <input type="hidden" name="id_genre" value="<?php echo $id_genre ?>">

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input value="<?php echo $reset['lib'] ?>" type="text" class="form-control" placeholder="Utilisation" name="nom_genre">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <div class="card-footer">
                                                                <button type="submit" name="modif_genre" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>

                                                        </form>

                                                    <?php } else if (!isset($_GET["id_genre"])) { ?>

                                                        <form name="n_genre" action="edit_adm.php" method="post">

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input type="text" class="form-control" placeholder="Utilisation" name="nom_genre">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- /.card-body -->
                                                            <div class="card-footer">
                                                                <button type="submit" name="new_genre" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                            </div>

                                                        </form>

                                                    <?php } ?>

                                                    <br>


                                                    <div class="col-sm-12">

                                                        <div class="card card-outline card-danger">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Liste des genres</h3>

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
                                                                            <th style="width: 25px">Action</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        include("api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT * FROM genre ORDER BY id ASC";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $categ) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $categ['id'] ?> </td>
                                                                                <td><?php echo $categ['lib'] ?> </td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-info">Edition</button>
                                                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                                        </button>
                                                                                        <div class="dropdown-menu" role="menu">
                                                                                            <a class="dropdown-item" href="gest_vehicule.php?id_genre=<?= $categ["id"]; ?>">Modifier</a>
                                                                                            <div class="dropdown-divider"></div>
                                                                                            <a class="dropdown-item" href="edit_adm.php?id_genre=<?= $categ["id"]; ?>&supp_genre=vrai">Supprimer</a>
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



                                    </div>
                                </div>
                                <!-- /.card -->
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