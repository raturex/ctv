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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 6 || $_SESSION["role"] == 7 || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vWait FROM facturation WHERE etat = 3 and date = '" . $date . "%'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vWait = $request->fetch();


        $id_user=$_SESSION["id_user"];
        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vehicEnreg FROM prefacture WHERE id_user='".$id_user."'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vehicEnreg = $request->fetch();


        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vehicEnreg2 FROM prefacture WHERE id_user=".$id_user." and date like '".$date."%'" ;
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vehicEnreg2 = $request->fetch();

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vCtrlperso2 FROM controle WHERE id_ctrler= ".$_SESSION["id_user"]." and date like '" . $date . "'";
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
                                    <h1>Edition</h1>
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
                                <div class="col-lg-12 col-12">
                                    <!-- small box -->
                                    <a href="controle_termine.php" class="small-box-footer">
                                        <div class="small-box bg-primary">
                                            <div class="inner">
                                                    <p><strong>Editer les résultats </strong></p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-bag"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- ./col -->

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
                                        <img class="img-circle elevation-2" src="../img/form.png" alt="User Avatar">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-6 border-right">


                                                <div class="description-block">

                                                    <?php if ($vehicEnreg["vehicEnreg"] > 1) { ?>
                                                        <h5 class="description-header"><?php echo $vehicEnreg["vehicEnreg"]; ?></h5>
                                                        <span class="description-text">Véhicules Traités</span>

                                                    <?php } else { ?>
                                                        <h5 class="description-header"><?php echo $vehicEnreg["vehicEnreg"]; ?></h5>
                                                        <span class="description-text">Véhicule Traité</span>
                                                    <?php } ?>


                                                </div>

                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6 ">

                                                <a href="#" class="small-box-footer">

                                                    <div class="description-block">

                                                        <?php if ($vehicEnreg2["vehicEnreg2"] > 1) { ?>
                                                            <h5 class="description-header"><?php echo $vehicEnreg2["vehicEnreg2"]; ?></h5>
                                                            <span class="description-text">Véhicules Traités aujourd'hui</span>
                                                        <?php } else { ?>
                                                            <h5 class="description-header"><?php echo $vehicEnreg2["vehicEnreg2"]; ?></h5>
                                                            <span class="description-text">Véhicule Traité aujourd'hui</span>
                                                        <?php } ?>

                                                    </div>
                                                    <!-- /.description-block -->
                                                </a>


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