<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACTIA SA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- bs-stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
</head>


<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php
        // Include config file
        include("nav_bar.php");
        ?>

        <?php

        $annee = date("Y");
        $id_station = $_SESSION["id_station"];
        $id_user = $_SESSION["id_user"];



        require_once("api/db_connect.php");
        //requête
        $sql = "SELECT * FROM station left join user on user.id_station=station.id where station.id='" . $id_station . "'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $reset = $request->fetch();

        $resp_station = $reset["id_responsable"];
        $station = $reset["nom"];
        $code_station = $reset["code"];



        require_once("api/db_connect.php");
        //requête
        $sql = "SELECT max(id) as max FROM vignette";
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $reset = $request->fetch();
        $number = $reset["max"] + 1;

        $length = 6;
        $numb = substr(str_repeat(0, $length) . $number, -$length);
        $num_vignette = $code_station . '' . $annee . '' . $numb;

        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Contrôle technique</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Visite technique</a></li>
                                <li class="breadcrumb-item active">Enregistrement véhicule</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">



                    <div class="card card-outline card-warning">
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
                                <div class="col-sd-6">
                                    <!-- Détail client -->
                                    <div class="form-group">
                                        <label for="inputPid">Pièce d'identité</label>
                                        <input readonly type="text" name="id_pid" class="form-control" id="inputPid" placeholder="P id" value="<?php
                                                                                                                                                echo $_GET['id_pid'];
                                                                                                                                                ?>">

                                        <input readonly type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php
                                                                                                                                                            echo $_GET['id_client'];
                                                                                                                                                            ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="inputNom_client">Nom</label>
                                        <input readonly type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom" value="<?php
                                                                                                                                                            echo $_GET['nom_client'];
                                                                                                                                                            ?>">
                                    </div>

                                </div>


                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="inputNumPiece">Numéro de la pièce</label>
                                        <input readonly type="text" class="form-control" id="inputNumPiece" name="num_piece_client" placeholder="numero de la pièce" value="<?php
                                                                                                                                                                            echo $_GET['num_piece_client'];
                                                                                                                                                                            ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPnom_client">Prénoms</label>
                                        <input readonly type="text" class="form-control" id="inputPnom_client" name="prenom_client" placeholder="Prénoms" value="<?php
                                                                                                                                                                    echo $_GET['prenom_client'];
                                                                                                                                                                    ?>">
                                    </div>

                                    <!-- /.Détail client -->
                                </div>
                            </div>

                            <!-- /.form start -->
                        </div>

                    </div>







                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="pt-2 px-3">
                                    <h3 class="card-title">Véhicule</h3>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-vp-tab" data-toggle="pill" href="#custom-tabs-two-vp" role="tab" aria-controls="custom-tabs-two-vp" aria-selected="true">Véhicule personnel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-vtc-tab" data-toggle="pill" href="#custom-tabs-two-vtc" role="tab" aria-controls="custom-tabs-two-vtc" aria-selected="false">Véhicule de transport en commun</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-moto-tab" data-toggle="pill" href="#custom-tabs-two-moto" role="tab" aria-controls="custom-tabs-two-moto" aria-selected="false">Moto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-tm-tab" data-toggle="pill" href="#custom-tabs-two-tm" role="tab" aria-controls="custom-tabs-two-tm" aria-selected="false">Transport de marchandise</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-two-vp" role="tabpanel" aria-labelledby="custom-tabs-two-vp-tab">

                                    <div class="bs-stepper linear">
                                        <div class="bs-stepper-header" role="tablist">
                                            <!-- your steps here -->
                                            <div class="step" data-target="#logins-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Détails fiscal</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#vehic-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="vehic-part" id="vehic-part-trigger">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">information</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
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
                                                                        <input class="form-check-input" type="radio" name="id_genre" value=1 onchange="CalculVignette()">
                                                                        <label class="form-check-label">Transport de marchandise</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="id_genre" value=2 onchange="CalculVignette()">
                                                                        <label class="form-check-label">Transport de personne</label>
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

                                                                        <?php include("api/db_connect.php");

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


                                                        <div class="form-group">
                                                            <label for="inputCateg">Catégorie</label>
                                                            <input onchange="CalculVignette()" type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup="CalculVignette()" step=1 min=0 disabled>
                                                            <input onchange="CalculVignette()" type="hidden" class="form-control" id="id_categ" name="id_categ" placeholder="id_categ" onkeyup="CalculVignette()">
                                                        </div>

                                                        <p id="CalVignette"></p>

                                                    </div>




                                                    <div class="col-sm-6">

                                                        <div class="form-group">
                                                            <p></br></p>

                                                            <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input onchange="CalculVignette()" onkeyup="CalculVignette()" type="date" class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h5>
                                                                        <p id="anneeMC"></p>
                                                                    </h5>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="inputPTAC">PTAC</label>
                                                                    <input type="number" class="form-control" id="inputPTAC" name="ptac" placeholder="Poids Total à charge" onkeyup="CalculVignette()" onchange="CalculVignette()" step=1 min=0>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="inputPA">Place assise</label>
                                                                    <input onchange="CalculVignette()" type="number" class="form-control" id="inputPA" name="nb_place" placeholder="Place Assise" onkeyup="CalculVignette()" step=1 min=0>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /.Détail fiscal -->
                                                </div>

                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                            </div>


                                            <div id="vehic-part" class="content" role="tabpanel" aria-labelledby="vehic-part-trigger">

                                                <div class="row">

                                                    <div class="col-sm-6">
                                                        <!-- Info véhicule -->

                                                        <div class="form-group">
                                                            <label for="inputImmatriculation">Immatriculation</label>
                                                            <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                                            <input type="text" name="immatriculation" class="form-control" placeholder="Immatriculation">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputSerie">Numéro de série</label>
                                                            <input type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputDate_local">Date immatriculation</label>
                                                            <input type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA">
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6">

                                                        <div class="form-group">
                                                            <label for="inputMarque">Marque du véhicule</label>
                                                            <input type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputTypeTech">Type technique</label>
                                                            <input type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputProprietaire">Proprietaire</label>
                                                            <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule">
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- /.Info véhicule -->


                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                            </div>


                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">


                                                <div class="col-sm-12">

                                                    <div class="form-group">
                                                        <label for="num_old_vign">Numero de la vignette (ancienne)</label>
                                                        <input type="text" class="form-control" id="num_old_vign" name="num_old_vign" placeholder="Numéro de la vignette">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="date_vign">Date de fin de validité de la vignette(ancienne)</label>
                                                        <input onchange="CalculAmVign()" onkeyup="CalculAmVign()" type="date" class="form-control" name="date_vign" id="date_vign" placeholder="JJ/MM/AAAA">
                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <h6>
                                                        <p id="date_vign_show"></p>
                                                    </h6>
                                                </div>





                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="num_vign">Numero de la vignette (Nouvelle vignette)</label>
                                                        <input type="text" class="form-control" id="num_vign" name="num_vign" placeholder="Numéro de la vignette" value="<?php echo $num_vignette ?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputDate_vign">Date de début (Nouvelle vignette)</label>
                                                    <input type="date" class="form-control" id="inputDate_vign" name="inputDate_vign" placeholder="JJ/MM/AAAA">
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="date_debut_vign">Date de début (Nouvelle vignette)</label>
                                                        <input type="date" class="form-control" name="date_debut_vign" id="date_debut_vign" placeholder="JJ/MM/AAAA">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <h6>
                                                        <p id="date_exp_vign_show"></p>
                                                    </h6>

                                                </div>




                                                <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                <button type="submit" class="btn btn-primary">valider</button>

                                            </div>


                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-two-vtc" role="tabpanel" aria-labelledby="custom-tabs-two-vtc-tab">

                                    <div class="card">

                                        <div class="bs-stepper linear">
                                            <div class="bs-stepper-header" role="tablist">
                                                <!-- your steps here -->
                                                <div class="step" data-target="#logins-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                        <span class="bs-stepper-circle">1</span>
                                                        <span class="bs-stepper-label">Détails fiscal</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
                                                <div class="step" data-target="#vehic-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="vehic-part" id="vehic-part-trigger">
                                                        <span class="bs-stepper-circle">2</span>
                                                        <span class="bs-stepper-label">information</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
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
                                                                            <input class="form-check-input" type="radio" name="id_genre" value=1 onchange="CalculVignette()">
                                                                            <label class="form-check-label">Transport de marchandise</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="id_genre" value=2 onchange="CalculVignette()">
                                                                            <label class="form-check-label">Transport de personne</label>
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

                                                                            <?php include("api/db_connect.php");

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


                                                            <div class="form-group">
                                                                <label for="inputCateg">Catégorie</label>
                                                                <input onchange="CalculVignette()" type="text" class="form-control" id="inputCateg" name="categ" placeholder="Catégorie" onkeyup="CalculVignette()" step=1 min=0 disabled>
                                                                <input onchange="CalculVignette()" type="hidden" class="form-control" id="id_categ" name="id_categ" placeholder="id_categ" onkeyup="CalculVignette()">
                                                            </div>

                                                            <p id="CalVignette"></p>

                                                        </div>




                                                        <div class="col-sm-6">

                                                            <div class="form-group">
                                                                <p></br></p>

                                                                <label for="inputDateMC">Date de 1ere mise en circulation</label>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <input onchange="CalculVignette()" onkeyup="CalculVignette()" type="date" class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <h5>
                                                                            <p id="anneeMC"></p>
                                                                        </h5>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="inputPTAC">PTAC</label>
                                                                        <input type="number" class="form-control" id="inputPTAC" name="ptac" placeholder="Poids Total à charge" onkeyup="CalculVignette()" onchange="CalculVignette()" step=1 min=0>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="inputPA">Place assise</label>
                                                                        <input onchange="CalculVignette()" type="number" class="form-control" id="inputPA" name="nb_place" placeholder="Place Assise" onkeyup="CalculVignette()" step=1 min=0>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- /.Détail fiscal -->
                                                    </div>

                                                    <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                                </div>


                                                <div id="vehic-part" class="content" role="tabpanel" aria-labelledby="vehic-part-trigger">

                                                    <div class="row">

                                                        <div class="col-sm-6">
                                                            <!-- Info véhicule -->

                                                            <div class="form-group">
                                                                <label for="inputImmatriculation">Immatriculation</label>
                                                                <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                                                <input type="text" name="immatriculation" class="form-control" placeholder="Immatriculation">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="inputSerie">Numéro de série</label>
                                                                <input type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="inputDate_local">Date immatriculation</label>
                                                                <input type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA">
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-6">

                                                            <div class="form-group">
                                                                <label for="inputMarque">Marque du véhicule</label>
                                                                <input type="text" class="form-control" id="inputMarque" name="marque" placeholder="Marque du véhicule">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="inputTypeTech">Type technique</label>
                                                                <input type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="inputProprietaire">Proprietaire</label>
                                                                <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- /.Info véhicule -->


                                                    <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                    <button class="btn btn-primary" type="button" onclick="stepper.next()">suivant</button>
                                                </div>


                                                <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">


                                                    <div class="col-sm-12">

                                                        <div class="form-group">
                                                            <label for="num_old_vign">Numero de la vignette (ancienne)</label>
                                                            <input type="text" class="form-control" id="num_old_vign" name="num_old_vign" placeholder="Numéro de la vignette">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="date_vign">Date de fin de validité de la vignette(ancienne)</label>
                                                            <input onchange="CalculAmVign()" onkeyup="CalculAmVign()" type="date" class="form-control" name="date_vign" id="date_vign" placeholder="JJ/MM/AAAA">
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-6">
                                                        <h6>
                                                            <p id="date_vign_show"></p>
                                                        </h6>
                                                    </div>





                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="num_vign">Numero de la vignette (Nouvelle vignette)</label>
                                                            <input type="text" class="form-control" id="num_vign" name="num_vign" placeholder="Numéro de la vignette" value="<?php echo $num_vignette ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputDate_vign">Date de début (Nouvelle vignette)</label>
                                                        <input type="date" class="form-control" id="inputDate_vign" name="inputDate_vign" placeholder="JJ/MM/AAAA">
                                                    </div>


                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="date_debut_vign">Date de début (Nouvelle vignette)</label>
                                                            <input type="date" class="form-control" name="date_debut_vign" id="date_debut_vign" placeholder="JJ/MM/AAAA">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <h6>
                                                            <p id="date_exp_vign_show"></p>
                                                        </h6>

                                                    </div>




                                                    <button class="btn btn-primary" type="button" onclick="stepper.previous()">retour</button>
                                                    <button type="submit" class="btn btn-primary">valider</button>

                                                </div>


                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <div class="tab-pane fade" id="custom-tabs-two-moto" role="tabpanel" aria-labelledby="custom-tabs-two-moto-tab">
                                    <div class="bs-stepper linear">

                                        <div class="bs-stepper-header" role="tablist">
                                            <!-- your steps here -->
                                            <div class="step active" data-target="#logins-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Logins</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#information-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Various information</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <!-- your steps content here -->
                                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>

                                                <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                            </div>
                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">File input</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="tab-pane fade" id="custom-tabs-two-tm" role="tabpanel" aria-labelledby="custom-tabs-two-tm-tab">

                                    <div class="bs-stepper linear">

                                        <div class="bs-stepper-header" role="tablist">
                                            <!-- your steps here -->
                                            <div class="step active" data-target="#logins-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Logins</span>
                                                </button>
                                            </div>
                                            <div class="line"></div>
                                            <div class="step" data-target="#information-part">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Various information</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <!-- your steps content here -->
                                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                                <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                            </div>
                                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">File input</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- /.card -->



                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                Véhicule
                            </h3>
                        </div>
                        <!-- /.card-header -->



                        <form name="nVehicule" action="insert_vehic.php" method="post">

                            <div class="card-body">



                            </div>




                            <!-- form start -->
                            <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->



                            <input type="hidden" class="form-control" id="id_client" name="id_client" placeholder="id_client" value="<?php
                                                                                                                                        echo $_GET['id_client'];
                                                                                                                                        ?>">


                            <input type="hidden" class="form-control" id="id_ctrl" name="id_ctrl" placeholder="id_ctrl" value="1">
                            <input type="hidden" class="form-control" id="action" name="action" value="1">
                            <input type="hidden" class="form-control" id="etat_fact" name="etat_fact" value="1">
                            <input type="hidden" class="form-control" id="num_vign" name="num_vign" value="<?php echo $num_vignette ?>">


                            <input type="hidden" class="form-control" id="prix_visite" name="prix_visite" value="">
                            <input type="hidden" class="form-control" id="prix_vignette" name="prix_vignette" value="">
                            <input type="hidden" class="form-control" id="prix_vignette_pen" name="prix_vignette_pen" value="0">
                            <input type="hidden" class="form-control" id="date_exp_vign" name="date_exp_vign" value="">


                            <input type="hidden" class="form-control" id="age_vehic" name="age_vehic" value="">


                            <!-- /.form start -->

                            <div class="card-footer">
                                <button onclick="clea()" action="" type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                            </div>

                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>

    <?php
    // Include config file
    include("footer.php");
    ?>

    </div>


    <script>
        function Clea() {
            document.getElementById("date_vign_show").innerHTML = "";
            document.getElementById("anne_MC").innerHTML = "";
            document.getElementById("CalVignette").innerHTML = "";
        }
    </script>

    <script>
        /*function DateExp() {
            var date_debut_vign = Date.parse(document.getElementById("date_debut_vign").value);

            var year = new Date(date_debut_vign).getFullYear();
            var month = new Date(date_debut_vign).getMonth();
            var day = new Date(date_debut_vign).getDate();

            var date = new Date(year + 1, month, day);


            document.getElementById("date_exp_vign_show").innerHTML = date;
            document.getElementById("date_exp_vign").value = date;

        }*/
    </script>

    <script>
        function CalculAmVign() {
            var dateVign = Date.parse(document.getElementById("date_vign").value);
            var now = Date.now();
            var prixVign = document.getElementById("prix_vignette").value;

            var diff = dateDiff(dateVign, now);
            var dvign = diff.day;

            //document.getElementById("date_vign_show").innerHTML = "La date de validité de la vignette est dépassée de " + diff.day + " jour(s) une pénalité de 100% de la valeur de la vignette sera appliqué conformement à la loi en vigueur : </br> Nouveau montant de la vignette : " + prix_vignette_pen + " F CFA";

            if (diff.day >= 61) {
                var prix_vignette_pen = 0;

                prix_vignette_pen = prixVign * 2;

                document.getElementById("prix_vignette_pen").value = prix_vignette_pen;
                document.getElementById("date_vign_show").innerHTML = "La date de validité de la vignette est dépassée de " + diff.day + " jour(s) une pénalité de 100% de la valeur de la vignette sera appliqué conformement à la loi en vigueur. </br> Nouveau montant de la vignette : " + prix_vignette_pen + " F CFA";
            }
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
        function CalculVignette() {

            var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
            var type
            var rad = document.nVehicule.id_genre;
            var prev = null;

            var dateMC = Date.parse(document.getElementById("inputDateMC").value);
            var now = Date.now();

            var diff = dateDiff(dateMC, now);
            var ageVehic = diff.year + 1;
            document.getElementById("anneeMC").innerHTML = +ageVehic + " ans";

            document.getElementById("age_vehic").value = ageVehic;

            puisFisc = document.getElementById("inputPuisFiscal").value;
            ptac = document.getElementById("inputPTAC").value;
            pA = document.getElementById("inputPA").value;


            //Type transport de marchandise
            if (rad.value == 1) {
                document.getElementById("inputPA").value = 0;
                document.getElementById("inputPA").disabled = true;
                document.getElementById("inputPTAC").disabled = false;

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
                        document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                        document.getElementById("inputCateg").value = categ;
                        document.getElementById("id_categ").value = id_categ;

                    } else if (puisFisc > 7) {
                        categ = "TP02";
                        id_categ = 6;
                        prixVisite = 15500;
                        document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                        document.getElementById("inputCateg").value = categ;
                        document.getElementById("id_categ").value = id_categ;

                    }
                } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
                    categ = "TP03";
                    id_categ = 7;
                    prixVisite = 18000;
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;

                } else if (ptac > 10 && puisFisc > 0) {
                    categ = "TP04";
                    id_categ = 8;
                    prixVisite = 20450;
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;
                }

            } //Type transport de personne
            else if (rad.value == 2) {
                document.getElementById("inputPA").disabled = false;
                document.getElementById("inputPTAC").value = 0;
                document.getElementById("inputPTAC").disabled = true;
                document.getElementById("CalVignette").innerHTML = rad.value;

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
                        document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                        document.getElementById("inputCateg").value = categ;
                        document.getElementById("id_categ").value = id_categ;


                    } else if (puisFisc > 7) {
                        categ = "VL02";
                        id_categ = 2;
                        prixVisite = 15500;
                        document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                        document.getElementById("inputCateg").value = categ;
                        document.getElementById("id_categ").value = id_categ;


                    }
                } else if (pA > 9 && puisFisc <= 7) {
                    document.getElementById("CalVignette").innerHTML = "Veuillez ajuster la puissance fiscale du véhicule";

                } else if (pA > 9 && pA <= 25 && puisFisc > 7) {
                    categ = "PL01";
                    id_categ = 3;
                    prixVisite = 18000;
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;


                } else if (pA > 25 && puisFisc > 7) {
                    categ = "PL02";
                    id_categ = 4;
                    prixVisite = 20450;
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;


                }
            }

            if (ageVehic > 0 && ageVehic <= 4) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 19000;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 35000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 49000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 96000;

                }

            } else if (ageVehic > 4 && ageVehic <= 10) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 14250;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 26250;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 36750;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 72000;
                }

            } else if (ageVehic > 11) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 13500;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 25000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 30000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 40000;

                }
            }

            document.getElementById("CalVignette").innerHTML = "Visite Technique: " + prixVisite + " F CFA  //  Vignette: " + prixVignette + " F CFA";
            document.getElementById("prix_visite").value = prixVisite;
            document.getElementById("prix_vignette").value = prixVignette;


            /*for (var i = 0; i < rad.length; i++) {
              rad[i].addEventListener('change', function() {
                  // (prev) ? console.log(prev.value): null;
                  if (this !== prev) {
                      prev = this;
                  }*/

            //document.getElementById("CalVignette").innerHTML = x;

            //console.log(this.value)
            //});
        }
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
    <!-- bs-stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <!-- jquery-validation -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>

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