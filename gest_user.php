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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 3 /* || $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

        // Include config file
        include("api/db_connect.php");

        global $conn;
        // Define variables and initialize with empty values
        $username = $password = $confirm_password = $station = $role = $prenoms = $nom = "";
        $username_err = $password_err = $confirm_password_err = $role_err = $station_err = $prenoms_err = $nom_err = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate username
            if (empty(trim($_POST["username"]))) {
                $username_err = "Entrez un email.";
            } else {
                // Prepare a select statement
                $sql = "SELECT id FROM user WHERE username = ?";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_username);

                    // Set parameters
                    $param_username = trim($_POST["username"]);

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        /* store result */
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $username_err = "Cet identifiant existe déja.";
                        } else {
                            $username = trim($_POST["username"]);
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }

            // Validate nom
            if (empty(trim($_POST["nom"]))) {
                $nom_err = "Entrez votre nom.";
            } else {
                $nom = trim($_POST["nom"]);
                // Set parameters
                $param_nom = trim($_POST["nom"]);
            }

            // Validate prenom
            if (empty(trim($_POST["prenoms"]))) {
                $prenoms_err = "Entrez vos prenoms.";
            } else {
                $prenoms = trim($_POST["prenoms"]);
                // Set parameters
                $param_prenoms = trim($_POST["prenoms"]);
            }

            // Validate station
            if (empty(trim($_POST["station"]))) {
                $station_err = "Selectionnez votre station.";
            } else {
                $station = trim($_POST["station"]);
                // Set parameters
                $param_station = trim($_POST["station"]);
            }

            // Validate role
            if (empty(trim($_POST["role"]))) {
                $role_err = "Selectionnez votre role.";
            } else {
                $role = trim($_POST["role"]);
                // Set parameters
                $param_role = trim($_POST["role"]);
            }


            // Validate password
            if (empty(trim($_POST["password"]))) {
                $password_err = "Veuillez entrer un mot de passe.";
            } elseif (strlen(trim($_POST["password"])) < 6) {
                $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                $password = trim($_POST["password"]);
            }

            // Validate confirm password
            if (empty(trim($_POST["confirm_password"]))) {
                $confirm_password_err = "Veuillez confirmer le mot de passe.";
            } else {
                $confirm_password = trim($_POST["confirm_password"]);
                if (empty($password_err) && ($password != $confirm_password)) {
                    $confirm_password_err = "Veuillez entrer le meme mot de passe.";
                }
            }

            // Check input errors before inserting in database
            if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($nom_err) && empty($prenoms_err) && empty($station_err) && empty($role_err)) {

                // Prepare an insert statement
                $sql = "INSERT INTO user (username, password, nom, prenoms, role, id_station) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssssii", $param_username, $param_password, $param_nom, $param_prenoms, $param_role, $param_station);

                    // Set parameters
                    $param_username = $username;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                    $param_nom = $nom;
                    $param_prenoms = $prenoms;
                    $param_role = $role;
                    $param_station = $station;

                    // Attempt to execute the prepared stçatement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect to login page
                        header("location: login.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again later. 22";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }

            // Close connection
            mysqli_close($conn);
        }
        ?>

        <!DOCTYPE html>
        <html lang="fr">


        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ACTIA SA | Tableau de bord supervision</title>

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
            <!-- DataTables -->
            <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        </head>

        <body class="hold-transition sidebar-mini layout-fixed">
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
                                    <h1 class="m-0">Gestion des utilisateurs</h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                                        <li class="breadcrumb-item active">Gestion des utilisateurs</li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->


                    <!-- StatGen -->
                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <!-- Station column -->

                                <?php
                                require_once("api/db_connect.php");
                                if (
                                    isset($_GET["id_user"]) && !empty($_GET["id_user"])
                                ) {
                                    $id_user = $_GET["id_user"];
                                    //requête
                                    $sql = "SELECT * FROM user where id='" . $id_user . "'";
                                    // On prépare la requête
                                    $request = $db_PDO->prepare($sql);
                                    $request = $db_PDO->query($sql);
                                    // On exécute la requête
                                    $request->execute();
                                    // On stocke le résultat dans un tableau associatif
                                    $reset = $request->fetch();

                                ?>

                                    <div class="col-sm-12">

                                        <input type="hidden" name="id_user" value="<?php echo $reset["id"] ?>">
                                        <div class="card card-danger">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                                <div class="card-header">
                                                    <h3 class="card-title">Utilisateurs</h3>
                                                </div>
                                                <div class="card-body">
                                                    <p>veuillez remplir tous les champs pour creer un nouvel utilisateur.</p>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["username"]; ?>" >
                                                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nom</label>
                                                        <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["nom"]; ?>" >
                                                        <span class="invalid-feedback"><?php echo $nom_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Prenoms</label>
                                                        <input type="text" name="prenoms" class="form-control <?php echo (!empty($prenoms_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reset["prenoms"]; ?>" >
                                                        <span class="invalid-feedback"><?php echo $prenoms_err; ?></span>
                                                    </div>


                                                    <?php
                                                    // Include config file
                                                    include("api/db_connect.php");
                                                    global $conn;
                                                    $query2 = "SELECT station.id, nom, ville, type_station.lib AS type_station 
                                                FROM station, type_station 
                                                WHERE station.id_type = type_station.id ORDER BY ville ASC";

                                                    //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                                                    $response2 = array();
                                                    $result2 = mysqli_query($conn, $query2);
                                                    ?>
                                                    <div class="form-group">
                                                        <label>Station</label>
                                                        <select class="form-control" style="width: 100%;" name="station">
                                                            <option value="00">Selection de la station </option>
                                                            <?php
                                                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                                                                <option value="<?php echo $row2["id"] ?>" id="<?php echo $row2["id"] ?>">[<?php echo $row2["ville"] ?>] - [<?php echo $row2["nom"] ?>] - [<?php echo $row2["type_station"] ?>]</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="invalid-feedback"><?php echo $station_err; ?></span>
                                                    </div>


                                                    <?php
                                                    // Include config file
                                                    include("api/db_connect.php");
                                                    global $conn;
                                                    $query2 = "SELECT * From role ORDER BY lib ASC";

                                                    //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                                                    $response2 = array();
                                                    $result2 = mysqli_query($conn, $query2);
                                                    ?>
                                                    <div class="form-group">
                                                        <label>Rôle</label>
                                                        <select class="form-control" style="width: 100%;" name="role">
                                                            <option value="00">Selection du rôle dans l'organisation </option>
                                                            <?php
                                                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                                                                <option value="<?php echo $row2["id"] ?>" id="<?php echo $row2["id"] ?>"><?php echo $row2["lib"] ?> </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="invalid-feedback"><?php echo $role_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Mot de passe</label>
                                                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Resaisir le mot de passe</label>
                                                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <button type="submit" name="new_user" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                    <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>

                                <?php } else if (!isset($_GET["id_user"])) { ?>

                                    <div class="col-sm-12">

                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="card card-danger">

                                                <div class="card-header">
                                                    <h3 class="card-title">Utilisateurs</h3>
                                                </div>
                                                <div class="card-body">
                                                    <p>veuillez remplir tous les champs pour creer un nouvel utilisateur.</p>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nom</label>
                                                        <input type="text" name="nom" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                                                        <span class="invalid-feedback"><?php echo $nom_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Prenoms</label>
                                                        <input type="text" name="prenoms" class="form-control <?php echo (!empty($prenoms_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prenoms; ?>">
                                                        <span class="invalid-feedback"><?php echo $prenoms_err; ?></span>
                                                    </div>


                                                    <?php
                                                    // Include config file
                                                    include("api/db_connect.php");
                                                    global $conn;
                                                    $query2 = "SELECT station.id, nom, ville, type_station.lib AS type_station 
                                            FROM station, type_station 
                                            WHERE station.id_type = type_station.id ORDER BY ville ASC";

                                                    //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                                                    $response2 = array();
                                                    $result2 = mysqli_query($conn, $query2);
                                                    ?>
                                                    <div class="form-group">
                                                        <label>Station</label>
                                                        <select class="form-control" style="width: 100%;" name="station">
                                                            <option value="00">Selection de la station </option>
                                                            <?php
                                                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                                                                <option value="<?php echo $row2["id"] ?>" id="<?php echo $row2["id"] ?>">[<?php echo $row2["ville"] ?>] - [<?php echo $row2["nom"] ?>] - [<?php echo $row2["type_station"] ?>]</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="invalid-feedback"><?php echo $station_err; ?></span>
                                                    </div>


                                                    <?php
                                                    // Include config file
                                                    include("api/db_connect.php");
                                                    global $conn;
                                                    $query2 = "SELECT * From role ORDER BY lib ASC";

                                                    //$query2 = "SELECT code_obs, date_ctrl FROM ctrl_obs WHERE id_vehicule = $id_vehicule ORDER BY date_ctrl DESC";
                                                    $response2 = array();
                                                    $result2 = mysqli_query($conn, $query2);
                                                    ?>
                                                    <div class="form-group">
                                                        <label>Rôle</label>
                                                        <select class="form-control" style="width: 100%;" name="role">
                                                            <option value="00">Selection du rôle dans l'organisation </option>
                                                            <?php
                                                            while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { ?>
                                                                <option value="<?php echo $row2["id"] ?>" id="<?php echo $row2["id"] ?>"><?php echo $row2["lib"] ?> </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="invalid-feedback"><?php echo $role_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Mot de passe</label>
                                                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Resaisir le mot de passe</label>
                                                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="submit" name="new_user" value="Submit" class="btn btn-info float-right">Enregistrer</button>
                                                        <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                                                    </div>
                                                </div>

                                            </div>


                                        </form>

                                    </div>
                                    <!-- /.card-body -->

                            </div>
                        <?php }  ?>




                        <!--
                <div class="col-sm-12">
                     mapbox 
                    <div id='map' style='width: 1000px; height: 500px;'></div>
                    <script>
                        mapboxgl.accessToken = 'pk.eyJ1IjoibWFudWVsYmxhY2siLCJhIjoiY2sxN3lkNjIyMGlnZzNubGxkZmxkNjI3ciJ9.KAaRnKJO5y2OCMcU4WxVcA';
                        var map = new mapboxgl.Map({
                            container: 'map',
                            style: 'mapbox://styles/mapbox/streets-v11'
                        });
                    </script>
                </div>
                -->

                        <div class="col-sm-12">

                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Liste des stations
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->

                                <!-- Table -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Nom</th>
                                                <th>Prénoms</th>
                                                <th>Station</th>
                                                <th>Rôle</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            include("api/db_connect.php");

                                            //requête
                                            $sql = "SELECT user.id, username, user.nom, prenoms, role as id_role, role.lib as role , id_station, station.nom as station FROM user left join station on station.id=user.id_station left join role on user.role=role.id";
                                            // On prépare la requête
                                            $request = $db_PDO->prepare($sql);
                                            // On exécute la requête
                                            $request->execute();
                                            // On stocke le résultat dans un tableau associatif
                                            $result = $request->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($result as $user) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $user['id'] ?> </td>
                                                    <td><?php echo $user['nom'] ?> </td>
                                                    <td><?php echo $user['prenoms'] ?> </td>
                                                    <td><?php echo $user['station'] ?> </td>
                                                    <td><?php echo $user['role'] ?> </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info">Edition</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a class="dropdown-item" href="gest_user.php?id_user=<?= $user["id"]; ?>">Modifier</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="edit_adm.php?id_user=<?= $user["id"]; ?>&supp_user=vrai">Supprimer</a>
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
                </div>


            </div><!-- /.container-fluid -->
            </section>
            </div>


            <!-- footer -->
            <?php
            // Include config file
            include("footer.php");
            ?>
            <!-- ./footer -->

            </div>

            <!-- jQuery -->
            <script src="plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables  & Plugins -->
            <script src="plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <script src="plugins/jszip/jszip.min.js"></script>
            <script src="plugins/pdfmake/pdfmake.min.js"></script>
            <script src="plugins/pdfmake/vfs_fonts.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

            <!-- bs-custom-file-input -->
            <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
            <!-- AdminLTE App -->
            <script src="dist/js/adminlte.min.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="dist/js/demo.js"></script>
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
        </body>


        </html>

<?php
    } else {
        header('Location: restriction.php');
    }
}
?>