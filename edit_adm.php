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


if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 3 /*|| $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1) ) {
    // Initialize the session
//session_start();

?>

<?php

// Include config file
include("api/db_connect.php");

if (isset($_POST['new_station']) && !empty($_POST['new_station'])) {

    $type_station = $_POST['type_station'];
    $nom_station = strip_tags($_POST['nom_station']);
    $details_station = strip_tags($_POST['details_station']);
    $ville_station = strip_tags($_POST['ville_station']);
    $new_station = $_POST['new_station'];


    $sql = "INSERT INTO station (nom, ville, details, id_type) VALUES (:nom_station, :ville_station, :details_station, :type_station)";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':type_station', $type_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':nom_station', $nom_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':details_station', $details_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':ville_station', $ville_station/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_station.php');
} else if (
    isset($_POST['modif_station']) && !empty($_POST['modif_station'])
    && isset($_POST['id_station']) && !empty($_POST['id_station'])

) {

    $id_station = $_POST['id_station'];
    $type_station = $_POST['type_station'];
    $nom_station = strip_tags($_POST['nom_station']);
    $details_station = strip_tags($_POST['details_station']);
    $ville_station = strip_tags($_POST['ville_station']);
    $modif_station = $_POST['modif_station'];


    $sql = "UPDATE station SET nom=:nom_station, ville=:ville_station, details=:details_station, id_type=:type_station WHERE id=:id_station";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':type_station', $type_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':id_station', $id_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':nom_station', $nom_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':details_station', $details_station/*, PDO::PARAM_STR*/);
    $query->bindValue(':ville_station', $ville_station/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_station.php');

}else if (
    isset($_GET['supp_station']) && !empty($_GET['supp_station'])
    && isset($_GET['id_station']) && !empty($_GET['id_station'])
) {

    $id_station = $_GET['id_station'];
    $supp_station = $_GET['supp_station'];

    $sql = "DELETE FROM station WHERE id = :id_station ";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':id_station', $id_station/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_station.php');
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else if (isset($_POST['new_categ']) && !empty($_POST['new_categ'])) {

    $nom_categ = strip_tags($_POST['nom_categ']);
    $prix_visite = $_POST['prix_visite'];
    $prix_revisite = $_POST['prix_revisite'];
    $new_categ = $_POST['new_categ'];


    $sql = "INSERT INTO categ(categorie, prix_visite, prix_revisite) VALUES (:nom_categ, :prix_visite, :prix_revisite)";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':nom_categ', $nom_categ/*, PDO::PARAM_STR*/);
    $query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
    $query->bindValue(':prix_revisite', $prix_revisite/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_vehicule.php');
} else if (
    isset($_POST['modif_categ']) && !empty($_POST['modif_categ'])
    && isset($_POST['id_categ']) && !empty($_POST['id_categ'])

) {

    $id_categ = $_POST['id_categ'];
    $nom_categ = strip_tags($_POST['nom_categ']);
    $prix_visite = $_POST['prix_visite'];
    $prix_revisite = $_POST['prix_revisite'];
    $modif_categ = $_POST['modif_categ'];


    //$sql = "UPDATE categ SET categorie=:nom_categ, prix_visite=:prix_visite, prix_revisite=:prix_revisite WHERE id=:id_categ";
    $sql = "UPDATE categ SET categorie='".$nom_categ."', prix_visite=$prix_visite, prix_revisite =$prix_revisite WHERE id = $id_categ";

    $query = $db_PDO->prepare($sql);

    //$query->bindValue(':nom_categ', $nom_categ/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_revisite', $prix_revisite/*, PDO::PARAM_STR*/);
    $query->execute();

    header('Location: gest_vehicule.php');

}else if (
    isset($_GET['supp_categ']) && !empty($_GET['supp_categ'])
    && isset($_GET['id_categ']) && !empty($_GET['id_categ'])
) {

    $id_categ = $_GET['id_categ'];
    $supp_categ = $_GET['supp_categ'];

    $sql = "DELETE FROM categ WHERE id = :id_categ ";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':id_categ', $id_categ/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_vehicule.php');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else if (isset($_POST['new_energie']) && !empty($_POST['new_energie'])) {

    $nom_energie = strip_tags($_POST['nom_energie']);


    $sql = "INSERT INTO energie(lib) VALUES (:nom_energie)";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':nom_energie', $nom_energie/*, PDO::PARAM_STR*/);
    
    $query->execute();

    header('Location: gest_vehicule.php');
} else if (
    isset($_POST['modif_energie']) && !empty($_POST['modif_energie'])
    && isset($_POST['id_energie']) && !empty($_POST['id_energie'])

) {

    $id_energie = $_POST['id_energie'];
    $nom_energie = strip_tags($_POST['nom_energie']);
    $modif_energie = $_POST['modif_energie'];


    //$sql = "UPDATE categ SET categorie=:nom_categ, prix_visite=:prix_visite, prix_revisite=:prix_revisite WHERE id=:id_categ";
    $sql = "UPDATE energie SET lib='".$nom_energie."' WHERE id = $id_energie";

    $query = $db_PDO->prepare($sql);

    //$query->bindValue(':nom_categ', $nom_categ/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_revisite', $prix_revisite/*, PDO::PARAM_STR*/);
    $query->execute();

    header('Location: gest_vehicule.php');

}else if (
    isset($_GET['supp_energie']) && !empty($_GET['supp_energie'])
    && isset($_GET['id_energie']) && !empty($_GET['id_energie'])
) {

    $id_energie = $_GET['id_energie'];
    $supp_energie = $_GET['supp_energie'];

    $sql = "DELETE FROM energie WHERE id = :id_energie ";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_vehicule.php');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else if (isset($_POST['new_genre']) && !empty($_POST['new_genre'])) {

    $nom_genre = strip_tags($_POST['nom_genre']);
    $new_genre = $_POST['new_genre'];


    $sql = "INSERT INTO genre(lib) VALUES (:nom_genre)";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':nom_genre', $nom_genre/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_vehicule.php');
} else if (
    isset($_POST['modif_genre']) && !empty($_POST['modif_genre'])
    && isset($_POST['id_genre']) && !empty($_POST['id_genre'])

) {

    $id_genre = $_POST['id_genre'];
    $nom_genre = strip_tags($_POST['nom_genre']);
    $modif_genre = $_POST['modif_genre'];


    //$sql = "UPDATE categ SET categorie=:nom_categ, prix_visite=:prix_visite, prix_revisite=:prix_revisite WHERE id=:id_categ";
    $sql = "UPDATE genre SET lib='".$nom_genre."' WHERE id = $id_genre";

    $query = $db_PDO->prepare($sql);

    //$query->bindValue(':nom_categ', $nom_categ/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_revisite', $prix_revisite/*, PDO::PARAM_STR*/);
    $query->execute();

    header('Location: gest_vehicule.php');

}else if (
    isset($_GET['supp_genre']) && !empty($_GET['supp_genre'])
    && isset($_GET['id_genre']) && !empty($_GET['id_genre'])
) {

    $id_genre = $_GET['id_genre'];
    $supp_genre = $_GET['supp_genre'];

    $sql = "DELETE FROM genre WHERE id = :id_genre ";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':id_genre', $id_genre/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_vehicule.php');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else if (isset($_POST['new_service']) && !empty($_POST['new_service'])) {

    $nom_service = strip_tags($_POST['nom_service']);
    $new_service = $_POST['new_service'];


    $sql = "INSERT INTO type_ctrl(lib) VALUES (:nom_service)";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':nom_service', $nom_service/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_service.php');
} else if (
    isset($_POST['modif_service']) && !empty($_POST['modif_service'])
    && isset($_POST['id_service']) && !empty($_POST['id_service'])

) {

    $id_service = $_POST['id_service'];
    $nom_service = strip_tags($_POST['nom_service']);
    $modif_service = $_POST['modif_service'];


    //$sql = "UPDATE categ SET categorie=:nom_categ, prix_visite=:prix_visite, prix_revisite=:prix_revisite WHERE id=:id_categ";
    $sql = "UPDATE type_ctrl SET lib='".$nom_service."' WHERE id = $id_service";

    $query = $db_PDO->prepare($sql);

    //$query->bindValue(':nom_categ', $nom_categ/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
    //$query->bindValue(':prix_revisite', $prix_revisite/*, PDO::PARAM_STR*/);
    $query->execute();

    header('Location: gest_service.php');

}else if (
    isset($_GET['supp_service']) && !empty($_GET['supp_service'])
    && isset($_GET['id_service']) && !empty($_GET['id_service'])
) {

    $id_service = $_GET['id_service'];
    $supp_service = $_GET['supp_service'];

    $sql = "DELETE FROM type_ctrl WHERE id = :id_service ";

    $query = $db_PDO->prepare($sql);

    $query->bindValue(':id_service', $id_service/*, PDO::PARAM_STR*/);

    $query->execute();

    header('Location: gest_service.php');

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

}else {
    header('Location: restriction.php');
}
  }
?>