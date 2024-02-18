<?php
// Include config file
include("api/db_connect.php");
 
global $conn;
// Definition des variables et initialisation avec une valeur vide

$immatriculation = $marque = $proprietaire = $type_tech = $num_serie = $id_energie = $nb_place = $ptac = $puiss_fisc = $id_genre = $date_mise_circul = $date_local =""; 
$immatriculation_err = $marque_err = $proprietaire_err = $type_tech_err = $num_serie_err = $id_energie_err = $nb_place_err = $ptac_err = $puiss_fisc_err = $id_genre_err = $date_mise_circul_err = $date_local_err =""; 


// Traitement des données du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate immatriculation
    if(empty(trim($_POST["immatriculation"]))){
        $immatriculation_err = "Entrez l'immatriculation.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vehicule WHERE immatriculation = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_immatriculation = trim($_POST["immatriculation"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $immatriculation_err = "Cette voiture est deja enregistré";
                } else{
                    $immatriculation = trim($_POST["immatriculation"]);
                }
            } else{
                echo "Oops! Quelque chose ne va pas veuillez réessayer.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
/*
    // Validate nom
    if(empty(trim($_POST["nom"]))){
        $nom_err = "Entrez votre nom.";
    } else{
            $nom = trim($_POST["nom"]);
            // Set parameters
            $param_nom = trim($_POST["nom"]);
    }

    // Validate prenom
    if(empty(trim($_POST["prenoms"]))){
        $prenoms_err = "Entrez vos prenoms.";
    } else{
            $prenoms = trim($_POST["prenoms"]);
            // Set parameters
            $param_prenoms = trim($_POST["prenoms"]);
    }

    // Validate station
    if(empty(trim($_POST["station"]))){
        $station_err = "Selectionnez votre station.";
    } else{
            $station = trim($_POST["station"]);
            // Set parameters
            $param_station = trim($_POST["station"]);
    }

    // Validate role
    if(empty(trim($_POST["role"]))){
        $role_err = "Selectionnez votre role.";
    } else {
        $role = trim($_POST["role"]);
        // Set parameters
        $param_role = trim($_POST["role"]);
    }

    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer un mot de passe.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Le mot de passe doit contenir au moins 6 caractères.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer le mot de passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Veuillez entrer le meme mot de passe.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($nom_err) && empty($prenoms_err) && empty($station_err) && empty($role_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password, nom, prenoms, role, id_station) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
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
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later. 22";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    */
    // Close connection
    mysqli_close($conn);
}
?>