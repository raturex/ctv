<script>
    function dateDiff(date1, date2) {
        var diff = {} // Initialisation du retour
        var tmp = date2 - date1;

        tmp = Math.floor(tmp / 1000); // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60; // Extraction du nombre de secondes

        tmp = Math.floor((tmp - diff.sec) / 60); // Nombre de minutes (partie entière)
        diff.min = tmp % 60; // Extraction du nombre de minutes

        tmp = Math.floor((tmp - diff.min) / 60); // Nombre d'heures (entières)
        diff.hour = tmp % 24; // Extraction du nombre d'heures

        tmp = Math.floor((tmp - diff.hour) / 24); // Nombre de jours restants
        diff.day = tmp % 365;

        tmp = Math.floor((tmp - diff.day) / 365); // Nombre d'année restants
        diff.year = tmp;

        //3,154e+10
        return diff;
    }
</script>

<script>
    function CalculVignette() {

        var puisFisc, ptac, placeAssis, prixVignette, prixVisite, categ;
        var type
        var rad = document.nVehicule.id_genre;
        var prev = null;

        var dateMC = Date.parse(document.getElementById("inputDateMC").value);
        var now = Date.now();

        var diff = dateDiff(dateMC, now);
        document.getElementById("anneeMC").innerHTML = +diff.year + 1 + " ans";
        puisFisc = document.getElementById("inputPuisFiscal").value;
        ptac = document.getElementById("inputPTAC").value;

        //Type transport de marchandise
        if (rad.value == 1) {
            document.getElementById("inputPA").disabled = true;
            document.getElementById("inputPTAC").disabled = false;

            if (ptac == 0) {
                if (puisFisc == 0) {
                    document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que son PTAC";
                    // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                } else {
                    document.getElementById("CalVignette").innerHTML = "Veuillez saisir le PTAC du véhicule";
                }
            } else if (ptac > 0 && ptac <= 3.5) {
                if (puisFisc == 0) {
                    document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule";
                } else if (puisFisc > 0 && puisFisc <= 7) {
                    categ = "TP1";
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 13.700 FCFA  //  Vignette:  ";
                } else if (puisFisc > 7) {
                    categ = "TP2";
                    document.getElementById("CalVignette").innerHTML = "Visite Technique: 16.100 FCFA  //  Vignette:  ";
                }
            }
        } //Type transport de personne
        else if (rad.value == 2) {
            document.getElementById("inputPA").disabled = false;
            document.getElementById("inputPTAC").disabled = true;

            document.getElementById("CalVignette").innerHTML = rad.value;
        }

        /*for (var i = 0; i < rad.length; i++) {
          rad[i].addEventListener('change', function() {
              // (prev) ? console.log(prev.value): null;
              if (this !== prev) {
                  prev = this;
              }*/

        //document.getElementById("CalVignette").innerHTML = x;

        //console.log(this.value)
        //});
    }
</script>





//table vehicules

CREATE TABLE `actia`.`vehicules` ( `id` INT NOT NULL AUTO_INCREMENT , `num_serie` VARCHAR(255) NULL DEFAULT NULL , 
`immat` VARCHAR(255) NULL DEFAULT NULL , `marque` VARCHAR(255) NULL DEFAULT NULL , `proprio` VARCHAR(255) NULL DEFAULT NULL , 
`type_tech` VARCHAR(255) NULL DEFAULT NULL , `puiss_fisc` INT(3) NULL DEFAULT NULL , `id_genre` INT(2) NULL DEFAULT NULL , 
`id_energie` INT(2) NULL DEFAULT NULL , `id_categ` INT(2) NULL DEFAULT NULL , `ptac` INT NULL DEFAULT NULL , `p_a` INT NULL DEFAULT NULL , 
`date_mc` INT NULL DEFAULT NULL , `date_immat` INT NULL DEFAULT NULL , PRIMARY KEY (`id`), INDEX (`id_categ`), INDEX (`id_energie`), 
INDEX (`id_genre`), UNIQUE (`num_serie`), UNIQUE (`immat`)) ENGINE = InnoDB;

























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
        $sql = "SELECT id FROM vehi WHERE immatriculation = ?";
        
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

$sql = "SELECT * FROM vehicule WHERE immatriculation like '".$immat_vehic."' and marque like '".$marque_vehic."' and id_energie=".$energie_vehic." and id_categ= '".$categ_vehic."' order by id DESC;";
?>



