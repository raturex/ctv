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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 /*|| $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

?>

        <?php
        include "api/db_connect.php";
        ?>

        <!DOCTYPE html>
        <html lang="fr">


        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TUX AUTO</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- JQVMap -->
            <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="dist/css/adminlte.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
            <!-- summernote -->
            <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

            <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        </head>


        <body class="hold-transition sidebar-mini layout-fixed" onload="observation()">

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
                                    <h1 class="m-0">Comptabilité</h1>

                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Comptabilité</a></li>
                                        <li class="breadcrumb-item active">Générale</li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->


                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="card">

                                <div class="card-header">
                                    <div class="row">
                                        <div class="form-check">

                                            <div class="col-sm-12">
                                                <h4>
                                                    <p> Comptabilité</p>
                                                </h4>
                                            </div>
                                        </div>


                                        <div class="form-check">
                                            <div class="col-sm-12">
                                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="card-body">
                                    <table width="50%" border="3">
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="form-check">
                                                        <div class="col-sm-12">
                                                            <h4>
                                                                <p>Facture interne</p>
                                                            </h4>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                    <p></p>
                                    <p></p>

                                    <?php
                                    $query = "SELECT id, categorie, prix_visite from categ ";
                                    $response = array();
                                    $result = mysqli_query($conn, $query);
                                    ?>

                                    <!-- Visite technique -->

                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie des véhicules</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la prestation</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest = array();
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                                            $query2 = "SELECT count(vehicule.id) as qte, categ.categorie FROM vehicule left join categ on id_categ = categ.id where id_categ = " . $row["id"] . "";
                                            $response = array();
                                            $result2 = mysqli_query($conn, $query2);

                                        ?>

                                            <tbody>
                                                <tr class="odd">
                                                    <td class="dtr-control" tabindex="0">

                                                        <?php
                                                        echo $row["categorie"];

                                                        ?>

                                                    </td>

                                                    <td>
                                                        <?php
                                                        $prix_visite = $row["prix_visite"];
                                                        echo $prix_visite;
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                                                            $qte = $row2["qte"];
                                                            echo $qte;
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $cout = $qte * $prix_visite;

                                                        $cout_prest[] = $cout;

                                                        echo $cout;
                                                        ?>
                                                    </td>

                                                </tr>

                                            <?php
                                        }
                                            ?>


                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">

                                                    <?php
                                                    echo "Timbre fiscal";
                                                    ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    $timbre = 100;
                                                    echo $timbre;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $query3 = "SELECT count(vehicule.id) as qte FROM vehicule";
                                                    $result3 = mysqli_query($conn, $query3);

                                                    while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                                                        $qte3 = $row3["qte"];
                                                        echo $qte3;
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $timbreFisc = 0;
                                                    $timbreFisc = $qte3 * 100;
                                                    echo $timbreFisc;
                                                    ?>
                                                </td>

                                            </tr>


                                            <tr class="odd">

                                                <td class="dtr-control" tabindex="0">

                                                    <?php
                                                    echo "TVA";
                                                    ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    $tva = 0.18;
                                                    echo "18%";
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                                                        $qte = $row2["qte"];
                                                        echo $qte;
                                                    }

                                                    $tvaCount = 0;
                                                    foreach ($cout_prest as $p) :
                                                        $tvaCount = $tvaCount + ($p * $tva);
                                                    endforeach;

                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    echo $tvaCount;
                                                    ?>
                                                </td>
                                            </tr>


                                            </tbody>


                                            <?php
                                            $v = 0;
                                            foreach ($cout_prest as $p) :
                                                $v = $v + $p;
                                            endforeach;
                                            $v=$v+$tvaCount+$timbreFisc;
                                            ?>

                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">
                                                        <h3>
                                                            <p>Sous total
                                                            <p>
                                                        </h3>
                                                    </th>
                                                    <th rowspan="1" colspan="1"></th>
                                                    <th rowspan="1" colspan="1"></th>
                                                    <th rowspan="1" colspan="1">
                                                        <h3>
                                                            <p> <?php echo $v; ?></p>
                                                        </h3>
                                                    </th>
                                                </tr>
                                            </tfoot>

                                    </table>
                                    <!-- /.Visite technique -->

                                    <p></p>
                                    <p></p>

                                    <table width="50%" border="3">
                                        <tr>
                                            <td>
                                                <h4>
                                                    <p>Traitement des vignettes auto</p>
                                                </h4>
                                            </td>
                                        </tr>
                                    </table>

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 1 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 1</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans
                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 19000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qteVignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 14250;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 13100;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 1 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 2 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 2</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 35000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 26250;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 25000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 2 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 3 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 3</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 49000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php



                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 36750;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 30000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 3 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 4 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 4</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 96000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 72000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 40000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 4 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 5 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 5</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 190000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 142000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 80000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 5 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 6 -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 6</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 2 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 250000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 3 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 190000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 142000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 80000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 6 -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette moto 125 cm3 -->

                                    <table width="50%" border="3">
                                        <tr>
                                            <td>
                                                <h4>
                                                    <p>Traitement des vignettes moto</p>
                                                </h4>
                                            </td>
                                        </tr>
                                    </table>

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 1 moto 125 cm3( moins de 1CV) -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 1</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 5000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 3750;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 3500;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 1 moto 125 cm3( moins de 1CV) -->

                                    <p></p>
                                    <p></p>

                                    <!-- vignette categorie 2 moto 125 cm3 (plus de 1CV) -->
                                    <table width="75%" border="2">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Catégorie 2</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Le montant de la vignette</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                    Détail des opérations</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                    Coût de la prestation</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $cout_prest_vign = array();
                                        ?>

                                        <tbody>
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 1 à 4 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 12000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 5 à 10 ans

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 9000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>

                                            </tr>

                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="0">
                                                    Vignette 11 ans et plus

                                                </td>
                                                <td>
                                                    <?php
                                                    $prix_vignette = 6000;
                                                    echo $prix_vignette;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $qteVignette = 2;
                                                    echo $qte;
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $cout_vignette = $qteVignette * $prix_vignette;

                                                    $cout_prest_vign[] = $cout_vignette;

                                                    echo $cout_vignette;
                                                    ?>
                                                </td>
                                            </tr>


                                        </tbody>

                                        <?php
                                        $v = 0;
                                        foreach ($cout_prest_vign as $p) :
                                            $v = $v + $p;
                                        endforeach;
                                        ?>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p>Sous total
                                                        <p>
                                                    </h3>
                                                </th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1"></th>
                                                <th rowspan="1" colspan="1">
                                                    <h3>
                                                        <p> <?php echo $v; ?></p>
                                                    </h3>
                                                </th>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <!-- /.vignette categorie 2 moto 125 cm3 (plus de 1CV)-->

                                    <!-- /.vignette moto 125 cm3 -->

                                </div>

                            </div>

                        </div>
                    </section>
                    <!-- /.main content -->

                </div>
                <!-- /.container-fluid -->

            </div>


            <!-- footer -->
            <?php
            // Include config file
            include("footer.php");
            ?>
            <!-- ./footer -->

            </div>



            <!-- Date Ranger -->
            <script type="text/javascript">
                $(function() {

                    var start = moment().subtract(29, 'days');
                    var end = moment();

                    function cb(start, end) {
                        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' -- ' + end.format('DD-MM-YYYY'));

                    }

                    $('#reportrange').daterangepicker({
                        startDate: start,
                        endDate: end,
                        ranges: {
                            'Aujourd\'hui': [moment(), moment()],
                            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                            '30 dernier jours': [moment().subtract(29, 'days'), moment()],
                            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                            'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    }, cb);

                    cb(start, end);

                });
            </script>







            </script>
            <!-- jQuery -->
            <script src="plugins/jquery/jquery.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
            <script>
                $.widget.bridge('uibutton', $.ui.button)
            </script>
            <!-- Bootstrap 4 -->
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- ChartJS -->
            <script src="plugins/chart.js/Chart.min.js"></script>
            <!-- Sparkline -->
            <script src="plugins/sparklines/sparkline.js"></script>
            <!-- JQVMap -->
            <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
            <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
            <!-- jQuery Knob Chart -->
            <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
            <!-- daterangepicker -->
            <script src="plugins/moment/moment.min.js"></script>
            <script src="plugins/daterangepicker/daterangepicker.js"></script>
            <!-- Tempusdominus Bootstrap 4 -->
            <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
            <!-- Summernote -->
            <script src="plugins/summernote/summernote-bs4.min.js"></script>
            <!-- AdminLTE App -->
            <script src="dist/js/adminlte.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="dist/js/demo.js"></script>
            <!-- overlayScrollbars -->
            <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

        </body>


        </html>

<?php
    } else {
        header('Location: restriction.php');
    }
}
?>