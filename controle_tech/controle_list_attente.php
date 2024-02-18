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
                                    <h1>Liste d'Attente</h1>
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
                        <div class="container-fluid">
                            <div class="row">





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
        etat = 4 and  etat = 4   /*and facturation.date like '$date%'*/ and immatriculation not in ($listfichier)
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
                                                        <th>Etat</th>
                                                        <th>Immatriculation</th>
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
                                                            <p>
                <span class="right badge badge-danger"><?php
                                                                echo $row["id_factur"];
                                                                ?></span>
              </p>
                                                                
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

                                                            <div class="btn-group">
                    <button type="button" class="btn btn-info">CONTRÔLE</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" href="result_ctrl_tech.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">Contrôle Visuel</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="result_ctrl_banc.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">Banc</a>
                    </div>
                  </div>
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
                        </div>
                        <!-- /.container-fluid -->
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