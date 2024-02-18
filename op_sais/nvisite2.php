<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 2 || $_SESSION["role"] == 5 || $_SESSION["role"] == 1)) {

?>

        <?PHP
        require_once("../api/db_connect.php");
        //requête
        $sql = 'SELECT *, type_piece.lib as lib_piece FROM client left join type_piece on type_piece.id = client.id_piece where client.id=' . $_GET["id_client"] . '';
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $client = $request->fetch();
        ?>


        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ACTIA SA</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome Icons -->
            <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <!-- iCheck for checkboxes and radio inputs -->
            <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

            <!-- JQVMap -->
            <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
            <!-- summernote -->
            <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
            <!-- bs-stepper -->
            <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
            <!-- SweetAlert2 -->
            <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
            <!-- Toastr -->
            <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
        </head>


        <body class="hold-transition sidebar-mini layout-fixed">

            <div class="wrapper">

                <?php
                // Include config file
                include("../nav_bar.php");

                $annee = date("Y");
                $id_station = $_SESSION["id_station"];
                $id_user = $_SESSION["id_user"];
                ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid-sm">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0">Identification</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Identification</a></li>
                                        <li class="breadcrumb-item active">Nouveau véhicule</li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->

                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="card card-outline card-warning ">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Client
                                    </h3>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">
                                    <!-- form start -->
                                    <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->
                                    <div class="row">

                                        <div class="col-sm-2">
                                            <!-- Détail client -->
                                            <div class="form-group">
                                                <label for="inputPid">Pièce d'identité</label>
                                                <input readonly type="text" name="id_pid" class="form-control" id="inputPid" placeholder="P id" value="<?php echo $client['lib_piece']; ?>">
                                                <input readonly type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php echo $_GET['id_client']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">

                                            <div class="form-group">
                                                <label for="inputNumPiece">Numéro de la pièce</label>
                                                <input readonly type="text" class="form-control" id="inputNumPiece" name="num_piece_client" placeholder="numero de la pièce" value="<?php echo $client['num_piece']; ?>">
                                            </div>

                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="inputNom_client">Nom</label>
                                                <input readonly type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom" value="<?php echo $client['nom']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="inputPnom_client">Prénoms</label>
                                                <input readonly type="text" class="form-control" id="inputPnom_client" name="prenom_client" placeholder="Prénoms" value="<?php echo $client['prenom']; ?>">
                                            </div>
                                        </div>

                                        <!-- /.Détail client -->
                                    </div>

                                    <!-- /.form start -->
                                </div>

                            </div>


                            <?php

                            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                                //Véhicule deja enregistré
                                if (isset($_GET['action']) && $_GET['action'] == 3) {

                                    if (
                                        isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule'])
                                        && isset($_GET['id_ctrl']) && !empty($_GET['id_ctrl'])
                                        && isset($_GET['id_client']) && !empty($_GET['id_client'])
                                    ) {

                                        $id_vehicule = strip_tags($_GET['id_vehicule']);
                                        $id_client = strip_tags($_GET['id_client']);
                                        $id_ctrl = strip_tags($_GET['id_ctrl']);
                                        $action = strip_tags($_GET['action']);

                                        require_once("../api/db_connect.php");

                                        //$sql = "SELECT * FROM vignette LEFT JOIN vehicule on id_vehicule=vehicule.id LEFT JOIN facturation on id_facturation=facturation.id where vehicule.id=$id_vehicule order by vignette.date DESC LIMIT 1";

                                        $sql = "SELECT * FROM vehicule join vignette on (vignette.id_vehicule=vehicule.id) WHERE vehicule.id=$id_vehicule ";

                                        $request = $db_PDO->prepare($sql);
                                        $request = $db_PDO->query($sql);
                                        // On exécute la requête
                                        $request->execute();
                                        // On stocke le résultat dans un tableau associatif
                                        $vign = $request->fetch();
                                        //}


                            ?>

                                        <form name="nVehicule" action="insert_vehic.php" method="get">

                                            <div class="card card-outline card-warning card">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Véhicule
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->

                                                <div class="card-body">

                                                    <div class="bs-stepper linear" id="bs_step">

                                                        <div class="bs-stepper-header" role="tablist">
                                                            <!-- your steps here -->
                                                            <div class="step" data-target="#logins-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                                    <span class="bs-stepper-circle">1</span>
                                                                    <span class="bs-stepper-label">Détails fiscal</span>
                                                                </button>
                                                            </div>
                                                            <div class="bs-stepper-line"></div>
                                                            <div class="step" data-target="#vehic-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="vehic-part" id="vehic-part-trigger">
                                                                    <span class="bs-stepper-circle">2</span>
                                                                    <span class="bs-stepper-label">information</span>
                                                                </button>
                                                            </div>
                                                            <div class="bs-stepper-line"></div>
                                                            <div class="step" data-target="#information-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                                    <span class="bs-stepper-circle">3</span>
                                                                    <span class="bs-stepper-label">Vignette</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="bs-stepper-content">
                                                            <!-- your steps content here -->


                                                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- Détail fiscal -->

                                                                        <?php if ($vign["id_genre"] == 1) {
                                                                        ?>
                                                                            <div class="form-group">
                                                                                <label for="id_genre">Genre</label>
                                                                                <input type="text" readonly class="form-control" id="id_genre" name="" placeholder="genre" step=1 min=0 readonly value="<?php echo 'Transport de marchandise'; ?>" onchange=CalculVignette() onkeyup=CalculVignette()>
                                                                                <input type="hidden" name="id_genre" value="1">
                                                                            </div>

                                                                        <?php
                                                                        } else {
                                                                        ?>

                                                                            <div class="form-group">
                                                                                <label for="id_genre">Genre</label>
                                                                                <input type="text" readonly class="form-control" name="" placeholder="genre" step=1 min=0 readonly value="<?php echo 'Transport de personne'; ?>" onchange=CalculVignette() onkeyup=CalculVignette()>
                                                                                <input type="hidden" name="id_genre" id="id_genre" value="2">
                                                                            </div>

                                                                        <?PHP
                                                                        }
                                                                        ?>



                                                                        <div class="row">
                                                                            <div class="col-sm-6">

                                                                                <div class="form-group">
                                                                                    <label for="inputPuisFiscal">Puissance fiscale</label>
                                                                                    <input type="number" class="form-control" id="inputPuisFiscal" name="puiss_fisc" placeholder="Puissance Fiscale" step=1 min=0 readonly value="<?php echo '' . $vign["puiss_fisc"]; ?>" onchange=CalculVignette() onkeyup=CalculVignette()>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-6">

                                                                                <div class="form-group">
                                                                                    <label for="inputEnergie">Energie</label>
                                                                                    <select class="form-control" name="id_energie" id="inputEnergie" disabled="disabled">

                                                                                        <?php require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = 'SELECT * FROM energie WHERE id= ' . $vign["id_energie"] . '';
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $energie) { ?>
                                                                                            <option value="<?php echo $energie['id'] ?>"> <?= $energie['lib'] ?> </option>
                                                                                        <?php }  ?>
                                                                                    </select>
                                                                                </div>

                                                                            </div>

                                                                        </div>



                                                                        <div class="form-group clearfix">
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input disabled="disabled" type="checkbox" id="checkTP" name="checkTP" onchange="CalculVignette()">
                                                                                        <label for="checkTP">Transport en commun</label>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-sm-6">
                                                                                    <label for="inputPatente">Patente</label>

                                                                                    <input type="number" class="form-control" id="inputPatente" name="patente" step=1 min=0 readonly value="<?php echo '' . $vign["patente"]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div class="col-sm-6">

                                                                        <div class="form-group">
                                                                            <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <input onchange=CalculVignette() onkeyup=CalculVignette() type="date" class="form-control" readonly value="<?php echo '' . $vign["date_mise_circul"]; ?>" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <h5>
                                                                                        <p id="anneeMC"></p>
                                                                                    </h5>

                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputPTAC">PTAC</label>
                                                                                    <input readonly value="<?php echo '' . $vign["ptac"]; ?>" onchange=CalculVignette() type="number" class="form-control" id="inputPTAC" name="ptac" onkeyup=CalculVignette() onchange=CalculVignette() step=0.1 min=0>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputPA">Place assise</label>
                                                                                    <input readonly value="<?php echo '' . $vign["nb_place"]; ?>" onchange=CalculVignette() type="number" class="form-control" id="inputPA" name="nb_place" placeholder=0 onkeyup=CalculVignette() step=1 min=0 value=0>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputCateg">Catégorie</label>
                                                                                    <input readonly value="<?php echo '' . $vign["categorie"]; ?>" onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup=CalculVignette()>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                        <!-- /.Détail fiscal -->
                                                                    </div>

                                                                </div>

                                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                                            </div>

                                                            <div id="vehic-part" class="content" role="tabpanel" aria-labelledby="vehic-part-trigger">

                                                                <div class="row">

                                                                    <div class="col-sm-6">
                                                                        <!-- Info véhicule -->
                                                                        <div class="row">

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputImmatriculation">Immatriculation</label>
                                                                                    <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                                                                    <input readonly required type="text" id="inputImmatriculation" name="immatriculation" class="form-control" placeholder="Immatriculation" value="<?php echo '' . $vign["immatriculation"]; ?>">

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputDate_local">Date immatriculation</label>
                                                                                    <input readonly required type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA" value="<?php echo '' . $vign["date_local"]; ?>">

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="inputSerie">Numéro de série</label>
                                                                            <input readonly required type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série" /*pattern="[0-9,A-Z]{17}" */ value="<?php echo '' . $vign["num_serie"]; ?>">
                                                                        </div>


                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputMarque">Marque</label>
                                                                                    <input readonly required type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule" value="<?php echo '' . $vign["marque"]; ?>">
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputTypeTech">Type technique</label>
                                                                                    <input readonly required type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique" value="<?php echo '' . $vign["type_tech"]; ?>">
                                                                                </div>
                                                                            </div>



                                                                            <div class="col-sm-12">

                                                                                <div class="form-group">
                                                                                    <label for="inputProprietaire">Proprietaire</label>
                                                                                    <input readonly required type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule" value="<?php echo '' . $vign["proprietaire"]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <!-- /.Info véhicule -->

                                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>

                                                            </div>

                                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                                                                <div class="row">

                                                                    <div class="col-sm-6">

                                                                        <div class="form-group">
                                                                            <label for="dateOldVign">Exp. ancienne vignette</label>
                                                                            <input readonly required type="date" class="form-control" id="dateOldVign" name="dateOldVign" placeholder="JJ/MM/AAAA" value="<?php echo '' . $vign["exp"]; ?>">

                                                                        </div>


                                                                    </div>
                                                                    <P id="amende1"> </P>
                                                                </div>

                                                                <input type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value=<?php echo $_GET['id_client']; ?>>
                                                                <input type="hidden" class="form-control" id="id_ctrl" name="id_ctrl" placeholder="id_ctrl" value=1>
                                                                <input type="hidden" class="form-control" id="action" name="action" value=3>
                                                                <input type="hidden" class="form-control" id="etat_fact" name="etat_fact" value=1>
                                                                <input type="hidden" class="form-control" id="prix_visite" name="prix_visite" value=0>
                                                                <input type="hidden" class="form-control" id="prix_vignette" name="prix_vignette" value=5>
                                                                <input type="hidden" class="form-control" id="prix_vignette_pen" name="prix_vignette_pen" value=6>
                                                                <input type="hidden" class="form-control" id="age_vehic" name="age_vehic" value="0">
                                                                <input type="hidden" class="form-control" id="id_vehicule" name="id_vehicule" value="<?php echo $id_vehicule; ?>">

                                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- form start -->
                                                    <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->



                                                    <!-- /.form start -->
                                                </div>
                                                <div class="card-footer">

                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <!-- <input type="button" value="Visite/vignette" onclick="CalculVignette()" onclick="CalculAmVign()" onchange=CalculVignette() onkeyup=CalculVignette() />-->
                                                            <input type="reset" class="btn btn-danger">
                                                            <input type="submit" class="btn btn-primary">
                                                        </div>

                                                        <div id="CalVignette" class="col-sm-8"></div>
                                                        <div id="CalVignette2" class="col-sm-4"></div>


                                                    </div>
                                                </div>

                                            </div>

                                        </form>

                                    <?php
                                    } else {
                                    ?>

                                        <form name="nVehicule" action="insert_vehic.php" method="post">

                                            <div class="card card-outline card-warning card">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Véhicule
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->

                                                <div class="card-body">

                                                    <div class="bs-stepper linear" id="bs_step">

                                                        <div class="bs-stepper-header" role="tablist">
                                                            <!-- your steps here -->
                                                            <div class="step" data-target="#logins-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                                    <span class="bs-stepper-circle">1</span>
                                                                    <span class="bs-stepper-label">Détails fiscal</span>
                                                                </button>
                                                            </div>
                                                            <div class="bs-stepper-line"></div>
                                                            <div class="step" data-target="#vehic-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="vehic-part" id="vehic-part-trigger">
                                                                    <span class="bs-stepper-circle">2</span>
                                                                    <span class="bs-stepper-label">information</span>
                                                                </button>
                                                            </div>
                                                            <div class="bs-stepper-line"></div>
                                                            <div class="step" data-target="#information-part">
                                                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                                    <span class="bs-stepper-circle">3</span>
                                                                    <span class="bs-stepper-label">Vignette</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="bs-stepper-content">
                                                            <!-- your steps content here -->


                                                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- Détail fiscal -->

                                                                        <div class="form-group">
                                                                            <div class="row">

                                                                                <div class="col-sm-6">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" id="id_genre1" name="id_genre" value=1 onchange=CalculVignette()>
                                                                                        <label class="form-check-label" for="id_genre1">Transport de marchandise</label>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-sm-6">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="radio" id="id_genre2" name="id_genre" value=2 onchange=CalculVignette()>
                                                                                        <label class="form-check-label" for="id_genre2">Transport de personne</label>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-6">

                                                                                <div class="form-group">
                                                                                    <label for="inputPuisFiscal">Puissance fiscale</label>
                                                                                    <input type="number" class="form-control" id="inputPuisFiscal" name="puiss_fisc" placeholder="Puissance Fiscale" step=1 min=0 onchange=CalculVignette() onkeyup=CalculVignette()>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-6">

                                                                                <div class="form-group">
                                                                                    <label for="inputEnergie">Energie</label>
                                                                                    <select class="form-control" name="id_energie" id="inputEnergie">

                                                                                        <?php require_once("../api/db_connect.php");

                                                                                        //requête
                                                                                        $sql = "SELECT * FROM energie";
                                                                                        // On prépare la requête
                                                                                        $request = $db_PDO->prepare($sql);
                                                                                        // On exécute la requête
                                                                                        $request->execute();
                                                                                        // On stocke le résultat dans un tableau associatif
                                                                                        $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($result as $energie) { ?>
                                                                                            <option value="<?php echo $energie['id'] ?>"> <?= $energie['lib'] ?> </option>
                                                                                        <?php }  ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>



                                                                        <div class="form-group clearfix">
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="checkTP" name="checkTP" onchange="CalculVignette()" readonly>
                                                                                        <label for="checkTP">Transport en commun</label>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-sm-6">
                                                                                    <label for="inputPatente">Patente</label>

                                                                                    <input type="number" class="form-control" id="inputPatente" name="patente" step=1 min=0 value="0" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <div class="col-sm-6">

                                                                        <div class="form-group">
                                                                            <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <input onchange=CalculVignette() onkeyup=CalculVignette() type="date" class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <h5>
                                                                                        <p id="anneeMC"></p>
                                                                                    </h5>

                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row">

                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputPTAC">PTAC</label>
                                                                                    <input onchange=CalculVignette() type="number" class="form-control" value="0" id="inputPTAC" name="ptac" placeholder=0 onkeyup=CalculVignette() onchange=CalculVignette() step=0.1 min=0>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputPA">Place assise</label>
                                                                                    <input onchange=CalculVignette() type="number" class="form-control" id="inputPA" name="nb_place" placeholder=0 onkeyup=CalculVignette() step=1 min=0 value=0>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-4">

                                                                                <div class="form-group">
                                                                                    <label for="inputCateg">Catégorie</label>
                                                                                    <input readonly onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup=CalculVignette()>
                                                                                    <input onchange=CalculVignette() type="hidden" class="form-control" id="id_categ" name="id_categ" placeholder="id_categ" onkeyup=CalculVignette()>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                        <!-- /.Détail fiscal -->
                                                                    </div>

                                                                </div>

                                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                                            </div>

                                                            <div id="vehic-part" class="content" role="tabpanel" aria-labelledby="vehic-part-trigger">

                                                                <div class="row">

                                                                    <div class="col-sm-6">
                                                                        <!-- Info véhicule -->
                                                                        <div class="row">

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputImmatriculation">Immatriculation</label>
                                                                                    <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                                                                    <input required type="text" id="inputImmatriculation" name="immatriculation" class="form-control" placeholder="Immatriculation">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputDate_local">Date immatriculation</label>
                                                                                    <input required type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA">

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="inputSerie">Numéro de série</label>
                                                                            <input required type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série" /*pattern="[0-9,A-Z]{17}" * />
                                                                        </div>


                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputMarque">Marque</label>
                                                                                    <input required type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule">
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputTypeTech">Type technique</label>
                                                                                    <input required type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique">
                                                                                </div>
                                                                            </div>



                                                                            <div class="col-sm-12">

                                                                                <div class="form-group">
                                                                                    <label for="inputProprietaire">Proprietaire</label>
                                                                                    <input required type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <!-- /.Info véhicule -->


                                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>

                                                            </div>

                                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                                                                <div class="row">

                                                                    <div class="col-sm-6">

                                                                        <div class="form-group">
                                                                            <label for="dateOldVign">Exp. acienne vignette</label>
                                                                            <input class="form-control" type="date" name="dateOldVign" id="dateOldVign" onchange="CalculAmVign()" onkeyup="CalculAmVign()">
                                                                        </div>

                                                                    </div>

                                                                    <P id="amende1"> </P>
                                                                </div>

                                                                <input type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php echo $_GET['id_client']; ?>">
                                                                <input type="hidden" class="form-control" id="id_ctrl" name="id_ctrl" placeholder="id_ctrl" value="1">
                                                                <input type="hidden" class="form-control" id="action" name="action" value="1">
                                                                <input type="hidden" class="form-control" id="etat_fact" name="etat_fact" value="1">
                                                                <input type="hidden" class="form-control" id="prix_visite" name="prix_visite" value="">
                                                                <input type="hidden" class="form-control" id="prix_vignette" name="prix_vignette" value="">
                                                                <input type="hidden" class="form-control" id="prix_vignette_pen" name="prix_vignette_pen" value="">
                                                                <input type="hidden" class="form-control" id="age_vehic" name="age_vehic" value="">

                                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <!-- form start -->
                                                    <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->



                                                    <!-- /.form start -->
                                                </div>

                                                <div class="card-footer">

                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <!-- <input type="button" class="btn btn-primary" value="Visite/vignette" onclick="CalculVignette()" onclick="CalculAmVign()" onchange="CalculVignette()"  onkeyup="CalculAmVign()" onkeyup=CalculVignette() /> -->
                                                            <input type="reset" class="btn btn-danger">
                                                            <input type="submit" class="btn btn-primary">
                                                        </div>

                                                        <div id="CalVignette" class="col-sm-8"></div>
                                                        <div id="CalVignette2" class="col-sm-4"></div>


                                                    </div>
                                                </div>



                                            </div>

                                        </form>

                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>
                    </section>

                </div>

            </div>

            <?php
            // Include config file
            include("../footer.php");
            ?>

            <script>
                /*
                function Exp() {
                    var dateOldVign = Date.parse(document.getElementById("dateOldVign").value);


                    document.getElementById("oldVign").value = "" + datevignette;
                    // document.getElementById("date_exp_vign_show").innerHTML = date +"****"+date_debut_vign+ "*** "+year+"***";

                }*/
            </script>

            <script>
                function Clea() {
                    document.getElementById("date_vign_show").innerHTML = "";
                    document.getElementById("anne_MC").innerHTML = "";
                    document.getElementById("CalVignette").innerHTML = "";
                }
            </script>

            <script>
                function CalculAmVign() {

                    var dateVign = new Date(document.getElementById("dateOldVign").value);

                    var day = dateVign.getDate();
                    var mois = dateVign.getMonth();
                    var year = dateVign.getUTCFullYear();

                    var now = Date.now();
                    var prixVign = document.getElementById("prix_vignette").value;

                    var diff = dateDiff(dateVign, now);
                    var dvign = diff.day;

                    var prix_vignette_pen = 0;
                    var Sprix_vignette_pen = 0;


                    //document.getElementById("amende1").innerHTML = "La date de validité de la vignette est dépassée de " + diff.day + " jour(s) une pénalité de 100% de la valeur de la vignette sera appliqué conformement à la loi en vigueur : </br> Nouveau montant de la vignette : " + prix_vignette_pen + " F CFA";
                    //document.getElementById("amende2").innerHTML = "La date de validité de la vignette est dépassée de " + diff.day + " jour(s) une pénalité de 100% de la valeur de la vignette sera appliqué conformement à la loi en vigueur : </br> Nouveau montant de la vignette : " + prix_vignette_pen + " F CFA";

                    if (dvign >= 61) {

                        prix_vignette_pen = prixVign;
                        Sprix_vignette_pen = prixVign * 2;
                        document.getElementById("prix_vignette_pen").value = prix_vignette_pen;
                        document.getElementById("amende1").innerHTML = "La date de validité de la vignette est dépassée de " + diff.day + " jour(s) une pénalité de 100% de la valeur de la vignette sera appliqué conformement à la loi en vigueur. </br> Nouveau montant de la vignette : " + Sprix_vignette_pen + " F CFA";

                        //return prix_vignette_pen;
                        //document.getElementById("prix_vignette").value = Sprix_vignette_pen;
                    } else if (dvign < 61) {

                        Sprix_vignette_pen = prixVign;

                        document.getElementById("amende1").innerHTML = "Aucune pénalité n'est applicable";
                        document.getElementById("prix_vignette_pen").value = prix_vignette_pen;
                    }

                    var categ = 0;
                    var prix_visite = 0;
                    var totalPay = 0;

                    categ = document.getElementById("inputCateg").value;
                    prix_visite = document.getElementById("prix_visite").value;
                    //document.getElementById("prix_vignette").value = Sprix_vignette_pen;

                    totalPay = (prix_visite * 1) + (Sprix_vignette_pen * 1);
                    var affich2 = '<br><h6>Catégorie du véhicule: <b>' + categ + ' </b><br>Visite Technique: <b>' + prix_visite + 'FCFA </b><br>Vignette: <b>' + Sprix_vignette_pen + 'FCFA </b><br></h6><h4> Somme à régler : <b>' + totalPay + ' FCFA </b> </h4>';
                    document.getElementById("CalVignette").innerHTML = "" + affich2;
                }
            </script>


            <script>
                function dateDiff(date1, date2) {
                    var diff = {} // Initialisation du retour
                    var tmp = date2 - date1;

                    tmp = Math.floor(tmp / 1000); // Nombre de secondes entre les 2 dates
                    diff.sec = tmp % 60; // Extraction du nombre de secondes

                    tmp = Math.floor((tmp - diff.sec) / 60); // Nombre de minutes (partie entière)
                    diff.min = tmp % 60; // Extraction du nombre de minutes

                    tmp = Math.floor((tmp - diff.min) / 60); // Nombre d'heures (entières)
                    diff.hour = tmp % 24; // Extraction du nombre d'heures

                    tmp = Math.floor((tmp - diff.hour) / 24); // Nombre de jours restants
                    diff.day = tmp % 365;

                    tmp = Math.floor((tmp - diff.day) / 365); // Nombre d'année restants
                    diff.year = tmp;

                    //3,154e+10
                    return diff;
                }
            </script>


            <script>
                /*   function showPatente() {
                var tp = document.querySelector('input[id="checkTP"]');
                var inputpatente = document.querySelector('input[id="inputPatente"]');
                var inputptac = document.querySelector('input[id="inputPTAC"]');
                var rad = document.nVehicule.id_genre;

                if (rad.value == 2 && tp.checked) {
                    inputpatente.disabled = false;
                    inputptac.disabled = false;




                } else if (rad.value == 2 && !tp.checked) {
                    inputpatente.disabled = true;
                    inputptac.disabled = true;
                }
             }*/
            </script>


            <script>
                /*
                function CalculVignette() {

                    var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
                    var type
                    var rad = document.nVehicule.id_genre;

                    var prixVign = 0;
                    var prixVisite = 0;

                    var dateMC = Date.parse(document.getElementById("inputDateMC").value);
                    var now = Date.now();


                    var diff = dateDiff(dateMC, now);

                    var ageVehic = diff.year + 1;
                    document.getElementById("anneeMC").innerHTML = +ageVehic + " ans";
                    document.getElementById("age_vehic").value = ageVehic;


                    puisFisc = document.getElementById("inputPuisFiscal").value;
                    ptac = document.getElementById("inputPTAC").value;
                    pA = document.getElementById("inputPA").value;

                    var tp = document.querySelector('input[id="checkTP"]');

                    categ = "";


                    //Type transport de marchandise
                    if (rad.value == 1) {

                        var inputpatente = document.querySelector('input[id="inputPatente"]');
                        document.getElementById("inputPA").value = 0;
                        document.getElementById("inputPA").readOnly = true;
                        document.getElementById("inputPTAC").readOnly = false;

                        tp.checked = false;
                        tp.readOnly = true;
                        inputpatente.readOnly = true;


                        if (ptac == 0) {
                            if (puisFisc == 0) {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que son PTAC";
                                // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                            } else {
                                affich = "Veuillez saisir le PTAC du véhicule";
                            }
                        } else if (ptac > 0 && ptac <= 3.5) {
                            if (puisFisc == 0) {
                                affich = "Veuillez saisir la puissance fiscale du véhicule";
                            } else if (puisFisc > 0 && puisFisc <= 7) {
                                categ = "TP01";
                                id_categ = 5;
                                prixVisite = 13100;
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            } else if (puisFisc > 7) {
                                categ = "TP02";
                                id_categ = 6;
                                prixVisite = 15500;
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            }
                        } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
                            categ = "TP03";
                            id_categ = 7;
                            prixVisite = 18000;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;

                        } else if (ptac > 10 && puisFisc > 0) {
                            categ = "TP04";
                            id_categ = 8;
                            prixVisite = 20450;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;
                        }

                    } //Type transport de personne
                    else if (rad.value == 2) {

                        var inputpatente = document.querySelector('input[id="inputPatente"]');
                        var inputptac = document.querySelector('input[id="inputPTAC"]');


                        tp.readOnly = false;
                        if (tp.checked) {
                            inputpatente.readOnly = false;
                            inputptac.readOnly = false;


                        } else if (!tp.checked) {
                            inputpatente.readOnly = true;
                            inputptac.readOnly = true;

                            inputpatente.value = 0;
                            inputptac.value = 0;
                        }

                        document.getElementById("inputPA").readOnly = false;
                        document.getElementById("inputPTAC").value = 0;
                        document.getElementById("inputPTAC").readOnly = true;

                        if (pA == 0 && puisFisc == 0) {

                            affich = "Veuillez saisir la puissance fiscale du véhicule ainsi que le nombre de place";
                            // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                        } else if (pA == 0 && puisFisc > 0) {
                            affich = "Veuillez saisir le nombre de place du véhicule";


                        } else if (pA > 0 && pA <= 9 && puisFisc == 0) {
                            affich = "Veuillez saisir la puissance fiscale du véhicule";

                        } else if (pA > 0 && pA <= 9 && puisFisc > 0 && puisFisc <= 7) {
                            categ = "VL01";
                            id_categ = 1;
                            prixVisite = 13100;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;

                        } else if (pA > 0 && pA <= 9 && puisFisc > 7) {
                            categ = "VL02";
                            id_categ = 2;
                            prixVisite = 15500;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;
                            document.getElementById("CalVignette").innerHTML = "<h6>  Véhicule de catégorie : <b>" + categ + "</b> || Visite Technique :  <b>" + prixVisite + " F CFA </b> || Vignette : <b>" + prixVign + " F CFA </b> </h6>";


                        } else if (pA > 9 && puisFisc <= 7) {
                            affich = "Veuillez ajuster la puissance fiscale du véhicule";

                        } else if (pA > 9 && pA <= 25 && puisFisc > 7 && ptac > 3.5) {
                            categ = "PL01";
                            id_categ = 3;
                            prixVisite = 18000;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;


                        } else if ((pA >= 17 && pA <= 70) && (puisFisc > 7 && ptac >= 3.5)) {
                            categ = "PL02";
                            id_categ = 4;
                            prixVisite = 20450;
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;

                        }

                    }

                    if (ageVehic > 0 && ageVehic <= 4) {

                        if (puisFisc >= 2 && puisFisc <= 4) {
                            prixVign = 19000;

                        } else if (puisFisc >= 5 && puisFisc <= 7) {
                            prixVign = 35000;

                        } else if (puisFisc >= 8 && puisFisc <= 11) {
                            prixVign = 49000;

                        } else if (puisFisc >= 12 && puisFisc <= 15) {
                            prixVign = 96000;

                        }

                    } else if (ageVehic > 4 && ageVehic <= 10) {

                        if (puisFisc >= 2 && puisFisc <= 4) {
                            prixVign = 14250;

                        } else if (puisFisc >= 5 && puisFisc <= 7) {
                            prixVign = 26250;

                        } else if (puisFisc >= 8 && puisFisc <= 11) {
                            prixVign = 36750;

                        } else if (puisFisc >= 12 && puisFisc <= 15) {
                            prixVign = 72000;
                        }

                    } else if (ageVehic > 11) {

                        if (puisFisc >= 2 && puisFisc <= 4) {
                            prixVign = 13500;

                        } else if (puisFisc >= 5 && puisFisc <= 7) {
                            prixVign = 25000;

                        } else if (puisFisc >= 8 && puisFisc <= 11) {
                            prixVign = 30000;

                        } else if (puisFisc >= 12 && puisFisc <= 15) {
                            prixVign = 40000;

                        }
                    }

                    document.getElementById("prix_visite").value = prixVisite;
                    document.getElementById("prix_vignette").value = prixVign;
                    //document.getElementById("CalVignette").innerHTML = "<h6>  Véhicule de catégorie : <b>" + categ + "</b> || Visite Technique :  <b>" + prixVisite + " F CFA </b> || Vignette : <b>" + prixVign + " F CFA </b> </h6>";

                    document.getElementById("CalVignette").innerHTML = "" + affich;

                    
                    var affichCateg = "";
                    var affichVTech = "";
                    var affichVign = "";

                }
            */
            </script>

            <script>
                function CalculVignette() {

                    var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
                    var type
                    var rad = document.nVehicule.id_genre;
                    var prev = null;
                    var prixVign = 0;
                    var prixVisite = 0;

                    var dateMC = Date.parse(document.getElementById("inputDateMC").value);
                    var now = Date.now();

                    var diff = dateDiff(dateMC, now);
                    var ageVehic = diff.year + 1;
                    document.getElementById("anneeMC").innerHTML = +ageVehic + " ans";

                    document.getElementById("age_vehic").value = ageVehic;

                    puisFisc = document.getElementById("inputPuisFiscal").value;
                    ptac = document.getElementById("inputPTAC").value;
                    pA = document.getElementById("inputPA").value;


                    document.getElementById("CalVignette").innerHTML = "Visite Technique: " + document.getElementById("prix_visite").value + " FCFA  //  Vignette:  " + document.getElementById("prix_vignette").value + " FCFA ";

                    //Type transport de marchandise
                    if (rad.value == 1) {

                        var inputpatente = document.querySelector('input[id="inputPatente"]');
                        var tp = document.querySelector('input[id="checkTP"]');
                        document.getElementById("inputPA").value = 0;
                        document.getElementById("inputPA").readOnly = true;
                        document.getElementById("inputPTAC").readOnly = false;
                        tp.disabled = true;
                        inputpatente.disabled = true;

                        if (ageVehic > 0 && ageVehic <= 4) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 19000;
                                prixVign = 19000;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 35000;
                                prixVign = 35000;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 49000;
                                prixVign = 49000;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 96000;
                                prixVign = 96000;
                                document.getElementById("prix_vignette").value = prixVign;


                            }

                        } else if (ageVehic > 4 && ageVehic <= 10) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 14250;
                                prixVign = 14250;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 26250;
                                prixVign = 26250;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 36750;
                                prixVign = 36750;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 72000;
                                prixVign = 72000;
                                document.getElementById("prix_vignette").value = prixVign;
                            }

                        } else if (ageVehic > 11) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 13500;
                                prixVign = 13500;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 25000;
                                prixVign = 25000;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 30000;
                                prixVign = 30000;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 40000;
                                prixVign = 40000;
                                document.getElementById("prix_vignette").value = prixVign;


                            }
                        }


                        if (ptac == 0) {
                            if (puisFisc == 0) {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que son PTAC";
                                // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                            } else {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir le PTAC du véhicule";
                            }
                        } else if (ptac > 0 && ptac <= 3.5) {
                            if (puisFisc == 0) {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule";
                            } else if (puisFisc > 0 && puisFisc <= 7) {
                                categ = "TP01";
                                id_categ = 5;
                                prixVisite = 13100;
                                document.getElementById("prix_visite").value = prixVisite;
                                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            } else if (puisFisc > 7) {
                                categ = "TP02";
                                id_categ = 6;
                                prixVisite = 15500;
                                document.getElementById("prix_visite").value = prixVisite;
                                document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            }
                        } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
                            categ = "TP03";
                            id_categ = 7;
                            prixVisite = 18000;
                            document.getElementById("prix_visite").value = prixVisite;
                            document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;

                        } else if (ptac > 10 && puisFisc > 0) {
                            categ = "TP04";
                            id_categ = 8;
                            prixVisite = 20450;
                            document.getElementById("prix_visite").value = prixVisite;
                            document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;
                        }




                        document.getElementById("CalVignette").innerHTML = "Visite Technique: " + document.getElementById("prix_visite").value + " FCFA  //  Vignette:  " + document.getElementById("prix_vignette").value + " FCFA ";

                    } //Type transport de personne
                    else if (rad.value == 2) {

                        var tp = document.querySelector('input[id="checkTP"]');
                        var inputpatente = document.querySelector('input[id="inputPatente"]');
                        var inputptac = document.querySelector('input[id="inputPTAC"]');

                        tp.readOnly = false;
                        if (rad.value == 2 && tp.checked) {
                            inputpatente.readOnly = false;
                            inputptac.readOnly = false;


                        } else if (rad.value == 2 && !tp.checked) {
                            inputpatente.readOnly = true;
                            inputptac.readOnly = true;
                        }

                        document.getElementById("inputPA").readOnly = false;
                        //document.getElementById("inputPTAC").value = 0;
                        //document.getElementById("inputPTAC").disabled = true;
                        //document.getElementById("CalVignette").innerHTML = rad.value;

                        //ageVehic= document.getElementById("age_vehic").value;
                        if (ageVehic > 0 && ageVehic <= 4) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 19000;
                                prixVign = 19000;
                                document.getElementById("prix_vignette").value = prixVign;

                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 35000;
                                prixVign = 35000;
                                document.getElementById("prix_vignette").value = prixVign;

                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 49000;
                                prixVign = 49000;
                                document.getElementById("prix_vignette").value = prixVign;

                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 96000;
                                prixVign = 96000;
                                document.getElementById("prix_vignette").value = prixVign;

                            }


                        } else if (ageVehic > 4 && ageVehic <= 10) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 14250;
                                prixVign = 14250;
                                document.getElementById("prix_vignette").value = prixVign;

                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 26250;
                                prixVign = 26250;
                                document.getElementById("prix_vignette").value = prixVign;


                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 36750;
                                prixVign = 36750;
                                document.getElementById("prix_vignette").value = prixVign;
                                //document.getElementById("CalVignette").innerHTML = "Visite Technique:"+document.getElementById('prix_visite').value+" FCFA  //  Vignette: "+document.getElementById('prix_vignette').value+""+ageVehic+2+"";


                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 72000;
                                prixVign = 72000;
                                document.getElementById("prix_vignette").value = prixVign;
                            }


                        } else if (ageVehic > 11) {

                            if (puisFisc >= 2 && puisFisc <= 4) {
                                prixVignette = 13500;
                                prixVign = 13500;
                                document.getElementById("prix_vignette").value = prixVign;

                            } else if (puisFisc >= 5 && puisFisc <= 7) {
                                prixVignette = 25000;
                                prixVign = 25000;
                                document.getElementById("prix_vignette").value = prixVign;
                                //document.getElementById("CalVignette").innerHTML = "Visite Technique: "+document.getElementById("prix_visite").value+" FCFA  //  Vignette:  "+document.getElementById("prix_vignette").value+""+ageVehic+"gtr";

                                //document.getElementById("CalVignette").innerHTML = "Visite Technique:"+document.getElementById('prix_visite').value+" FCFA  //  Vignette: "+document.getElementById('prix_vignette').value+"";


                            } else if (puisFisc >= 8 && puisFisc <= 11) {
                                prixVignette = 30000;
                                prixVign = 30000;
                                document.getElementById("prix_vignette").value = prixVign;
                                //document.getElementById("CalVignette").innerHTML = "Visite Technique:"+document.getElementById('prix_visite').value+" FCFA  //  Vignette: "+document.getElementById('prix_vignette').value+"";

                            } else if (puisFisc >= 12 && puisFisc <= 15) {
                                prixVignette = 40000;
                                prixVign = 40000;
                                document.getElementById("prix_vignette").value = prixVign;
                                //document.getElementById("CalVignette").innerHTML = "Visite Technique:"+document.getElementById('prix_visite').value+" FCFA  //  Vignette: "+document.getElementById('prix_vignette').value+"";

                            }
                        }


                        if (pA == 0) {
                            if (puisFisc == 0) {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que le nombre de place";
                                // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                            } else {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir le nombre de place du véhicule";

                            }

                        } else if (pA > 0 && pA <= 9) {
                            if (puisFisc == 0) {
                                document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule";

                            } else if (puisFisc > 0 && puisFisc <= 7) {
                                categ = "VL01";
                                id_categ = 1;
                                prixVisite = 13100;
                                document.getElementById("prix_visite").value = prixVisite;
                                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            } else if (puisFisc > 7) {
                                categ = "VL02";
                                id_categ = 2;
                                prixVisite = 15500;
                                document.getElementById("prix_visite").value = prixVisite;
                                document.getElementById("CalVignette").innerHTML = "Visite Technique: " + document.getElementById("prix_visite").value + " FCFA  //  Vignette:  " + document.getElementById("prix_vignette").value + "";
                                document.getElementById("inputCateg").value = categ;
                                document.getElementById("id_categ").value = id_categ;

                            }
                        } else if (pA > 9 && puisFisc <= 7) {
                            document.getElementById("CalVignette").innerHTML = "Veuillez ajuster la puissance fiscale du véhicule";

                        } else if (pA > 9 && pA <= 25 && puisFisc > 7 && ptac > 3.5) {
                            categ = "PL01";
                            id_categ = 3;
                            prixVisite = 18000;
                            document.getElementById("prix_visite").value = prixVisite;
                            document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;


                        } else if (pA >= 17 && pA <= 70 && puisFisc > 7 && ptac >= 3.5) {
                            categ = "PL02";
                            id_categ = 4;
                            prixVisite = 20450;
                            document.getElementById("prix_visite").value = prixVisite;
                            document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
                            document.getElementById("inputCateg").value = categ;
                            document.getElementById("id_categ").value = id_categ;

                        }


                    }

                    document.getElementById("CalVignette").innerHTML = "Visite Technique: " + document.getElementById("prix_visite").value + " FCFA  //  Vignette:  " + document.getElementById("prix_vignette").value + " FCFA ";

                }
            </script>


            <!-- jQuery -->
            <script src="../plugins/jquery/jquery.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
            <script>
                $.widget.bridge('uibutton', $.ui.button)
            </script>
            <!-- Bootstrap 4 -->
            <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- ChartJS -->
            <script src="../plugins/chart.js/Chart.min.js"></script>
            <!-- Sparkline -->
            <script src="../plugins/sparklines/sparkline.js"></script>
            <!-- JQVMap -->
            <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
            <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
            <!-- jQuery Knob Chart -->
            <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
            <!-- daterangepicker -->
            <script src="../plugins/moment/moment.min.js"></script>
            <script src="../plugins/daterangepicker/daterangepicker.js"></script>
            <!-- Tempusdominus Bootstrap 4 -->
            <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
            <!-- Summernote -->
            <script src="../plugins/summernote/summernote-bs4.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js"></script>
            <!-- overlayScrollbars -->
            <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
            <!-- bs-stepper -->
            <script src="../plugins/bs-stepper/js/bs-stepper.min.js"></script>

            <!-- jquery-validation -->
            <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
            <script src="../plugins/jquery-validation/additional-methods.min.js"></script>

            <!-- Page specific script -->
            <script>
                $(function() {
                    $("#example1").DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
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

            <!-- Page specific script -->
            <script>
                // BS-Stepper Init
                document.addEventListener('DOMContentLoaded', function() {
                    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
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