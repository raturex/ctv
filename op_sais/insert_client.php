<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

    require_once('../api/db_connect.php');

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


        // Include config file
        include("../api/db_connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                isset($_POST['id_pid']) && !empty($_POST['id_pid'])
                && isset($_POST['nom_client']) && !empty($_POST['nom_client'])
                && isset($_POST['num_piece_client']) && !empty($_POST['num_piece_client'])
            ) {

                $nom_client = strip_tags($_POST['nom_client']);
                $id_pid = strip_tags($_POST['id_pid']);
                $tel_client = strip_tags($_POST['tel_client']);
                $num_piece_client = strip_tags($_POST['num_piece_client']);
                $prenom_client = strip_tags($_POST['prenom_client']);
                $email_Client = strip_tags($_POST['email_Client']);
                $datenaiss_client = strip_tags($_POST['datenaiss_client']);

                $sql = "INSERT INTO client (nom, prenom, tel, id_piece,  num_piece, email, date_naiss) VALUES ( :nom_client, :prenom_client, :tel_client, :id_pid, :num_piece_client, :email_Client, :datenaiss_client);";

                $query = $db_PDO->prepare($sql);

                $query->bindValue(':id_pid', $id_pid/*, PDO::PARAM_STR*/);
                $query->bindValue(':nom_client', $nom_client/*, PDO::PARAM_STR*/);
                $query->bindValue(':tel_client', $tel_client/*, PDO::PARAM_STR*/);
                $query->bindValue(':num_piece_client', $num_piece_client/*, PDO::PARAM_STR*/);
                $query->bindValue(':prenom_client', $prenom_client/*, PDO::PARAM_STR*/);
                $query->bindValue(':email_Client', $email_Client/*, PDO::PARAM_INT*/);
                $query->bindValue(':datenaiss_client', $datenaiss_client/*, PDO::PARAM_INT*/);

                $query->execute();

                $id_client = $db_PDO->lastInsertId();


                //header('Location: nvisite.php?id_pid='.$id_pid.'&id_client='.$id_client.'&nom_client='.$nom_client.'&prenom_client='.$prenom_client.'&num_piece_client='.$num_piece_client.'');
                header('Location: nvisite2.php?id_client=' . $id_client . '');
            }
        }


        //require_once('close.php');

    } else {
        header('Location: ../restriction.php');
    }
}
