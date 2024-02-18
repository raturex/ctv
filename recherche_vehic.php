<?php

// Include config file
include("api/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query;
    if (
        //!Marque - !energie - !categorie - !age - !date_debut - !date_fin - !type_ctrl
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
        && isset($_POST['ctrl_vehic']) && empty($_POST['ctrl_vehic'])
    ) {

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->execute();
    } else if (
        //Marque - energie - categorie - age - date_debut - date_fin - type_ctrl
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
        //&& isset($_POST['ctrl_vehic']) && !empty($_POST['ctrl_vehic'])

    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);
        //$ctrl_vehic = $_POST['ctrl_vehic'];

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic /*and type_ctrl.id = :ctrl_vehic*/ order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':ctrl_vehic', $ctrl_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])

    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id  and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - !categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_categ= :categ_vehic and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_categ= :categ_vehic and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and date >= :date_debut and date <= :date_fin   order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - !categorie - age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and date >= :date_debut and date <= :date_fin order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie  and date >= :date_debut   order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - !categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - energie - categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - !categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date >= :date_debut and date <= :date_fin order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - !categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date >= :date_debut order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - !categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - categorie - !age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - !categorie - age - !date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        //$date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Marque - !energie - !categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and date >= :date_debut order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - !categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and date like :date_debut order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - energie - !categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and date >= :date_debut and date <= :date_fin order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - !age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic and date like :date_debut order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - categorie - !age - date_debut - date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && !empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        //$age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic and date >= :date_debut and date <= :date_fin order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //!Marque - !energie - !categorie - age - date_debut - !date_fin
        isset($_POST['marque_vehic']) && empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])
        && isset($_POST['date_debut']) && !empty($_POST['date_debut'])
        && isset($_POST['date_fin']) && empty($_POST['date_fin'])
    ) {
        //$marque_vehic = strip_tags($_POST['marque_vehic']);
        //$id_energie = $_POST['id_energie'];
        //$categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];
        $date_debut = strip_tags($_POST['date_debut']);
        //$date_fin = strip_tags($_POST['date_fin']);


        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date >= :date_debut and age_vehi = :age_vehic  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        //$query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        //$query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        //$query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_debut', $date_debut . '%'/*, PDO::PARAM_STR*/);
        //$query->bindValue(':date_fin', $date_fin . '%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    } else if (
        //Immatriculation
        isset($_POST['immat_vehic']) && !empty($_POST['immat_vehic'])
    ) {
        $immat_vehic = strip_tags($_POST['immat_vehic']);

        $sql = "SELECT vehicule.id as id, facturation.id as id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and immatriculation like :immat_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':immat_vehic', $immat_vehic/*, PDO::PARAM_STR*/);

        $query->execute();
    }
}else {

    header('Location: recherche.php');
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
                            <h1 class="m-0">Recherche</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="recherche.php">Recherche</a></li>
                                <li class="breadcrumb-item active">Résultat</li>
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

                    <!-- Tableau véhicules controlés -->

                    <!-- Tableau de données -->
                    <div class="card">
                        <!-- card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Résultat de la recherche</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                        N° Immatriculation</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                        Marque</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                        Propriétaire</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                        numero de serie</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                                        Type de transport</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            //while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            while ($row = $query->fetch()) {

                                            ?>

                                                <tbody>
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="0">
                                                            <?php
                                                            echo $row["immatriculation"];
                                                            ?>
                                                        </td>
                                                        <td class="">
                                                            <?php
                                                            echo $row["marque"];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $row["proprietaire"];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $row["num_serie"];
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $row["genre"];
                                                            ?>
                                                        </td>

                                                        <?php
                                                        $id_vehic = $row["id"];
                                                        $id_factur = $row["id_factur"];

                                                        ?>

                                                        <td class="sorting_1">
                                                            <a href="details.php?immat=<?= $row["immatriculation"]; ?>" class="nav-link">
                                                                <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="example1" type="button"><span>Voir plus</span></button>
                                                            </a>
                                                            <a href="edit_result.php?id_vehic=<?= $id_vehic ?>&id_factur=<?= $id_factur ?>" class="nav-link">
                                                                <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="example1" type="button"><span>Resultat visite</span></button>
                                                            </a>
                                                        </td>

                                                    </tr>

                                                <?php
                                            }
                                                ?>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th rowspan="1" colspan="1">N° Immatriculation</th>
                                                        <th rowspan="1" colspan="1">Marque</th>
                                                        <th rowspan="1" colspan="1">Propriétaire</th>
                                                        <th rowspan="1" colspan="1">numero de serie</th>
                                                        <th rowspan="1" colspan="1">Type de transport</th>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.Tableau véhicules controlés -->


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






    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
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
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- Page specific script -->

    <!--
        <script>
            $(function () {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
    -->




</body>


</html>