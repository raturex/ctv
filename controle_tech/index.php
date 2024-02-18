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
    $date = date("Y-m-d");


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 4 || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

        $listfichier = "";
        $nup = 0;
        $scandir = scandir("../certificat/PISTE1/");
        foreach ($scandir as $fichier) {
            if ($nup == 0) {
                if (($pos = strpos($fichier, ".")) !== FALSE) {
                    $listfichier = "'" . substr($fichier, 0, $pos) . "'";
                    $nup++;
                }
            } else {
                if (($pos = strpos($fichier, ".")) !== FALSE) {
                    $listfichier = $listfichier . ",'" . substr($fichier, 0, $pos) . "'";
                }
                $nup++;
            }
        }


        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vWait FROM facturation WHERE etat = 4 and facturation.date like '$date%' ";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vWait = $request->fetch();

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vDo FROM facturation WHERE etat = 2 or etat = 5 or etat = 6 /*and facturation.date like '$date%'*/ ";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vDo = $request->fetch();

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vCtrl FROM controle WHERE date like '" . $date . "%'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vCtrl = $request->fetch();


        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vCtrlperso FROM controle WHERE id_ctrler=" . $_SESSION["id_user"] . " ";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vCtrlperso = $request->fetch();

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vCtrlperso2 FROM controle WHERE id_ctrler=" . $_SESSION["id_user"] . " and date like '" . $date . "%'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vCtrlperso2 = $request->fetch();

