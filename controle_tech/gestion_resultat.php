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

        // Include config file

        $id_user = $_SESSION["id_user"];
        $id_station = $_SESSION["id_station"];

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



        $immatriculation;

        //chargement du fichier resultat .G
        $fich_g = parse_ini_file("758gc01.G", true);

        if ($fich_g != null) {

            $sql1 = "INSERT INTO `res_g` (`id_res`, `id_vehicule`, `0200`, `0509`, `0510`, `0517`, `7805`, `0513`, `crc_0200`, `crc_0509`, `crc_0510`, `crc_0517`, `crc_7805`, `crc_0513`) VALUES ('5', '15',:0200, :0509, :0510, :0517, :7805, :0513 , :crc_0200, :crc_0509, :crc_0510, :crc_0517, :crc_7805, :crc_0513)";
            $query1 = $db_PDO->prepare($sql1);

            $query1->bindValue(':0200', $fich_g['MESURES']['0200']);
            $query1->bindValue(':0509', $fich_g['MESURES']['0509']);
            $query1->bindValue(':0510', $fich_g['MESURES']['0510']);
            $query1->bindValue(':0517', $fich_g['MESURES']['0517']);
            $query1->bindValue(':7805', $fich_g['MESURES']['7805']);
            $query1->bindValue(':0513', $fich_g['MESURES']['0513']);
            $query1->bindValue(':crc_0200', $fich_g['CRC']['0200']);
            $query1->bindValue(':crc_0509', $fich_g['CRC']['0509']);
            $query1->bindValue(':crc_0510', $fich_g['CRC']['0510']);
            $query1->bindValue(':crc_0517', $fich_g['CRC']['0517']);
            $query1->bindValue(':crc_7805', $fich_g['CRC']['7805']);
            $query1->bindValue(':crc_0513', $fich_g['CRC']['0513']);
            $query1->execute();
        } else {
            //
        }


        //chargement du fichier resultat .F
        $fich_f = parse_ini_file("758gc01.F", true);

        if ($fich_f != null) {

            //$sql = 'INSERT INTO res_g([0200],"0509","0510","0517","7805","0513") VALUES (:0200, :0509, :0510, :0517, :7805, :0513)';

            $sql2 = "INSERT INTO `res_f` (`id_res`, `id_vehicule`,`0200`, `0420`,	`0421`,	`0422`,	`0423`,	`0424`,	`0425`,	`0426`,	`0427`,	`0430`,	`0431`,	`0434`,	`0435`,	`0438`,	`0439`,	`0442`,	`0443`,	`0446`,	`0447`,	`0448`,	`0449`,	`1128`,	`1228`,	`0450`,	`0460`,	`0461`,	`0462`,	`0465`,	`0466`,	`0468`,	`0469`,	`0470`,`crc_0200`,	`crc_0420`,	`crc_0421`,	`crc_0422`,	`crc_0423`,	`crc_0424`,	`crc_0425`,	`crc_0426`,	`crc_0427`,	`crc_0430`,	`crc_0431`,	`crc_0434`,	`crc_0435`,	`crc_0438`,	`crc_0439`,	`crc_0442`,	`crc_0443`,	`crc_0446`,	`crc_0447`,	`crc_0448`,	`crc_0449`,	`crc_1128`,	`crc_1228`,	`crc_0450`,	`crc_0460`,	`crc_0461`,	`crc_0462`,	`crc_0465`,	`crc_0466`,	`crc_0468`,	`crc_0469`,	`crc_0470`) VALUES ('5', '15',:0200,:0420,:0421,:0422,:0423,:0424,:0425,:0426,:0427,:0430,:0431,:0434,:0435,:0438,:0439,:0442,:0443,:0446,:0447,:0448,:0449,:1128,:1228,:0450,:0460,:0461,:0462,:0465,:0466,:0468,:0469,:0470,:crc_0200,:crc_0420,:crc_0421,:crc_0422, :crc_0423,:crc_0424, :crc_0425, :crc_0426,:crc_0427,:crc_0430,:crc_0431,:crc_0434,:crc_0435	,:crc_0438,:crc_0439,:crc_0442,:crc_0443,:crc_0446,:crc_0447,:crc_0448,:crc_0449,:crc_1128,:crc_1228,:crc_0450,:crc_0460,:crc_0461,:crc_0462,:crc_0465,:crc_0466,:crc_0468,:crc_0469,:crc_0470)";
            $query2 = $db_PDO->prepare($sql2);

            $query2->bindValue(':0200',    $fich_f['MESURES']['0200']);
            $query2->bindValue(':0420',    $fich_f['MESURES']['0420']);
            $query2->bindValue(':0421',    $fich_f['MESURES']['0421']);
            $query2->bindValue(':0422',    $fich_f['MESURES']['0422']);
            $query2->bindValue(':0423',    $fich_f['MESURES']['0423']);
            $query2->bindValue(':0424',    $fich_f['MESURES']['0424']);
            $query2->bindValue(':0425',    $fich_f['MESURES']['0425']);
            $query2->bindValue(':0426',    $fich_f['MESURES']['0426']);
            $query2->bindValue(':0427',    $fich_f['MESURES']['0427']);
            $query2->bindValue(':0430',    $fich_f['MESURES']['0430']);
            $query2->bindValue(':0431',    $fich_f['MESURES']['0431']);
            $query2->bindValue(':0434',    $fich_f['MESURES']['0434']);
            $query2->bindValue(':0435',    $fich_f['MESURES']['0435']);
            $query2->bindValue(':0438',    $fich_f['MESURES']['0438']);
            $query2->bindValue(':0439',    $fich_f['MESURES']['0439']);
            $query2->bindValue(':0442',    $fich_f['MESURES']['0442']);
            $query2->bindValue(':0443',    $fich_f['MESURES']['0443']);
            $query2->bindValue(':0446',    $fich_f['MESURES']['0446']);
            $query2->bindValue(':0447',    $fich_f['MESURES']['0447']);
            $query2->bindValue(':0448',    $fich_f['MESURES']['0448']);
            $query2->bindValue(':0449',    $fich_f['MESURES']['0449']);
            $query2->bindValue(':1128',    $fich_f['MESURES']['1128']);
            $query2->bindValue(':1228',    $fich_f['MESURES']['1228']);
            $query2->bindValue(':0450',    $fich_f['MESURES']['0450']);
            $query2->bindValue(':0460',    $fich_f['MESURES']['0460']);
            $query2->bindValue(':0461',    $fich_f['MESURES']['0461']);
            $query2->bindValue(':0462',    $fich_f['MESURES']['0462']);
            $query2->bindValue(':0465',    $fich_f['MESURES']['0465']);
            $query2->bindValue(':0466',    $fich_f['MESURES']['0466']);
            $query2->bindValue(':0468',    $fich_f['MESURES']['0468']);
            $query2->bindValue(':0469',    $fich_f['MESURES']['0469']);
            $query2->bindValue(':0470', $fich_f['MESURES']['0470']);
            $query2->bindValue(':crc_0200',    $fich_f['CRC']['0200']);
            $query2->bindValue(':crc_0420',    $fich_f['CRC']['0420']);
            $query2->bindValue(':crc_0421', $fich_f['CRC']['0421']);
            $query2->bindValue(':crc_0422',    $fich_f['CRC']['0422']);
            $query2->bindValue(':crc_0423',    $fich_f['CRC']['0423']);
            $query2->bindValue(':crc_0424',    $fich_f['CRC']['0424']);
            $query2->bindValue(':crc_0425',    $fich_f['CRC']['0425']);
            $query2->bindValue(':crc_0426',    $fich_f['CRC']['0426']);
            $query2->bindValue(':crc_0427',    $fich_f['CRC']['0427']);
            $query2->bindValue(':crc_0430',    $fich_f['CRC']['0430']);
            $query2->bindValue(':crc_0431',    $fich_f['CRC']['0431']);
            $query2->bindValue(':crc_0434',    $fich_f['CRC']['0434']);
            $query2->bindValue(':crc_0435',    $fich_f['CRC']['0435']);
            $query2->bindValue(':crc_0438',    $fich_f['CRC']['0438']);
            $query2->bindValue(':crc_0439',    $fich_f['CRC']['0439']);
            $query2->bindValue(':crc_0442',    $fich_f['CRC']['0442']);
            $query2->bindValue(':crc_0443',    $fich_f['CRC']['0443']);
            $query2->bindValue(':crc_0446',    $fich_f['CRC']['0446']);
            $query2->bindValue(':crc_0447',    $fich_f['CRC']['0447']);
            $query2->bindValue(':crc_0448',    $fich_f['CRC']['0448']);
            $query2->bindValue(':crc_0449',    $fich_f['CRC']['0449']);
            $query2->bindValue(':crc_1128',    $fich_f['CRC']['1128']);
            $query2->bindValue(':crc_1228',    $fich_f['CRC']['1228']);
            $query2->bindValue(':crc_0450',    $fich_f['CRC']['0450']);
            $query2->bindValue(':crc_0460',    $fich_f['CRC']['0460']);
            $query2->bindValue(':crc_0461',    $fich_f['CRC']['0461']);
            $query2->bindValue(':crc_0462',    $fich_f['CRC']['0462']);
            $query2->bindValue(':crc_0465',    $fich_f['CRC']['0465']);
            $query2->bindValue(':crc_0466',    $fich_f['CRC']['0466']);
            $query2->bindValue(':crc_0468',    $fich_f['CRC']['0468']);
            $query2->bindValue(':crc_0469',    $fich_f['CRC']['0469']);
            $query2->bindValue(':crc_0470', $fich_f['CRC']['0470']);

            $query2->execute();
        }



        $fich_o = parse_ini_file("758gc01.O", true);

        if ($fich_o != null) {

            $sql3 = "INSERT INTO `res_o` (`id_res`, `id_vehicule`, `0538`, `0543`,	`crc_0538`,	`crc_0543`) VALUES ('5', '15',:0538,:0543,:crc_0538,:crc_0543)";
            $query3 = $db_PDO->prepare($sql3);

            $query3->bindValue(':0538', $fich_o['MESURES']['0538']);
            $query3->bindValue(':0543', $fich_o['MESURES']['0543']);
            $query3->bindValue(':crc_0538', $fich_o['CRC']['0538']);
            $query3->bindValue(':crc_0543', $fich_o['CRC']['0543']);

            $query3->execute();
        } else {
            //
        }



        $fich_p = parse_ini_file("758gc01.P", true);

        if ($fich_p != null) {

            $sql4 = "INSERT INTO `res_p` (`id_res`, `id_vehicule`, `0494`,	`7703`,	`0491`,	`7704`,	`7708`,	`0493`,	`7709`,	`7723`,	`7721`,	`7724`,	`7728`,	`7726`,	`7729`, `crc_0494`,	`crc_7703`,	`crc_0491`,	`crc_7704`,	`crc_7708`,	`crc_0493`,	`crc_7709`,	`crc_7723`,	`crc_7721`,	`crc_7724`,	`crc_7728`,	`crc_7726`,	`crc_7729`
        ) VALUES ('5', '15',:0494	,:7703	,:0491	,:7704	,:7708	,:0493	,:7709	,:7723	,:7721	,:7724	,:7728	,:7726	,:7729    ,:crc_0494,:crc_7703	,:crc_0491	,:crc_7704	,:crc_7708	,:crc_0493	,:crc_7709	,:crc_7723	,:crc_7721	,:crc_7724	,:crc_7728	,:crc_7726	,:crc_7729)";
            $query4 = $db_PDO->prepare($sql4);

            $query4->bindValue(':0494', $fich_p['MESURES']['0494']);
            $query4->bindValue(':7703', $fich_p['MESURES']['7703']);
            $query4->bindValue(':0491', $fich_p['MESURES']['0491']);
            $query4->bindValue(':7704', $fich_p['MESURES']['7704']);
            $query4->bindValue(':7708', $fich_p['MESURES']['7708']);
            $query4->bindValue(':0493', $fich_p['MESURES']['0493']);
            $query4->bindValue(':7709', $fich_p['MESURES']['7709']);
            $query4->bindValue(':7723', $fich_p['MESURES']['7723']);
            $query4->bindValue(':7721', $fich_p['MESURES']['7721']);
            $query4->bindValue(':7724', $fich_p['MESURES']['7724']);
            $query4->bindValue(':7728', $fich_p['MESURES']['7728']);
            $query4->bindValue(':7726', $fich_p['MESURES']['7726']);
            $query4->bindValue(':7729', $fich_p['MESURES']['7729']);
            $query4->bindValue(':crc_0494', $fich_p['CRC']['0494']);
            $query4->bindValue(':crc_7703', $fich_p['CRC']['7703']);
            $query4->bindValue(':crc_0491', $fich_p['CRC']['0491']);
            $query4->bindValue(':crc_7704', $fich_p['CRC']['7704']);
            $query4->bindValue(':crc_7708', $fich_p['CRC']['7708']);
            $query4->bindValue(':crc_0493', $fich_p['CRC']['0493']);
            $query4->bindValue(':crc_7709', $fich_p['CRC']['7709']);
            $query4->bindValue(':crc_7723', $fich_p['CRC']['7723']);
            $query4->bindValue(':crc_7721', $fich_p['CRC']['7721']);
            $query4->bindValue(':crc_7724', $fich_p['CRC']['7724']);
            $query4->bindValue(':crc_7728', $fich_p['CRC']['7728']);
            $query4->bindValue(':crc_7726', $fich_p['CRC']['7726']);
            $query4->bindValue(':crc_7729', $fich_p['CRC']['7729']);

            $query4->execute();
        } else {
            //
        }
    }
};
