<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Widgets</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        // Include config file
        include("nav_bar.php");
        ?>

        <!-- Navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Widgets</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Widgets</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <h5 class="mb-2">Card with Image Overlay</h5>
                    <div class="card card-success">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 col-xl-4">

                                    <a href="#" class="">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top" src="dist/img/photo1.png" alt="Dist Photo 1">
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">Client</h5>
                                                <p class="card-text text-white pb-2 pt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod tempor.</p>
                                                <p class="card-text text-white pb-2 pt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod tempor.</p>

                                            </div>
                                        </div>
                                    </a>

                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="card mb-2">
                                        <img class="card-img-top" src="dist/img/photo2.png" alt="Dist Photo 2">
                                        <div class="card-img-overlay d-flex flex-column justify-content-center">
                                            <h5 class="card-title text-white mt-5 pt-2">Card Title</h5>
                                            <p class="card-text pb-2 pt-1 text-white">
                                                Lorem ipsum dolor sit amet, <br>
                                                consectetur adipisicing elit <br>
                                                sed do eiusmod tempor.
                                            </p>
                                            <a href="#" class="text-white">Last update 15 hours ago</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="card mb-2">
                                        <img class="card-img-top" src="dist/img/photo3.jpg" alt="Dist Photo 3">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title text-primary">Card Title</h5>
                                            <p class="card-text pb-1 pt-1 text-white">
                                                Lorem ipsum dolor <br>
                                                sit amet, consectetur <br>
                                                adipisicing elit sed <br>
                                                do eiusmod tempor. </p>
                                            <a href="#" class="text-primary">Last update 3 days ago</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
        <!-- /.content-wrapper -->



        <?php
        // Include footer file
        include("footer.php");
        ?>


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>