<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
   header("location: ../login.php");
   exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

   require_once('../api/db_connect.php');

   //$sql = 'select * from role where role.id= $_SESSION["role"]';

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


   if (isset($_SESSION["role"]) && ($_SESSION["role"] == 6 || $_SESSION["role"] == 7 || $_SESSION["role"] == 1)) {
      // Initialize the session
      //session_start();



      $id_fact = $_GET['id_factur'];


      require_once("../api/db_connect.php");
      //requête
      $sql = "SELECT
   DATE_FORMAT(facturation.date,'%d-%m-%Y') AS date,
   station.ville AS station,
   vehicule.id AS id,
   vehicule.immatriculation AS immat,
   vehicule.marque AS marque,
   vignette.exp AS exp,
   vehicule.num_serie AS num_serie,
   vehicule.type_tech AS type_tech,
   energie.lib AS energie,
   vehicule.puiss_fisc AS puiss_fisc,
   vehicule.nb_place AS nb_place,
   genre.lib AS genre,
   categ.categorie AS categ,
   vehicule.date_mise_circul AS date_mise_circ,
   facturation.prix_visite AS prix_visite,
   facturation.prix_vignette AS prix_vignette,
   station.id_responsable AS responsable,
   user.nom As nom_responsable,
   controle.kilometrage AS km,
   vignette.numero AS nvignette
FROM
   facturation
LEFT JOIN controle ON controle.id_facturation = facturation.id
LEFT JOIN vehicule ON facturation.id_vehicule = vehicule.id
LEFT JOIN energie ON vehicule.id_energie = energie.id
LEFT JOIN genre ON genre.id = vehicule.id_genre
LEFT JOIN categ ON categ.id = vehicule.id_categ
LEFT JOIN user ON user.id = facturation.id_user
LEFT JOIN vignette ON vignette.id_facturation = facturation.id
LEFT JOIN station ON user.id_station = station.id

WHERE
    facturation.id = '" . $id_fact . "'";

      /* exp.
   vignette
   nom_responsable
   nom_
   */

      // On prépare la requête
      $request = $db_PDO->prepare($sql);
      $request = $db_PDO->query($sql);
      // On exécute la requête
      $request->execute();
      // On stocke le résultat dans un tableau associatif
      $reset = $request->fetch();

      $Date = $reset['date'];
      $Station = $reset['station'];
      $Immatriculation = $reset['immat'];
      $Marque = $reset['marque'];
      $Expiration = $reset['exp'];
      $Nserie = $reset['num_serie'];
      $Type = $reset['type_tech'];
      $Energie = $reset['energie'];
      $Puissancefisc = $reset['puiss_fisc'];
      $Datemc = $reset['date_mise_circ'];
      //$Ncc= $reset['ncc'];
      $Ncc = '';
      $Nvignette =   $reset['nvignette'];
      $CFAvisite = $reset['prix_visite'];
      $QR = '';
      $CAT =   $reset['categ'];
      $KMS =   $reset['km'];
      $Mtt_vignette = $reset['prix_vignette'];
      $Responsable =   $reset['responsable'];
      //$Nom_Responsable =   $reset['nom_responsable'];

      require_once("../api/db_connect.php");
      //requête
      $sql = "SELECT id, nom, prenoms, id_station FROM user where id =" . $Responsable . "";


      // On prépare la requête
      $request = $db_PDO->prepare($sql);
      $request = $db_PDO->query($sql);
      // On exécute la requête
      $request->execute();
      // On stocke le résultat dans un tableau associatif
      $reset = $request->fetch();

      $Nom_Responsable = $reset['nom'];




      //$Observation= $reset['obs'];
      $Observation = 'RAS';
      $list = array(
         //array('Date', 'Station', 'Immatriculation', 'Marque', 'Expiration', 'Nserie', 'Type', 'Energie', 'Puissancefisc', 'Datemc', 'Ncc', 'Nvignette', 'CFAvisite', 'QR', 'CAT', 'KMS' , 'Mtt_vignette', 'Responsable', 'Nom_Responsable', 'Observation'),
         array($Date, $Station, $Immatriculation, $Marque, $Expiration, $Nserie, $Type, $Energie, $Puissancefisc, $Datemc, $Ncc, $Nvignette, $CFAvisite, $QR, $CAT, $KMS, $Mtt_vignette, $Responsable, $Nom_Responsable, $Observation),
      );

      $fp = fopen('../certificat/certificat_auto_final.csv', 'a+');


      foreach ($list as $fields) {


         fputcsv($fp, $fields);
      }


      fclose($fp);

      header('Location: index.php');

      /*
   
   } else if (isset($typeVehicule) && !empty($typeVehicule) && $typeVehicule==1 ) {

      $Date= $_GET['date'];
      $Station= $_GET['station'];
      $Immatriculation= $_GET['immat'];
      $Marque= $_GET['marque'];
      $Expiration= $_GET['exp'];
      $Nserie=$_GET['num_serie'];
      $Type= $_GET['type_tech'];
      $Energie= $_GET['energie'];
      $Puissancefisc= $_GET['puiss_fisc'];
      $Datemc= $_GET['date_mise_circ'];
      $Ncc= $_GET['ncc'];
      $Nvignette=	$_GET['num_vign'];
      $CFAvisite= $_GET['prix_visite'];
      $QR='';
      
      $list = array (
         array('Date', 'Station', 'Immatriculation', 'Marque', 'Expiration', 'Nserie', 'Type', 'Energie', 'Puissancefisc', 'Datemc', 'Ncc', 'Nvignette', 'CFAvisite', 'QR'),
         array($Date, $Station, $Immatriculation, $Marque, $Expiration, $Nserie, $Type, $Energie, $Puissancefisc, $Datemc, $Ncc, $Nvignette, $CFAvisite, $QR),
      );
      
      $fp = fopen('certificat/certif01.csv', 'a+');
      
      
      foreach ($list as $fields) {
      
          fputcsv($fp, $fields);
      
      }
      
      
      fclose($fp);
      
      
      }

*/
   } else {
      header('Location: ../restriction.php');
   }
}
