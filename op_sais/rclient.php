<!DOCTYPE html>
<html>

<head>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../dist/css/adminlte.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>

    <?php
    $search = intval($_GET['q']);

    require_once('../api/db_connect.php');

            $search = $_GET['q'];

            $sql = "SELECT *, client.id as id_client , type_piece.lib AS t_piece  FROM client LEFT JOIN type_piece ON type_piece.id=client.id_piece WHERE num_piece LIKE :search";

            $query = $db_PDO->prepare($sql);

            $query->bindValue(':search', $search . '%'/*, PDO::PARAM_STR*/);

            $query->execute();

    echo '<table id="example1" class="table table-bordered table-striped">
<tr>
<th>  </th>
<th>Nom</th>
<th>Prenoms</th>
<th>Date de Naissance</th>
<th>Tel</th>
<th>Type de la pièce</th>
<th>No de la pièce</th>

</tr>';
        while ($row = $query->fetch()) {

        echo "<tr>";
        //echo "<a href='index.php' target='_blank'>";
        echo '<td><a class="btn bg-warning" href="vehicule.php?id_client='. $row['id_client'] . '">
        <i class="fas fa-user"></i> 
    </a>    </td>';

        echo "<td>" . $row['nom'] . "</td>";
        //echo "</a>";
        echo "<td>" . $row['prenom'] . "</td>";
        echo "<td>" . $row['date_naiss'] . "</td>";
        echo "<td>" . $row['tel'] . "</td>";
        echo "<td>" . $row['t_piece'] . "</td>";
        echo "<td>" . $row['num_piece'] . "</td>";

        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);
    ?>



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
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": false,
                "info": true,

                //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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



</body>

</html>