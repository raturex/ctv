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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 4 || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

?>


        <?php
        require_once("../api/db_connect.php");

        if (
            isset($_GET["id_vehic"]) && !empty($_GET["id_vehic"])
            && isset($_GET["id_factur"]) && !empty($_GET["id_factur"])

        ) {

            $id_vehic = $_GET["id_vehic"];
            $id_factur = $_GET["id_factur"];

            $query = "SELECT vehicule.id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, energie.lib, nb_place, ptac, puiss_fisc, id_genre, genre.lib as genre, date_mise_circul, date_local 
from vehicule left join energie on vehicule.id_energie=energie.id left join genre on vehicule.id_genre=genre.id Where vehicule.id='" . $id_vehic . "'";
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
                                    <h3 class="card-title">CONTROLE TECHNIQUE</h3>

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
                                $id_vehicule = $id_vehic;
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
                                                    <div class="col-12 col-sm-4">
                                                        <div class="info-box bg-light">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text text-center text-muted"> CATEGORIE</span>
                                                                <span class="info-box-number text-center text-muted mb-0"><?php echo $row2["km"]; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="info-box bg-light">
                                                            <div class="info-box-content">
                                                                <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                                                <span class="info-box-number text-center text-muted mb-0">20</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                // }
                                                ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Recent Activity</h4>
                                                        <div class="post">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                                <span class="username">
                                                                    <a href="#">CONTROLE VISUEL</a>
                                                                </span>
                                                                <span class="description">Shared publicly - <?php echo $row2["def_vis_label"]; ?></span>
                                                            </div>
                                                            <!-- /.user-block -->


                                                            <td>
                                                                <?php

                                                                //while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { 
                                                                ?>

                                                                <div class="card-body">
                                                                    <dl class="row">

                                                                        <dt class="col-sm-1">
                                                                            <b class="text-sm"><?php echo $row2["code_ctrl"]; ?></b>
                                                                        </dt>

                                                                        <dd class="col-sm-6">

                                                                            <p class="d-block"><?php echo $row2["def_vis_label"]; ?></p>
                                                                        </dd>
                                                                        <dd class="col-sm-4">

                                                                            <b class="d-block"><?php echo $row2["resultat"];  ?></b>
                                                                        </dd>

                                                                        <dd class="col-sm-1">
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
                                                                        </dd>

                                                                    </dl>
                                                                </div>


                                                                <p class="text-sm"><?php echo $row2["code_ctrl"]; ?>
                                                                    <b class="d-block"><?php echo $row2["def_vis_label"]; ?></b>
                                                                    <b class="d-block"><?php echo $row2["resultat"];  ?></b>
                                                                </p>

                                                            <?php
                                                        
                                                            ?>
                                                            </td>
                                                            </p>

                                                            <p>
                                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                                                            </p>
                                                        </div>

                                                        <div class="post clearfix">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                                                <span class="username">
                                                                    <a href="#">RESULTAT P</a>
                                                                </span>
                                                                <span class="description">Sent you a message - 3 days ago</span>
                                                            </div>
                                                            <!-- /.user-block -->
                                                            <p>
                                                                Lorem ipsum represents a long-held tradition for designers,
                                                                typographers and the like. Some people hate it and argue for
                                                                its demise, but others ignore.
                                                            </p>
                                                            <p>
                                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                                                            </p>
                                                        </div>

                                                        <div class="post">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                                <span class="username">
                                                                    <a href="#">RESULTAT O</a>
                                                                </span>
                                                                <span class="description">Shared publicly - 5 days ago</span>
                                                            </div>
                                                            <!-- /.user-block -->
                                                            <p>
                                                                Lorem ipsum represents a long-held tradition for designers,
                                                                typographers and the like. Some people hate it and argue for
                                                                its demise, but others ignore.
                                                            </p>

                                                            <p>
                                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                                            </p>
                                                        </div>
                                                        <div class="post">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                                <span class="username">
                                                                    <a href="#">RESULTAT F</a>
                                                                </span>
                                                                <span class="description">Shared publicly - 5 days ago</span>
                                                            </div>
                                                            <!-- /.user-block -->
                                                            <p>
                                                                Lorem ipsum represents a long-held tradition for designers,
                                                                typographers and the like. Some people hate it and argue for
                                                                its demise, but others ignore.
                                                            </p>

                                                            <p>
                                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                                            </p>
                                                        </div>
                                                        <div class="post">
                                                            <div class="user-block">
                                                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                                <span class="username">
                                                                    <a href="#">RESULTAT G</a>
                                                                </span>
                                                                <span class="description">Shared publicly - 5 days ago</span>
                                                            </div>
                                                            <!-- /.user-block -->
                                                            <p>
                                                                Lorem ipsum represents a long-held tradition for designers,
                                                                typographers and the like. Some people hate it and argue for
                                                                its demise, but others ignore.
                                                            </p>

                                                            <p>
                                                                <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                                                <h3 class="text-primary"><i class="fas fa-paint-brush"> <?php echo $vehicule["immatriculation"] ?> </i> </h3>
                                                <p class="text-muted">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
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
                                                    <p class="text-sm">Numéro de vignette
                                                        <b class="d-block"><?php echo $vehicule["num_serie"] ?></b>
                                                    </p>
                                                    <p class="text-sm">Exp. vignette
                                                        <b class="d-block"><?php echo $vehicule["num_serie"] ?></b>
                                                    </p>
                                                </div>

                                                <h5 class="mt-5 text-muted">CONTROLE EFFECTUE</h5>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Functional-requirements.docx</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> UAT.pdf</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> Email-from-flatbal.mln</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i> Logo.png</a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Contract-10_12_2014.docx</a>
                                                    </li>
                                                </ul>
                                                <div class="text-center mt-5 mb-3">
                                                    <a href="#" class="btn btn-sm btn-primary">CHARGER LES RESULTATS</a>
                                                    <a href="#" class="btn btn-sm btn-success">VALIDER LE RESULTAT</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php   } ?>
                                    </div>
                                        <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

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
                            "ordering": false,
                            "info": true,

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

                <!-- jQuery -->
                <script src="../../plugins/jquery/jquery.min.js"></script>
                <!-- Bootstrap 4 -->
                <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- AdminLTE App -->
                <script src="../../dist/js/adminlte.min.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script src="../../dist/js/demo.js"></script>
            </body>

            </html>
<?php
       } } else {
            header('Location: ../restriction.php');
        }
    }
?>