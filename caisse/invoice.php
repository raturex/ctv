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

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ACTIA SA</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../dist/css/adminlte.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


      <script>
        function imprimer(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents + "</br></br></br></br></br></br></br></br></br></br></br></br></br>" + printContents;
          window.print();
          document.body.innerHTML = originalContents;
        }
      </script>

    </head>


    <body>
      <div class="wrapper">

        <?php
        // Include config file
        include("../nav_bar.php");
        ?>

        <?php

        $id_station = $_SESSION["id_station"];
        $id_user = $_SESSION["id_user"];
        $annee = date("Y");
        $ncc = '';
        $date_fact = date("d / m / Y");
        $totalPay = 0;
        $totalHT = 0;
        $tva = 0.18;
        $RMC = 0;
        $TPM = 0;
        $totalTTC = 0;
        $mtTva = 0;
        $montantPrest = 0;
        $_timbre = 100;
        $_securisation = 424;
        $_visite_vip = 5932;

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


        $id_op = $_GET['id_op'];
        $id_prefact = $_GET['id_prefact'];
        $prix_visite = $_GET['prix_visite'];
        $prix_vignette = $_GET['prix_vignette'];
        $num_vign = $num_vignette;
        $prix_vignette_pen = $_GET['prix_vignette_pen'];
        $id_vehicule = $_GET["id_vehicule"];
        $id_ctrl = $_GET["id_ctrl"];

        $age_vehic = $_GET["age_vehic"];
        $etat_fact = $_GET["etat_fact"];
        $id_client = $_GET["id_client"];

        $date_debut_vign = $_GET["date_debut_vign"];
        $date_exp_vign = $_GET["date_exp_vign"];






        require_once("../api/db_connect.php");
        //requête
        //$sql = "SELECT vehicule.*, energie.lib as energie, categ.categorie as categorie  FROM vehicule left join energie on energie.id = vehicule.id_energie left join categ on categ.id = vehicule.id_categ  where vehicule.id='" . $id_vehicule . "'";
        $sql = "SELECT vehicule.*, energie.lib as energie, categ.categorie as categorie, facturation.date as date, facturation.id_user as agent, facturation.prix_vignette as prix_vignette, facturation.prix_visite as prix_visite FROM vehicule left join facturation on facturation.id_vehicule = vehicule.id left join energie on energie.id = vehicule.id_energie left join categ on categ.id = vehicule.id_categ  where vehicule.id='" . $id_vehicule . "'";

        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vehic = $request->fetch();
        $immat = $vehic["immatriculation"];
        $marque = $vehic["marque"];
        $nSerie = $vehic["num_serie"];
        $dateMc = $vehic["date_mise_circul"];
        $puisFisc = $vehic["puiss_fisc"];
        $typeTech = $vehic["type_tech"];
        $energie = $vehic["energie"];
        $categorie = $vehic["categorie"];
        //$prix_visite = $vehic['prix_visite'];
        //$prix_vignette = $vehic['prix_vignette'];


        $Tprix_vignette = $prix_vignette + $prix_vignette_pen;
        $mprixtTva = ($prix_visite * $tva);
        $mprixtTva = round($mprixtTva, 0, PHP_ROUND_HALF_UP);

        $prix_visiteHT = $prix_visite / 1.18;
        //$prix_visiteHT = floor($prix_visiteHT);
        $prix_visiteHT = round($prix_visiteHT, 0.0, PHP_ROUND_HALF_DOWN);
        $totalHT = ($prix_visiteHT + $_securisation + $_visite_vip);
        $mtTva = $totalHT * $tva;
        //$mtTva = round($mtTva, 0.0, PHP_ROUND_HALF_DOWN);
        $mtTva = floor($mtTva);

        $totalTTC = $totalHT + $mtTva + $_timbre + $RMC + $TPM;

        $totalPay = $totalTTC + $Tprix_vignette;
        //$totalPay = $mprixtTva;




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


        $length = 6;
        $numb = substr(str_repeat(0, $length) . $number, -$length);
        $num_certificat = $numb;

        /*
    $num_vignette;
    require_once("api/db_connect.php");
    //requête
    $sql = "SELECT max(id) as max FROM vignette";
    $request = $db_PDO->prepare($sql);
    $request= $db_PDO->query($sql);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $reset = $request->fetch();
    $number = $reset["max"]+1;

    $length=6;
    $numb = substr(str_repeat(0,$length).$number, - $length);
    $num_vignette=$code_station.''.$annee.''.$numb;
*/

        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Facture N : <?php echo $num_factur ?></h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Facture</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <section class="content">
            <div class="container-fluid">

              <div class="col-sm-12" id="rec">

                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-12">
                      <h3>
                        <i class="fas fa-globe"></i> Actia
                        <small class="float-right">Date: <?php echo $date_fact ?></small>
                      </h3>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                      <h4><b>Immatriculation :</b> <?php echo $immat; ?><br></h4>
                      <h4><b>Marque :</b> <?php echo $marque; ?><br></h4>
                      <h4><b>N° Chassis :</b> <?php echo $nSerie; ?><br></h4>
                      <h4><b>Energie :</b> <?php echo $energie; ?><br></h4>

                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      <h4><b>Type :</b><?php echo $typeTech; ?><br></h4>
                      <h4><b>Puissance :</b> <?php echo $puisFisc; ?> <b>CV</b><br></h4>
                      <h4><b>Date MC :</b> <?php echo $dateMc; ?><br></h4>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      <h4><b>Vignette N° :</b><?php echo $num_vign; ?><br></h4>
                      <h4><b>NCC :<?php //echo $num_vignette; 
                                  ?></h4>
                      <h4><b>N° certificat </b> <?php echo $num_certificat; ?><br></h4>
                    </div>
                    <!-- /.col -->

                  </div>
                  <!-- /.row -->

                  <br>
                  <br>

                  <div class="row">

                    <!-- /.col -->

                    <div class="col-12">

                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <th>
                              <h4>DESIGNATION</h4><br>
                            </th>
                            <th>
                              <h4>QTE</h4><br>
                            </th>
                            <th>
                              <h4>PU. HT</h4><br>
                            </th>
                            <th>
                              <h4>MONTANT</h4><br>
                            </th>
                          </thead>


                          <tr>
                            <td>
                              <h4>Visite VIP</h4>
                            </td>
                            <td>
                              <h4><?php echo 1; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $_visite_vip; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $_visite_vip * 1; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h4>Sécurisation visite
                            </td>
                            </h4>
                            <td>
                              <h4><?php echo 1; ?>
                            </td>
                            </h4>
                            <td>
                              <h4><?php echo $_securisation; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $_securisation * 1; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h4>Vignette - (Non soumis à la TVA)</h4>
                            </td>
                            <td>
                              <h4><?php echo 1; ?>
                            </td>
                            </h4>
                            <td>
                              <h4><?php echo $Tprix_vignette; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $Tprix_vignette * 1; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h4>Visite - <?php echo $categorie; ?> </h4>
                            </td>
                            <td>
                              <h4><?php echo 1; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $prix_visiteHT; ?></h4>
                            </td>
                            <td>
                              <h4><?php echo $prix_visiteHT * 1; ?></h4>
                            </td>
                          </tr>


                        </table>
                      </div>
                    </div>
                    <!-- /.col -->



                    <br>
                    <br>


                    <div class="col-6">

                      <br>
                      <br>
                      <br>

                      <div class="col-md-12">
                        <div class="card bg-success">
                          <div class="card-header">
                            <div class="card-title">
                              <h3>Calculatrice</h3>
                            </div>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body" style="display: block;">

                            <div class="row">
                              <div class="col-sm-6">

                                <div class="form-group">
                                  <label for="sommePercu">
                                    Somme perçu (en F CFA)
                                  </label>
                                  <input required class="form-control form-control-lg" type="number" step="5" min="0" id="sommePercu" onkeyup=CalculMonnaie(1) onchange=CalculMonnaie(1)>
                                </div>
                              </div>

                              <div class="col-sm-6">

                                <div class="form-group">
                                  <label for="sommeRendu">
                                    Somme à rendre (en F CFA)
                                  </label>
                                  <input required class="form-control form-control-lg" type="number" step="5" min="0" id="sommeRendu" onkeyup=CalculMonnaie(2) onchange=CalculMonnaie(2)>
                                </div>
                              </div>
                            </div>

                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>


                    </div>


                    <div class="col-6">

                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:50%">
                              <h4>Total HT :</h4>
                            </th>
                            <td>
                              <h4><?php echo $totalHT; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th style="width:50%">
                              <h4>TVA 18 % :</h4>
                            </th>
                            <td>
                              <h4><?php echo $mtTva; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>Timbre :</h4>
                            </th>
                            <td>
                              <h4><?php echo $_timbre; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>RMC :</h4>
                            </th>
                            <td>
                              <h4><?php echo $RMC; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>TPM :</h4>
                            </th>
                            <td>
                              <h4><?php echo $TPM; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>Total TTC ACTIA :</h4>
                            </th>
                            <td>
                              <h4><?php echo $totalTTC; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>Vignette :</h4>
                            </th>
                            <td>
                              <h4><?php echo $Tprix_vignette; ?></h4>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <h4>Total :</h4>
                            </th>
                            <td>
                              <h2><?php echo $totalPay; ?></h2>
                            </td>
                          </tr>

                        </table>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->




                  <!-- this row will not appear when printing -->
                  <div class="row no-print">
                    <div class="col-12">

                      <form name="invoice" action="fact.php" method="post">

                        <input type="hidden" name="nSerie" value="<?php echo $nSerie; ?>">
                        <input type="hidden" name="id_prefact" value="<?php echo $id_prefact; ?>">
                        <input type="hidden" name="id_vehicule" value="<?php echo $id_vehicule; ?>">
                        <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
                        <input type="hidden" name="securisation" value="<?php echo $_securisation; ?>">
                        <input type="hidden" name="timbre" value="<?php echo $_timbre; ?>">
                        <input type="hidden" name="visite_vip" value="<?php echo $_visite_vip; ?>">

                        <input type="hidden" name="mnt_prest" value="<?php echo $montantPrest; ?>">
                        <input type="hidden" name="id_station" value="<?php echo $id_station; ?>">

                        <input type="hidden" name="id_ctrl" value="<?php echo $id_ctrl; ?>">
                        <input type="hidden" name="etat_fact" value="<?php echo $etat_fact; ?>">
                        <input type="hidden" name="age_vehic" value="<?php echo $age_vehic; ?>">
                        <input type="hidden" name="prix_visite" value="<?php echo $prix_visite; ?>">
                        <input type="hidden" name="prix_vignette" value="<?php echo $prix_vignette; ?>">
                        <input type="hidden" name="prix_vignette_pen" value="<?php echo $prix_vignette_pen; ?>">

                        <input type="hidden" name="id_op" value="<?php echo $id_op; ?>">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="date_fact" value="<?php echo $date_fact; ?>">
                        <input type="hidden" name="date_exp_vign" value="<?php echo $date_exp_vign; ?>">
                        <input type="hidden" name="date_debut_vign" value="<?php echo $date_debut_vign; ?>">

                        <input type="hidden" name="num_certificat" value="<?php echo $num_certificat; ?>">
                        <input type="hidden" name="num_factur" value="<?php echo $num_factur; ?>">
                        <input type="hidden" name="num_vignette" value="<?php echo $num_vign; ?>">
                        <input type="hidden" name="ncc" value="<?php echo $ncc; ?>">

                        <input type="hidden" name="t_ttc_act" value="<?php echo $totalTTC; ?>">
                        <input type="hidden" name="t_to_pay" value="<?php echo $totalPay; ?>">
                        <input type="hidden" name="t__vign" value="<?php echo $Tprix_vignette; ?>">

                        <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Valider le payement</button>
                      </form>

                      <a href="index.php"><button type="button" class="btn btn-danger float-right" style="margin-right: 5px;"></a>
                      Annuler
                      </button>

                      <!--
                    <button onClick="imprimer('rec')" type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-print"></i>  Imprimer le reçu
                    </button>
                    -->



                    </div>
                  </div>
                </div>
                <!-- /.invoice -->
              </div><!-- /.col -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
        // Include footer file
        include("../footer.php");
        ?>
      </div>
      <!-- ./wrapper -->






      <script type="text/javascript">
        function CalculVignette(id) {

          var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
          var type
          var rad = document.nVehicule.id_genre;
          var prev = null;
          var prixVign = 0;
          var prixVisite = 0;

          var dateMC = Date.parse(document.getElementById("inputDateMC").value);
          var now = Date.now();

          var diff = dateDiff(dateMC, now);
          var ageVehic = diff.year + 1;
          document.getElementById("anneeMC").innerHTML = +ageVehic + " ans";

          document.getElementById("age_vehic").value = ageVehic;

          puisFisc = document.getElementById("inputPuisFiscal").value;
          ptac = document.getElementById("inputPTAC").value;
          pA = document.getElementById("inputPA").value;


          //Type transport de marchandise
          if (rad.value == 1) {

            var inputpatente = document.querySelector('input[id="inputPatente"]');
            var tp = document.querySelector('input[id="checkTP"]');
            document.getElementById("inputPA").value = 0;
            document.getElementById("inputPA").readOnly = true;
            document.getElementById("inputPTAC").readOnly = false;
            tp.disabled = true;
            inputpatente.disabled = true;


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
                categ = "TP01";
                id_categ = 5;
                prixVisite = 13100;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 13100 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

              } else if (puisFisc > 7) {
                categ = "TP02";
                id_categ = 6;
                prixVisite = 15500;
                document.getElementById("CalVignette").innerHTML = "Visite Technique: 15500 FCFA  //  Vignette:  ";
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

              }
            } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
              categ = "TP03";
              id_categ = 7;
              prixVisite = 18000;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 18000 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;

            } else if (ptac > 10 && puisFisc > 0) {
              categ = "TP04";
              id_categ = 8;
              prixVisite = 20450;
              document.getElementById("CalVignette").innerHTML = "Visite Technique: 20450 FCFA  //  Vignette:  ";
              document.getElementById("inputCateg").value = categ;
              document.getElementById("id_categ").value = id_categ;
            }



            document.getElementById("CalVignette").innerHTML = "Visite Technique: " + prixVisite + " F CFA  //  Vignette: " + prixVign + " F CFA";
            document.getElementById("prix_visite").value = prixVisite;
            //document.getElementById("prix_vignette").value = prixVignette;
            document.getElementById("prix_vignette").value = prixVign;

          }
      </script>



      <script type="text/javascript">
        function CalculMonnaie(id) {
          var somPercu;
          var somRendu;
          var rendre;
          var montantTTC = <?php echo $totalPay ?>;

          //document.getElementById("rendre").innerHTML = " test01";

          if (id == 1) {

            somPercu = document.getElementById("sommePercu").value;

            somRendu = somPercu - montantTTC;


            document.getElementById("sommePercu").value = somPercu;
            document.getElementById("sommeRendu").value = somRendu;


            document.getElementById("rendre").innerHTML = "id1";

            console.log(montantTTC);
            console.log(somRendu);

          } else if (id == 2) {

            somRendu = document.getElementById("sommeRendu").value;

            somPercu = 0;
            somPercu = (montantTTC * 1 + somRendu * 1);

            document.getElementById("sommePercu").value = somPercu;
            document.getElementById("sommeRendu").value = somRendu;

            document.getElementById("rendre").innerHTML = " id2";

            console.log(montantTTC);
            console.log(somRendu);
            console.log(somPercu);


          }

        }
      </script>


      <!-- jQuery -->
      <script src="../plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../dist/js/adminlte.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="../dist/js/demo.js"></script>
      <!-- DataTables  & Plugins -->
      <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
      <script src="../plugins/jszip/jszip.min.js"></script>
      <script src="../plugins/pdfmake/pdfmake.min.js"></script>
      <script src="../plugins/pdfmake/vfs_fonts.js"></script>
      <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
      <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    </body>

    </html>

<?php
  } else {
    header('Location: ../restriction.php');
  }
}
?>