?>





        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>AdminLTE 3 | ChartJS</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
        </head>

        <body class="hold-transition sidebar-mini">
            <div class="wrapper">

                <?php
                // Include menu nav_bar
                include("../nav_bar.php");
                ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Contrôle technique</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>


                   


                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <!-- small box -->
                                    <a href="controle_cours.php" class="small-box-footer">
                                        <div class="small-box bg-primary">
                                            <div class="inner">
                                                <h3><?php echo $vDo["vDo"]; ?></h3>
                                                <?php if ($vDo["vDo"] > 1) { ?>
                                                    <p><strong>Contrôle En Cours</strong></p>

                                                <?php } else { ?>
                                                    <p><strong>Contrôle En Cours</strong></p>
                                                <?php } ?>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <!-- small box -->
                                    <a href="controle_list_attente.php" class="small-box-footer">

                                        <div class="small-box bg-primary">
                                            <div class="inner">
                                                <h3><?php echo $vWait["vWait"]; ?></h3>
                                                <?php if ($vWait["vWait"] > 1) { ?>
                                                    <p><strong>Véhicules En Attente </strong></p>

                                                <?php } else { ?>
                                                    <p><strong>Véhicule En Attente </strong></p>
                                                <?php } ?>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- ./col -->
                                
                                <div class="col-12">

                                    <!-- card -->
                                    <div class="card">
                                        <?php

                                        $listfichier = "";
                                        $nup = 0;
                                        $scandir = scandir("../certificat/PISTE1/GIEGLAN/CG");
                                        foreach ($scandir as $fichier) {
                                            if ($nup == 0) {
                                                if (($pos = strpos($fichier, ".")) !== FALSE) {
                                                    $listfichier = "'" . substr($fichier, 0, $pos) . "'";
                                                    $nup++;
                                                }
                                            } else {
                                                if (($pos = strpos($fichier, ".")) !== FALSE) {
                                                    $listfichier = $listfichier . ",'" . substr($fichier, 0, $pos) . "'";
                                                }
                                                $nup++;
                                            }
                                        }

                                        require_once "../api/db_connect.php";

                                        global $conn;
                                        $date = date("Y-m-d");

                                        $query = "SELECT client.nom AS nom_client, client.prenom AS pnoms_client, vehicule.id AS id, etat, facturation.id AS id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib AS energie, nb_place, ptac, puiss_fisc, genre.lib AS type_trans, categ.categorie AS categ, date_mise_circul, date_local AS date_immatri, type_ctrl.lib AS type_ctrl, id_client, age_vehi, date
    FROM
        facturation
    LEFT JOIN vehicule ON vehicule.id = id_vehicule
    LEFT JOIN energie ON vehicule.id_energie = energie.id
    LEFT JOIN genre ON vehicule.id_genre = genre.id
    LEFT JOIN categ ON vehicule.id_categ = categ.id
    LEFT JOIN client ON client.id = facturation.id_client
    LEFT JOIN type_ctrl ON facturation.id_ctrl = type_ctrl.id

    WHERE
        etat = 4 and facturation.date like '$date%' and immatriculation not in ($listfichier)
    ORDER BY
        id_factur
    ASC
        ";

                                        $response = array();
                                        $result = mysqli_query($conn, $query);
                                        ?>

                                        <!-- /.card-header -->
                                        <div class="card-body">


                                            <table id="example1" class="table table-bordered table-striped">

                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>N° Immatriculation</th>
                                                        <th>Marque</th>
                                                        <th>Propriétaire</th>
                                                        <th>numéro de série</th>
                                                        <th>Type de transport</th>
                                                        <th>Action</th>


                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo $row["id_factur"];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $row["immatriculation"];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $row["marque"];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $row["nom_client"] . ' ' . $row["pnoms_client"];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $row["num_serie"];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $row["type_trans"];
                                                                ?>
                                                            </td>

                                                            <td width="15%">

                                                            <?php if ($vDo["vDo"] > 0) { ?>

                                                                <a class="btn btn-app bg-warning" >
                                                                    <i class="fas fa-cogs"></i> Commencer le contrôle
                                                                </a>
                                    <?php } else { ?>
                                        <a class="btn btn-app bg-warning" href="result_ctrl_tech.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">
                                                                    <i class="fas fa-cogs"></i> Commencer le contrôle
                                                                </a>
                                                            <?php } ?>


                                                            
                                                            </td>



                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>

                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->



                            </div>
                            <!-- /.row -->

                            <div class="col-md-12">
                                <!-- Widget: user widget style 1 -->
                                <div class="card card-widget widget-user shadow">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-info">
                                        <h3 class="widget-user-username"><?php echo $_SESSION["nom"] . ' ' . $_SESSION["prenoms"]; ?></h3>
                                        <h5 class="widget-user-desc"><?php echo $nom_role; ?></h5>

                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../img/meca.png" alt="User Avatar">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6 border-right">

                                                <a href="controle_cours.php" class="small-box-footer">

                                                    <div class="description-block">

                                                        <?php if ($vCtrlperso["vCtrlperso"] > 1) { ?>
                                                            <h5 class="description-header"><?php echo $vCtrlperso["vCtrlperso"]; ?></h5>
                                                            <span class="description-text">Véhicules Contrôlés</span>

                                                        <?php } else { ?>
                                                            <h5 class="description-header"><?php echo $vCtrlperso["vCtrlperso"]; ?></h5>
                                                            <span class="description-text">Véhicule Contrôlé</span>
                                                        <?php } ?>


                                                    </div>
                                                </a>

                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6 ">

                                                <div class="description-block">

                                                    <?php if ($vCtrlperso["vCtrlperso"] > 1) { ?>
                                                        <h5 class="description-header"><?php echo $vCtrlperso2["vCtrlperso2"]; ?></h5>
                                                        <span class="description-text">Véhicules Contrôlés aujourd'hui</span>
                                                    <?php } else { ?>
                                                        <h5 class="description-header"><?php echo $vCtrlperso2["vCtrlperso2"]; ?></h5>
                                                        <span class="description-text">Véhicule Contrôlé aujourd'hui</span>
                                                    <?php } ?>

                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>




                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <!-- footer -->
                <?php
                // Include config file
                include("../footer.php");
                ?>
                <!-- ./footer -->

                <!-- /.control-sidebar -->
            </div>
            <!-- ./wrapper -->

            <!-- jQuery -->
            <script src="../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- ChartJS -->
            <script src="../plugins/chart.js/Chart.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js"></script>
            <!-- Page specific script -->
            <script>
                $(function() {
                    /* ChartJS
                     * -------
                     * Here we will create a few charts using ChartJS
                     */


                    //-------------
                    //- PIE CHART -
                    //-------------
                    // Get context with jQuery - using jQuery's .get() method.
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieData = donutData;
                    var pieOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                    }
                    //Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                    new Chart(pieChartCanvas, {
                        type: 'pie',
                        data: pieData,
                        options: pieOptions
                    })

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $('#barChart').get(0).getContext('2d')
                    var barChartData = $.extend(true, {}, areaChartData)
                    var temp0 = areaChartData.datasets[0]
                    var temp1 = areaChartData.datasets[1]
                    barChartData.datasets[0] = temp1
                    barChartData.datasets[1] = temp0

                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }

                    new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    })


                })
            </script>
        </body>

        </html>

<?php
    } else {
        header('Location: ../restriction.php');
    }
}
?>