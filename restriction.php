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


    //Operateur de saisie
    if (isset($_SESSION["role"]) && $_SESSION["role"] == 2 ) {
      
        header('Location: op_sais/');
        exit;

        //Controleur
}else if  (isset($_SESSION["role"]) && $_SESSION["role"] == 4 )  {
    header('Location: controle_tech/');
    exit;

    //Caissier
}else if  (isset($_SESSION["role"]) && $_SESSION["role"] == 5 )  {
    header('Location: caisse/');
    exit;

 //Edition & Fin de ligne
}else if  (isset($_SESSION["role"]) && ($_SESSION["role"] == 6 || $_SESSION["role"] == 7 ))  {
    header('Location: edition/');
    exit;
}
  }
?>