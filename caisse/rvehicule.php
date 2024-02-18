<?php
$search = intval($_GET['q']);

require_once('../api/db_connect.php');

$seach = $_GET['q'];
$id_client = $_GET['id_client'];


$sql = "SELECT vehicule.id as id, immatriculation, marque, proprietaire, type_tech, nb_place, ptac, puiss_fisc, categorie, num_serie, tp_com, energie.lib as energie, genre.lib as genre FROM vehicule LEFT JOIN energie on energie.id=vehicule.id_energie LEFT JOIN genre on genre.id=vehicule.id_genre WHERE immatriculation LIKE :search;";

$query = $db_PDO->prepare($sql);

$query->bindValue(':search', $search . '%', PDO::PARAM_STR);

$query->execute();

echo '<div class="card"> <table id="example1" class="table table-bordered table-striped">
    <thead>
    <th>  </th>
<th>Imm.</th>
<th>Marque</th>
<th>Proprietaire</th>
<th>Type Tech.</th>
<th>Puiss. Fisc.</th>
<th>Categorie</th>
</thead>
<tbody>
';

while ($row = $query->fetch()) {

    /*
    echo "<tr>";
    echo '<td><a class="btn btn-app bg-warning" href="vehicule.php?id_client='. $row['id_client'] . '">
    <i class="fas fa-"></i> 
    </a>    </td>';*/

    echo '<tr>';
    echo '<td><a class="btn bg-warning" href="nvisite2.php?id_vehicule=' . $row["id"] . '&action=3&id_ctrl=1&id_client=' . $id_client . '">
         <i class="fas fa-car-side"></i> 
         </a></td>';

    echo '<td>' . $row["immatriculation"] . '</td>';
    //echo "</a>";
    echo '<td>' . $row["marque"] . '</td>';
    echo '<td>' . $row["proprietaire"] . '</td>';
    echo '<td>' . $row["type_tech"] . '</td>';
    echo '<td>' . $row["puiss_fisc"] . '</td>';
    echo '<td>' . $row["categorie"] . '</td>';
    echo '<td>' . $row["categorie"] . '</td>';
    echo '</tr>';
}
echo '</tbody>
    </table></div>';
mysqli_close($conn);
?>


