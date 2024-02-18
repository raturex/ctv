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

  if (isset($_SESSION["role"])/* && ($_SESSION["role"] == 2 || $_SESSION["role"] == 5)*/) {
    // Initialize the session
    //session_start();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Actia | Statistiques</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
    </head>


    <?php
    require_once("api/db_connect.php");
    //requête
    $dateNow = date("Y-m-d");
    $sql = "SELECT COUNT(id) as nbVehic FROM vehicule WHERE date_enreg like '%$dateNow%' ";
    // On prépare la requête
    $request = $db_PDO->prepare($sql);
    $request = $db_PDO->query($sql);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $count = $request->fetch();

    $nbVehic = $count["nbVehic"];

    //requête
    $sql = "SELECT COUNT(id) as nbVehicControl FROM facturation WHERE date like '%$dateNow%' and etat = 3";
    // On prépare la requête
    $request = $db_PDO->prepare($sql);
    $request = $db_PDO->query($sql);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $count = $request->fetch();

    $nbVehicControl = $count["nbVehicControl"];

    //requête
    $sql = "SELECT SUM(prix_visite)+SUM(prix_vignette)+SUM(prix_vignette_pen)+SUM(prix_timbre) as somTotal FROM facturation WHERE  date like '%$dateNow%' and etat = 3";
    // On prépare la requête
    $request = $db_PDO->prepare($sql);
    $request = $db_PDO->query($sql);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $count = $request->fetch();

    $SommEncaiss = $count["somTotal"];
    ?>


    <body class="hold-transition sidebar-mini">
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
                  <h1 class="m-0">Mes statistiques</h1> <?php echo date("Y-m-d"); ?>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Statistiques</a></li>
                    <li class="breadcrumb-item active">Mes statistiques</li>
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content-header -->

          <?php
          require_once("api/db_connect.php");
          //requête
          //$sql = "SELECT DISTINCT categorie, COUNT(categorie) as nb FROM `vehicule`  group by categorie";
          $sql = "SELECT DISTINCT vehicule.categorie as label,  COUNT(vehicule.categorie) as nb, categ.code_couleur as c_couleur FROM vehicule JOIN categ ON categ.id = vehicule.id_categ WHERE vehicule.date like '%$dateNow%' group by vehicule.categorie";
          // On prépare la requête
          $request = $db_PDO->prepare($sql);
          $request = $db_PDO->query($sql);
          // On exécute la requête
          $request->execute();
          // On stocke le résultat dans un tableau associatif
          $count = $request->fetchAll(PDO::FETCH_ASSOC);

          //$categ_data = Array();

          //$categ_data = json_encode($count);

          $stat1 = array(
            'labels'    => array(),
            'datasets'  => array()
          );
          $datasets = array(
            'data'    => array(),
            'backgroundColor'  => array()
          );

          foreach ($count as $lab) {

            $label = $lab['label'];
            $data = $lab['nb'];
            $bgColor = $lab['c_couleur'];

            array_push($stat1['labels'], $label);
            array_push($datasets['backgroundColor'], $bgColor);
            array_push($datasets['data'], $data);
          }
          

          array_push($stat1['datasets'], $datasets);
          echo json_encode($stat1, JSON_NUMERIC_CHECK);
          echo $bgColor;





          // echo "".$stat1['labels'];
          //echo $label;

          ?>


          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Véhicules Reçus</span>
                      <span class="info-box-number"><?php echo $nbVehic ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Véhicules Contrôlés</span>
                      <span class="info-box-number"><?php echo $nbVehicControl ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Somme Total Encaissé</span>
                      <span class="info-box-number"><?php echo $SommEncaiss ?></span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Likes</span>
                      <span class="info-box-number">41,410</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>

              </div>

              <div class="row">
                <div class="col-md-6">
                  <!-- AREA CHART -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Area Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                  <!-- DONUT CHART -->
                  <div class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">Donut Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                  <!-- PIE CHART -->
                  <div class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">Pie Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                  <!-- LINE CHART -->
                  <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Line Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                  <!-- BAR CHART -->
                  <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Bar Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                  <!-- STACKED BAR CHART -->
                  <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Stacked Bar Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
          <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.1.0
          </div>
          <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Add Content Here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->

      <!-- jQuery -->
      <script src="plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- ChartJS -->
      <script src="plugins/chart.js/Chart.min.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/adminlte.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js"></script>



      <?php
      require_once("api/db_connect.php");
      //requête
     // $sql = "SELECT DISTINCT categorie, COUNT(categorie) as nb FROM vehicule group by categorie";
      // On prépare la requête
     // $request = $db_PDO->prepare($sql);
      //$request = $db_PDO->query($sql);
      // On exécute la requête
    //  $request->execute();
      // On stocke le résultat dans un tableau associatif
  //    $stat1 = $request->fetchAll(PDO::FETCH_ASSOC);
      //$categ_data = Array();
//      $categ_data = json_encode($stat1);

      //$label = array();
/*
      $labell = json_encode($label['categorie']);

      foreach ($stat1 as $labels) {
      }
      foreach ($stat1 as $nb) {
        echo $label['nb'];
      }

*/
      ?>


      <!-- Page specific script -->
      <script>
        $(function() {
          /* ChartJS
           * -------
           * Here we will create a few charts using ChartJS
           */

          //--------------
          //- AREA CHART -
          //--------------

          // Get context with jQuery - using jQuery's .get() method.
          var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
          var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Digital Goods',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27, 90]
              },
              {
                label: 'Electronics',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55, 40]
              },
            ]
          }
          var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
              display: false
            },
            scales: {
              xAxes: [{
                gridLines: {
                  display: false,
                }
              }],
              yAxes: [{
                gridLines: {
                  display: false,
                }
              }]
            }
          }

          // This will get the first returned node in the jQuery collection.
          new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
          })

          //-------------
          //- LINE CHART -
          //--------------
          var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
          var lineChartOptions = $.extend(true, {}, areaChartOptions)
          var lineChartData = $.extend(true, {}, areaChartData)
          lineChartData.datasets[0].fill = false;
          lineChartData.datasets[1].fill = false;
          lineChartOptions.datasetFill = false

          var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
          })

          //-------------
          //- DONUT CHART -
          //-------------
          // Get context with jQuery - using jQuery's .get() method.


          var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
          var donutData = <?php echo json_encode($stat1, JSON_NUMERIC_CHECK); ?>;
          
          /*{
            labels: [''],
            datasets: [{
              data: [500, 51],
              backgroundColor: ['#f56954', '#00a65a'],
            }]
          }
          */
          var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
          }
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
          })




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

          //---------------------
          //- STACKED BAR CHART -
          //---------------------
          var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
          var stackedBarChartData = $.extend(true, {}, barChartData)

          var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              xAxes: [{
                stacked: true,
              }],
              yAxes: [{
                stacked: true
              }]
            }
          }

          new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
          })
        })
      </script>

    </body>

    </html>




<?php
  } else {
    header('Location: restriction.php');
  }
}
?>