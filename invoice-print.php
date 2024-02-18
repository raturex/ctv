<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body style="font-family:TradeGothic, sans-serif; margin-left:-512px; margin-top:-384px; position:absolute; height:768px; width:1024px; left:50%; top:50%;">

  <div class="wrapper">
    <?php

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
    $prix_visite = $_GET['prix_visite'];
    $prix_vignette = $_GET['prix_vignette'];

    $id_vehicule = $_GET["id_vehicule"];
    $id_ctrl = $_GET["id_ctrl"];
    $age_vehic = $_GET["age_vehic"];
    $etat_fact = $_GET["etat_fact"];
    $id_client = $_GET["id_client"];

    $id_station = $_SESSION["id_station"];
    $id_user = $_SESSION["id_user"];


    require_once("api/db_connect.php");
    //requête
    $sql = "SELECT * FROM station where station.id='" . $id_station . "'";
    // On prépare la requête
    $request = $db_PDO->prepare($sql);
    $request = $db_PDO->query($sql);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $reset = $request->fetch();

    $resp_station = $reset["id_responsable"];
    $station = $reset["nom"];

    require_once("api/db_connect.php");
    //requête
    $sql = "SELECT vehicule.*, energie.lib as energie, categ.categorie as categorie  FROM vehicule left join energie on energie.id = vehicule.id_energie left join categ on categ.id = vehicule.id_categ  where vehicule.id='" . $id_vehicule . "'";
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


    $totalHT = $prix_visite + $_securisation + $_visite_vip;

    $mtTva = $totalHT * $tva;
    $mtTva = round($mtTva, 0, PHP_ROUND_HALF_DOWN);

    $totalTTC = $totalHT + $mtTva + $_timbre;


    $totalPay = $_timbre + $_securisation + $totalTTC + $prix_vignette + $montantPrest;


    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-6">

          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> Actia
                  <small class="float-right">Date: <?php echo date("d / m / Y") ?></small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <b>Immatriculation :</b> <?php echo $immat; ?><br>
                <b>Marque :</b> <?php echo $marque; ?><br>
                <b>N° Chassis :</b> <?php echo $nSerie; ?><br>
                <b>Energie :</b> <?php echo $energie; ?><br>

              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Type :</b><?php echo $typeTech; ?><br>
                <b>Puissance :</b> <?php echo $puisFisc; ?> <b>CV</b><br>
                <b>Date :</b> <?php echo $dateMc; ?><br>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Vignette N° :</b> 2/22/2014<br>
                <b>NCC :</b> 968-34567<br>
                <b>N° certificat </b> <?php echo $_SESSION["id_station"]; ?><br>
              </div>
              <!-- /.col -->

            </div>
            <!-- /.row -->

            <div class="row">

              <!-- /.col -->

              <div class="col-12">

                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <th>DESIGNATION</th>
                      <th>QTE</th>
                      <th>PU. HT</th>
                      <th>MONTANT</th>
                    </thead>

                    <tr>
                      <td>Visite VIP</td>
                      <td><?php echo 1; ?></td>
                      <td><?php echo $_GET['prix_visite']; ?></td>
                      <td><?php echo $_GET['prix_visite'] * 1; ?></td>
                    </tr>
                    <tr>
                      <td>Sécurisation visite</td>
                      <td><?php echo 1; ?></td>
                      <td><?php echo $_securisation; ?></td>
                      <td><?php echo $_securisation * 1; ?></td>
                    </tr>
                    <tr>
                      <td>Vignette - (Non soumis à la TVA)</td>
                      <td><?php echo 1; ?></td>
                      <td><?php echo $prix_vignette; ?></td>
                      <td><?php echo $prix_vignette * 1; ?></td>
                    </tr>
                    <tr>
                      <td>Visite - <?php echo $categorie; ?> </td>
                      <td><?php echo 1; ?></td>
                      <td><?php echo $prix_visite; ?></td>
                      <td><?php echo $prix_visite * 1; ?></td>
                    </tr>


                  </table>
                </div>
              </div>
              <!-- /.col -->

              <div class="col-6">
              </div>


              <div class="col-6">

                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Total HT :</th>
                      <td><?php echo $totalHT; ?></td>
                    </tr>
                    <tr>
                      <th style="width:50%">TVA 18 % :</th>
                      <td><?php echo $mtTva; ?></td>
                    </tr>
                    <tr>
                      <th>Timbre :</th>
                      <td><?php echo $_timbre; ?></td>
                    </tr>
                    <tr>
                      <th>RMC :</th>
                      <td><?php echo $RMC; ?></td>
                    </tr>
                    <tr>
                      <th>TPM :</th>
                      <td><?php echo $TPM; ?></td>
                    </tr>
                    <tr>
                      <th>Total TTC ACTIA :</th>
                      <td><?php echo $totalTTC; ?></td>
                    </tr>
                    <tr>
                      <th>Vignette :</th>
                      <td><?php echo $prix_vignette; ?></td>
                    </tr>
                    <tr>
                      <th>Total :</th>
                      <td><?php echo $totalPay; ?></td>
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
                <form name="nVehicule" action="fact.php" method="post">

                  <input type="hidden" name="id_vehicule" value="<?php echo $id_vehicule; ?>">
                  <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
                  <input type="hidden" name="securisation" value="<?php echo $_securisation; ?>">
                  <input type="hidden" name="timbre" value="<?php echo $_timbre; ?>">
                  <input type="hidden" name="mnt_prest" value="<?php echo $montantPrest; ?>">
                  <input type="hidden" name="id_station" value="<?php echo $id_station; ?>">

                  <input type="hidden" name="id_ctrl" value="<?php echo $id_ctrl; ?>">
                  <input type="hidden" name="etat_fact" value="<?php echo $etat_fact; ?>">
                  <input type="hidden" name="age_vehic" value="<?php echo $age_vehic; ?>">
                  <input type="hidden" name="prix_visite" value="<?php echo $prix_visite; ?>">
                  <input type="hidden" name="prix_vignette" value="<?php echo $prix_vignette; ?>">
                  <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">


                </form>

                
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script -->
  <script>
    window.addEventListener("load", window.print());
  </script>
</body>

</html>