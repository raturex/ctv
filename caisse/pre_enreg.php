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


    if (isset($_SESSION["role"])/* && ($_SESSION["role"] == 2 || $_SESSION["role"] == 5)*/) {
        // Initialize the session
        //session_start();


        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT *,vehicule.id as id , facturation.id as id_fact, pvignette.id as id_vignette FROM prefacture as facturation left join vehicule on vehicule.id =facturation.id_vehicule left join pvignette on facturation.id=pvignette.id_facturation  where facturation.etat = 1 order by vehicule.date_enreg Desc";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $list_vehic = $request->fetchAll(PDO::FETCH_ASSOC);


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

            <!-- DataTables -->
            <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        </head>

        <body class="hold-transition sidebar-mini">


            <div class="wrapper">

                <?php
                // Include config file
                include("../nav_bar.php");
                ?>


                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">Facture en attente</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Liste d'attente</a></li>
                                        <li class="breadcrumb-item active"></li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->

                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">



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










                        </div>
                    </section>

                </div>





                <?php
                // Include config file
                include("../footer.php");
                ?>


            </div>



            <!-- jQuery -->
            <script src="../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js"></script>

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

            <script>
                $(function() {
                    $("#example1").DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": true,
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