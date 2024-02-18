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

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as vWait FROM facturation WHERE etat = 1 and date = '" . $date . "%'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vWait = $request->fetch();

        $id_user = $_SESSION["id_user"];
        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as AtPay FROM prefacture  WHERE etat= 1 ";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $AtPay = $request->fetch();


        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT count(id) as nbFacture ,  SUM(COALESCE(t_to_pay,0)) as sumTopay FROM facturation WHERE id_caisse=" . $id_user . " and date like '" . $date . "%'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $nbFacture = $request->fetch();

        /*
        require_once("../api/db_connect.php");
        //requête
        //$sql = "SELECT prix_visite, prix_vignette, prix_timbre, prix_vignette_pen FROM facturation WHERE etat= 3 and id_caisse= " . $id_user . " and date like '" . $date . "%'";
        $sql = "SELECT SUM(t_to_pay) as sumTopay FROM facturation  WHERE date LIKE '" . $date . "%' AND id_caisse = " . $id_user . "";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $totalDateJ = $request->fetch();
        */
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
                    





                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <!-- small box -->
                                    <a href="pre_enreg.php" class="small-box-footer">
                                        <div class="small-box bg-lightblue">
                                            <div class="inner">
                                                <p><strong>Facture en attente : </strong> <strong><?php echo $AtPay["AtPay"] ?></strong></p>
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

                            <div class="row">

<div class="col-lg-3 col-3">
    <!-- small box -->
    <a href="client.php" class="small-box-footer">
        <div class="small-box bg-primary">
            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
            <div class="inner">
                <h5 class="card-title text-primary text-white"><STRONG>VISITE TECHNIQUE</STRONG></h5>
                <p class="card-text text-white pb-0.5 pt-0.5">Visite technique de vehicule + vignette</p>                                            
            </div>
        </div>
    </a>

</div>
<!-- ./col -->

<div class="col-lg-3 col-3">
    <!-- small box -->
    <a href="client.php" class="small-box-footer">
        <div class="small-box bg-primary">
            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
            <div class="inner">
                <h5 class="card-title text-primary text-white"><STRONG>PRE-VISITE</STRONG></h5>
                <p class="card-text text-white pb-0.5 pt-0.5">Visite technique de vehicule</p>                                            
            </div>
        </div>
    </a>

</div>
<!-- ./col -->

<div class="col-lg-3 col-3">
    <!-- small box -->
    <a href="client.php" class="small-box-footer">
        <div class="small-box bg-primary">
            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
            <div class="inner">
                <h5 class="card-title text-primary text-white"><STRONG>DUPLICATA</STRONG></h5>
                <p class="card-text text-white pb-0.5 pt-0.5">Duplicata de documents</p>                                            
            </div>
        </div>
    </a>

</div>
<!-- ./col -->


<div class="col-lg-3 col-3">
    <!-- small box -->
    <a href="client.php" class="small-box-footer">
        <div class="small-box bg-primary">
            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
            <div class="inner">
                <h5 class="card-title text-primary text-white"><STRONG>...</STRONG></h5>
                <p class="card-text text-white pb-0.5 pt-0.5">...</p>                                            
            </div>
        </div>
    </a>

</div>
<!-- ./col -->



</div>
<!-- /.row -->
                            <!-- /.container-fluid<div class="row">
                                <div class="row">


                                <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">VISITE TECHNIQUE</h5>
                                                <p class="card-text text-white pb-2 pt-1">Visite technique de vehicule + vignette</p>
                                            </a>
                                        </div>
                                    </div>



                                    <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">VISITE TECHNIQUE</h5>
                                                <p class="card-text text-white pb-2 pt-1">Visite technique de vehicule + vignette</p>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">PREVISITE</h5>
                                                <p class="card-text text-white pb-2 pt-1">Pre-visite technique des vehicules </p>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">REVISITE</h5>
                                                <p class="card-text text-white pb-2 pt-1">Re-visite technique des vehicules </p>
                                            </a>
                                        </div>
                                    </div>




                                    <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">DUPLICATA</h5>
                                                <p class="card-text text-white pb-2 pt-1">Duplicata des documents </p>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="col-sd-3 col-md-3 col-lg-3 col-xl-3">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="../dist/img/photo1.png" alt="Dist Photo 1">
                                            <a href="pre_enreg.php" class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">IMMATRICULATION</h5>
                                                <p class="card-text text-white pb-2 pt-1">Pré-commande des plaques d'immatriculations </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
-->


                                <div class="col-md-12">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="card card-widget widget-user shadow">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-lightblue">
                                        <div class="row">

                                            <div class="col-lg-2 col-2">
                                            
                                            </div>

                                            <div class="col-lg-8 col-8">
                                                <h3 class="widget-user-username"><?php echo $_SESSION["nom"] . ' ' . $_SESSION["prenoms"]; ?></h3>
                                                <h5 class="widget-user-desc"><?php echo $nom_role; ?></h5>
                                            </div>

                                            <div class="col-lg-2 col-2">
                                            <button></button>
                                            </div>

                                            </div>

                                        </div>

                                        <div class="widget-user-image">
                                            <img class="img-circle elevation-2" src="../img/caisse.png" alt="caisse">
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6 border-right">

                                                <a href="caisse.php" class="small-box-footer">

                                                    <div class="description-block">

                                                        <?php if ($nbFacture["nbFacture"] > 1) { ?>
                                                            <h5 class="description-header"><?php echo $nbFacture["nbFacture"]; ?></h5>
                                                            <span class="description-text">Factures réglés</span>

                                                        <?php } else { ?>
                                                            <h5 class="description-header"><?php echo $nbFacture["nbFacture"]; ?></h5>
                                                            <span class="description-text">Facture réglé</span>
                                                        <?php } ?>


                                                    </div>

                                                    <!-- /.description-block -->
                                                    </a>

                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-6 ">

                                                    <a href="caisse.php" class="small-box-footer">

                                                        <div class="description-block">


                                                            <h5 class="description-header"><?php echo 0 + $nbFacture["sumTopay"]; ?></h5>
                                                            <span class="description-text">Somme totale encaissée</span>


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




                            </div> 

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