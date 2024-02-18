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


    




    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 4 || $_SESSION["role"] == 1)) {


            $nSerie = $_POST['nSerie'];
            $id_vehic = $_POST['id_vehic'];
            $id_factur = $_POST['id_factur'];
            $etat_fact = 3;
            $id_ctrler = $_POST['id_ctrler'];
            $kilometrage = $_POST['kilometrage'];
            $certificat = $_POST['certificat'];
            $id_type_ctrl = 1;

            $dateNewVign = date("Y-m-d");

            //$new_date = date('Y-m-d', strtotime($dateNewVign));
            //durée à rajouter : 1 an;
            $duree = 1;
            //la première étape est de transformer cette date en timestamp
            $dateNewVignTimestamp = strtotime($dateNewVign);
            //on calcule la date de fin
            $date_exp = date('Y-m-d', strtotime('+' . $duree . 'year', $dateNewVignTimestamp));


        if (
            isset($_POST['id_vehic']) && !empty($_POST['id_vehic'])
            && isset($_POST['id_obs']) && !empty($_POST['id_obs'])
            && isset($_POST['id_factur']) && !empty($_POST['id_factur'])
        ) {

            require_once("../api/db_connect.php");
            $id_obs = $_POST['id_obs'];

            

            //$id_type_ctrl = $_POST['id_type_ctrl'];

            $sql = "INSERT INTO controle (id_facturation,nserie, id_ctrler, id_type_ctrl, certificat, kilometrage, date_exp ) VALUES (:id_factur, :nSerie, :id_ctrler, :id_type_ctrl, :certificat, :kilometrage, :date_exp);";

            $query = $db_PDO->prepare($sql);

            $query->bindValue(':id_factur', $id_factur/*, PDO::PARAM_STR*/);
            $query->bindValue(':date_exp', $date_exp/*, PDO::PARAM_STR*/);
            $query->bindValue(':nSerie', $nSerie/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_ctrler', $id_ctrler/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_type_ctrl', $id_type_ctrl/*, PDO::PARAM_STR*/);
            $query->bindValue(':certificat', $certificat/*, PDO::PARAM_STR*/);
            $query->bindValue(':kilometrage', $kilometrage/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_ctrler', $id_ctrler/*, PDO::PARAM_STR*/);

            $query->execute();

            $last_id_controle = $db_PDO->lastInsertId();

            $id_controle = $last_id_controle;


            foreach ($id_obs as $obs) {
                $obs_v = $obs;
                require_once("../api/db_connect.php");
                $sql3 = "INSERT INTO ctrl_obs(nserie, id_certificat, id_controle, id_vehicule, id_factur, id_obs) VALUES (:nSerie, :certificat, :id_controle, :id_vehic, :id_factur, :obs_v)";

                $query3 = $db_PDO->prepare($sql3);

                    $query3->bindValue(':certificat', $certificat/*, PDO::PARAM_STR*/);
                    $query3->bindValue(':nSerie', $nSerie/*, PDO::PARAM_STR*/);
                    $query3->bindValue(':id_controle', $id_controle/*, PDO::PARAM_STR*/);
                    $query3->bindValue(':id_vehic', $id_vehic/*, PDO::PARAM_STR*/);
                    $query3->bindValue(':id_factur', $id_factur/*, PDO::PARAM_STR*/);
                    $query3->bindValue(':obs_v', $obs_v/*, PDO::PARAM_STR*/);

                $query3->execute();
            }


            $sql2 = "UPDATE facturation SET etat = $etat_fact where id = $id_factur;";
            $query2 = $db_PDO->prepare($sql2);
            $query2->execute();


            header('Location: index.php');
        } else if (
            isset($_POST['id_vehic']) && !empty($_POST['id_vehic'])
            && (!isset($_POST['id_obs']) || empty($_POST['id_obs']))
            && isset($_POST['id_factur']) && !empty($_POST['id_factur'])
            //&& isset($_POST['etat_fact']) && !empty($_POST['etat_fact'])
        ) {
            require_once("../api/db_connect.php");

            //echo "test01";
            
            
            //$id_type_ctrl = $_POST['id_type_ctrl'];

            $sql = "INSERT INTO controle (id_facturation, nserie, id_ctrler, id_type_ctrl, certificat, kilometrage, date_exp ) VALUES (:id_factur, :nserie, :id_ctrler, :id_type_ctrl, :certificat, :kilometrage, :date_exp);";
            
            //echo "test02";

            $query = $db_PDO->prepare($sql);

            $query->bindValue(':id_factur', $id_factur/*, PDO::PARAM_STR*/);
            $query->bindValue(':date_exp', $date_exp/*, PDO::PARAM_STR*/);
            $query->bindValue(':nserie', $nSerie/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_ctrler', $id_ctrler/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_type_ctrl', $id_type_ctrl/*, PDO::PARAM_STR*/);
            $query->bindValue(':certificat', $certificat/*, PDO::PARAM_STR*/);
            $query->bindValue(':kilometrage', $kilometrage/*, PDO::PARAM_STR*/);
            $query->bindValue(':id_ctrler', $id_ctrler/*, PDO::PARAM_STR*/);

            $query->execute();

            $last_id_controle = $db_PDO->lastInsertId();

            $id_controle = $last_id_controle;

            $sql2 = "UPDATE facturation SET etat = $etat_fact where id = $id_factur;";
            $query2 = $db_PDO->prepare($sql2);
            $query2->execute();

            //echo "test03";

            header('Location: controle_cours.php');
            
        }
    } else {
        header('Location: ../restriction.php');
    }
}