<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
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

        var puisFisc, ptac, pA, prixVignette, prixVisite, categ, id_categ;
        var type
        var rad = document.nVehicule.id_genre;
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

        var tp = document.querySelector('input[id="checkTP"]');
        categ = "";
        var affich = "<h6>  Véhicule de catégorie : <b>" + categ + "</b> || Visite Technique :  <b>" + prixVisite + " F CFA </b> || Vignette : <b>" + prixVign + " F CFA </b> </h6>";

        //Type transport de marchandise
        if (rad.value == 1) {

            var inputpatente = document.querySelector('input[id="inputPatente"]');
            document.getElementById("inputPA").value = 0;
            document.getElementById("inputPA").readOnly = true;
            document.getElementById("inputPTAC").readOnly = false;

            tp.checked = false;
            tp.readOnly = true;
            inputpatente.readOnly = true;


            if (ptac == 0) {
                if (puisFisc == 0) {
                    document.getElementById("CalVignette").innerHTML = "Veuillez saisir la puissance fiscale du véhicule ainsi que son PTAC";
                    // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                } else {
                    affich = "Veuillez saisir le PTAC du véhicule";
                }
            } else if (ptac > 0 && ptac <= 3.5) {
                if (puisFisc == 0) {
                    affich = "Veuillez saisir la puissance fiscale du véhicule";
                } else if (puisFisc > 0 && puisFisc <= 7) {
                    categ = "TP01";
                    id_categ = 5;
                    prixVisite = 13100;
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;

                } else if (puisFisc > 7) {
                    categ = "TP02";
                    id_categ = 6;
                    prixVisite = 15500;
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;

                }
            } else if (ptac > 3.5 && ptac < 10 && puisFisc > 0) {
                categ = "TP03";
                id_categ = 7;
                prixVisite = 18000;
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

            } else if (ptac > 10 && puisFisc > 0) {
                categ = "TP04";
                id_categ = 8;
                prixVisite = 20450;
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;
            }


            if (ageVehic > 0 && ageVehic <= 4) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 19000;
                    prixVign = 19000;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 35000;
                    prixVign = 35000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 49000;
                    prixVign = 49000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 96000;
                    prixVign = 96000;

                }

            } else if (ageVehic > 4 && ageVehic <= 10) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 14250;
                    prixVign = 14250;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 26250;
                    prixVign = 26250;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 36750;
                    prixVign = 36750;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 72000;
                    prixVign = 72000;
                }

            } else if (ageVehic > 11) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 13500;
                    prixVign = 13500;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 25000;
                    prixVign = 25000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 30000;
                    prixVign = 30000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 40000;
                    prixVign = 40000;

                }
            }

        } //Type transport de personne
        else if (rad.value == 2) {

            var inputpatente = document.querySelector('input[id="inputPatente"]');
            var inputptac = document.querySelector('input[id="inputPTAC"]');
            var inputptac = document.querySelector('input[id="inputPTAC"]');

            tp.readOnly = false;
            if (rad.value == 2 && tp.checked) {
                inputpatente.readOnly = false;
                inputptac.readOnly = false;


            } else if (rad.value == 2 && !tp.checked) {
                inputpatente.readOnly = true;
                inputptac.readOnly = true;

                inputpatente.value = 0;
                inputptac.value = 0;
            }

            document.getElementById("inputPA").readOnly = false;
            //document.getElementById("inputPTAC").value = 0;
            //document.getElementById("inputPTAC").disabled = true;
            document.getElementById("CalVignette").innerHTML = rad.value;

            if (pA == 0) {
                if (puisFisc == 0) {
                    affich = "Veuillez saisir la puissance fiscale du véhicule ainsi que le nombre de place";
                    // document.getElementById("CalVignette").innerHTML = "Entre le "+dateMC.toString()+" et "+now.toString()+" il y a " +diff.year+" ans, " +diff.day+" jours, "+diff.hour+" heures, "+diff.min+" minutes et "+diff.sec+" secondes";
                } else {
                    affich = "Veuillez saisir le nombre de place du véhicule";

                }

            } else if (pA > 0 && pA <= 9) {
                if (puisFisc == 0) {
                    affich = "Veuillez saisir la puissance fiscale du véhicule";

                } else if (puisFisc > 0 && puisFisc <= 7) {
                    categ = "VL01";
                    id_categ = 1;
                    prixVisite = 13100;
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;

                } else if (puisFisc > 7) {
                    categ = "VL02";
                    id_categ = 2;
                    prixVisite = 15500;
                    document.getElementById("inputCateg").value = categ;
                    document.getElementById("id_categ").value = id_categ;

                }
            } else if (pA > 9 && puisFisc <= 7) {
                affich = "Veuillez ajuster la puissance fiscale du véhicule";

            } else if (pA > 9 && pA <= 25 && puisFisc > 7 && ptac > 3.5) {
                categ = "PL01";
                id_categ = 3;
                prixVisite = 18000;
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;


            } else if (pA >= 17 && pA <= 70 && puisFisc > 7 && ptac >= 3.5) {
                categ = "PL02";
                id_categ = 4;
                prixVisite = 20450;
                document.getElementById("inputCateg").value = categ;
                document.getElementById("id_categ").value = id_categ;

            }

            if (ageVehic > 0 && ageVehic <= 4) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 19000;
                    prixVign = 19000;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 35000;
                    prixVign = 35000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 49000;
                    prixVign = 49000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 96000;
                    prixVign = 96000;

                }

            } else if (ageVehic > 4 && ageVehic <= 10) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 14250;
                    prixVign = 14250;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 26250;
                    prixVign = 26250;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 36750;
                    prixVign = 36750;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 72000;
                    prixVign = 72000;
                }

            } else if (ageVehic > 11) {

                if (puisFisc >= 2 && puisFisc <= 4) {
                    prixVignette = 13500;
                    prixVign = 13500;

                } else if (puisFisc >= 5 && puisFisc <= 7) {
                    prixVignette = 25000;
                    prixVign = 25000;

                } else if (puisFisc >= 8 && puisFisc <= 11) {
                    prixVignette = 30000;
                    prixVign = 30000;

                } else if (puisFisc >= 12 && puisFisc <= 15) {
                    prixVignette = 40000;
                    prixVign = 40000;

                }
            }

        }

        if (ageVehic > 0 && ageVehic <= 4) {

            if (puisFisc >= 2 && puisFisc <= 4) {
                prixVign = 19000;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
                prixVign = 35000;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
                prixVign = 49000;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
                prixVign = 96000;

            }

        } else if (ageVehic > 4 && ageVehic <= 10) {

            if (puisFisc >= 2 && puisFisc <= 4) {
                prixVign = 14250;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
                prixVign = 26250;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
                prixVign = 36750;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
                prixVign = 72000;
            }

        } else if (ageVehic > 11) {

            if (puisFisc >= 2 && puisFisc <= 4) {
                prixVign = 13500;

            } else if (puisFisc >= 5 && puisFisc <= 7) {
                prixVign = 25000;

            } else if (puisFisc >= 8 && puisFisc <= 11) {
                prixVign = 30000;

            } else if (puisFisc >= 12 && puisFisc <= 15) {
                prixVign = 40000;

            }
        }

        //document.getElementById("CalVignette").innerHTML = "<h6>  Véhicule de catégorie : <b>" + categ + "</b> || Visite Technique :  <b>" + prixVisite + " F CFA </b> || Vignette : <b>" + prixVign + " F CFA </b> </h6>";

        document.getElementById("CalVignette").innerHTML = "" + affich;

        var affichCateg = "";
        var affichVTech = "";
        var affichVign = "";

        document.getElementById("prix_visite").value = prixVisite;
        document.getElementById("prix_vignette").value = prixVign;

    }
</script>