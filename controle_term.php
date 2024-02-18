<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  } else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {
  
    require_once('api/db_connect.php');
  
    $sql = 'select * from role where role.id= $_SESSION["role"]';
  
    require_once("api/db_connect.php");
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


if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 3 || $_SESSION["role"] == 6 || $_SESSION["role"] == 1) ) {
    // Initialize the session
//session_start();

?>


<!-- Main content -->

<?php
include "api/db_connect.php";

global $conn;
//$query = "SELECT * FROM visite_tech";
/*$query = "SELECT vehicule.id as id_vehic, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib, nb_place, ptac, puiss_fisc, genre.lib AS type_trans, date_mise_circul, date_local 
                    from vehicule 
                    left join energie on vehicule.id_energie=energie.id 
                    left join genre on vehicule.id_genre=genre.id";*/

$query = "SELECT vehicule.id AS id, etat, facturation.id AS id_factur, immatriculation, marque, proprietaire, type_tech, num_serie, energie.lib AS energie, nb_place, ptac, puiss_fisc, genre.lib AS type_trans, categ.categorie AS categ, date_mise_circul, date_local AS date_immatri, type_ctrl.lib AS type_ctrl, id_client, age_vehi, date
                        FROM
                            vehicule
                        LEFT JOIN `facturation` ON vehicule.id = id_vehicule
                        JOIN energie ON vehicule.id_energie = energie.id
                        JOIN genre ON vehicule.id_genre = genre.id
                        JOIN categ ON vehicule.id_categ = categ.id,
                            type_ctrl
                        WHERE
                            facturation.id_ctrl = type_ctrl.id AND etat = 3
                        ORDER BY
                            id
                        DESC
                            ";


$response = array();
$result = mysqli_query($conn, $query);
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <!-- card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable with default features</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">


                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>N° Immatriculation</th>
                                    <th>Marque</th>
                                    <th>Propriétaire</th>
                                    <th>numero de serie</th>
                                    <th>Type de transport</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $row["immatriculation"];
                                            ?>
                                        </td>
                                        <td>
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
                                            echo $row["type_trans"];
                                            ?>
                                        </td>

                                        <td width="15%">


                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info" href="edit_result.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">Rapport</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="rapport.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">imprimer rapport</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="edit_result.php?id_vehic=<?= $row["id"]; ?>&id_factur=<?= $row["id_factur"]; ?>">Résultat visite</a>
                                                </div>
                                            </div>



                                        </td>


                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>N° Immatriculation</th>
                                    <th>Marque</th>
                                    <th>Propriétaire</th>
                                    <th>numero de serie</th>
                                    <th>Type de transport</th>
                                    <th>Action</th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php                 
}else {
    header('Location: restriction.php');
}
  }
?>