<?php

// Include config file
include("api/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['immatriculation']) && !empty($_POST['immatriculation'])
        //&& isset($_POST['marque']) && !empty($_POST['marque'])
        //&& isset($_POST['proprietaire']) && !empty($_POST['proprietaire'])
        //&& isset($_POST['type_tech']) && !empty($_POST['type_tech'])
        //&& isset($_POST['num_serie']) && !empty($_POST['num_serie'])
        //&& isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        //&& isset($_POST['nb_place']) && !empty($_POST['nb_place'])
        //&& isset($_POST['ptac']) && !empty($_POST['ptac'])
        //&& isset($_POST['puiss_fisc']) && !empty($_POST['puiss_fisc'])
        //&& isset($_POST['id_genre']) && !empty($_POST['id_genre'])
        //&& isset($_POST['date_mise_circul']) && !empty($_POST['date_mise_circul'])
        //&& isset($_POST['date_local']) && !empty($_POST['date_local'])
    ) {

        $immatriculation = $_POST['immatriculation'];
        /*$marque = strip_tags($_POST['marque']);
    $proprietaire = strip_tags($_POST['proprietaire']);
    $type_tech = strip_tags($_POST['type_tech']);
    $num_serie = strip_tags($_POST['num_serie']);
    $id_energie = strip_tags($_POST['id_energie']);
    $nb_place = strip_tags($_POST['nb_place']);
    $ptac = strip_tags($_POST['ptac']);
    $puiss_fisc = strip_tags($_POST['puiss_fisc']);
    $id_genre = strip_tags($_POST['id_genre']);
    $date_mise_circul = strip_tags($_POST['date_mise_circul']);
    $date_local = strip_tags($_POST['date_local']);*/

        //$sql = "INSERT INTO vehicule (id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, nb_place, ptac, puiss_fisc, id_genre, date_mise_circul, date_local) VALUES (null, ':immatriculation', ':marque', ':proprietaire', ':type_tech', ':num_serie', :id_energie, :nb_place, :ptac, :puiss_fisc, :id_genre, :date_mise_circul, :date_local);";

        //$sql = "INSERT INTO vehi (immatriculation) VALUES (:immatriculation);";


        $query = $db_PDO->prepare("INSERT INTO vehi (id, immatriculation) VALUES (null,?)");

        $query->bindValue(1, $_POST['immatriculation']/*, PDO::PARAM_STR*/);
        //$query->bindValue(':marque', $marque/*, PDO::PARAM_STR*/);
        //$query->bindValue(':proprietaire', $proprietaire/*, PDO::PARAM_STR*/);
        //$query->bindValue(':type_tech', $type_tech/*, PDO::PARAM_STR*/);
        //$query->bindValue(':num_serie', $num_serie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie, PDO::PARAM_INT);
        //$query->bindValue(':nb_place', $nb_place, PDO::PARAM_INT);
        //$query->bindValue(':ptac', $ptac/*, PDO::PARAM_STR*/);
        //$query->bindValue(':puiss_fisc', $puiss_fisc/*, PDO::PARAM_INT*/);
        //$query->bindValue(':id_genre', $id_genre/*, PDO::PARAM_INT*/);
        //$query->bindValue(':date_mise_circul', $date_mise_circul/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_local', $date_local/*, PDO::PARAM_STR*/);

        $query->execute();

        echo "Entrée ajoutée dans la table";
        header('Location: index.php');




    }
}
//require_once('close.php');

?>































