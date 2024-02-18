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

            $query = "SELECT vehicule.id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, energie.lib, nb_place, ptac, puiss_fisc, id_genre, genre.lib as genre, date_mise_circul, date_local, categorie
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
                <!-- daterange picker -->
                <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
                <!-- iCheck for checkboxes and radio inputs -->
                <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
                <!-- Bootstrap Color Picker -->
                <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
                <!-- Tempusdominus Bootstrap 4 -->
                <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
                <!-- Select2 -->
                <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
                <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
                <!-- Bootstrap4 Duallistbox -->
                <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
                <!-- BS Stepper -->
                <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
                <!-- dropzonejs -->
                <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
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

                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1 class="m-0">Contrôle technique : N° <?PHP echo $num_certificat; ?> </h1>

                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="controle_cours.php">Liste d'attente</a></li>
                                            <li class="breadcrumb-item active">Véhicule</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.container-fluid -->
                        </section>
                        <!-- /.content-header -->





                        <!-- Main content -->
                        <section class="content">
                            <div class="container-fluid">

                                <!-- form start -->

                                <div class="card card-warning collapsed-card" data-card-widget="collapse">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $vehicule["marque"] . " | " . $vehicule["immatriculation"] . " ";

                                                                $id_station = $_SESSION["id_station"];
                                                                $id_user = $_SESSION["id_user"]; ?> </h3>
                                    </div>


                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Détail fiscal -->

                                                <div class="form-group">
                                                    <label for="genre">Genre</label>
                                                    <input disabled type="text" class="form-control" id="genre" name="genre" placeholder="Genre du véhicule" value="<?php echo $vehicule["genre"] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPuisFiscal">Puissance fiscale</label>
                                                    <input disabled type="number" class="form-control" id="inputPuisFiscal" name="inputPuisFiscal" placeholder="Puissance Fiscale" step=1 min=0 value="<?php echo $vehicule["puiss_fisc"] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <input disabled type="date" class="form-control" name="inputDateMC" id="inputDateMC" name="inputDateMC" placeholder="JJ/MM/AAAA" value="<?php echo $vehicule["date_mise_circul"] ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <h5>
                                                                <p id="anneeMC"></p>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPA">Catégorie</label>
                                                    <input disabled type="text" class="form-control" id="inputCateg" name="inputCateg" placeholder="Categorie" step=1 min=0 value="<?php echo $vehicule["categorie"] ?>">
                                                </div>

                                                <p id="CalVignette"></p>

                                                <!-- /.Détail fiscal -->
                                            </div>



                                            <div class="col-sm-6">
                                                <!-- Info véhicule -->

                                                <div class="form-group">
                                                    <label for="inputProprietaire">Proprietaire</label>
                                                    <input disabled type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule" value="<?php echo $vehicule["proprietaire"] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputMarque">Marque du véhicule</label>
                                                    <input disabled type="text" class="form-control" id="inputMarque" name="inputMarque" placeholder="Marque du véhicule" value="<?php echo $vehicule["marque"] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputTypeTech">Type technique</label>
                                                    <input disabled type="text" class="form-control" id="inputTypeTech" name="inputTypeTech" placeholder="Type technique" value="<?php echo $vehicule["type_tech"] ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputSerie">Numéro de série</label>
                                                    <input disabled type="text" class="form-control" id="nSerie" name="nSerie" placeholder="Numéro de série" value="<?php echo $vehicule["num_serie"] ?>">
                                                </div>

                                                <!-- /.Info véhicule -->
                                            </div>

                                        </div>
                                        <!-- /.form start -->
                                    </div>

                                </div>
                                <!-- /.card -->


                                <div class="card card-outline card-primary">
                                    <form name="obs" action="controle_result.php" method="post">
                                        <input type="hidden" class="form-control" id="nSerie" name="nSerie" value="<?php echo $vehicule['num_serie'] ?>">
                                        <input type="hidden" class="form-control" id="id_vehic" name="id_vehic" value="<?php echo $id_vehic ?>">
                                        <input type="hidden" class="form-control" id="id_factur" name="id_factur" value="<?php echo $id_factur ?>">
                                        <input type="hidden" class="form-control" id="id_ctrler" name="id_ctrler" value="<?php echo $id_user; ?>">
                                        <input type="hidden" class="form-control" id="certificat" name="certificat" value=" <?PHP echo $num_certificat ?>">



                                        <div class="card-header">
                                            <h3 class="card-title">Observation</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="kilometrage">KILOMETRAGE OBSERVE</label>
                                                        <input required class="form-control" type="number" name="kilometrage" id="kilometrage" value="" step="1" min="0">
                                                    </div>
                                                    <!-- /.form-group -->
                                                </div>
                                                <!-- /.col -->



                                                <div class="col-12">
                                                    <!-- Custom Tabs -->
                                                    <div class="card">
                                                        <div class="card-header d-flex p-0">
                                                            <h3 class="card-title p-3">Controle visuel</h3>
                                                            <ul class="nav nav-pills ml-auto p-2">
                                                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">IDENTIFICATION</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">EXTERIEUR</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">INTERIEUR</a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">DIVERS</a></li>

                                                               
                                                               <!--
                                                                <li class="nav-item dropdown">
                                                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                                        Dropdown <span class="caret"></span>
                                                                    </a>

                                                                     
                                                                    <div class="dropdown-menu" style="">
                                                                        <a class="dropdown-item" tabindex="-1" href="#">Action</a>
                                                                        <a class="dropdown-item" tabindex="-1" href="#">Another action</a>
                                                                        <a class="dropdown-item" tabindex="-1" href="#">Something else here</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" tabindex="-1" href="#">Separated link</a>
                                                                    </div>
                                                                    -->
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="tab-content">

                                                                <div class="tab-pane active" id="tab_1">
                                                                    <div class="row">

                                                                        <?php
                                                                        require_once("../api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT fonction_ctrl FROM observation where zone ='IDENTIFICATION' group by fonction_ctrl ";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $fonction_ctrl) { ?>

                                                                            <div class="col-sm-12">

                                                                                <div class="card card-warning collapsed-card">
                                                                                    <div class="card-header" data-card-widget="collapse">
                                                                                        <h3 class="card-title"><?php echo $fonction_ctrl['fonction_ctrl'] ?></h3>
                                                                                        <!-- /.card-tools -->
                                                                                    </div>
                                                                                    <!-- /.card-header -->



                                                                                    <div class="card-body" style="display: none;">

                                                                                        <?php
                                                                                        require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = "SELECT fonction_ctrl, group_pt_ctrl FROM observation where fonction_ctrl = '" . $fonction_ctrl['fonction_ctrl'] . "'  group by group_pt_ctrl";
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $group_pt_ctrl) {

                                                                                        ?>



                                                                                            <div class="card card-primary collapsed-card">

                                                                                                <div class="card-header" data-card-widget="collapse">
                                                                                                    <h3 class="card-title"><?php echo $group_pt_ctrl['group_pt_ctrl'] ?></h3>
                                                                                                </div>
                                                                                                <!-- /.card-header -->

                                                                                                <div class="card-body" style="display: none;">
                                                                                                    <?php
                                                                                                    $group_pt_ctrl = $conn->real_escape_string($group_pt_ctrl['group_pt_ctrl']);


                                                                                                    require_once("../api/db_connect.php");

                                                                                                    //requête
                                                                                                    $sql = "SELECT pt_ctrl FROM observation where group_pt_ctrl = '" . $group_pt_ctrl . "' group by pt_ctrl ";
                                                                                                    // On prépare la requête

                                                                                                    $request = $db_PDO->prepare($sql);
                                                                                                    // On exécute la requête
                                                                                                    $request->execute();
                                                                                                    // On stocke le résultat dans un tableau associatif
                                                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                    foreach ($result as $pt_ctrl) { ?>



                                                                                                        <div class="card card-primary collapsed-card">
                                                                                                            <div class="card-header" data-card-widget="collapse">
                                                                                                                <h3 class="card-title"><?php echo $pt_ctrl['pt_ctrl'] ?></h3>
                                                                                                            </div>
                                                                                                            <!-- /.card-header -->


                                                                                                            <div class="card-body" style="display: none;">

                                                                                                                <?php
                                                                                                                $pt_ctrl = $conn->real_escape_string($pt_ctrl['pt_ctrl']);


                                                                                                                require_once("../api/db_connect.php");

                                                                                                                //requête
                                                                                                                $sql = "SELECT type_def FROM observation where pt_ctrl = '" . $pt_ctrl . "' group by type_def ";
                                                                                                                // On prépare la requête

                                                                                                                $request = $db_PDO->prepare($sql);
                                                                                                                // On exécute la requête
                                                                                                                $request->execute();
                                                                                                                // On stocke le résultat dans un tableau associatif
                                                                                                                $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                foreach ($result as $type_def) { ?>


                                                                                                                    <div class="card card-success collapsed-card">

                                                                                                                        <div class="card-header" data-card-widget="collapse">
                                                                                                                            <h3 class="card-title"><?php echo $type_def['type_def'] ?></h3>
                                                                                                                            </br>
                                                                                                                        </div>
                                                                                                                        <!-- /.card-header -->

                                                                                                                        <?php
                                                                                                                        $type_def = $conn->real_escape_string($type_def['type_def']);


                                                                                                                        require_once("../api/db_connect.php");

                                                                                                                        //requête
                                                                                                                        //$sql = "SELECT def_const_localis FROM observation where type_def = '" . $type_def . "'";
                                                                                                                        $sql = "SELECT id, def_const_localis FROM observation where type_def = '" . $type_def . "' and pt_ctrl = '" . $pt_ctrl . "'";

                                                                                                                        // On prépare la requête

                                                                                                                        $request = $db_PDO->prepare($sql);
                                                                                                                        // On exécute la requête
                                                                                                                        $request->execute();
                                                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                        $x = 1;
                                                                                                                        ?>

                                                                                                                        <div class="card-body" style="display: none;">

                                                                                                                            <?php

                                                                                                                            foreach ($result as $def_const_localis) { ?>

                                                                                                                                <div class="dropdown-divider"></div>

                                                                                                                                <div class="form-group">
                                                                                                                                    <input class="check-control" id="<?PHP echo 'def_const_localis' . $x; ?>" name="id_obs[]" type="checkbox" value="<?PHP echo $def_const_localis['id']; ?>">
                                                                                                                                    <label for="<?PHP echo 'def_const_localis' . $x; ?>"> -- <?PHP echo $def_const_localis['def_const_localis']; ?></label>
                                                                                                                                </div>
                                                                                                                                <div class="dropdown-divider"></div>



                                                                                                                                <!-- /.card-body -->
                                                                                                                            <?php
                                                                                                                                $x++;
                                                                                                                            }  ?>
                                                                                                                        </div>


                                                                                                                    </div>
                                                                                                                    <!-- /.card -->



                                                                                                                <?php }  ?>



                                                                                                            </div>
                                                                                                            <!-- /.card-body -->

                                                                                                        </div>
                                                                                                        <!-- /.card -->


                                                                                                    <?php }  ?>

                                                                                                </div>
                                                                                                <!-- /.card-body -->

                                                                                            </div>
                                                                                            <!-- /.card -->

                                                                                        <?php }  ?>

                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                                <!-- /.card -->

                                                                            </div>
                                                                            <!-- /.col -->
                                                                        <?php }  ?>


                                                                    </div>
                                                                    <!-- /.row -->
                                                                </div>

                                                                <!-- /.tab-pane -->
                                                                <div class="tab-pane" id="tab_2">
                                                                    <div class="row">

                                                                        <?php
                                                                        require_once("../api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT fonction_ctrl FROM observation where zone ='EXTERIEUR' group by fonction_ctrl ";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $fonction_ctrl) { ?>

                                                                            <div class="col-sm-12">

                                                                                <div class="card card-warning collapsed-card">
                                                                                    <div class="card-header" data-card-widget="collapse">
                                                                                        <h3 class="card-title"><?php echo $fonction_ctrl['fonction_ctrl'] ?></h3>
                                                                                        <!-- /.card-tools -->
                                                                                    </div>
                                                                                    <!-- /.card-header -->



                                                                                    <div class="card-body" style="display: none;">

                                                                                        <?php
                                                                                        require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = "SELECT fonction_ctrl, group_pt_ctrl FROM observation where fonction_ctrl = '" . $fonction_ctrl['fonction_ctrl'] . "'  group by group_pt_ctrl";
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $group_pt_ctrl) {

                                                                                        ?>



                                                                                            <div class="card card-primary collapsed-card">

                                                                                                <div class="card-header" data-card-widget="collapse">
                                                                                                    <h3 class="card-title"><?php echo $group_pt_ctrl['group_pt_ctrl'] ?></h3>
                                                                                                </div>
                                                                                                <!-- /.card-header -->

                                                                                                <div class="card-body" style="display: none;">
                                                                                                    <?php
                                                                                                    $group_pt_ctrl = $conn->real_escape_string($group_pt_ctrl['group_pt_ctrl']);


                                                                                                    require_once("../api/db_connect.php");

                                                                                                    //requête
                                                                                                    $sql = "SELECT pt_ctrl FROM observation where group_pt_ctrl = '" . $group_pt_ctrl . "' group by pt_ctrl ";
                                                                                                    // On prépare la requête

                                                                                                    $request = $db_PDO->prepare($sql);
                                                                                                    // On exécute la requête
                                                                                                    $request->execute();
                                                                                                    // On stocke le résultat dans un tableau associatif
                                                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                    foreach ($result as $pt_ctrl) { ?>



                                                                                                        <div class="card card-primary collapsed-card">
                                                                                                            <div class="card-header" data-card-widget="collapse">
                                                                                                                <h3 class="card-title"><?php echo $pt_ctrl['pt_ctrl'] ?></h3>
                                                                                                            </div>
                                                                                                            <!-- /.card-header -->


                                                                                                            <div class="card-body" style="display: none;">

                                                                                                                <?php
                                                                                                                $pt_ctrl = $conn->real_escape_string($pt_ctrl['pt_ctrl']);


                                                                                                                require_once("../api/db_connect.php");

                                                                                                                //requête
                                                                                                                $sql = "SELECT type_def FROM observation where pt_ctrl = '" . $pt_ctrl . "' group by type_def ";
                                                                                                                // On prépare la requête

                                                                                                                $request = $db_PDO->prepare($sql);
                                                                                                                // On exécute la requête
                                                                                                                $request->execute();
                                                                                                                // On stocke le résultat dans un tableau associatif
                                                                                                                $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                foreach ($result as $type_def) { ?>


                                                                                                                    <div class="card card-success collapsed-card">

                                                                                                                        <div class="card-header" data-card-widget="collapse">
                                                                                                                            <h3 class="card-title"><?php echo $type_def['type_def'] ?></h3>
                                                                                                                            </br>
                                                                                                                        </div>
                                                                                                                        <!-- /.card-header -->

                                                                                                                        <?php
                                                                                                                        $type_def = $conn->real_escape_string($type_def['type_def']);


                                                                                                                        require_once("../api/db_connect.php");

                                                                                                                        //requête
                                                                                                                        //$sql = "SELECT def_const_localis FROM observation where type_def = '" . $type_def . "'";
                                                                                                                        $sql = "SELECT id, def_const_localis FROM observation where type_def = '" . $type_def . "' and pt_ctrl = '" . $pt_ctrl . "'";

                                                                                                                        // On prépare la requête

                                                                                                                        $request = $db_PDO->prepare($sql);
                                                                                                                        // On exécute la requête
                                                                                                                        $request->execute();
                                                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                        $x = 1;
                                                                                                                        ?>

                                                                                                                        <div class="card-body" style="display: none;">

                                                                                                                            <?php

                                                                                                                            foreach ($result as $def_const_localis) { ?>

                                                                                                                                <div class="dropdown-divider"></div>

                                                                                                                                <div class="form-group">
                                                                                                                                    <input class="check-control" id="<?PHP echo 'def_const_localis' . $x; ?>" name="id_obs[]" type="checkbox" value="<?PHP echo $def_const_localis['id']; ?>">
                                                                                                                                    <label for="<?PHP echo 'def_const_localis' . $x; ?>"> -- <?PHP echo $def_const_localis['def_const_localis']; ?></label>
                                                                                                                                </div>
                                                                                                                                <div class="dropdown-divider"></div>



                                                                                                                                <!-- /.card-body -->
                                                                                                                            <?php
                                                                                                                                $x++;
                                                                                                                            }  ?>
                                                                                                                        </div>


                                                                                                                    </div>
                                                                                                                    <!-- /.card -->



                                                                                                                <?php }  ?>



                                                                                                            </div>
                                                                                                            <!-- /.card-body -->

                                                                                                        </div>
                                                                                                        <!-- /.card -->


                                                                                                    <?php }  ?>

                                                                                                </div>
                                                                                                <!-- /.card-body -->

                                                                                            </div>
                                                                                            <!-- /.card -->

                                                                                        <?php }  ?>

                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                                <!-- /.card -->

                                                                            </div>
                                                                            <!-- /.col -->
                                                                        <?php }  ?>


                                                                    </div>
                                                                    <!-- /.row -->
                                                                </div>

                                                                <!-- /.tab-pane -->
                                                                <div class="tab-pane" id="tab_3">


                                                                    <div class="row">

                                                                        <?php
                                                                        require_once("../api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT fonction_ctrl FROM observation where zone ='INTERIEUR' group by fonction_ctrl ";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $fonction_ctrl) { ?>

                                                                            <div class="col-sm-12">

                                                                                <div class="card card-warning collapsed-card">
                                                                                    <div class="card-header" data-card-widget="collapse">
                                                                                        <h3 class="card-title"><?php echo $fonction_ctrl['fonction_ctrl'] ?></h3>
                                                                                        <!-- /.card-tools -->
                                                                                    </div>
                                                                                    <!-- /.card-header -->



                                                                                    <div class="card-body" style="display: none;">

                                                                                        <?php
                                                                                        require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = "SELECT fonction_ctrl, group_pt_ctrl FROM observation where fonction_ctrl = '" . $fonction_ctrl['fonction_ctrl'] . "'  group by group_pt_ctrl";
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $group_pt_ctrl) {

                                                                                        ?>



                                                                                            <div class="card card-primary collapsed-card">

                                                                                                <div class="card-header" data-card-widget="collapse">
                                                                                                    <h3 class="card-title"><?php echo $group_pt_ctrl['group_pt_ctrl'] ?></h3>
                                                                                                </div>
                                                                                                <!-- /.card-header -->

                                                                                                <div class="card-body" style="display: none;">
                                                                                                    <?php
                                                                                                    $group_pt_ctrl = $conn->real_escape_string($group_pt_ctrl['group_pt_ctrl']);


                                                                                                    require_once("../api/db_connect.php");

                                                                                                    //requête
                                                                                                    $sql = "SELECT pt_ctrl FROM observation where group_pt_ctrl = '" . $group_pt_ctrl . "' group by pt_ctrl ";
                                                                                                    // On prépare la requête

                                                                                                    $request = $db_PDO->prepare($sql);
                                                                                                    // On exécute la requête
                                                                                                    $request->execute();
                                                                                                    // On stocke le résultat dans un tableau associatif
                                                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                    foreach ($result as $pt_ctrl) { ?>



                                                                                                        <div class="card card-primary collapsed-card">
                                                                                                            <div class="card-header" data-card-widget="collapse">
                                                                                                                <h3 class="card-title"><?php echo $pt_ctrl['pt_ctrl'] ?></h3>
                                                                                                            </div>
                                                                                                            <!-- /.card-header -->


                                                                                                            <div class="card-body" style="display: none;">

                                                                                                                <?php
                                                                                                                $pt_ctrl = $conn->real_escape_string($pt_ctrl['pt_ctrl']);


                                                                                                                require_once("../api/db_connect.php");

                                                                                                                //requête
                                                                                                                $sql = "SELECT type_def FROM observation where pt_ctrl = '" . $pt_ctrl . "' group by type_def ";
                                                                                                                // On prépare la requête

                                                                                                                $request = $db_PDO->prepare($sql);
                                                                                                                // On exécute la requête
                                                                                                                $request->execute();
                                                                                                                // On stocke le résultat dans un tableau associatif
                                                                                                                $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                foreach ($result as $type_def) { ?>


                                                                                                                    <div class="card card-success collapsed-card">

                                                                                                                        <div class="card-header" data-card-widget="collapse">
                                                                                                                            <h3 class="card-title"><?php echo $type_def['type_def'] ?></h3>
                                                                                                                            </br>
                                                                                                                        </div>
                                                                                                                        <!-- /.card-header -->

                                                                                                                        <?php
                                                                                                                        $type_def = $conn->real_escape_string($type_def['type_def']);


                                                                                                                        require_once("../api/db_connect.php");

                                                                                                                        //requête
                                                                                                                        //$sql = "SELECT def_const_localis FROM observation where type_def = '" . $type_def . "'";
                                                                                                                        $sql = "SELECT id, def_const_localis FROM observation where type_def = '" . $type_def . "' and pt_ctrl = '" . $pt_ctrl . "'";

                                                                                                                        // On prépare la requête

                                                                                                                        $request = $db_PDO->prepare($sql);
                                                                                                                        // On exécute la requête
                                                                                                                        $request->execute();
                                                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                        $x = 1;
                                                                                                                        ?>

                                                                                                                        <div class="card-body" style="display: none;">

                                                                                                                            <?php

                                                                                                                            foreach ($result as $def_const_localis) { ?>

                                                                                                                                <div class="dropdown-divider"></div>

                                                                                                                                <div class="form-group">
                                                                                                                                    <input class="check-control" id="<?PHP echo 'def_const_localis' . $x; ?>" name="id_obs[]" type="checkbox" value="<?PHP echo $def_const_localis['id']; ?>">
                                                                                                                                    <label for="<?PHP echo 'def_const_localis' . $x; ?>"> -- <?PHP echo $def_const_localis['def_const_localis']; ?></label>
                                                                                                                                </div>
                                                                                                                                <div class="dropdown-divider"></div>



                                                                                                                                <!-- /.card-body -->
                                                                                                                            <?php
                                                                                                                                $x++;
                                                                                                                            }  ?>
                                                                                                                        </div>


                                                                                                                    </div>
                                                                                                                    <!-- /.card -->



                                                                                                                <?php }  ?>



                                                                                                            </div>
                                                                                                            <!-- /.card-body -->

                                                                                                        </div>
                                                                                                        <!-- /.card -->


                                                                                                    <?php }  ?>

                                                                                                </div>
                                                                                                <!-- /.card-body -->

                                                                                            </div>
                                                                                            <!-- /.card -->

                                                                                        <?php }  ?>

                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                                <!-- /.card -->

                                                                            </div>
                                                                            <!-- /.col -->
                                                                        <?php }  ?>


                                                                    </div>
                                                                    <!-- /.row -->

                                                                </div>

                                                                <!-- /.tab-pane -->

                                                                <!-- /.tab-pane -->
                                                                <div class="tab-pane" id="tab_4">


                                                                    <div class="row">

                                                                        <?php
                                                                        require_once("../api/db_connect.php");

                                                                        //requête
                                                                        $sql = "SELECT fonction_ctrl FROM observation where zone ='DIVERS' group by fonction_ctrl ";
                                                                        // On prépare la requête
                                                                        $request = $db_PDO->prepare($sql);
                                                                        // On exécute la requête
                                                                        $request->execute();
                                                                        // On stocke le résultat dans un tableau associatif
                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                        foreach ($result as $fonction_ctrl) { ?>

                                                                            <div class="col-sm-12">

                                                                                <div class="card card-warning collapsed-card">
                                                                                    <div class="card-header" data-card-widget="collapse">
                                                                                        <h3 class="card-title"><?php echo $fonction_ctrl['fonction_ctrl'] ?></h3>
                                                                                        <!-- /.card-tools -->
                                                                                    </div>
                                                                                    <!-- /.card-header -->



                                                                                    <div class="card-body" style="display: none;">

                                                                                        <?php
                                                                                        require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = "SELECT fonction_ctrl, group_pt_ctrl FROM observation where fonction_ctrl = '" . $fonction_ctrl['fonction_ctrl'] . "'  group by group_pt_ctrl";
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $group_pt_ctrl) {

                                                                                        ?>



                                                                                            <div class="card card-primary collapsed-card">

                                                                                                <div class="card-header" data-card-widget="collapse">
                                                                                                    <h3 class="card-title"><?php echo $group_pt_ctrl['group_pt_ctrl'] ?></h3>
                                                                                                </div>
                                                                                                <!-- /.card-header -->

                                                                                                <div class="card-body" style="display: none;">
                                                                                                    <?php
                                                                                                    $group_pt_ctrl = $conn->real_escape_string($group_pt_ctrl['group_pt_ctrl']);


                                                                                                    require_once("../api/db_connect.php");

                                                                                                    //requête
                                                                                                    $sql = "SELECT pt_ctrl FROM observation where group_pt_ctrl = '" . $group_pt_ctrl . "' group by pt_ctrl ";
                                                                                                    // On prépare la requête

                                                                                                    $request = $db_PDO->prepare($sql);
                                                                                                    // On exécute la requête
                                                                                                    $request->execute();
                                                                                                    // On stocke le résultat dans un tableau associatif
                                                                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                    foreach ($result as $pt_ctrl) { ?>



                                                                                                        <div class="card card-primary collapsed-card">
                                                                                                            <div class="card-header" data-card-widget="collapse">
                                                                                                                <h3 class="card-title"><?php echo $pt_ctrl['pt_ctrl'] ?></h3>
                                                                                                            </div>
                                                                                                            <!-- /.card-header -->


                                                                                                            <div class="card-body" style="display: none;">

                                                                                                                <?php
                                                                                                                $pt_ctrl = $conn->real_escape_string($pt_ctrl['pt_ctrl']);


                                                                                                                require_once("../api/db_connect.php");

                                                                                                                //requête
                                                                                                                $sql = "SELECT type_def FROM observation where pt_ctrl = '" . $pt_ctrl . "' group by type_def ";
                                                                                                                // On prépare la requête

                                                                                                                $request = $db_PDO->prepare($sql);
                                                                                                                // On exécute la requête
                                                                                                                $request->execute();
                                                                                                                // On stocke le résultat dans un tableau associatif
                                                                                                                $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                foreach ($result as $type_def) { ?>


                                                                                                                    <div class="card card-success collapsed-card">

                                                                                                                        <div class="card-header" data-card-widget="collapse">
                                                                                                                            <h3 class="card-title"><?php echo $type_def['type_def'] ?></h3>
                                                                                                                            </br>
                                                                                                                        </div>
                                                                                                                        <!-- /.card-header -->

                                                                                                                        <?php
                                                                                                                        $type_def = $conn->real_escape_string($type_def['type_def']);


                                                                                                                        require_once("../api/db_connect.php");

                                                                                                                        //requête
                                                                                                                        //$sql = "SELECT def_const_localis FROM observation where type_def = '" . $type_def . "'";
                                                                                                                        $sql = "SELECT id, def_const_localis FROM observation where type_def = '" . $type_def . "' and pt_ctrl = '" . $pt_ctrl . "'";

                                                                                                                        // On prépare la requête

                                                                                                                        $request = $db_PDO->prepare($sql);
                                                                                                                        // On exécute la requête
                                                                                                                        $request->execute();
                                                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                                                        $x = 1;
                                                                                                                        ?>

                                                                                                                        <div class="card-body" style="display: none;">

                                                                                                                            <?php

                                                                                                                            foreach ($result as $def_const_localis) { ?>

                                                                                                                                <div class="dropdown-divider"></div>

                                                                                                                                <div class="form-group">
                                                                                                                                    <input class="check-control" id="<?PHP echo 'def_const_localis' . $x; ?>" name="id_obs[]" type="checkbox" value="<?PHP echo $def_const_localis['id']; ?>">
                                                                                                                                    <label for="<?PHP echo 'def_const_localis' . $x; ?>"> -- <?PHP echo $def_const_localis['def_const_localis']; ?></label>
                                                                                                                                </div>
                                                                                                                                <div class="dropdown-divider"></div>



                                                                                                                                <!-- /.card-body -->
                                                                                                                            <?php
                                                                                                                                $x++;
                                                                                                                            }  ?>
                                                                                                                        </div>


                                                                                                                    </div>
                                                                                                                    <!-- /.card -->



                                                                                                                <?php }  ?>



                                                                                                            </div>
                                                                                                            <!-- /.card-body -->

                                                                                                        </div>
                                                                                                        <!-- /.card -->


                                                                                                    <?php }  ?>

                                                                                                </div>
                                                                                                <!-- /.card-body -->

                                                                                            </div>
                                                                                            <!-- /.card -->

                                                                                        <?php }  ?>

                                                                                    </div>
                                                                                    <!-- /.card-body -->
                                                                                </div>
                                                                                <!-- /.card -->

                                                                            </div>
                                                                            <!-- /.col -->
                                                                        <?php }  ?>


                                                                    </div>
                                                                    <!-- /.row -->

                                                                </div>

                                                                <!-- /.tab-pane -->




                                                            </div>
                                                            <!-- /.tab-content -->
                                                        </div><!-- /.card-body -->
                                                    </div>
                                                    <!-- ./card -->
                                                </div>
                                                <!-- /.col -->
















                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.card-body -->
                                        <?
                    $text = nl2br('[CARTEGRISE]
                    0200=' . $immatriculation . ' \n
                    0202=' . $num_serie . '\n
                    0204=' . $en . '\n
                    0212=' . $categ . '\n
                    0213=' . $marque . '\n
                    0214=
                    0215=' . $type_tech . '\n
                    0216=000001\n
                    [CRC]\n
                    0200=1703\n
                    0202=2791\n
                    0204=68\n
                    0207=0\n
                    0208=0\n
                    0209=0\n
                    0210=0\n
                    0211=0\n
                    0212=238\n
                    0213=1061\n
                    0215=1194\n
                    0216=770\n');

                    echo '' . $text;

                    $fichier = fopen('../certificat/PISTE1/' . $immatriculation . '.cg', 'c+b');
                    fwrite($fichier, $text);

                    fclose($fichier);
?>
                                        <div class="card-footer">
                                            <button type="submit" value="Submit" class="btn btn-info float-right">Valider</button>
                                            <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->

                            </div>
                        </section>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <!-- /.content -->


                <!-- footer -->
                <?php
                // Include config file
                include("../footer.php");
                ?>
                <!-- ./footer -->


                </div>
                <!-- ./wrapper -->


                <script>
                    function edit() {
                        document.getElementById("inputPA").disabled = false;
                        document.getElementById("inputPTAC").disabled = false;
                        document.getElementById("inputImmatriculation").disabled = false;
                        document.getElementById("inputMarque").disabled = false;
                        document.getElementById("inputTypeTech").disabled = false;
                        document.getElementById("inputSerie").disabled = false;
                        document.getElementById("inputMiseCircu").disabled = false;
                        document.getElementById("inputPuisFiscal").disabled = false;
                        document.getElementById("inputDateMC").disabled = false;
                        document.getElementById("inputProprietaire").disabled = false;

                        document.getElementById("radio1").disabled = false;
                        document.getElementById("radio2").disabled = false;
                        document.getElementById("radio3").disabled = false;
                        document.getElementById("radio4").disabled = false;
                    }
                </script>


                <!-- jQuery -->
                <script src="../plugins/jquery/jquery.min.js"></script>
                <!-- Bootstrap 4 -->
                <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Select2 -->
                <script src="../plugins/select2/js/select2.full.min.js"></script>
                <!-- Bootstrap4 Duallistbox -->
                <script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
                <!-- InputMask -->
                <script src="../plugins/moment/moment.min.js"></script>
                <script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
                <!-- date-range-picker -->
                <script src="../plugins/daterangepicker/daterangepicker.js"></script>
                <!-- bootstrap color picker -->
                <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
                <!-- Tempusdominus Bootstrap 4 -->
                <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
                <!-- Bootstrap Switch -->
                <script src="../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
                <!-- BS-Stepper -->
                <script src="../plugins/bs-stepper/js/bs-stepper.min.js"></script>
                <!-- dropzonejs -->
                <script src="../plugins/dropzone/min/dropzone.min.js"></script>
                <!-- AdminLTE App -->
                <script src="../dist/js/adminlte.min.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script src="../dist/js/demo.js"></script>
                <!-- Page specific script -->
                <script>
                    $(function() {
                        //Initialize Select2 Elements
                        $('.select2').select2()

                        //Initialize Select2 Elements
                        $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        })

                        //Datemask dd/mm/yyyy
                        $('#datemask').inputmask('dd/mm/yyyy', {
                            'placeholder': 'dd/mm/yyyy'
                        })
                        //Datemask2 mm/dd/yyyy
                        $('#datemask2').inputmask('mm/dd/yyyy', {
                            'placeholder': 'mm/dd/yyyy'
                        })
                        //Money Euro
                        $('[data-mask]').inputmask()

                        //Date picker
                        $('#reservationdate').datetimepicker({
                            format: 'L'
                        });

                        //Date and time picker
                        $('#reservationdatetime').datetimepicker({
                            icons: {
                                time: 'far fa-clock'
                            }
                        });

                        //Date range picker
                        $('#reservation').daterangepicker()
                        //Date range picker with time picker
                        $('#reservationtime').daterangepicker({
                            timePicker: true,
                            timePickerIncrement: 30,
                            locale: {
                                format: 'MM/DD/YYYY hh:mm A'
                            }
                        })
                        //Date range as a button
                        $('#daterange-btn').daterangepicker({
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            },
                            function(start, end) {
                                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                            }
                        )

                        //Timepicker
                        $('#timepicker').datetimepicker({
                            format: 'LT'
                        })

                        //Bootstrap Duallistbox
                        $('.duallistbox').bootstrapDualListbox()

                        //Colorpicker
                        $('.my-colorpicker1').colorpicker()
                        //color picker with addon
                        $('.my-colorpicker2').colorpicker()

                        $('.my-colorpicker2').on('colorpickerChange', function(event) {
                            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                        })

                        $("input[data-bootstrap-switch]").each(function() {
                            $(this).bootstrapSwitch('state', $(this).prop('checked'));
                        })

                    })
                    // BS-Stepper Init
                    document.addEventListener('DOMContentLoaded', function() {
                        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
                    })

                    // DropzoneJS Demo Code Start
                    Dropzone.autoDiscover = false

                    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
                    var previewNode = document.querySelector("#template")
                    previewNode.id = ""
                    var previewTemplate = previewNode.parentNode.innerHTML
                    previewNode.parentNode.removeChild(previewNode)

                    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
                        url: "/target-url", // Set the url
                        thumbnailWidth: 80,
                        thumbnailHeight: 80,
                        parallelUploads: 20,
                        previewTemplate: previewTemplate,
                        autoQueue: false, // Make sure the files aren't queued until manually added
                        previewsContainer: "#previews", // Define the container to display the previews
                        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
                    })

                    myDropzone.on("addedfile", function(file) {
                        // Hookup the start button
                        file.previewElement.querySelector(".start").onclick = function() {
                            myDropzone.enqueueFile(file)
                        }
                    })

                    // Update the total progress bar
                    myDropzone.on("totaluploadprogress", function(progress) {
                        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
                    })

                    myDropzone.on("sending", function(file) {
                        // Show the total progress bar when upload starts
                        document.querySelector("#total-progress").style.opacity = "1"
                        // And disable the start button
                        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
                    })

                    // Hide the total progress bar when nothing's uploading anymore
                    myDropzone.on("queuecomplete", function(progress) {
                        document.querySelector("#total-progress").style.opacity = "0"
                    })

                    // Setup the buttons for all transfers
                    // The "add files" button doesn't need to be setup because the config
                    // `clickable` has already been specified.
                    document.querySelector("#actions .start").onclick = function() {
                        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
                    }
                    document.querySelector("#actions .cancel").onclick = function() {
                        myDropzone.removeAllFiles(true)
                    }
                    // DropzoneJS Demo Code End
                </script>
            </body>

            </html>

<?php
        } else {
            header('Location: ../restriction.php');
        }
    }
}
?>