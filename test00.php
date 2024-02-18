<?php
// Initialize the session
/*session_start();
require_once("api/db_connect.php");

if (isset($_SESSION["n_client"]) && !empty($_SESSION["n_client"])) {

    $id_client = $_SESSION["n_client"];
    //requête
    $sql9 = "SELECT * FROM client where id=$id_client";
    // On prépare la requête
    $request = $db_PDO->prepare($sql9);
    // On exécute la requête
    $request->execute();
    // On stocke le résultat dans un tableau associatif
    $client1 = $request->fetch();

    $id_pid = $client1['id_piece'];
    $nom_client = $client1['nom'];
    $tel_client = $client1['tel'];
    $num_piece_client = $client1['num_piece'];
    $prenom_client = $client1['prenom'];
    $email_Client = $client1['email'];

    header('Location: nvisite.php?id_pid=' . $id_pid . '&id_client=' . $id_client . '&nom_client=' . $nom_client . '&prenom_client=' . $prenom_client . '&num_piece_client=' . $num_piece_client . '');
    exit;
    
} elseif (!isset($_SESSION["n_client"]) || empty($_SESSION["n_client"])) { */ ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACTIA SA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- bs-stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
</head>


<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <?php
        // Include config file
        include("nav_bar.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Contrôle Technique</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Contrôle technique</a></li>
                                <li class="breadcrumb-item active">Nouveau client</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    <div class="card card-warning">

                        <div class="card-header">
                            <h4>
                                <p> Client</p>
                            </h4>
                        </div>

                        <form name="nClient" action="lp.php" method="GET">

                            <div class="card-body">
                                <!-- form start -->
                                <!--<form name="nVehicule" action="insert_vehicule.php" method="POST">-->

                                <!-- piece identite -->
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="inputPid">Pièce d'identité</label>
                                            <select  class="form-control" name="id_pid" id="inputPid">

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
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputNumPiece">Numéro de la pièce</label>
                                            <input  type="text" class="form-control" id="inputNumPiece" name="num_piece_client" placeholder="numero de la pièce">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="inputTelClient">Téléphone</label>
                                            <input type="tel" class="form-control telephone" id="inputTelClient" name="tel_client" placeholder="00-00-00-00-00" minlength="10" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputEmailClient">Email</label>
                                            <input type="email" class="form-control email" id="inputEmailClient" name="email_Client" placeholder="xxx@xx.xx">
                                        </div>
                                    </div>
                                </div>

                                <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="tpcom" name="tpcom" value=1>
                                                            <label class="form-check-label" for="tpcom">Transport en commun</label>
                                                            </label>
                                                        </div>


                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputNom_client">Nom</label>
                                            <input type="text" name="nom_client" class="form-control" id="inputNom_client" placeholder="Nom" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="inputPnom_client">Prénoms</label>
                                            <input  type="text" class="form-control" id="inputPnom_client" name="prenom_client" placeholder="Prénoms" maxlength="50">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="inputdatenaiss">Date de naissance</label>
                                            <input type="date" class="form-control" id="inputdatenaiss" name="datenaiss_client" onchange="DateExp()" onkeyup="DateExp()">
                                        </div>
                                    </div>
                                </div>

                                <!-- /.Détail fiscal -->

                            </div>
                            <div class="card-footer">
                                <button type="submit" value="Submit" class="btn btn-info float-right">Enregistrer client</button>
                                <button type="reset" value="Reset" class="btn btn-danger">Annuler</button>
                            </div>
                        </form>
                    </div>



                    <!-- /.form start -->
                </div>



        </div>



    </div>
    </section>

    </div>

    <?php
    // Include config file
    include("footer.php");
    ?>

    </div>

    <script>
        function DateExp() {
            const date_debut_vign = new  Date.parse(document.getElementById("inputdatenaiss").value);



            document.getElementById("inputPnom_client").value = ""+date_debut_vign;
           // document.getElementById("date_exp_vign_show").innerHTML = date +"****"+date_debut_vign+ "*** "+year+"***";

        }
    </script>



    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
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
    <!-- bs-stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <!-- jquery-validation -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>

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

<?php                    //}
?>