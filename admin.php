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

if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 3 || $_SESSION["role"] == 1/*|| $_SESSION["role"] == 1*/) ) {
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

                        <!-- categories column -->
                        <div class="col-md-6">

                            <form name="edit_categ" action="edit_adm.php" method="GET">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Catégories</h3>
                                    </div>
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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right" name="formcateg">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <!-- energies column -->
                        <div class="col-md-6">

                            <form name="edit_energie" action="edit_adm.php" method="post">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Energie</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control" placeholder="Nom" name="nom_energie">
                                            </div>
                                        </div>

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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <!-- genres column -->
                        <div class="col-md-6">

                            <form name="edit_genre" action="edit_adm.php" method="post">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Utilisation du véhicule</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control" placeholder="Utilisation" name="nom_genre">
                                            </div>
                                        </div>

                                        <br>


                                        <div class="col-sm-12">

                                            <div class="card card-outline card-danger">
                                                <div class="card-header">
                                                    <h3 class="card-title">Liste des utilisations du véhicule</h3>

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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <!-- observation column -->
                        <div class="col-md-6">

                            <form name="edit_observation" action="edit_adm.php" method="post">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Observation</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Fonction" name="fonction_obs">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Groupe" name="group_obs">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Point" name="point_obs">
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Type défaut" name="type_def_obs">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" placeholder="Localisation du défaut" name="loc_def_obs">
                                            </div>

                                            <select class="form-control col-2" name="resultat_obs">

                                                <?php include("api/db_connect.php");

                                                //requête
                                                $sql = "SELECT * FROM resultat order by id ASC";
                                                // On prépare la requête
                                                $request = $db_PDO->prepare($sql);
                                                // On exécute la requête
                                                $request->execute();
                                                // On stocke le résultat dans un tableau associatif
                                                $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($result as $res) { ?>
                                                    <option value="<?php echo $res['id'] ?>"> <?= $res['lib'] ?> </option>
                                                <?php }  ?>
                                            </select>

                                            <div class="col-2">
                                                <input type="text" class="form-control" placeholder="code" name="code_obs">
                                            </div>
                                        </div>

                                        <br>


                                        <div class="col-sm-12">

                                            <div class="card card-outline card-danger">
                                                <div class="card-header">
                                                    <h3 class="card-title">Liste des observations</h3>

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
                                                                <th>code</th>
                                                                <th>Fonction</th>
                                                                <th>Groupe</th>
                                                                <th>Point</th>
                                                                <th>Type défaut</th>
                                                                <th>Localisation du défaut</th>
                                                                <th>resultat</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            include("api/db_connect.php");

                                                            //requête
                                                            $sql = "SELECT * FROM observation left join resultat on result= resultat.id ORDER BY observation.id ASC";
                                                            // On prépare la requête
                                                            $request = $db_PDO->prepare($sql);
                                                            // On exécute la requête
                                                            $request->execute();
                                                            // On stocke le résultat dans un tableau associatif
                                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($result as $obs) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $obs['id'] ?> </td>
                                                                    <td><?php echo $obs['code_ctrl'] ?> </td>
                                                                    <td><?php echo $obs['fonction_ctrl'] ?> </td>
                                                                    <td><?php echo $obs['group_pt_ctrl'] ?> </td>
                                                                    <td><?php echo $obs['pt_ctrl'] ?> </td>
                                                                    <td><?php echo $obs['type_def'] ?> </td>
                                                                    <td><?php echo $obs['def_const_localis'] ?> </td>
                                                                    <td><?php echo $obs['lib'] ?> </td>
                                                                    <td><?php echo $obs['code_ctrl'] ?> </td>



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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <!-- Station column -->
                        <div class="col-md-6">

                            <form name="edit_station" action="edit_adm.php" method="post">
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
                                                <input type="text" class="form-control" placeholder="Nom de la station" name="nom_station">
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="détails" name="details_station">
                                            </div>

                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="Ville" name="ville_station">
                                            </div>

                                        </div>

                                        <br>


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
                                                                <th>Nom</th>
                                                                <th>Prix visite</th>
                                                                <th>Prix revisite</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            include("api/db_connect.php");

                                                            //requête
                                                            $sql = "SELECT * FROM station, type_station where id_type=type_station.id order by ville ASC";
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
                                                                    <td><?php echo $categ['ville'] ?> </td>
                                                                    <td><?php echo $categ['nom'] ?> </td>
                                                                    <td><?php echo $categ['details'] ?> </td>
                                                                    <td><?php echo $categ['lib'] ?> </td>
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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <!-- service column -->
                        <div class="col-md-6">

                            <form name="edit_service" action="edit_adm.php" method="post">
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

                                                            foreach ($result as $categ) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $categ['id'] ?> </td>
                                                                    <td><?php echo $categ['lib'] ?> </td>
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

                                    <div class="card-footer">
                                        <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                    </div>

                                </div>
                            </form>

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
}else {
    header('Location: restriction.php');
}
  }
?>