<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php
        // Include menu nav_bar
        include("nav_bar.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Véhicule</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Nouveau véhicule</a></li>
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
                        <div class="card-body">
                            <!-- form start -->
                            <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                            <form name="nVehicule" action="insert_vehic.php" method="post">

                                <div class="row">

                                    <div class="col-sm-6">
                                        <!-- Détail fiscal -->
                                        <div class="card-body">

                                            <!-- Genre -->
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" checked=true name="id_genre" value=1 onchange=CalculVignette()>
                                                            <label class="form-check-label">Transport de personne</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="id_genre" value=2 onchange=CalculVignette()>
                                                            <label class="form-check-label">Transport de marchandise</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Puissance fiscale -->
                                            <div class="form-group">
                                                <label for="inputPuisFiscal">Puissance fiscale</label>
                                                <input type="number" class="form-control" id="inputPuisFiscal" name="puiss_fisc" placeholder="Puissance Fiscale" step=1 min=0 onchange=CalculVignette() onkeyup=CalculVignette() value=0>
                                            </div>

                                            <!-- Energie -->
                                            <div class="form-group">
                                                <label for="inputEnergie">Energie</label>
                                                <select class="form-control" name="id_energie" id="inputEnergie">

                                                    <?php
                                                    //requête
                                                    $sql = "SELECT * FROM energie";
                                                    // On prépare la requête
                                                    $request = $db_PDO->prepare($sql);
                                                    // On exécute la requête
                                                    $request->execute();
                                                    // On stocke le résultat dans un tableau associatif
                                                    $result = $request->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $energie) {
                                                    ?>

                                                        <option value="<?php echo $energie['id'] ?>"> <?= $energie['lib'] ?> </option>

                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <!-- Date 1ere mise en circulation -->
                                            <div class="form-group">
                                                <label for="inputDateMC">Date de la 1ere mise en circulation</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <!-- date-->
                                                        <input type="date" onchange=CalculVignette() onkeyup=CalculVignette() class="form-control" name="date_mise_circul" id="inputDateMC" placeholder="JJ/MM/AAAA" value="01/01/2000">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <!-- Nombre d'année-->
                                                        <h5>
                                                            <p id="anneeMC"></p>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PTAC -->
                                            <div class="form-group">
                                                <label for="inputPTAC">PTAC</label>
                                                <input type="number" onchange=CalculVignette() class="form-control" id="inputPTAC" name="ptac" placeholder="Poids Total à charge" onkeyup=CalculVignette() onchange=CalculVignette() step=1 min=0 value=0>
                                            </div>

                                            <!-- Place assise -->
                                            <div class="form-group">
                                                <label for="inputPA">Place assise</label>
                                                <input type="number" onchange=CalculVignette() class="form-control" id="inputPA" name="nb_place" placeholder="Place Assise" onkeyup=CalculVignette() step=1 min=0 value=0>
                                            </div>

                                            <!-- Categorie -->
                                            <div class="form-group">
                                                <label for="inputCateg">Catégorie</label>
                                                <input onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="Categ" placeholder="Place Assise" onkeyup=CalculVignette() step=1 min=0 disabled>
                                            </div>

                                            <p id="CalVignette"></p>

                                        </div>
                                        <!-- /.Détail fiscal -->
                                    </div>

                                    <div class="col-sm-6">
                                        <!-- Info véhicule -->
                                        <div class="card-body">

                                            <!-- Immatriculation -->
                                            <div class="form-group">
                                                <label for="inputImmatriculation">Immatriculation</label>
                                                <!--<input type="text" class="form-control " id="inputImmatriculation" name="immatriculation" placeholder="Immatriculation">-->
                                                <input type="text" name="immatriculation" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $immatriculation; ?>">
                                                <span class="invalid-feedback"><?php echo $immatriculation_err; ?></span>
                                            </div>

                                            <!-- Propriétaire -->
                                            <div class="form-group">
                                                <label for="inputProprietaire">Propriétaire</label>
                                                <input type="text" class="form-control" id="inputProprietaire" name="proprietaire" placeholder="proprietaire du vehicule" value="">
                                            </div>

                                            <!-- marque -->
                                            <div class="form-group">
                                                <label for="inputMarque">Marque du véhicule</label>
                                                <input type="text" class="form-control" id="inputMarque" name="marque du véhicule" placeholder="Marque du véhicule" value="">
                                            </div>

                                            <!-- Type technique -->
                                            <div class="form-group">
                                                <label for="inputTypeTech">Type technique</label>
                                                <input type="text" class="form-control" id="inputTypeTech" name="type_tech" placeholder="Type technique" value="">
                                            </div>

                                            <!-- Numéro de série -->
                                            <div class="form-group">
                                                <label for="inputSerie">Numéro de série</label>
                                                <input type="text" class="form-control" id="inputSerie" name="num_serie" placeholder="Numéro de série" value="">
                                            </div>

                                            <!-- Date d"immatriculation -->
                                            <div class="form-group">
                                                <label for="inputMiseCircu">Date d'immatriculation</label>
                                                <input type="date" class="form-control" id="inputDate_local" name="date_local" placeholder="JJ/MM/AAAA" value="">
                                            </div>

                                        </div>
                                        <!-- /.Info véhicule -->
                                    </div>

                                </div>


                                <div class="card-footer">
                                    <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                </div>
                            </form>


                            <!-- /.form start -->
                        </div>


                    </div>
                </div>
            </section>








        </div>


        <?php
        // Include footer
        include("footer.php");
        ?>


    </div>

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
    <!-- jquery-validation -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

</body>

</html>