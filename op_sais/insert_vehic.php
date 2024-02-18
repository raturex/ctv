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

        // Initialize the session

        $id_user = $_SESSION["id_user"];
        $id_station = $_SESSION["id_station"];

        require_once("../api/db_connect.php");
        //requête
        $sql = "SELECT * FROM station left join user on user.id_station=station.id where station.id='" . $id_station . "'";
        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $reset = $request->fetch();

        $resp_station = $reset["id_responsable"];
        $station = $reset["nom"];
        $code_station = $reset["code"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Nouveau véhicule
            if (isset($_POST['action']) && $_POST['action'] == 1) {
                if (
                    isset($_POST['immatriculation']) && !empty($_POST['immatriculation'])
                    && isset($_POST['id_genre']) && !empty($_POST['id_genre'])
                    && isset($_POST['num_serie']) && !empty($_POST['num_serie'])
                    && isset($_POST['marque']) && !empty($_POST['marque'])
                    && isset($_POST['proprietaire']) && !empty($_POST['proprietaire'])
                    && isset($_POST['type_tech']) && !empty($_POST['type_tech'])
                    && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
                    && isset($_POST['puiss_fisc']) && !empty($_POST['puiss_fisc'])
                    && isset($_POST['date_mise_circul']) && !empty($_POST['date_mise_circul'])
                    && isset($_POST['date_local']) && !empty($_POST['date_local'])
                    && isset($_POST['id_client']) && !empty($_POST['id_client'])
                    && !isset($_POST['tp_com']) || empty($_POST['tp_com'])
                    && !isset($_POST['patente']) || empty($_POST['patente'])
                ) {


                    require_once("../api/db_connect.php");



                    $immatriculation = strip_tags($_POST['immatriculation']);
                    $marque = strip_tags($_POST['marque']);
                    $proprietaire = strip_tags($_POST['proprietaire']);
                    $type_tech = strip_tags($_POST['type_tech']);
                    $num_serie = strip_tags($_POST['num_serie']);
                    $id_energie = $_POST['id_energie'];
                    $nb_place = $_POST['nb_place'];
                    $ptac = $_POST['ptac'];
                    $puiss_fisc = strip_tags($_POST['puiss_fisc']);
                    $id_genre = $_POST['id_genre'];
                    $id_categ = $_POST['id_categ'];
                    $categorie = strip_tags($_POST['categ']);
                    $date_mise_circul = strip_tags($_POST['date_mise_circul']);
                    $date_local = strip_tags($_POST['date_local']);

                    $prix_timbre = 100;
                    $id_client = $_POST['id_client'];
                    $prix_visite = $_POST['prix_visite'];
                    $prix_vignette = $_POST['prix_vignette'];
                    $prix_vignette_pen = $_POST['prix_vignette_pen'];
                    $age_vehic = $_POST['age_vehic'];
                    $id_ctrl = $_POST['id_ctrl'];
                    //$patente = strip_tags($_POST['patente']);
                    //$tp_com = $_POST['tp_com'];


                    $oldVign = $_POST['oldVign'];
                    $newVign = $_POST['newVign'];
                    $dateOldVign = strip_tags($_POST['dateOldVign']);

                    $dateNewVign = $_POST['dateNewVign'];


                    $new_date = date('Y-m-d', strtotime($dateNewVign));
                    //durée à rajouter : 1 an;
                    $duree = 1;
                    //la première étape est de transformer cette date en timestamp
                    $dateNewVignTimestamp = strtotime($dateNewVign);
                    //on calcule la date de fin
                    $dateExp = date('Y-m-d', strtotime('+' . $duree . 'year', $dateNewVignTimestamp));

                    $etat_fact = 1;

                    $sql = "INSERT INTO vehicule (immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, nb_place, ptac, puiss_fisc, id_genre/*, tp_com, patente*/, id_categ, categorie, date_mise_circul, date_local) VALUES ( :immatriculation, :marque, :proprietaire, :type_tech, :num_serie, :id_energie, :nb_place, :ptac, :puiss_fisc, :id_genre,/* :tp_com, :patente,*/ :id_categ, :categorie, :date_mise_circul, :date_local);";

                    //$sql = "INSERT INTO vehi (immatriculation) VALUES (:immatriculation);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':immatriculation', $immatriculation/*, PDO::PARAM_STR*/);
                    $query->bindValue(':marque', $marque/*, PDO::PARAM_STR*/);
                    $query->bindValue(':proprietaire', $proprietaire/*, PDO::PARAM_STR*/);
                    $query->bindValue(':type_tech', $type_tech/*, PDO::PARAM_STR*/);
                    $query->bindValue(':num_serie', $num_serie/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':nb_place', $nb_place/*, PDO::PARAM_INT*/);
                    $query->bindValue(':ptac', $ptac/*, PDO::PARAM_STR*/);
                    $query->bindValue(':puiss_fisc', $puiss_fisc/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_genre', $id_genre/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_categ', $id_categ/*, PDO::PARAM_INT*/);
                    $query->bindValue(':categorie', $categorie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':date_mise_circul', $date_mise_circul/*, PDO::PARAM_STR*/);
                    $query->bindValue(':date_local', $date_local/*, PDO::PARAM_STR*/);
                    // $query->bindValue(':patente', $patente/*, PDO::PARAM_STR*/);
                    // $query->bindValue(':tp_com', $tp_com/*, PDO::PARAM_STR*/);

                    $query->execute();

                    $last_id_vehic = $db_PDO->lastInsertId();

                    $annee = date("Y");
                    require_once("../api/db_connect.php");
                    //requête
                    $sql = "SELECT max(id) as max FROM facturation where facturation.date like '" . $annee . "%'";
                    // On prépare la requête
                    $request = $db_PDO->prepare($sql);
                    $request = $db_PDO->query($sql);
                    // On exécute la requête
                    $request->execute();
                    // On stocke le résultat dans un tableau associatif
                    $reset2 = $request->fetch();
                    $number = $reset2["max"];
                    $number = $number + 1;
                    $length = 6;
                    $numb = substr(str_repeat(0, $length) . $number, -$length);
                    $num_factur = $code_station . '' . $annee . '' . $numb;


                    require_once("../api/db_connect.php");

                    $sql = "INSERT INTO prefacture (id_vehicule, id_ctrl, id_client, age_vehi, prix_visite, prix_vignette, prix_vignette_pen, prix_timbre, etat, id_user, num_facture) VALUES ( :id_vehicule, :id_ctrl, :id_client, :age_vehic, :prix_visite, :prix_vignette, :prix_vignette_pen, :prix_timbre, :etat_fact, :id_user, :num_factur);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':id_vehicule', $last_id_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_ctrl', $id_ctrl/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_client', $id_client/*, PDO::PARAM_STR*/);
                    $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_vignette', $prix_vignette/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_vignette_pen', $prix_vignette_pen/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_timbre', $prix_timbre/*, PDO::PARAM_STR*/);
                    $query->bindValue(':etat_fact', $etat_fact/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_user', $id_user/*, PDO::PARAM_STR*/);
                    $query->bindValue(':num_factur', $num_factur/*, PDO::PARAM_STR*/);


                    $query->execute();
                    $last_id_fact = $db_PDO->lastInsertId();

                    require_once("../api/db_connect.php");


                    $sql = "INSERT INTO pvignette(date, exp, numero, id_vehicule, id_facturation) VALUES ( :date_vign, :exp, :numero, :id_vehicule, :id_facturation);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':id_vehicule', $last_id_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':date_vign', $dateNewVign/*, PDO::PARAM_STR*/);
                    $query->bindValue(':exp', $dateExp/*, PDO::PARAM_STR*/);
                    $query->bindValue(':numero', $newVign/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_facturation', $last_id_fact/*, PDO::PARAM_STR*/);

                    $query->execute();

                    header('Location: ../caisse/invoice.php?id_client=' . $id_client . '&id_vehicule=' . $last_id_vehic .  '&age_vehic=' . $age_vehic . '&id_ctrl=' . $id_ctrl . '&prix_visite=' . $prix_visite . '&prix_vignette=' . $prix_vignette . '&prix_vignette_pen=' . $prix_vignette_pen . '&etat_fact=' . $etat_fact . '&date_exp_vign=' . $dateExp . '&date_debut_vign=' . $dateNewVign . '&num_vign=' . $newVign . '');
                    exit;
                    //invoice.php?id_client=12&id_vehicule=23&id_ctrl=1&prix_visite=15000&prix_vignette=36000&etat_fact=3

                } else if (
                    isset($_POST['immatriculation']) && !empty($_POST['immatriculation'])
                    && isset($_POST['id_genre']) && !empty($_POST['id_genre'])
                    && isset($_POST['num_serie']) && !empty($_POST['num_serie'])
                    && isset($_POST['marque']) && !empty($_POST['marque'])
                    && isset($_POST['tp_com']) && !empty($_POST['tp_com'])
                    && isset($_POST['patente']) && !empty($_POST['patente'])
                    /*&& isset($_POST['id_energie']) && !empty($_POST['id_energie'])
            && isset($_POST['puiss_fisc']) && !empty($_POST['puiss_fisc'])
            && isset($_POST['date_mise_circul']) && !empty($_POST['date_mise_circul'])
            && isset($_POST['date_local']) && !empty($_POST['date_local'])
            && isset($_POST['id_client']) && !empty($_POST['id_client'])*/
                ) {

                    require_once("../api/db_connect.php");


                    $tp_com = $_POST['tp_com'];

                    $immatriculation = strip_tags($_POST['immatriculation']);
                    $marque = strip_tags($_POST['marque']);
                    $proprietaire = strip_tags($_POST['proprietaire']);
                    $type_tech = strip_tags($_POST['type_tech']);
                    $num_serie = strip_tags($_POST['num_serie']);
                    $id_energie = strip_tags($_POST['id_energie']);
                    $nb_place = $_POST['nb_place'];
                    $ptac = $_POST['ptac'];
                    $puiss_fisc = strip_tags($_POST['puiss_fisc']);
                    $id_genre = strip_tags($_POST['id_genre']);
                    $id_categ = strip_tags($_POST['id_categ']);
                    $categorie = strip_tags($_POST['categ']);
                    $date_mise_circul = strip_tags($_POST['date_mise_circul']);
                    $date_local = strip_tags($_POST['date_local']);

                    $id_client = $_POST['id_client'];
                    $prix_visite = $_POST['prix_visite'];
                    $prix_vignette = $_POST['prix_vignette'];
                    $prix_vignette_pen = $_POST['prix_vignette_pen'];
                    $age_vehic = $_POST['age_vehic'];
                    $id_ctrl = $_POST['id_ctrl'];
                    $patente = strip_tags($_POST['patente']);
                    $tp_com = $_POST['tp_com'];


                    $oldVign = $_POST['oldVign'];
                    $newVign = $_POST['newVign'];
                    $dateOldVign = strip_tags($_POST['dateOldVign']);
                    $dateNewVign = strip_tags($_POST['dateNewVign']);



                    $etat_fact = 1;

                    $sql = "INSERT INTO vehicule (immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, nb_place, ptac, puiss_fisc, id_genre, tp_com, patente, id_categ, categorie, date_mise_circul, date_local) VALUES ( :immatriculation, :marque, :proprietaire, :type_tech, :num_serie, :id_energie, :nb_place, :ptac, :puiss_fisc, :id_genre, :tp_com, :patente, :id_categ, :categorie, :date_mise_circul, :date_local);";

                    //$sql = "INSERT INTO vehi (immatriculation) VALUES (:immatriculation);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':immatriculation', $immatriculation/*, PDO::PARAM_STR*/);
                    $query->bindValue(':marque', $marque/*, PDO::PARAM_STR*/);
                    $query->bindValue(':proprietaire', $proprietaire/*, PDO::PARAM_STR*/);
                    $query->bindValue(':type_tech', $type_tech/*, PDO::PARAM_STR*/);
                    $query->bindValue(':num_serie', $num_serie/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':nb_place', $nb_place/*, PDO::PARAM_INT*/);
                    $query->bindValue(':ptac', $ptac/*, PDO::PARAM_STR*/);
                    $query->bindValue(':puiss_fisc', $puiss_fisc/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_genre', $id_genre/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_categ', $id_categ/*, PDO::PARAM_INT*/);
                    $query->bindValue(':categorie', $categorie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':date_mise_circul', $date_mise_circul/*, PDO::PARAM_STR*/);
                    $query->bindValue(':date_local', $date_local/*, PDO::PARAM_STR*/);
                    $query->bindValue(':patente', $patente/*, PDO::PARAM_STR*/);
                    $query->bindValue(':tp_com', $tp_com/*, PDO::PARAM_STR*/);


                    $query->execute();

                    $last_id_vehic = $db_PDO->lastInsertId();


                    require_once("../api/db_connect.php");
                    //requête
                    $sql = "SELECT max(id) as max FROM facturation where facturation.date like '" . $annee . "%'";
                    // On prépare la requête
                    $request = $db_PDO->prepare($sql);
                    $request = $db_PDO->query($sql);
                    // On exécute la requête
                    $request->execute();
                    // On stocke le résultat dans un tableau associatif
                    $reset2 = $request->fetch();
                    $number = $reset2["max"];
                    $number = $number + 1;
                    $length = 6;
                    $numb = substr(str_repeat(0, $length) . $number, -$length);
                    $num_factur = $code_station . '' . $annee . '' . $numb;


                    require_once("../api/db_connect.php");

                    $sql = "INSERT INTO prefacture (id_vehicule, id_ctrl, id_client, age_vehi, prix_visite, prix_vignette, prix_vignette_pen, prix_timbre, etat, id_user, num_facture) VALUES ( :id_vehicule, :id_ctrl, :id_client, :age_vehic, :prix_visite, :prix_vignette, :prix_vignette_pen, :prix_timbre, :etat_fact, :id_user, :num_factur, num_certificat);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':id_vehicule', $last_id_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_ctrl', $id_ctrl/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_client', $id_client/*, PDO::PARAM_STR*/);
                    $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_visite', $prix_visite/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_vignette', $prix_vignette/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_vignette_pen', $prix_vignette_pen/*, PDO::PARAM_STR*/);
                    $query->bindValue(':prix_timbre', $prix_timbre/*, PDO::PARAM_STR*/);
                    $query->bindValue(':etat_fact', $etat_fact/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_user', $id_user/*, PDO::PARAM_STR*/);
                    $query->bindValue(':num_factur', $num_factur/*, PDO::PARAM_STR*/);


                    $query->execute();
                    $last_id_fact = $db_PDO->lastInsertId();

                    require_once("../api/db_connect.php");


                    $sql = "INSERT INTO pvignette(date, exp, numero, id_vehicule, id_facturation) VALUES ( :date_vign, :exp, :numero, :id_vehicule, :id_facturation);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':id_vehicule', $last_id_vehic/*, PDO::PARAM_STR*/);
                    $query->bindValue(':date_vign', $dateNewVign/*, PDO::PARAM_STR*/);
                    $query->bindValue(':exp', $dateExp/*, PDO::PARAM_STR*/);
                    $query->bindValue(':numero', $newVign/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_facturation', $last_id_fact/*, PDO::PARAM_STR*/);

                    $query->execute();




                    header('Location: invoice.php?id_client=' . $id_client . '&id_vehicule=' . $last_id_vehic .  '&age_vehic=' . $age_vehic . '&id_ctrl=' . $id_ctrl . '&prix_visite=' . $prix_visite . '&prix_vignette=' . $prix_vignette . '&prix_vignette_pen=' . $prix_vignette_pen . '&etat_fact=' . $etat_fact . '&date_exp_vign=' . $dateExpNewVign . '&date_debut_vign=' . $dateNewVign . '&num_vign=' . $newVign . '');
                    //invoice.php?id_client=12&id_vehicule=23&id_ctrl=1&prix_visite=15000&prix_vignette=36000&etat_fact=3
                }
            } else if (isset($_POST['action']) && $_POST['action'] == 2) {
                if (
                    isset($_POST['immatriculation']) && !empty($_POST['immatriculation'])
                    && isset($_POST['id_genre']) && !empty($_POST['id_genre'])
                    && isset($_POST['num_serie']) && !empty($_POST['num_serie'])
                    && isset($_POST['marque']) && !empty($_POST['marque'])
                    /*&& isset($_POST['proprietaire']) && !empty($_POST['proprietaire'])
            && isset($_POST['type_tech']) && !empty($_POST['type_tech'])
            && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
            && isset($_POST['puiss_fisc']) && !empty($_POST['puiss_fisc'])
            && isset($_POST['date_mise_circul']) && !empty($_POST['date_mise_circul'])
            && isset($_POST['date_local']) && !empty($_POST['date_local'])
            && isset($_POST['id_client']) && !empty($_POST['id_client'])*/
                ) {


                    $immatriculation = strip_tags($_POST['immatriculation']);
                    $marque = strip_tags($_POST['marque']);
                    $proprietaire = strip_tags($_POST['proprietaire']);
                    $type_tech = strip_tags($_POST['type_tech']);
                    $num_serie = strip_tags($_POST['num_serie']);
                    $id_energie = strip_tags($_POST['id_energie']);
                    $nb_place = $_POST['nb_place'];
                    $ptac = $_POST['ptac'];
                    $puiss_fisc = strip_tags($_POST['puiss_fisc']);
                    $id_genre = strip_tags($_POST['id_genre']);
                    $id_categ = strip_tags($_POST['id_categ']);
                    $categorie = strip_tags($_POST['categ']);
                    $date_mise_circul = strip_tags($_POST['date_mise_circul']);
                    $date_local = strip_tags($_POST['date_local']);

                    $id_client = $_POST['id_client'];
                    $age_vehic = $_POST['age_vehic'];
                    $id_ctrl = $_POST['id_ctrl'];

                    $sql = "UPDATE vehicule SET immatriculation = :immatriculation, marque = :marque, proprietaire = :proprietaire, type_tech = :type_tech, num_serie = :num_serie, id_energie = :id_energie, nb_place = :nb_place, ptac = :ptac, puiss_fisc = :puiss_fisc, id_genre = :id_genre, id_categ = :id_categ, categorie = :categorie,  date_mise_circul = :date_mise_circul, date_local = :date_local where id=$id);";

                    //$sql = "INSERT INTO vehi (immatriculation) VALUES (:immatriculation);";

                    $query = $db_PDO->prepare($sql);

                    $query->bindValue(':immatriculation', $immatriculation/*, PDO::PARAM_STR*/);
                    $query->bindValue(':marque', $marque/*, PDO::PARAM_STR*/);
                    $query->bindValue(':proprietaire', $proprietaire/*, PDO::PARAM_STR*/);
                    $query->bindValue(':type_tech', $type_tech/*, PDO::PARAM_STR*/);
                    $query->bindValue(':num_serie', $num_serie/*, PDO::PARAM_STR*/);
                    $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':nb_place', $nb_place/*, PDO::PARAM_INT*/);
                    $query->bindValue(':ptac', $ptac/*, PDO::PARAM_STR*/);
                    $query->bindValue(':puiss_fisc', $puiss_fisc/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_genre', $id_genre/*, PDO::PARAM_INT*/);
                    $query->bindValue(':id_categ', $id_categ/*, PDO::PARAM_INT*/);
                    $query->bindValue(':categorie', $categorie/*, PDO::PARAM_INT*/);
                    $query->bindValue(':date_mise_circul', $date_mise_circul/*, PDO::PARAM_STR*/);
                    $query->bindValue(':date_local', $date_local/*, PDO::PARAM_STR*/);

                    $query->execute();

                    $last_id_vehic = $db_PDO->lastInsertId();
                }
            }
        }
    } else {
        header('Location: ../restriction.php');
    }
}