else if (
        //Marque - energie
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else  if (
        //energie - categorie
        isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
    ) {

        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //Marque - categorie
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $categ_vehic = $_POST['categ_vehic'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else  if (
        //categorie
        isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
    ) {
        $categ_vehic = $_POST['categ_vehic'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //Marque
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //energie
        isset($_POST['id_energie']) && !empty($_POST['id_energie'])
    ) {
        $id_energie = $_POST['id_energie'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //immatriculation
        isset($_POST['immat_vehic']) && !empty($_POST['immat_vehic'])
    ) {
        $immat_vehic = strip_tags($_POST['immat_vehic']);
        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and immatriculation like :immat_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':immat_vehic', $immat_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //age
        isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $age_vehic = $_POST['age_vehic'];

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and age_vehi = :age_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);
        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //Marque - energie - categorie - age
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $id_energie = $_POST['id_energie'];
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];


        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and id_energie=:id_energie and age_vehi = :age_vehic and  id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    }else if (
        //Marque - categorie - age
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];

        
        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and age_vehi = :age_vehic and  id_categ=:categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //Marque - age
        isset($_POST['marque_vehic']) && !empty($_POST['marque_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $marque_vehic = strip_tags($_POST['marque_vehic']);
        $age_vehic = $_POST['age_vehic'];

        echo $_POST['age_vehic'];


        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and marque like :marque_vehic and age_vehi = :age_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':marque_vehic', $marque_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //categorie - age
        isset($_POST['categ_vehic']) && !empty($_POST['categ_vehic'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $categ_vehic = $_POST['categ_vehic'];
        $age_vehic = $_POST['age_vehic'];


        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and age_vehi = :age_vehic and  id_categ= :categ_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':categ_vehic', $categ_vehic/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    } else if (
        //energie - age
        isset($_POST['id_energie']) && !empty($_POST['id_energie'])
        && isset($_POST['age_vehic']) && !empty($_POST['age_vehic'])

    ) {
        $id_energie = $_POST['id_energie'];
        $age_vehic = $_POST['age_vehic'];


        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and id_energie=:id_energie and age_vehi = :age_vehic order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':id_energie', $id_energie/*, PDO::PARAM_STR*/);
        $query->bindValue(':age_vehic', $age_vehic/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    }
    /*(période)*/ else if (
        //date debut
        isset($_POST['date_debut']) && !empty($_POST['date_debut'])
    ) {
        $date_debut = strip_tags($_POST['date_debut']);

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date like :date_debut order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':date_debut', $date_debut.'%'/*, PDO::PARAM_STR*/);

        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    }



    /*(période)*/ else if (
        //date debut - date fin (période)
        isset($_POST['date_debut']) && !empty($_POST['date_debut'])
    ) {
        $date_debut = strip_tags($_POST['date_debut']);
        $date_fin = strip_tags($_POST['date_fin']);

        $sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib as energie, nb_place, ptac, puiss_fisc, genre.lib as genre, categ.categorie as categ, date_mise_circul, date_local as date_immatri, type_ctrl.lib as type_ctrl, id_client, age_vehi, date FROM vehicule left join `facturation` on vehicule.id = id_vehicule JOIN energie on vehicule.id_energie=energie.id JOIN genre on vehicule.id_genre=genre.id JOIN categ on vehicule.id_categ=categ.id, type_ctrl WHERE facturation.id_ctrl=type_ctrl.id and date >= %:date_debut% and date <= %:date_fin%  order by id DESC;";

        $query = $db_PDO->prepare($sql);

        $query->bindValue(':date_debut', $date_debut.'%'/*, PDO::PARAM_STR*/);
        $query->bindValue(':date_fin', $date_fin.'%'/*, PDO::PARAM_STR*/);


        $query->execute();

        while ($row = $query->fetch()) {
            echo $row['id'] . "<br />\n";
        }
    }















<div class="card">

            <div class="card-header">

              <h4>
                <p> Client</p>
              </h4>

            </div>

            <form name="nVehicule" action="insert_vehic.php" method="post">
              <div class="card-body">

                <!-- form start -->
                <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                <div class="row">
                  <div class="col-sm-6">
                    <!-- Détail fiscal -->

                    <div class="card-body">

                      <div class="form-group">
                        <label for="inputPid">Pièce d'identité</label>
                        <select class="form-control" name="id_pid" id="inputPid">

                          <?php include("api/db_connect.php");

                          //requête
                          $sql = "SELECT * FROM type_piece";
                          // On prépare la requête
                          $request = $db_PDO->prepare($sql);
                          // On exécute la requête
                          $request->execute();
                          // On stocke le résultat dans un tableau associatif
                          $result = $request->fetchAll(PDO::FETCH_ASSOC);

                          foreach ($result as $pid) { ?>
                            <option value="<?php echo $pid['id'] ?>"> <?= $pid['lib'] ?> </option>
                          <?php }  ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="inputNom_client">Nom</label>

                        <input type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom">

                      </div>

                      <div class="form-group">
                        <label for="inputTelClient">Téléphone</label>
                        <input type="tel" class="form-control telephone" id="inputTelClient" name="tel_client" placeholder="Téléphone">
                      </div>

                    </div>

                    <!-- /.Détail fiscal -->
                  </div>


                  <div class="col-sm-6">
                    <!-- Info véhicule -->

                    <div class="card-body">

                      <div class="form-group">
                        <label for="inputNumPiece">Numéro de la pièce</label>
                        <input type="text" class="form-control" id="inputNumPiece" name="num_piece_client" placeholder="numero de la pièce">
                      </div>

                      <div class="form-group">
                        <label for="inputPnom_client">Prénoms</label>
                        <input type="text" class="form-control" id="inputPnom_client" name="prenom_client" placeholder="Prénoms">
                      </div>

                      <div class="form-group">
                        <label for="inputEmailClient">Email</label>
                        <input type="email" class="form-control email" id="inputEmailClient" name="email_Client" placeholder="email">
                      </div>


                    </div>

                    <!-- /.Info véhicule -->
                  </div>
                </div>


                <!-- /.form start -->
              </div>

              <div class="card-footer">
                <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer véhicule</button>
                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
              </div>
            </form>

          </div>





