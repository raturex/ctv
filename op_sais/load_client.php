    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        if (
            //!Marque - !energie - !categorie - !age - !date_debut - !date_fin - !type_ctrl
            isset($_GET['q']) && !empty($_GET['q'])
        ) {

            require_once('api/db_connect.php');

            $seach = $_GET['q'];

            $sql = "SELECT *,energie.lib as energie, genre.lib as genre FROM vehicule LEFT JOIN energie on vehicule.id_energie=energie.id LEFT JOIN genre on vehicule.id_genre=genre.id WHERE immatriculation LIKE :seach or num_serie LIKE :seach ;";

            $query = $db_PDO->prepare($sql);

            $query->bindValue(':seach', $seach . '%'/*, PDO::PARAM_STR*/);

            $query->execute();
        }

    ?>




        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expandable Table</h3>
                    </div>
                    <!-- ./card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-widget="expandable-table">
                                    <td>183</td>
                                    <td>John Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Approved</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>219</td>
                                    <td>Alexander Pierce</td>
                                    <td>11-7-2014</td>
                                    <td>Pending</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>657</td>
                                    <td>Alexander Pierce</td>
                                    <td>11-7-2014</td>
                                    <td>Approved</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>175</td>
                                    <td>Mike Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Denied</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>134</td>
                                    <td>Jim Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Approved</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>494</td>
                                    <td>Victoria Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Pending</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>832</td>
                                    <td>Michael Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Approved</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td>Denied</td>
                                    <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                </tr>
                                <tr class="expandable-body d-none">
                                    <td colspan="5">
                                        <p style="display: none;">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>


        <div class="card-body">

            <table id="example1" class="table table-bordered table-hover">


                <thead>
                    <tr>
                        <th>
                            Immat.</th>
                        <th>
                            N série</th>
                        <th>
                            Marque</th>
                        <th>
                            Type_tech</th>
                        <th>
                            Genre</th>
                        <th>
                            Propriétaire</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    //while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    while ($row = $query->fetch()) {
                    ?>

                        <tr data-widget="expandable-table" aria-expanded="true">
                            <td>
                                <?php
                                echo $row["immatriculation"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["num_serie"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["marque"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["type_tech"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["genre"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["proprietaire"];
                                ?>
                            </td>
                        </tr>

                        <tr class="expandable-body">

                            <td>
                                <?php
                                echo $row["energie"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["nb_place"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["ptac"];
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $row["puiss_fisc"];
                                ?>
                            </td>


                            <td>
                                <?php
                                echo $row["date_mise_circul"];
                                ?>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    <?php
    }
    ?>