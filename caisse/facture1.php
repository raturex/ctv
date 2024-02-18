<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 5 || $_SESSION["role"] == 1)) {
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
                                    <h1>Caisse</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Facture</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>





                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12 col-12">

                                    <!-- small box -->
                                    <a href="nclient.php" class="small-box-footer">
                                        <div class="small-box bg-primary">
                                            <div class="inner">
                                                <p><strong>Nouvelle facture</strong></p>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                                <!-- ./col -->

                            </div>
                            <!-- /.row -->



                            <div class="col-sm-12">

                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Liste des véhicules pré-enregistré</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- Table -->
                                    <div class="card-body">

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Immatriculation</th>
                                                    <th>Marque</th>
                                                    <th>Type tech</th>
                                                    <th>Propriétaire</th>
                                                    <th>Date d'enregistrement</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($list_vehic as $vehicule) {
                                                ?>

                                                    <tr>
                                                        <td><?php echo $vehicule['id'] ?> </td>
                                                        <td><?php echo $vehicule['immatriculation'] ?> </td>
                                                        <td><?php echo $vehicule['marque'] ?> </td>
                                                        <td><?php echo $vehicule['type_tech'] ?> </td>
                                                        <td><?php echo $vehicule['proprietaire'] ?> </td>
                                                        <td><?php echo $vehicule['date_enreg'] ?> </td>

                                                        <td>
                                                            <input type="hidden" name="id_vehicule" value="<?= $vehicule["id"]; ?>">
                                                            <input type="hidden" name="id_fact" value="<?= $vehicule["id_fact"]; ?>">
                                                            <input type="hidden" name="id_pvign" value="<?= $vehicule["id_vignette"]; ?>">

                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-info" href="load_to_invoice.php?id_vehicule=<?= $vehicule["id"]; ?>&id_fact=<?= $vehicule["id_fact"]; ?>&id_pvign=<?= $vehicule["id_vignette"]; ?>" value="Payement">Caisse</button>
                                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <a class="dropdown-item" href="load_to_invoice.php?id_vehicule=<?= $vehicule["id"]; ?>&id_fact=<?= $vehicule["id_fact"]; ?>&id_pvign=<?= $vehicule["id_vignette"]; ?>" value="Payement">Régler facture</a>

                                                                
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