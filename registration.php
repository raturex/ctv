<?php
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

            // Attempt to execute the prepared statement
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="wrapper">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Sign Up</h3>
                </div>

                <div class="card-body">

                    <p>veuillez remplir tous les champs pour créer un nouvel utilisateur.</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
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
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                        </div>

                    </form>
                </div>


                <p>Vous avez deja un compte? <a href="login.php">Connectez vous ici</a>.</p>


            </div>
        </div>
    </div>


    <!-- jquery-validation -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>

</body>

</html>