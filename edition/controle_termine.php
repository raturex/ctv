<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

    require_once('../api/db_connect.php');

    $sql = 'select * from role where role.id= $_SESSION["role"]';

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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 6 || $_SESSION["role"] == 7 || $_SESSION["role"] == 1)) {
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
            <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- JQVMap -->
            <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
            <!-- summernote -->
            <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
            <!-- DataTables -->
            <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

        </head>

        <body class="hold-transition sidebar-mini layout-fixed">
            <div class="wrapper">

                <!-- En tete -->
                <?php
                // Include nav_bar 
                include("../nav_bar.php");
                ?>
                <!-- ./En tete -->


                <div class="content-wrapper">
                    <!-- Body -->
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">Contrôle technique effectué</h1>
                                    <h4></br>
                                        <?php
                                        $today = date("Y-m-d");
                                        ?>
                                    </h4>

                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="index.php">Contrôle technique</a></li>
                                        <li class="breadcrumb-item active">Terminé</li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->


                    <?php
                    include "../api/db_connect.php";
                    //global $conn;
                    $nb_vehic_control = 0;
                    $nb_succes = 0;
                    $nb_sorv = 0;
                    $nb_aorv = 0;


                    $query = "SELECT facturation.id, facturation.id_vehicule, facturation.id_ctrl, facturation.id_client,COUNT(ctrl_obs.id_obs) as nb_obs, etat, date, SUM(observation.result) as sum_result  FROM facturation left join ctrl_obs on ctrl_obs.id_factur = facturation.id left join observation on observation.id=ctrl_obs.id_obs where facturation.etat=3 /*AND date like '$today%'*/  group by facturation.id order by facturation.id ASC";
                    $result2 = mysqli_query($conn, $query);

                    while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {

                        $nb_vehic_control = $nb_vehic_control + 1;

                        if ($row2["nb_obs"] != 0) {
                            $test = $row2["sum_result"] / $row2["nb_obs"];

                            if ($test == 1) {
                                $nb_sorv = $nb_sorv + 1;
                            } else {
                                $nb_aorv = $nb_aorv + 1;
                            }
                        } else {
                            $nb_succes = $nb_succes + 1;
                        }
                    }
                    ?>


                    <!-- StatGen -->
                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">

                                            <h3><?php echo $nb_vehic_control; ?></h3>

                                            <p>
                                            <h6>Véhicules Contrôlés</h6>
                                            </p>

                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>

                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-success">
                                        <div class="inner">

                                            <h3><?php echo $nb_succes; ?></h3>

                                            <p>
                                            <h6>Terminé réussi</h6>
                                            </p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>

                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">

                                            <h3><?php echo $nb_sorv; ?></h3>

                                            <p>
                                            <h6>Terminé sans obligation de revisite</h6>
                                            </p>

                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-plus"></i>
                                        </div>

                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">

                                            <h3><?php echo $nb_aorv; ?></h3>

                                            <p>
                                            <h6>Terminé avec obligation de revisite</h6>
                                            </p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>

                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>


                            <!-- ./StatGen -->


                            <!-- Tableau véhicules controlés -->



                            <!-- Tableau de données -->
                            <div class="card">
                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Véhicules en fin de contrôle</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">



                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>N° Immatriculation</th>
                                                <th>Catégorie de véhicules</th>
                                                <th>Control effectué</th>
                                                <th>Observation</th>
                                                <th>Résultat</th>
                                                <th>Résultat</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            //$query = "SELECT * FROM visite_tech";
                                            include "../api/db_connect.php";

                                            $query3 = "SELECT DISTINCT(facturation.id) AS id_factur, vehicule.id AS id_vehic, etat,  immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib AS energie, nb_place, ptac, puiss_fisc, genre.lib AS type_trans, categ.categorie AS categ, date_mise_circul, date_local AS date_immatri, type_ctrl.lib AS type_ctrl, id_client, age_vehi, facturation.date as date
                            FROM
                            facturation
                            LEFT JOIN vehicule ON facturation.id_vehicule = vehicule.id
                            LEFT JOIN controle ON facturation.id = controle.id_facturation
                            LEFT JOIN energie ON vehicule.id_energie = energie.id
                            LEFT JOIN genre ON vehicule.id_genre = genre.id
                            LEFT JOIN categ ON vehicule.id_categ = categ.id 
                            LEFT JOIN type_ctrl ON facturation.id_ctrl = type_ctrl.id
                            WHERE
                                facturation.id_ctrl = type_ctrl.id AND etat = 3/* AND facturation.date like '$today%'*/
                            ORDER BY
                            facturation.date
                            DESC";



                                            //$query2 = "SELECT controle.id AS id, controle.id_facturation as id_factur, controle.id_ctrler, id_obs, observation.code_ctrl AS code_ctrl, observation.result as id_res, resultat.lib as resultat, date_ctrl FROM ctrl_obs JOIN observation ON observation.id = ctrl_obs.id_obs join resultat on observation.result = resultat.id where id_vehicule = $id_vehicule order by id_vehicule asc";


                                            $result3 = mysqli_query($conn, $query3);

                                            while ($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                                                $id_vehicule = $row["id_vehic"];
                                            ?>

                                                <tr id="result_line">
                                                    <td>
                                                        <?php
                                                        echo $row["immatriculation"];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo $row["categ"];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo $row["type_ctrl"];
                                                        ?>
                                                    </td>

                                                    <?php
                                                    global $conn;
                                                    $id_vehicule = $row["id_vehic"];
                                                    $query2 = "SELECT ctrl_obs.id AS id, id_vehicule, id_factur, id_obs, observation.code_ctrl AS code_ctrl, observation.result as id_res, resultat.lib as resultat, date_ctrl FROM ctrl_obs JOIN observation ON observation.id = ctrl_obs.id_obs join resultat on observation.result = resultat.id where id_vehicule = $id_vehicule group by code_ctrl order by id_vehicule asc ";

                                                    //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                                                    $response2 = array();
                                                    $result2 = mysqli_query($conn, $query2);

                                                    /*$code_obs = array();
                                            $resultat = array();*/
                                                    ?>

                                                    <td>
                                                        <?php
                                                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>

                                                            <li><?php echo $row2["code_ctrl"]; ?></li>

                                                        <?php
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $result2 = mysqli_query($conn, $query2);
                                                        $resultat = array();
                                                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                                                            $resultat[] = $row2["id_res"];
                                                        ?>
                                                            <li><?php echo $row2["resultat"]; ?></li>
                                                        <?php
                                                        }

                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php

                                                        $count = 0;
                                                        $count1 = 0;
                                                        $res_count;

                                                        $result2 = mysqli_query($conn, $query2);
                                                        $resultat = array();
                                                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                                                            $count1 = $count1 + $row2["id_res"];
                                                            $count++;
                                                        }



                                                        if ($count == 0) {
                                                        ?>
                                                            <span class="badge badge-success"> success </span>
                                                            <?php
                                                        } else if ($count > 0) {

                                                            $count2 = $count1 / $count;
                                                            if ($count2 == 1) {
                                                            ?>
                                                                <span class="badge badge-warning"> Avertissement </span>

                                                            <?php
                                                            } else if ($count2 > 1) {
                                                            ?>
                                                                <span class="badge badge-danger"> Echec </span>
                                                        <?php
                                                            }
                                                        }


                                                        ?>



                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info" href="edit_result.php?id_vehic=<?= $row["id_vehic"]; ?>&id_factur=<?= $row["id_factur"]; ?>">Rapport</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a class="dropdown-item" href="rapport.php?id_vehic=<?= $row["id_vehic"]; ?>&id_factur=<?= $row["id_factur"]; ?>">imprimer rapport</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a aria-disabled="true" class="dropdown-item" href="recu2.php?id_vehic=<?= $row["id_vehic"]; ?>&id_factur=<?= $row["id_factur"]; ?>">imprimer reçu</a>
                                                                <div class="dropdown-divider"></div>

                                                                <?php
                                                                if ($count > 1) {

                                                                ?>
                                                                    <a class="dropdown-item">imprimer vignette + visite</a>

                                                                <?php
                                                                } else { ?>
                                                                    <a class="dropdown-item" href="carte_vign.php?id_vehic=<?= $row["id_vehic"]; ?>&id_factur=<?= $row["id_factur"]; ?>">imprimer vignette + visite</a>

                                                                <?php
                                                                }

                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>

                                            <?php
                                            }
                                            ?>

                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>N° Immatriculation</th>
                                                <th>Catégorie de véhicules</th>
                                                <th>Control effectué</th>
                                                <th>Observation</th>
                                                <th>Résultat</th>
                                                <th>Résultat</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <!-- /.Tableau véhicules controlés -->

                        </div><!-- /.container-fluid -->
                    </section>
                </div>


                <!-- footer -->
                <?php
                // Include config file
                include("../footer.php");
                ?>
                <!-- ./footer -->

            </div>

            <!-- jQuery -->
            <script src="../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables  & Plugins -->
            <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <script src="../plugins/jszip/jszip.min.js"></script>
            <script src="../plugins/pdfmake/pdfmake.min.js"></script>
            <script src="../plugins/pdfmake/vfs_fonts.js"></script>
            <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js"></script>
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
        header('Location: ../restriction.php');
    }
}
?>