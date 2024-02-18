<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

  require_once('../api/db_connect.php');

  $sql = 'select * from role where role.id= $_SESSION["role"]';

  require_once("../api/db_connect.php");
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


  if (isset($_SESSION["role"]) && ($_SESSION["role"] == 5 /*|| $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
    // Initialize the session
    //session_start();



$annee = date("Y");
$id_station = $_SESSION["id_station"];
$id_user = $_SESSION["id_user"];


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


require_once("../api/db_connect.php");
//requête
$sql = "SELECT max(id) as max FROM vignette";
$request = $db_PDO->prepare($sql);
$request = $db_PDO->query($sql);
// On exécute la requête
$request->execute();
// On stocke le résultat dans un tableau associatif
$reset = $request->fetch();
$number = $reset["max"] + 1;

$length = 6;
$numb = substr(str_repeat(0, $length) . $number, -$length);
$num_vignette = $code_station . '' . $annee . '' . $numb;


require_once("../api/db_connect.php");

//requête
$id_vehicule = $_GET["id_vehicule"];
//$pvignette = $_GET["id_pvign"];
$id_fact = $_GET["id_fact"];

$sql = "SELECT facturation.id as id_prefact, facturation.id_vehicule as id_vehicule, id_controle, id_ctrl, id_client, age_vehi, prix_visite, prix_vignette, prix_vignette_pen, prix_timbre, etat, facturation.date as date, id_user, id_caisse ,pvignette.numero as num_vign, pvignette.date as date_debut_vign, pvignette.exp as date_exp_vign, vehicule.id as id_vehicule, facturation.id as id_fact, facturation.etat as etat_fact, facturation.prix_visite as prix_visite, facturation.age_vehi as age_vehic,  pvignette.id as id_vignette  FROM prefacture as facturation left join vehicule on vehicule.id =facturation.id_vehicule left join pvignette on facturation.id=pvignette.id_facturation  where facturation.etat = 1  and vehicule.id=" . $id_vehicule . "  order by facturation.date Desc limit 1";
// On prépare la requête
$request = $db_PDO->prepare($sql);
$request = $db_PDO->query($sql);
// On exécute la requête
$request->execute();
// On stocke le résultat dans un tableau associatif
$vehic = $request->fetch();

$id_prefact = $vehic['id_prefact'];
$prix_visite = $vehic['prix_visite'];
$prix_vignette = $vehic['prix_vignette'];
$num_vign = $num_vignette;
$prix_vignette_pen = $vehic['prix_vignette_pen'];
$id_vehicule = $vehic["id_vehicule"];
$id_ctrl = $vehic["id_ctrl"];
$id_op = $vehic["id_user"];


$age_vehic = $vehic["age_vehic"];
$etat_fact = $vehic["etat_fact"];
$id_client = $vehic["id_client"];

$date_debut_vign = $vehic["date_debut_vign"];
$date_exp_vign = $vehic["date_exp_vign"];

header('Location: invoice.php?id_prefact=' . $id_prefact . '&id_op=' . $id_op . '&id_client=' . $id_client . '&id_vehicule=' . $id_vehicule .  '&age_vehic=' . $age_vehic . '&id_ctrl=' . $id_ctrl . '&prix_visite=' . $prix_visite . '&prix_vignette=' . $prix_vignette . '&prix_vignette_pen=' . $prix_vignette_pen . '&etat_fact=' . $etat_fact . '&date_exp_vign=' . $date_exp_vign . '&date_debut_vign=' . $date_debut_vign . '&num_vign=' . $num_vignette . '&id_fact= '. $id_fact .'');


  } else {
    header('Location: ../restriction.php');
  }
}
