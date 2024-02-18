<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Erreur 1";
    if (
        isset($_POST['id_vehicule']) && !empty($_POST['id_vehicule'])
        && isset($_POST['id_client']) && !empty($_POST['id_client'])
        && isset($_POST['id_ctrl']) && !empty($_POST['id_ctrl'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['etat_fact']) && !empty($_POST['etat_fact'])
        && isset($_POST['prix_visite']) && !empty($_POST['prix_visite'])
        && isset($_POST['prix_vignette']) && !empty($_POST['prix_vignette'])
        /*&& isset($_POST['date_exp_vign']) && !empty($_POST['date_exp_vign'])*/
    ) {

        echo "Erreur 122";
        // Include config file
        require_once("../api/db_connect.php");

        $id_prefact = $_POST['id_prefact'];
        $visite_vip = $_POST['visite_vip'];
        $securisation = $_POST['securisation'];
        $date_debut_vign = $_POST['date_debut_vign'];
        $date_exp_vign = $_POST['date_exp_vign'];

        $num_certificat = $_POST['num_certificat'];
        $num_factur = $_POST['num_factur'];
        $num_vignette = $_POST['num_vignette'];
        $ncc = $_POST['ncc'];

        $id_op = $_POST['id_op'];
        $nSerie = $_POST['nSerie'];

        $id_client = $_POST['id_client'];
        $id_vehicule = $_POST['id_vehicule'];
        $id_ctrl = $_POST['id_ctrl'];
        $etat_fact = 2;
        $age_vehic = $_POST['age_vehic'];
        $prix_visite = $_POST['prix_visite'];
        $prix_vignette = $_POST['prix_vignette'];
        $prix_vignette_pen = $_POST['prix_vignette_pen'];
        $num_factur = $_POST['num_factur'];

        $totalTTC = $_POST['t_ttc_act'];
        $totalPay = $_POST['t_to_pay'];
        $Tprix_vignette = $_POST['t__vign'];


        //$numero = $_POST['numero'];

        $dateNewVign = date("Y-m-d");

        $new_date = date('Y-m-d', strtotime($dateNewVign));
        //durée à rajouter : 1 an;
        $duree = 1;
        //la première étape est de transformer cette date en timestamp
        $dateNewVignTimestamp = strtotime($dateNewVign);
        //on calcule la date de fin
        $dateExp = date('Y-m-d', strtotime('+' . $duree . 'year', $dateNewVignTimestamp));

        $etat_fact = 4;


        $id_user = $_POST['id_user'];
        $prix_timbre = $_POST['timbre'];


        //$sql2 = "UPDATE facturation SET etat = $etat_fact where id = $id_factur;";
        //$query2 = $db_PDO->prepare($sql2);
        //$query2->execute();


        $sql = "INSERT INTO facturation (id_vehicule,nserie, id_ctrl, id_client, age_vehi, prix_visite, prix_vignette, prix_vignette_pen, prix_timbre, t_actia, t_vign, t_to_pay, etat, id_user, id_caisse, num_facture) VALUES ( :id_vehicule, :nSerie, :id_ctrl, :id_client, :age_vehic, :prix_visite, :prix_vignette, :prix_vignette_pen, :prix_timbre, :t_actia, :t_vign, :t_to_pay, :etat_fact, :id_user, :id_caisse, :num_factur);";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':t_actia', $totalTTC/*, PDO::PARAM_STR*/);
        $query->bindValue(':t_vign', $Tprix_vignette/*, PDO::PARAM_STR*/);
        $query->bindValue(':t_to_pay', $totalPay/*, PDO::PARAM_STR*/);
        $query->bindValue(':nSerie', $nSerie/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_vehicule', $id_vehicule/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_ctrl', $id_ctrl/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_client', $id_client/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
        $query->bindValue(':prix_vignette', $prix_vignette/*, PDO::PARAM_STR*/);
        $query->bindValue(':prix_vignette_pen', $prix_vignette_pen/*, PDO::PARAM_STR*/);
        $query->bindValue(':prix_timbre', $prix_timbre/*, PDO::PARAM_STR*/);
        $query->bindValue(':etat_fact', $etat_fact/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_user', $id_op/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_caisse', $id_user/*, PDO::PARAM_STR*/);
        $query->bindValue(':num_factur', $num_factur/*, PDO::PARAM_STR*/);

        $query->execute();
        $last_id_fact = $db_PDO->lastInsertId();


        require_once("../api/db_connect.php");

        $sql = "INSERT INTO vignette(date, exp, numero, nserie, id_vehicule, id_facturation) VALUES ( :date_vign, :date_exp_vign, :numero, :nSerie, :id_vehicule, :id_facturation);";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':nSerie', $nSerie/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_vehicule', $id_vehicule/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_vign', $dateNewVign/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_exp_vign', $dateExp/*, PDO::PARAM_STR*/);
        $query->bindValue(':numero', $num_vignette/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_facturation', $last_id_fact/*, PDO::PARAM_STR*/);

        $query->execute();

        require_once("../api/db_connect.php");
        $sql = "DELETE FROM prefacture WHERE id=$id_prefact";
        $query = $db_PDO->prepare($sql);
        $query->execute();

        require_once("../api/db_connect.php");
        $sql = "DELETE FROM pvignette WHERE id=$id_prefact";
        $query = $db_PDO->prepare($sql);
        $query->execute();


        header('Location: index.php');
    } else echo "Erreur 2";
}
