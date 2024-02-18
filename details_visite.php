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


if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 4 || $_SESSION["role"] == 3 || $_SESSION["role"] == 1) ) {
    // Initialize the session
//session_start();

?>

<?php
require_once("api/db_connect.php");

if (isset($_GET["id_vehic"]) && !empty($_GET["id_vehic"])) {

    $id_vehic = $_GET["id_vehic"];
    $query = "SELECT vehicule.id, immatriculation, marque, proprietaire, type_tech, num_serie, id_energie, energie.lib, nb_place, ptac, puiss_fisc, id_genre, genre.lib, date_mise_circul, date_local 
from vehicule left join energie on vehicule.id_energie=energie.id left join genre on vehicule.id_genre=genre.id Where vehicule.id=" . $id_vehic . "";
    $request = $db_PDO->prepare($query);
    $request = $db_PDO->query($query);
    $vehicule = $request->fetch();
} else header('location:dashboard_sup.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TUX AUTO</title>

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

    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" type="text/css" href="src/bootstrap-duallistbox.css">



</head>


<body class="hold-transition sidebar-mini layout-fixed" onload="observation()">

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
                            <h1 class="m-0">Véhicule <?php echo $vehicule["marque"] . " | " . $vehicule["immatriculation"] . " "; ?> <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="modifier" onclick="edit()"><i class="fa fa-edit"></i></button> </h1>

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Visite technique</a></li>
                                <li class="breadcrumb-item active">Véhicule</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content-header -->


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <!-- form start -->
                        <form name="vehicule" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <div class="card-body">


                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Détail fiscal -->

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="inputMarque">Marque du véhicule</label>
                                                <input type="text" class="form-control" id="inputMarque" name="inputMarque" placeholder="Marque du véhicule" value="<?php echo $vehicule["marque"] ?>">
                                            </div>

                                            <div class="form-group">

                                                <div class="row">

                                                    <?php
                                                    if (isset($vehicule["id_genre"]) && !empty($vehicule["id_genre"]) && $vehicule["id_genre"] != null) {

                                                        if ($vehicule["id_genre"] == 1) {
                                                    ?>

                                                            <div class="form-check">
                                                                <div class="col-sm-6">
                                                                    <input class="form-check-input" checked="true" type="radio" id="radio1" name="radio1" value=1 onchange=CalculVignette()>
                                                                    <label class="form-check-label">Transport de personne</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-check">
                                                                <div class="col-sm-6">
                                                                    <input class="form-check-input" type="radio" id="radio2" name="radio1" value=2 onchange=CalculVignette()>
                                                                    <label class="form-check-label">Transport de marchandise</label>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } else if ($vehicule["id_genre"] == 2) {
                                                        ?>
                                                            <div class="form-check">
                                                                <div class="col-sm-6">
                                                                    <input class="form-check-input" type="radio" id="radio1" name="radio1" value=1 onchange=CalculVignette()>
                                                                    <label class="form-check-label">Transport de personne</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-check">
                                                                <div class="col-sm-6">
                                                                    <input class="form-check-input" checked="true" type="radio" id="radio2" name="radio1" value=2 onchange=CalculVignette()>
                                                                    <label class="form-check-label">Transport de marchandise</label>
                                                                </div>
                                                            </div>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="inputPA">Catégorie</label>
                                                <input onchange=CalculVignette() type="text" class="form-control" id="inputCateg" name="inputCateg" placeholder="Categorie" onkeyup=CalculVignette() step=1 min=0 disabled>
                                            </div>


                                            <p id="CalVignette"></p>


                                        </div>

                                        <!-- /.Détail fiscal -->
                                    </div>

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
                                            var rad = document.nVehicule.radio1;
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

                                    <script>
                                        function edit() {
                                            document.getElementById("inputPA").disabled = false;
                                            document.getElementById("inputPTAC").disabled = false;
                                            document.getElementById("inputImmatriculation").disabled = false;
                                            document.getElementById("inputMarque").disabled = false;
                                            document.getElementById("inputTypeTech").disabled = false;
                                            document.getElementById("inputSerie").disabled = false;
                                            document.getElementById("inputMiseCircu").disabled = false;
                                            document.getElementById("inputPuisFiscal").disabled = false;
                                            document.getElementById("inputDateMC").disabled = false;

                                            document.getElementById("radio1").disabled = false;
                                            document.getElementById("radio2").disabled = false;
                                            document.getElementById("radio3").disabled = false;
                                            document.getElementById("radio4").disabled = false;
                                        }
                                    </script>

                                    <div class="col-sm-6">
                                        <!-- Info véhicule -->


                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="inputImmatriculation">Immatriculation</label>
                                                <input type="text" class="form-control" id="inputImmatriculation" name="inputImmatriculation" placeholder="Immatriculation" pattern="" value="<?php echo $vehicule["immatriculation"] ?>">
                                            </div>



                                            <div class="form-group">
                                                <label for="inputTypeTech">Type technique</label>
                                                <input type="text" class="form-control" id="inputTypeTech" name="inputTypeTech" placeholder="Type technique" value="<?php echo $vehicule["type_tech"] ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputSerie">Numéro de série</label>
                                                <input type="text" class="form-control" id="inputSerie" name="inputSerie" placeholder="Numéro de série" value="<?php echo $vehicule["num_serie"] ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputMiseCircu">Date de mise en circulation</label>
                                                <input type="text" class="form-control" id="inputMiseCircu" name="inputMiseCircu" placeholder="Date de mise en circulation">
                                            </div>

                                        </div>

                                        <!-- /.Info véhicule -->
                                    </div>

                                    <div class="card-body">

                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h3 class="card-title">Défaut du vehicule</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="bootstrap-duallistbox-container row moveonselect moveondoubleclick">
                                                                <div class="box1 col-md-6"> <label for="bootstrap-duallistbox-nonselected-list_" style="display: none;"></label> <span class="info-container"> <span class="info">Showing all 7</span> <button type="button" class="btn btn-sm clear1" style="float:right!important;">show all</button> </span> <input class="form-control filter" type="text" placeholder="Filter">
                                                                    <div class="btn-group buttons"> <button type="button" class="btn moveall btn-outline-secondary" title="Move all">&gt;&gt;</button> </div> <select multiple="multiple" id="bootstrap-duallistbox-nonselected-list_" name="_helper1" style="height: 102px;">
                                                                        <option selected="">Alabama</option>
                                                                        <option>Alaska</option>
                                                                        <option>California</option>
                                                                        <option>Delaware</option>
                                                                        <option>Tennessee</option>
                                                                        <option>Texas</option>
                                                                        <option>Washington</option>
                                                                    </select>
                                                                </div>
                                                                <div class="box2 col-md-6"> <label for="bootstrap-duallistbox-selected-list_" style="display: none;"></label> <span class="info-container"> <span class="info">Empty list</span> <button type="button" class="btn btn-sm clear2" style="float:right!important;">show all</button> </span> <input class="form-control filter" type="text" placeholder="Filter">
                                                                    <div class="btn-group buttons"> <button type="button" class="btn removeall btn-outline-secondary" title="Remove all">&lt;&lt;</button> </div> <select multiple="multiple" id="bootstrap-duallistbox-selected-list_" name="_helper2" style="height: 102px;"></select>
                                                                </div>
                                                            </div><select class="duallistbox" multiple="multiple" style="display: none;">
                                                                <option selected="">Alabama</option>
                                                                <option>Alaska</option>
                                                                <option>California</option>
                                                                <option>Delaware</option>
                                                                <option>Tennessee</option>
                                                                <option>Texas</option>
                                                                <option>Washington</option>
                                                            </select>
                                                        </div>
                                                        <!-- /.form-group -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                Visit <a href="https://github.com/istvan-ujjmeszaros/bootstrap-duallistbox#readme">Bootstrap Duallistbox</a> for more examples and information about
                                                the plugin.
                                            </div>
                                        </div>



                                    </div>

                                </div>


                                <!-- /.form start -->


                            </div>

                            <div class="card-footer">
                                <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer véhicule</button>
                                <button type="reset" value="Reset" class="btn btn-danger" onclick="observation()">Annuler</button>
                            </div>
                        </form>

                    </div>





                </div>

        </div><!-- /.container-fluid -->
        </section>
        <!-- /.main content -->



    </div>


    <!-- footer -->
    <?php
    // Include config file
    include("footer.php");
    ?>
    <!-- ./footer -->

    </div>



    <script>
        function observation() {
            document.getElementById("inputPA").disabled = true;
            document.getElementById("inputPTAC").disabled = true;
            document.getElementById("inputImmatriculation").disabled = true;
            document.getElementById("inputMarque").disabled = true;
            document.getElementById("inputTypeTech").disabled = true;
            document.getElementById("inputSerie").disabled = true;
            document.getElementById("inputMiseCircu").disabled = true;
            document.getElementById("inputPuisFiscal").disabled = true;
            document.getElementById("inputDateMC").disabled = true;
            document.getElementById("radio1").disabled = true;
            document.getElementById("radio2").disabled = true;
            document.getElementById("radio3").disabled = true;
            document.getElementById("radio4").disabled = true;
        }
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>



</body>


</html>

<?php                 
}else {
    header('Location: restriction.php');
}
  }
?>