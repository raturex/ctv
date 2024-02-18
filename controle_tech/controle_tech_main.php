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


  if (isset($_SESSION["role"]) && ($_SESSION["role"] == 4 /*|| $_SESSION["role"] == 3*/ || $_SESSION["role"] == 1)) {
    // Initialize the session
    //session_start();




?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>AdminLTE 3 | DataTables</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">

        <!-- En tete -->
        <?php
        // Include nav_bar 
        include("../nav_bar.php");
        ?>
        <!-- ./En tete -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Contrôle technique en cours</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Contrôle technique</a></li>
                    <li class="breadcrumb-item active">Liste d'attente</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>




          <!-- Main content -->
          <section class="content">

            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">CONTROLE</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">

                <?php
                global $conn;
                $id_vehicule = 8;
                $query2 = "SELECT ctrl_obs.id AS id, id_vehicule, id_factur, id_obs, observation.code_ctrl AS code_ctrl, observation.result as id_res, resultat.lib as resultat, date_ctrl, observation.def_const_localis as def_vis_label, CONTROLE.kilometrage as km FROM ctrl_obs JOIN observation ON observation.id = ctrl_obs.id_obs join resultat on observation.result = resultat.id JOIN CONTROLE ON ctrl_obs.id_controle=CONTROLE.id where id_vehicule = $id_vehicule group by code_ctrl order by id_vehicule asc ";

                //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                $response2 = array();
                $result2 = mysqli_query($conn, $query2);

                while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                      <div class="row">
                        <div class="col-12 col-sm-4">
                          <div class="info-box bg-light">
                            <div class="info-box-content">
                              <span class="info-box-text text-center text-muted">KILOMETRAGE</span>
                              <span class="info-box-number text-center text-muted mb-0"><?php echo $row2["km"]; ?></span>
                            </div>
                          </div>
                        </div>



                      </div>
                      <div class="row">
                        <div class="col-12">
                          <h4>RESULTAT CONTROLE</h4>

                          <div>Défauts &amp; Observations :

                            <div class="post">
                              <div class="user-block">
                                <span class="username">
                                  <a href="#">DEFAUTS VISUEL</a>
                                </span>
                                <span class="description">Ensemble des defaut constatés par l'agent contrôleur</span>
                              </div>
                              <!-- /.user-block -->

                              <?php
                              global $conn;
                              $id_vehic = 8;
                              $id_factur = 23;
                              $id_controle = 1;

                              $query2 = "SELECT ctrl_obs.id AS id, id_vehicule, id_factur, id_obs, observation.code_ctrl AS code_ctrl, observation.pt_ctrl as pt_ctrl, observation.def_const_localis as defobs, observation.result as id_res, resultat.lib as resultat, date_ctrl FROM ctrl_obs LEFT JOIN observation ON observation.id = ctrl_obs.id_obs join resultat on observation.result = resultat.id where id_vehicule = $id_vehic and id_factur=$id_factur /*and id_controle=$id_controle*/ order by id_vehicule asc";

                              //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                              $response2 = array();
                              $result2 = mysqli_query($conn, $query2);

                              /*$code_obs = array();
                                            $resultat = array();*/

                              $count1 = 0;
                              $count2 = 0;
                              $sor1 = array();
                              $sor2 = array();


                              while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {


                                if ($row2["id_res"] == 2) {
                                  $count2 = $count2 + 1;
                                  $sor2[] = $row2["code_ctrl"] . ": " . $row2["defobs"];
                                } else if ($row2["id_res"] == 1) {
                                  $count1 = $count2 + 1;
                                  $sor1[] = $row2["code_ctrl"] .  ": " . $row2["defobs"];
                                }
                              }
                              ?>

                              <p>
                                <?php if ($count2 > 0) {
                                  echo "</br></br> 1 - A CORRIGER AVEC OBLIGATION DE REVISITE :  $count2  </br>";
                                  foreach ($sor2 as $aorv) {
                                    echo "$aorv <br>";
                                  }
                                } else {
                                  echo "</br></br> 1 - A CORRIGER AVEC OBLIGATION DE REVISITE : $count2 </br>";
                                }

                                if ($count1 > 0) {
                                  echo "</br></br> 2 - A CORRIGER SANS OBLIGATION DE REVISITE : $count1  </br>";
                                  foreach ($sor1 as $sorv1) {
                                    echo " $sorv1  <br>";
                                  }
                                } else {
                                  echo "</br></br>  2 - A CORRIGER SANS OBLIGATION DE REVISITE : $count1  </br>";
                                }
                                ?>
                              </p>
                            </div>

                          </div>





                          <div class="post clearfix">
                            <div class="user-block">
                              <span class="username">
                                <a href="#">MESURE G</a>
                              </span>
                              <span class="description">Gas analyser</span>
                            </div>
                            <!-- /.user-block -->



                            <?php
                            global $conn;
                            $id_vehic = 8;
                            $id_factur = 23;
                            $id_controle = 1;

                            $query2 = "
                              SELECT `id_res`, `id_fact`, `id_vehicule`, `0200`, `0509`, `0510`, `0517`, `7805`, `0513` FROM `res_g` where `id_vehicule` = $id_vehic and `id_fact`=$id_factur order by id_vehicule asc";

                            //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                            $response2 = array();
                            $result2 = mysqli_query($conn, $query2);

                            /*$code_obs = array();
                                            $resultat = array();*/

                            $count1 = 0;
                            $count2 = 0;
                            $sor1 = array();
                            $sor2 = array();


                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {


                              echo "</br> 0509 - Volume CO ralenti    : " . $row2["0509"];
                              echo "</br> 0510 - Volume CO² ralenti   : " . $row2["0510"];
                              echo "</br> 0517 -  : " . $row2["0517"];
                              echo "</br> 7805 : " . $row2["7805"];
                              echo "</br> 0513 : " . $row2["0513"];
                            }
                            ?>


                          </div>


                         

                          <div class="post clearfix">
                            <div class="user-block">
                              <span class="username">
                                <a href="#">MESURE F</a>
                              </span>
                              <span class="description">Mesure Brake tester</span>
                            </div>
                            <!-- /.user-block -->



                            <?php
                            global $conn;
                            $id_vehic = 8;
                            $id_factur = 23;
                            $id_controle = 1;

                            $query2 = "SELECT `id_res`, `id_fact`, `id_vehicule`, `0200`, `0420`, `0421`, `0422`, `0423`, `0424`, `0425`, `0426`, `0427`, `0430`, `0431`, `0434`, `0435`, `0438`, `0439`, `0442`, `0443`, `0446`, `0447`, `0448`, `0449`, `1128`, `1228`, `0450`, `0460`, `0461`, `0462`, `0465`, `0466`, `0468`, `0469`, `0470` FROM `res_f`  where `id_vehicule` = $id_vehic and `id_fact`=$id_factur order by id_vehicule asc";

                            //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                            $response2 = array();
                            $result2 = mysqli_query($conn, $query2);

                            /*$code_obs = array();
                                            $resultat = array();*/

                            $count1 = 0;
                            $count2 = 0;
                            $sor1 = array();
                            $sor2 = array();

                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {

                              echo "</br> 0420 - Pesée roue avant droite : " . $row2["0420"];
                              echo "</br> 0421 - Pesée roue avant gauche : " . $row2["0421"];
                              echo "</br> 0422 - Pesée essieux avant: " . $row2["0422"];
                              echo "</br> 0423 - Pesée roue arrière droite : " . $row2["0423"];
                              echo "</br> 0424 - Pesée roue arrière gauche : " . $row2["0424"];
                              echo "</br> 0425 - Pesée essieu arrière: " . $row2["0425"];
                              echo "</br> 0426 - Pesée totale véhicule : " . $row2["0426"];
                              echo "</br> 0427 - Date et heure de l'essaie : " . $row2["0427"];
                              echo "</br> 0430 - Force maximum avant gauche : " . $row2["0430"];
                              echo "</br> 0431 - Force maximum avant droite : " . $row2["0431"];
                              echo "</br> 0434 -Déséquilibrage freinage avant : " . $row2["0434"];
                              echo "</br> 0435 - Methode retenue (avant) : " . $row2["0435"];
                              echo "</br> 0438 : " . $row2["0438"];
                              echo "</br> 0439 : " . $row2["0439"];
                              echo "</br> 0442 : " . $row2["0442"];
                              echo "</br> 0442 : " . $row2["0443"];
                              echo "</br> 0446 : " . $row2["0446"];
                              echo "</br> 0447 : " . $row2["0447"];
                              echo "</br> 0448 : " . $row2["0448"];
                              echo "</br> 0449 : " . $row2["0449"];
                              echo "</br> 1128 : " . $row2["1128"];
                              echo "</br> 1228 : " . $row2["1228"];
                              echo "</br> 0450 : " . $row2["0450"];
                              echo "</br> 0460 : " . $row2["0460"];
                              echo "</br> 0461 : " . $row2["0461"];
                              echo "</br> 0462 : " . $row2["0462"];
                              echo "</br> 0465 : " . $row2["0465"];
                              echo "</br> 0466 : " . $row2["0466"];
                              echo "</br> 0468 : " . $row2["0468"];
                              echo "</br> 0469 : " . $row2["0469"];
                              echo "</br> 0470 : " . $row2["0470"];
                            }
                            ?>


                          </div>


                        </div>
                      </div>
                    </div>


                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                      <?php
                      require_once("../api/db_connect.php");

                      if (
                        isset($_GET["id_vehic"]) && !empty($_GET["id_vehic"])
                        && isset($_GET["id_factur"]) && !empty($_GET["id_factur"])

                      ) {

                        $id_vehic = $_GET["id_vehic"];
                        $id_factur = $_GET["id_factur"];

                        $query = "SELECT categ.categorie,vehicule.id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, energie.lib, nb_place, ptac, puiss_fisc, id_genre, genre.lib as genre, date_mise_circul, date_local 
from vehicule left join energie on vehicule.id_energie=energie.id left join genre on vehicule.id_genre=genre.id left join categ on vehicule.id_categ=categ.id  Where vehicule.id='" . $id_vehic . "'";
                        $request = $db_PDO->prepare($query);
                        $request = $db_PDO->query($query);
                        $vehicule = $request->fetch();


                        $annee = date("Y");

                        require_once("../api/db_connect.php");
                        //requête
                        $sql = "SELECT max(id) as max FROM facturation where facturation.date like '" . $annee . "%'";
                        // On prépare la requête
                        $request = $db_PDO->prepare($sql);
                        $request = $db_PDO->query($sql);
                        // On exécute la requête
                        $request->execute();
                        // On stocke le résultat dans un tableau associatif
                        $reset2 = $request->fetch();
                        $number = $reset2["max"] + 1;

                        $length = 6;
                        $numb = substr(str_repeat(0, $length) . $number, -$length);
                        $num_certificat = "A" . $numb;



                        /*$code_obs = array();
                                            $resultat = array();*/

                      ?>
                        <h3 class="text-primary"> <?php echo $vehicule["immatriculation"] ?> </h3>
                        <br>
                        <div class="text-muted">
                          <p class="text-sm">Proprietaire
                            <b class="d-block"><?php echo $vehicule["proprietaire"] ?></b>
                          </p>
                          <p class="text-sm">Marque du véhicule
                            <b class="d-block"><?php echo $vehicule["marque"] ?></b>
                          </p>
                          <p class="text-sm">Type Technique
                            <b class="d-block"><?php echo $vehicule["type_tech"] ?></b>
                          </p>
                          <p class="text-sm">Numéro de série
                            <b class="d-block"><?php echo $vehicule["num_serie"] ?></b>
                          </p>
                          <p class="text-sm">Categorie
                            <b class="d-block"><?php echo $vehicule["categorie"] ?></b>
                          </p>
                          <p class="text-sm">Numéro de vignette
                            <b class="d-block"><?php echo $vehicule["num_serie"] ?></b>
                          </p>
                          <p class="text-sm">Exp. vignette
                            <b class="d-block"><?php echo $vehicule["num_serie"] ?></b>
                          </p>

                        <?php
                      }
                        ?>
                        </div>

                       
                        <div class="text-center mt-5 mb-3">
                          <a href="gestion_resultat.php" class="btn btn-sm btn-primary">CHARGER LES RESULTATS</a>
                          <a href="controle_result.php?id_vehic=<?= $id_vehic; ?>&id_factur=<?= $id_factur; ?>" class="btn btn-sm btn-success">VALIDER LE RESULTAT</a>
                        </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.content -->


          <!-- footer -->
          <?php
          // Include config file
          include("../footer.php");
          ?>
          <!-- ./footer -->

        </div>
        <!-- ./wrapper -->

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
              "searching": true,
              "ordering": true,
              "info": false,

              //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
              "paging": false,
              "lengthChange": false,
              "searching": false,
              "ordering": false,
              "info": false,
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