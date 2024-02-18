<html lang="en" style="height: auto;" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Widgets</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="sidebar-mini sidebar-closed sidebar-collapse" style="height: auto;">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1854.8px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Widgets</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Widgets</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="col-12">


                            <h4 class="mb-2 mt-4">DEFAUTS TECHNIQUE</h4>

                            <form action="controle_result.php" method="GET">

                                <div class="row">


                                    <?php
                                    require_once("api/db_connect.php");

                                    //requête
                                    $sql = "SELECT fonction_ctrl FROM observation group by fonction_ctrl ";
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
                                                    require_once("api/db_connect.php");

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


                                                                require_once("api/db_connect.php");

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


                                                                            require_once("api/db_connect.php");

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


                                                                                    require_once("api/db_connect.php");

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
                                                                                                <input class="check-control" id="<?PHP echo 'def_const_localis' . $x; ?>" name="id_obs" type="checkbox" value="<?PHP echo $def_const_localis['id']; ?>">
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


                            </form>



                        </div>

                        <div class="card-footer">
                            <input id="" formmethod="get" type="submit" value="Valider le contrôle"></button>
                        </div>



                    </div>





                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>


</body>

</html>