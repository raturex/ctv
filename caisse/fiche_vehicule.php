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
        // Initialize the session
        //session_start();

?>

        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ACTIA SA</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome Icons -->
            <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- JQVMap -->
            <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
            <!-- summernote -->
            <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
            <!-- bs-stepper -->
            <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">


            <script>
                function showResult(str) {
                    if (str.length == 0) {
                        document.getElementById("livesearch").innerHTML = "";
                        document.getElementById("livesearch").style.border = "0px";
                        return;
                    }
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("livesearch").innerHTML = this.responseText;
                            //document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                        }
                    }
                    xmlhttp.open("GET", "rvehicule.php?q=" + str + "& id_client=<?php echo $_GET['id_client']; ?>", true);
                    xmlhttp.send();
                }
            </script>

        </head>


        <body class="hold-transition sidebar-mini layout-fixed">


            <?php
            // Include config file
            include("../nav_bar.php");
            ?>
            <div class="wrapper">
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">

                            <div class="row mb-8">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <h1 class="m-0">Véhicule</h1>
                                    </div><!-- /.col -->

                                    <div class="col-sm-8">
                                        <div class="row">
                                            <form class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Immatriculation" onkeyup="showResult(this.value)" onchange="showResult(this.value)">
                                            </form>
                                            <a class="btn bg-warning" href="nclient.php">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <br>

                                            <div id="livesearch"></div>
                                        </div>
                                    </div><!-- /.col -->


                                </div>

                            </div><!-- /.row -->

                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content-header -->


                    <?php

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {

                        //Véhicule deja enregistré
                        if (isset($_GET['action']) && $_GET['action'] == 3) {

                            if (
                                isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule'])
                                && isset($_GET['id_ctrl']) && !empty($_GET['id_ctrl'])
                                && isset($_GET['id_client']) && !empty($_GET['id_client'])
                            ) {

                                $id_vehicule = strip_tags($_GET['id_vehicule']);
                                $id_client = strip_tags($_GET['id_client']);
                                $id_ctrl = strip_tags($_GET['id_ctrl']);
                                $action = strip_tags($_GET['action']);

                                require_once("../api/db_connect.php");

                                //$sql = "SELECT * FROM vignette LEFT JOIN vehicule on id_vehicule=vehicule.id LEFT JOIN facturation on id_facturation=facturation.id where vehicule.id=$id_vehicule order by vignette.date DESC LIMIT 1";

                                $sql = "SELECT * FROM vehicule join vignette on (vignette.id_vehicule=vehicule.id) join  WHERE vehicule.id=$id_vehicule ";

                                $request = $db_PDO->prepare($sql);
                                $request = $db_PDO->query($sql);
                                // On exécute la requête
                                $request->execute();
                                // On stocke le résultat dans un tableau associatif
                                $vign = $request->fetch();
                                //}


                    ?>

                                <!-- Main content -->
                                <section class="content">
                                    <div class="container-fluid">


                                        <div class="col-md-6">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                    </h3>
                                                    <i class="fa fa-car-side fa-beat-fade" style="color: #fd9f1c;"></i> VEHICULE
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">

                                                    <br>
                                                    <div class="col-md-12" id="livesearch"></div>
                                                </div>
                                                    <div class="row">
                                                        <dt class="col-sm-4">GENRE </dt>
                                                        <dd class="col-sm-8"> <?php echo '' . $vign["id_genre"]; ?> </dd>

                                                        <dt class="col-sm-4">DATE MISE EN CIRCULATION</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["date_mise_circul"]; ?></dd>

                                                        <dt class="col-sm-4">PUISSANCE FISCALE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["puiss_fisc"]; ?></dd>

                                                        <dt class="col-sm-4">ENERGIE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["energie"]; ?></dd>

                                                        <dt class="col-sm-4">PTAC</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["ptac"]; ?></dd>

                                                        <dt class="col-sm-4">PLACE ASSISE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["nb_place"]; ?></dd>

                                                        <dt class="col-sm-4">CATEGORIE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["categorie"]; ?></dd>

                                                        <dt class="col-sm-4">PATENTE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["patente"]; ?></dd>

                                                        <dt class="col-sm-4">IMMATRICULATION</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["immatriculation"]; ?></dd>

                                                        <dt class="col-sm-4">DATE IMMATRICULATION</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["date_local"]; ?></dd>

                                                        <dt class="col-sm-4">MARQUE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["marque"]; ?></dd>

                                                        <dt class="col-sm-4">TYPE TECHNIQUE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["type_tech"]; ?></dd>

                                                        <dt class="col-sm-4">NUMERO DE SERIE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["num_serie"]; ?></dd>

                                                        <dt class="col-sm-4">PROPRIETAIRE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["proprietaire"]; ?></dd>

                                                        <dt class="col-sm-4">EXP. ANCIENNE VIGNETTE</dt>
                                                        <dd class="col-sm-8"><?php echo '' . $vign["exp"]; ?></dd>

                                                    </div>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>

                </div>
                </section>

    <?php
                            }
                        }
                    }
    ?>

            </div>

            </div>



            <?php
            // Include config file
            include("../footer.php");
            ?>


            <!-- jQuery -->
            <script src="../plugins/jquery/jquery.min.js"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
            <script>
                $.widget.bridge('uibutton', $.ui.button)
            </script>
            <!-- InputMask -->
            <script src="../plugins/moment/moment.min.js"></script>
            <script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- ChartJS -->
            <script src="../plugins/chart.js/Chart.min.js"></script>
            <!-- Sparkline -->
            <script src="../plugins/sparklines/sparkline.js"></script>
            <!-- JQVMap -->
            <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
            <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
            <!-- jQuery Knob Chart -->
            <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
            <!-- daterangepicker -->
            <script src="../plugins/moment/moment.min.js"></script>
            <script src="../plugins/daterangepicker/daterangepicker.js"></script>
            <!-- Tempusdominus Bootstrap 4 -->
            <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
            <!-- Summernote -->
            <script src="../plugins/summernote/summernote-bs4.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.js"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js"></script>
            <!-- overlayScrollbars -->
            <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
            <!-- bs-stepper -->
            <script src="../plugins/bs-stepper/js/bs-stepper.min.js"></script>

            <!-- jquery-validation -->
            <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
            <script src="../plugins/jquery-validation/additional-methods.min.js"></script>

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

        </body>

        </html>

<?php
    } else {
        header('Location: ../restriction.php');
    }
}
?>