<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
} else if (isset($_SESSION["loggedin"]) && isset($_SESSION["role"])) {

    require_once('../api/db_connect.php');

    $sql = 'select * from role where role.id= $_SESSION["role"]';

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


    if (isset($_SESSION["role"]) && ($_SESSION["role"] == 6 /*|| $_SESSION["role"] == 7*/ || $_SESSION["role"] == 1)) {
        // Initialize the session
        //session_start();

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

        //$prix_visite = $_GET['prix_visite'];
        //$prix_vignette = $_GET['prix_vignette'];
        //$prix_vignette = 30000;
        $id_vehicule = $_GET["id_vehicule"];

        $id_station = $_SESSION["id_station"];
        $id_user = $_SESSION["id_user"];


        $id_factur = $_GET["id_factur"];



        require_once("../api/db_connect.php");
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

        require_once("../api/db_connect.php");
        //requête
        //$sql = "SELECT vehicule.*, energie.lib as energie, categ.categorie as categorie  FROM vehicule left join energie on energie.id = vehicule.id_energie left join categ on categ.id = vehicule.id_categ  where vehicule.id='" . $id_vehicule . "'";
        $sql = "SELECT vehicule.*, energie.lib as energie, facturation.t_to_pay as t_to_pay, facturation.t_actia as t_actia, facturation.t_vign as t_vign, categ.categorie as categorie, facturation.date as date, facturation.id_user as agent, facturation.prix_vignette as prix_vignette, facturation.prix_visite as prix_visite FROM facturation left join vehicule on facturation.id_vehicule = vehicule.id left join energie on energie.id = vehicule.id_energie left join categ on categ.id = vehicule.id_categ  where facturation.id='" . $id_factur . "'";

        // On prépare la requête
        $request = $db_PDO->prepare($sql);
        $request = $db_PDO->query($sql);
        // On exécute la requête
        $request->execute();
        // On stocke le résultat dans un tableau associatif
        $vehic = $request->fetch();

        $t_to_pay = $vehic["t_to_pay"];
        $t_actia = $vehic["t_actia"];
        $t_vign = $vehic["t_vign"];

        $immat = $vehic["immatriculation"];
        $marque = $vehic["marque"];
        $nSerie = $vehic["num_serie"];
        $dateMc = $vehic["date_mise_circul"];
        $puisFisc = $vehic["puiss_fisc"];
        $typeTech = $vehic["type_tech"];
        $energie = $vehic["energie"];
        $categorie = $vehic["categorie"];
        $prix_visite = $vehic['prix_visite'];
        $prix_vignette = $vehic['prix_vignette'];
        $id_vehicule = $vehic["id"];
        $proprietaire = $vehic["proprietaire"];

        $date = date_create($vehic["date"]);



        $mprixtTva = ($prix_visite * $tva);
        $mprixtTva = round($mprixtTva, 0, PHP_ROUND_HALF_UP);

        $prix_visiteHT = $prix_visite / 1.18;
        //$prix_visiteHT = floor($prix_visiteHT);
        $prix_visiteHT = round($prix_visiteHT, 0.0, PHP_ROUND_HALF_DOWN);
        $totalHT = ($prix_visiteHT + $_securisation + $_visite_vip);
        $mtTva = $totalHT * $tva;
        //$mtTva = round($mtTva, 0.0, PHP_ROUND_HALF_DOWN);
        $mtTva = floor($mtTva);

        $totalTTC = $totalHT + $mtTva + $_timbre + $RMC + $TPM;
        $totalPay = $totalTTC + $prix_vignette;
        //$totalPay = $mprixtTva;

        ?>

        <!DOCTYPE html>
        <!-- Created by pdf2htmlEX (https://github.com/coolwanglu/pdf2htmlex) -->
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta charset="utf-8" />
            <meta name="generator" content="pdf2htmlEX" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <style type="text/css">
                /*! 
 * Base CSS for pdf2htmlEX
 * Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> 
 * https://github.com/coolwanglu/pdf2htmlEX/blob/master/share/LICENSE
 */
                #sidebar {
                    position: absolute;
                    top: 0;
                    left: 0;
                    bottom: 0;
                    width: 250px;
                    padding: 0;
                    margin: 0;
                    overflow: auto
                }

                #page-container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    margin: 0;
                    padding: 0;
                    border: 0
                }

                @media screen {
                    #sidebar.opened+#page-container {
                        left: 250px
                    }

                    #page-container {
                        bottom: 0;
                        right: 0;
                        overflow: auto
                    }

                    .loading-indicator {
                        display: none
                    }

                    .loading-indicator.active {
                        display: block;
                        position: absolute;
                        width: 64px;
                        height: 64px;
                        top: 50%;
                        left: 50%;
                        margin-top: -32px;
                        margin-left: -32px
                    }

                    .loading-indicator img {
                        position: absolute;
                        top: 0;
                        left: 0;
                        bottom: 0;
                        right: 0
                    }
                }

                @media print {
                    @page {
                        margin: 0
                    }

                    html {
                        margin: 0
                    }

                    body {
                        margin: 0;
                        -webkit-print-color-adjust: exact
                    }

                    #sidebar {
                        display: none
                    }

                    #page-container {
                        width: auto;
                        height: auto;
                        overflow: visible;
                        background-color: transparent
                    }

                    .d {
                        display: none
                    }
                }

                .pf {
                    position: relative;
                    background-color: white;
                    overflow: hidden;
                    margin: 0;
                    border: 0
                }

                .pc {
                    position: absolute;
                    border: 0;
                    padding: 0;
                    margin: 0;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                    display: block;
                    transform-origin: 0 0;
                    -ms-transform-origin: 0 0;
                    -webkit-transform-origin: 0 0
                }

                .pc.opened {
                    display: block
                }

                .bf {
                    position: absolute;
                    border: 0;
                    margin: 0;
                    top: 0;
                    bottom: 0;
                    width: 100%;
                    height: 100%;
                    -ms-user-select: none;
                    -moz-user-select: none;
                    -webkit-user-select: none;
                    user-select: none
                }

                .bi {
                    position: absolute;
                    border: 0;
                    margin: 0;
                    -ms-user-select: none;
                    -moz-user-select: none;
                    -webkit-user-select: none;
                    user-select: none
                }

                @media print {
                    .pf {
                        margin: 0;
                        box-shadow: none;
                        page-break-after: always;
                        page-break-inside: avoid
                    }

                    @-moz-document url-prefix() {
                        .pf {
                            overflow: visible;
                            border: 1px solid #fff
                        }

                        .pc {
                            overflow: visible
                        }
                    }
                }

                .c {
                    position: absolute;
                    border: 0;
                    padding: 0;
                    margin: 0;
                    overflow: hidden;
                    display: block
                }

                .t {
                    position: absolute;
                    white-space: pre;
                    font-size: 1px;
                    transform-origin: 0 100%;
                    -ms-transform-origin: 0 100%;
                    -webkit-transform-origin: 0 100%;
                    unicode-bidi: bidi-override;
                    -moz-font-feature-settings: "liga"0
                }

                .t:after {
                    content: ''
                }

                .t:before {
                    content: '';
                    display: inline-block
                }

                .t span {
                    position: relative;
                    unicode-bidi: bidi-override
                }

                ._ {
                    display: inline-block;
                    color: transparent;
                    z-index: -1
                }

                ::selection {
                    background: rgba(127, 255, 255, 0.4)
                }

                ::-moz-selection {
                    background: rgba(127, 255, 255, 0.4)
                }

                .pi {
                    display: none
                }

                .d {
                    position: absolute;
                    transform-origin: 0 100%;
                    -ms-transform-origin: 0 100%;
                    -webkit-transform-origin: 0 100%
                }

                .it {
                    border: 0;
                    background-color: rgba(255, 255, 255, 0.0)
                }

                .ir:hover {
                    cursor: pointer
                }
            </style>
            <style type="text/css">
                /*! 
 * Fancy styles for pdf2htmlEX
 * Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> 
 * https://github.com/coolwanglu/pdf2htmlEX/blob/master/share/LICENSE
 */
                @keyframes fadein {
                    from {
                        opacity: 0
                    }

                    to {
                        opacity: 1
                    }
                }

                @-webkit-keyframes fadein {
                    from {
                        opacity: 0
                    }

                    to {
                        opacity: 1
                    }
                }

                @keyframes swing {
                    0 {
                        transform: rotate(0)
                    }

                    10% {
                        transform: rotate(0)
                    }

                    90% {
                        transform: rotate(720deg)
                    }

                    100% {
                        transform: rotate(720deg)
                    }
                }

                @-webkit-keyframes swing {
                    0 {
                        -webkit-transform: rotate(0)
                    }

                    10% {
                        -webkit-transform: rotate(0)
                    }

                    90% {
                        -webkit-transform: rotate(720deg)
                    }

                    100% {
                        -webkit-transform: rotate(720deg)
                    }
                }

                @media screen {
                    #sidebar {
                        background-color: #2f3236;
                        background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjNDAzYzNmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDBMNCA0Wk00IDBMMCA0WiIgc3Ryb2tlLXdpZHRoPSIxIiBzdHJva2U9IiMxZTI5MmQiPjwvcGF0aD4KPC9zdmc+")
                    }

                    #outline {
                        font-family: Georgia, Times, "Times New Roman", serif;
                        font-size: 13px;
                        margin: 2em 1em
                    }

                    #outline ul {
                        padding: 0
                    }

                    #outline li {
                        list-style-type: none;
                        margin: 1em 0
                    }

                    #outline li>ul {
                        margin-left: 1em
                    }

                    #outline a,
                    #outline a:visited,
                    #outline a:hover,
                    #outline a:active {
                        line-height: 1.2;
                        color: #e8e8e8;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        text-decoration: none;
                        display: block;
                        overflow: hidden;
                        outline: 0
                    }

                    #outline a:hover {
                        color: #0cf
                    }

                    #page-container {
                        background-color: #9e9e9e;
                        background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjOWU5ZTllIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDVMNSAwWk02IDRMNCA2Wk0tMSAxTDEgLTFaIiBzdHJva2U9IiM4ODgiIHN0cm9rZS13aWR0aD0iMSI+PC9wYXRoPgo8L3N2Zz4=");
                        -webkit-transition: left 500ms;
                        transition: left 500ms
                    }

                    .pf {
                        margin: 13px auto;
                        box-shadow: 1px 1px 3px 1px #333;
                        border-collapse: separate
                    }

                    .pc.opened {
                        -webkit-animation: fadein 100ms;
                        animation: fadein 100ms
                    }

                    .loading-indicator.active {
                        -webkit-animation: swing 1.5s ease-in-out .01s infinite alternate none;
                        animation: swing 1.5s ease-in-out .01s infinite alternate none
                    }

                    .checked {
                        background: no-repeat url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3goQDSYgDiGofgAAAslJREFUOMvtlM9LFGEYx7/vvOPM6ywuuyPFihWFBUsdNnA6KLIh+QPx4KWExULdHQ/9A9EfUodYmATDYg/iRewQzklFWxcEBcGgEplDkDtI6sw4PzrIbrOuedBb9MALD7zv+3m+z4/3Bf7bZS2bzQIAcrmcMDExcTeXy10DAFVVAQDksgFUVZ1ljD3yfd+0LOuFpmnvVVW9GHhkZAQcxwkNDQ2FSCQyRMgJxnVdy7KstKZpn7nwha6urqqfTqfPBAJAuVymlNLXoigOhfd5nmeiKL5TVTV+lmIKwAOA7u5u6Lped2BsbOwjY6yf4zgQQkAIAcedaPR9H67r3uYBQFEUFItFtLe332lpaVkUBOHK3t5eRtf1DwAwODiIubk5DA8PM8bYW1EU+wEgCIJqsCAIQAiB7/u253k2BQDDMJBKpa4mEon5eDx+UxAESJL0uK2t7XosFlvSdf0QAEmlUnlRFJ9Waho2Qghc1/U9z3uWz+eX+Wr+lL6SZfleEAQIggA8z6OpqSknimIvYyybSCReMsZ6TislhCAIAti2Dc/zejVNWwCAavN8339j27YbTg0AGGM3WltbP4WhlRWq6Q/btrs1TVsYHx+vNgqKoqBUKn2NRqPFxsbGJzzP05puUlpt0ukyOI6z7zjOwNTU1OLo6CgmJyf/gA3DgKIoWF1d/cIY24/FYgOU0pp0z/Ityzo8Pj5OTk9PbwHA+vp6zWghDC+VSiuRSOQgGo32UErJ38CO42wdHR09LBQK3zKZDDY2NupmFmF4R0cHVlZWlmRZ/iVJUn9FeWWcCCE4ODjYtG27Z2Zm5juAOmgdGAB2d3cBADs7O8uSJN2SZfl+WKlpmpumaT6Yn58vn/fs6XmbhmHMNjc3tzDGFI7jYJrm5vb29sDa2trPC/9aiqJUy5pOp4f6+vqeJ5PJBAB0dnZe/t8NBajx/z37Df5OGX8d13xzAAAAAElFTkSuQmCC)
                    }
                }
            </style>
            <style type="text/css">
                .ff0 {
                    font-family: sans-serif;
                    visibility: hidden;
                }

                @font-face {
                    font-family: ff1;
                    src: url('data:application/font-woff;base64,d09GRgABAAAAABi0AA0AAAAAJMQAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABGRlRNAAABMAAAABoAAAAcyfbIREdERUYAAAFMAAAAHAAAAB4AJwBQT1MvMgAAAWgAAABDAAAAVlWrX45jbWFwAAABrAAAAOQAAAGqaTerm2dhc3AAAAKQAAAACAAAAAj//wADZ2x5ZgAAApgAABFtAAAZtB0kpOFoZWFkAAAUCAAAADAAAAA2G5M4jWhoZWEAABQ4AAAAIAAAACQFowKJaG10eAAAFFgAAADpAAABKI2qDGNsb2NhAAAVRAAAAJYAAACW3+7Zvm1heHAAABXcAAAAHgAAACAAkQBLbmFtZQAAFfwAAAIsAAAE+EUhI7pwb3N0AAAYKAAAAIkAAAC2B2UHnHicY2BgYGQAgour051BdI3qhgYYDQA/8QXKAAB4nGNgZGBg4AFiMSBmYmAEQk8gZgHzGAAGwQB4eJxjYGT8zDiBgZWBgamLaTcDA0MPhGa8z2DIyAQUZWBlZoABBAsIAtJcU4CUAsMXpov/lYEqLzLcBfIZQXIABmAL5AB4nGNgYGBmgGAZBkYGEFgC5DGC+SwMHUBajkEAKMLHoMCgyqDJoM1gxRDGEMlQylDOUMmwgeEBwyuGL///A9WB5DWA8roMDkD5RLj8S5D8/8f/7/+/+//O/9v/r/2/8v/s/zP/T/+f+j/tf9z/UKi9eAAjGwNcESMTkGBCVwDxAtDFDKxsDOwMHJxc3Dy8fPwCgkLCIqJgJWLiEpJS0jKycvIKikrKKqpq6hqaWto6DED3QoCevoGhkbGJqZm5haWVtY2tnb2DoxODM4MLqlVuYNKdwQMm4AmlXQn5gjIAAHQVNL0AAAAB//8AAniclVgJdBtVlq3/S1Jpl7VVafMilVSSZcmyLUuytVi2Nlved8m7nTibkxAMgZBkEhgIAwndhDRk6GaAkEAmkCZ9hjkDnAbOTA/NCfRpoJuGcOhhnTTQzdIwBwIMzLg0v1TeEgJkUknFLv3677373rvvfmFCDP0B5+BTGI6JMAkmx1QYVqu2qnGtVUupgVUG1Fpw7puT7MPPnWRvBYMnnzsJn1pIgVuwAvtKAbALZ7AC8LAQK2BCrKzwBfwaHkZ7lGM05seSGKato0i9jhDRNifjrA8FKRsh0oso0l8XCgbqnYyWBn78B9Y8Ocloe23uPrcFdDjcIZ0EVmv1SSUelzoawN4GfMqh6ab5j+1VQVICqjVk8WN4OO+N7fOTWX/b7qAp0GF1ztgVs5RxtxZfOAzvYz8f8UZvqCezdW17AqZAu9U1bVfyHxdhwZoLNwExfAzhgmn9Ij1J0Uwg+Ov0XrAnfQOEj5389L1HTn3wMb9WV7gJe51fS9HBAOP0o5jyKbQ2dcPOR/7ywamHPvmQW+fCMOiBOkyGfvHr/XpaTwfogB9Im8+eRX+h7qPoX/8a5fcswz4BeuBDuUH29XTZV18BXwt6Xl/4Avs5diWXKwphFkCY+Rcx3OZSCRwyuVshYGQyRq7wqAROudyrFKD9CoXCa2AUnuL2oxDuiSSgUi54BtmCmL3wBXhzMXcYuFhGdCsZAaJ9gbLd3vD2sAvMBpNZu6HdXD5rFM+o4eFberady5p2Dl33wrAvNZte/0REd7Qu+rZdxMe0Ed1a4AGMwDC/miacIb/6YzivvrUDNsSSnQtXc2u86PY88sWMYZUgEAqiCxmlRYRzOU4V0FvB8+xM+h+8laCXNLclLD2b9tZRa6oG6oE9mLw90xyZMYhAsCkxWVW/fru/twYW7btRnL9Ce/sxLA7IxZAYJ1MFAkvR0TZkaAVSAiV+GQ23oSErJuYqJCDnqKqt7XBbYobSTJRqyCvlO6u140plntH2xKemU7g1ZReATqNxuFyRqLI4U6S4qrlSDPpsrkkfIYSajL1qOuSp5NxC+KNcgo8QLlJMi2FWOmANAL8aJd3hR+mlUbzgtgH2D8A2NTbGvnYGx02WI4+EwRF2Szr9R7+/1vfmYmz/ivZANQb0NBH0I8cXXWecoeVQaTcQ2ZTAJrKpgBY88t/GcrI/3CuDA4mJ2SYy1t3vsYAtdJVQLpERcqECEoQbHmg/IQC26kmlYnOzHziT9kZ7zVypBAAA0b8GPgYbsv8OvAMrxXycBwzCTkT4g6FV1cTVKnfhK1ijRRzC4L5y+uYoReDxybmgPR3N7Y57ZoXCgT3Wne02baaUTlZJRVKYKYd3tAEhdYWnrlXQF2rfmAyva9t4aqtI2FsiXDieZmrX2pUNcrma3OnVIUwakScv8/WmteoBDQLWRnAX+94YMLFPwwPhhX+CcYg6woF8fwPVRSmqvgiGCTlfgyFU/ivtVawEHReJc9F7p4hnKq2tGEOQf4oVdsVocB2YFIPuQObKOgPctFs8EOnqs6lm9MZJrQAP2HztFhnc1afC/SZZpze0I4R7cmJirNbazXjW+fHaOUI0E2Saw6aKYZeEMHeUlLTYKWhtJI05q7lFoUiYFTzmlYVz4K1ir6CuoQJkEV56GetFx9GlXdXDvJ/T+rq+UFqNh6c2BOm2eO6aRgZs65z37G6166Ol9h63ABdnzdI2KJT745dleupTm1LhTenZZ7a2Kwg4mXT5h+zqRpFQqbnFreJ8KfISeJnnEO0FzIR/i6mUQp6p7DLFqp/BsKNIWy6ZvEolYI+s/g3ZqCr8FD4JezEl1ooyGyoW0FJY5eD8uBdrDsFBrDwmUL5Wao9/FfxKbzC119p9Eml9JZks6Vq3b3hoetMDB/sTXd4Gv5oAgkA+WqbJpqeavDa932stG4+NXDc8PJOcGMEK80TCH2+Sw2b7f1W5RvI33bP16jXd8zcmnNVaKgcCFZXrMy36Ry+DoLG+Y3/KMzF56LYOP4rFiEDrgsdQbSL4HDRBa/3cPER1hTwGD36aGX1v0/sT7Ou/TSj1UFPyyivw2MIkMDzt7svUY6hmOwvfgC/gCUyP8K7CsJCa7/hlzhJx8Wv1i31vw9XLBE53Jsf3REOgVUf1OkjQkLm/q7RnhlbCn9RaDLXXW6WzNheEdypBTVVnj08hgboWpro3FIezf4wZLFsB+zZbEPQYLJNmCeoxe+FLaEdzBcXjoFangFiFMVRrWuaPj3Vtmz60PqwPd9+R8c7FRwfH0hWbxw4+tHa4rNUyl1l/JOPm6xrFBq9Cscm5XRcjWwxoMYwgl8HOifHHR6fA9Jrn8mpL9JlmM9gX7Y8VXR/I33ViagZOLXwsvC3WdypqLvJ/J7o9izDn5q/eyl1q7g4eYr8BdvZGsIX9COxr+zwLj2XPLK1/HK2XcPOquF5PqzvBZvZjrFBAi95pY3+HFTH4GuXyoeL0VHN8yxQJ5EIUQmjYw66NG45MDIkBuGz2ro3N+sTAnW01cy0jvfb9YA37lAPk+w8qFMdnhstbSzek197bWqX5TWbRF9jC+65FzqjRAEV3ujMHMvk8+0QOHmPfByZUIlH2mcX12P1ofVE/cOtyXAHxc1iA+M6LPlNw6PrVXIfwE+LVHPht0KmwOQdMqvfBU2zsA1DSqmhhFu270DtKDgt0BeNIvAEaJ9SdOZwqe3HLOUBseKsZufGk1bnAnmX/BnS0s4Vl3H+N3hXy71r1yOsK5M6JLO9PGO39IfocZcmKF1sWp/FiI+BcW5AUmiPof3hYLQO4zb8jsTVghLhUM+DbdmU1iZO112xzA9fvBrf/iP0laDmy4cbj7NvIkSf2j44cABkuat7/DLKBJqyfVnObhpgAhyIyRJD6e/unXsvWQGl//tWBKpxAb//8yo1g/oEipMP7JsA192JLWgn+CNX7t7RS4GJaaeLvB9M7+uYPDnVsGtpxTcTRGhm6MuJOROCp+fGb/306MTf141+s7Wu9PDt9fU/zXPvsnt4UV/9FPXACYW3mEFtV/04jXOljW2dP/tqmCPBnbq42mL27adk6c3kDvEsBQvUjY4F2EfsZHGO/IQbN1vUGUdH3e+Ah5DuFOdGUIzg5wJxPmYg7lufbohKHh4wHrrEobh7o3jy0646h9DaHZ8t/bo9WJsIjuyIOkImYsna3VLhm4tA/r+2+fOLmX46XlQjMGRTM3p4UmM9OX9fTwscEcRSTEXOsxLTEVhTfM07aCPSrwkuv+btYYFinbzc6VKPKcl3A6OgfWcOUzOvIMPyZEgRretfVywncvPXuUtNNkwYZZN+A41+2WOiNSMZzmuhL8DSKt6qo95Y2XjXXV7qTWq3zyLbBmQp5s5E5qoI94b6xsCGSHi0VRyy+aysUfU0T40nCmvU0U5YEo1I1blEoJuoZa2tFk1YXsas1tZ1W12zQRQuwou5Gt8+KPM9p3gDHIM+/AD5/Eebb2xce5Ou/A9VUFK3RF3t1qX5QcS6VVkd+val0n0mU/0lN7Bd1GlSd8w8yktusDDjI7ng1or27saPY1wjjWp4jrDS+3DigefqNyU1+PSRDV0ygd//l6NjIMdDF20YcAC08F1hpNe6nuJeKvR3On1k75TLDkvqZtWdBGdj3RHeMWfcEu6fYBzTikOPgU6SZ3NybXLOusH+AU0e8YC8FOmeAIZbFBzjeS+BVPQrFmFNze1M/vrk1pEuOnygBQ8+DoFLVRosEwlgUab0Kxx5niXQbAHS46h9LSh5t2zGIXx5XCyIymQrZTyPMtPA0psMquY4uwrVKbqJaCvF59Z+nNg91CnKwfn5DuGoqlNzmx2UCbdxgGmW0MbomXVkiFqLezLK/z4NcYvL21kow+pucQps2Sga9jevrLGHKbEKYMaiuHgCffP/MA7ergkPXJ7yj6XVtdbrK2AYv1VFZHxxMWCaaR/+2rcGYogY9oblaE88rnAb9FMVjKJ6AuCpYhSnDdyjl1/MFTJ+n58DteUGPANJ9BuNspAYMhTvGqoUCKFA1mMqGnPo47U05VYQAnl54vM8zmNGKBlJT+9trYyLiPwZJVdyk6K+ObPYZGyiTmveFi+8llFsKq0ARWnkQqQv0lcMa5B0BL7IPw+lyR0dElZzcH2d6Yrl9NTr2JDob+Mq9Aw7Z2Z12mTFetjY2eEN7w05/g8rR4zQOWfj6Q/MEdMCXuNpHvIxOwyuDE3EDOgQ9lEulQMjXWmmTG8snwFVXgaNJanvAq0zJ4AFTkvfXBz5E/tqLih+d1tU8cPxQi4HzarOII3FRHO/pEoBUfH5dlGzqvUEvgJ4xqWRdpHok3Lq+GgIoFeqierLXZYjbqpOMDMm0d1ub2D8faQq7ksxOyhjMEmCgJb8/6+sWwBdyRlWLnmj3NW2oNjaUaEgUKxp34D2UY9PSDF3EEo3yleOQOpuHlMtT3etz5/uVJc2MVCSCp9k/OCljLDjOvgPInTq8QaVWmdk3UOxNCMWH4f1ozi9ONie3I7kS8NF83uOS4cAqlzvkAqsMvPtvdonUoRDYpFIH990ALLxc8GGPoz3UmBXDiuffZfpBl017wY52SbLULIB5vwCvzYmPMHIcVMgUDLf5S2lReUVfqQscZrP7IgJBrQjfbpNJ7QrhkjVsEYe3EQ4o91peSRBa2kkgarwPKktvnXvyzOYT3hwKullHn3iW/dNf6h5Dq4vvYUfRTziPHwLq9EIYPU+jIP4X5b+Ge17v9FM8EVDfAfD5aAu60JlsbZ9bLIJkRXWs2+MYHhUTYatYSAxHtWSUlggJMNMd6M6DlFLlNNhaQqPsn4BmvwwEFQqSZM8A27RFElaptAaUEYz3B7yH/LGs8ueimRZ0C2FFq6V00OfKDymULQ6Ua85Wb4wUx4Mj7NuA2q3GUfWoDeybS735BSigvS9Nf5C7Wqq3RLNXJOqnmvrGnZoYU9PhLqt1gk/HEuN3ppjB5JofZ6oTY976dYGKVn9iNFRZ5NYw1CIbJDc5qVWILn8vxA3qi7BrluOh8BXrwtUzwfRorQiRkDpmsowxmoi9NuFWi0WnoTw5NjABBpNTd2acMTHBfg3eGlDpEyZZztMwW1fWYCgl+TjD4BPkQ5EPhepvt3CI63P84nwImZy6ZDpStzbUMlON4xAfwPMcHZbmGH2TzZd1ikXEaaBuVcDe1MxPM86sSJhtal14HdwyRqqaTPIBb3iuxtSsUuuX89lQxOP8fOpXVxEuMMYpSilTlqRtUqEAdI1Fp7IGCTKd1BsNapbla9+JuHUW7eW8UJN8jyIhg02dKrxWbbgWNHsiKT/pDUbUQq+mdKNG2O2J9FJJ2i+Tek0SiW+0w2Uua7a45XLGIJG5UhrdMKPn7GqQ3Vq4ragxQhyvqkmqSOqcGuJ4d2J4715JYykpKKuJV9g6OmCeuiXJ/s+IUJSQA7t9FIiT3D4ZVH9nwbsch4HzhxTqSG7LIneAt7jSdvertZtdujycSzCEUAzeZe/rr+tpU+FTNWlgZs/9DIRlMr0BVHL+oaS/hPY1cxpoSYQsixG6eC5WAVoz2myW4LKKnvYOcwkuNadzd/e2lyqhqrS7F7z75ca6ug1ffZbPxKY/Zy1/Hk9mRt9He0sKNPj90t68KuJ0EV78bmSJ7xinZHpOK4c4oRBPT+zrbCxRB0Kkm/aZCSBErp8NeaRkNQUs7IlnM1qVT9quLGWiJUKxqtiXFqSGmKVzwepvvrnhfWFfHutyaKI2V7tDBxrpyoBW5NLoakiJQwtPNVXY2xkyUsG0OQ2+eo2mlpJ6dGQdJUOsV9Rc8NGi5qr+f6kupOvoS1FeH8zkmn5QfcHyg1wt47xOQP5wOsF+CUpB6yfoH1QLj8zsin+HYgBXH/yWXdcl2eXq9BJsb4pOJ8MwnPhu+1NTRfuIg5F9LtfOH2ZhfMn8d7HxaGw6hcy2fA8rAzFn+v8AH/1DGgAAAHicY2BkAIM1k/Ws4vltvjJwM78A8e9c+nULRv+//F+Z6Q/TRSCXg4EJJAoAoTUQEXicY2BkYGC6+F+ZgYHZ6f/l/zeZ/jAARVCAFwCoOgcveJwtjbFOAkEURc97a2MBJoRCDW6hu6AQpYAGC0KMqyGsHQk/YGHtR0hDRelf+Af+gYUaKNXGxGCMUev1LmGSM2/u3Htn7JflsgttTxBsElqFnij7kH1rEfJA20ZZ5kYkrsShqIuN1dwVHRGLgzzvrzT8ki0PSf1UvVtSW4h36RvpCSlf0tes5RmbkwYRxz6Vfye/vJrb8j6p27f+HzPwI+V3KNgbe94hsXuq3ia2P6oWUfSmdIM+H3T5yR7tWecF/eCERPeJx/LV85by5+pPqNmAktc48xdKNmPdulTy95dvirzzD9CEMnYAAAAAAAAmACYAJgAmAI4ApAC4AM4A2gD2AQQBOAFKAXgBxAHmAiYCcAKEAuADJgNYA74D3gQiBEwEeASQBKQE1gTuBPwFFgU0BUQFdgWaBcwF+AY2BnAGsgbEBugHAgceB14HnAfGCAwIQghkCLgI4gkECTwJWAlkCawJ2goMCk4KlAq6CvYLGgtGC3QLpgvYDCAMXAycDNoAAHicY2BkYGDwYvBgYGUAASYgZmQAiTmA+QwAEYIA3QAAeJytU0tqG0EQfZqRHULAy6Bl7S3Jo0HCyDvZIBC2wVi2N1mNNe3RYGladLcMukTISbIIOUDILUxOkGXIAZLqUqMoIQkkWI26XterelX9GQB7eIsa1r/H2vuAa2hEHwKO8Cz6HHCMbvwq4Doa8ceAd/Ai/hrwLhr1DkfW6s9Z6J1keVxDEr0OOMJe9BhwjGn0JeA6kvhNwDt4GX8KeJf933ACjQVWMChRYAoHQgd9HimaG9zdwoeCUyQyfuAuowFy1ruFYjxmVct6CnO2hBEqTJg1XM/PmXA52pI340FbXVhZKbaK7cMm8jz0mvGa2Po4xdZxlo8kZtaZhbBOvEqinVTNpaOM8T379Cbn9+zdf+7K91aJ6lTyrnlVbrgxo3WkleoVew9CL3prL155yayTPfvoNnCiFytTFlNHnX4/bfq5K/Nhk9IkSWTu0iDXt4rGK+vU3NKommiz0CZzKm/TYDYjkbBklFXmwTvPWTXLqbSkSjdVhjImi5LzjcrJmSxX88zck/bM1vLuL6WorIi16Loq/Wrs2Gkpq/IDVtFSZaKXlTOlsry1Aa5wijMc87nu/3TXF4w0WriUm13ya/F3hMHV6dnxaH/d+oXRrUtVLGcZM78EbvxDlvEHOpTjLuRyUj7WhO2RXPa/tbDOStFjxv/9x5Dyp4KhrtxQm0JR2k7oiP7UKlNpr9VrpUnaedITuJFHZDldy1PsyC5xo4wtdUWddvKU5b4DqrsBf3icbc3LUoEBAEDhDxszjCEKXVYh1y6iNNOycin0lzDGE1g1ti17cP3T2jdz1kfUv12gbZ9RWERUTFxCUkpaxoGsnENH8gqKjp04deZcSVnFhaqauoamlktXrt2Eh1sdXXfu9Tx49OTZi76BYXh69WZsYupd4MOnmS9zC0sra782vm39/AEfpREBAAAA')format("woff");
                }

                .ff1 {
                    font-family: ff1;
                    line-height: 0.942000;
                    font-style: normal;
                    font-weight: normal;
                    visibility: visible;
                }

                @font-face {
                    font-family: ff2;
                    src: url('data:application/font-woff;base64,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')format("woff");
                }

                .ff2 {
                    font-family: ff2;
                    line-height: 0.760254;
                    font-style: normal;
                    font-weight: normal;
                    visibility: visible;
                }

                @font-face {
                    font-family: ff3;
                    src: url('data:application/font-woff;base64,d09GRgABAAAAAApMAA0AAAAAD9wAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABGRlRNAAABMAAAABoAAAAcyfbIREdERUYAAAFMAAAAHAAAAB4AJwAfT1MvMgAAAWgAAABEAAAAVlTKT3tjbWFwAAABrAAAAEoAAAFKwB4m9Gdhc3AAAAH4AAAACAAAAAj//wADZ2x5ZgAAAgAAAATMAAAGQP4s9PtoZWFkAAAGzAAAADAAAAA2Grc5VWhoZWEAAAb8AAAAHwAAACQEuQL2aG10eAAABxwAAABcAAAAZC3bAiNsb2NhAAAHeAAAADQAAAA0EWoS+G1heHAAAAesAAAAHgAAACAAYAAubmFtZQAAB8wAAAIKAAAExUKqaeBwb3N0AAAJ2AAAAHQAAAD8U34fS3icY2BgYGQAgour051BdI3qhgYYDQA/8QXKAAB4nGNgZGBg4AFiMSBmYmAEQgkgZgHzGAAEpgBHeJxjYGR8zziBgZWBgamLaTcDA0MPhGa8z2DIyAQUZWBlZoABRgEGBAhIc00BUgoP5JmO/P8GVHmEgQukBiQHAAx5C994nGNgYGBmgGAZBkYGEHAB8hjBfBYGDSDNBqQZGZgYFB7I//8P5Cs84P7///9j+Z9Q9UDAyMYA5zAyAQkmBlTACLFiOAMA4cYJ8wAAAAAAAf//AAJ4nHVUb2wTZRh/n+f+tWu77na9XqHtSnvrFdcxxm53J4OOZBKDgMYofpCIMgkEiMi2sExhm6uEIWBAJwbi2IgkjjkwIokmi0v8wgfCFz8oJPjBbxo/qMSEGCXp1eeuWyBG2+Rte2/f5/n9fs/v9zKB0Qvu4wLjmMiCLMyijK2RszKnZBVNhmwIZAXuP5hzr96cc0/Dtrmbc7hQ2QinWNX9vgpu5TarQquLrMqQraRagzjJQqyZMUU1OxzbsToLhs7psi6bHVo8DTEprsXVmKYb3s5sQzEkwrKIIkTHZk4kxJ5iSOKHJTmC9ucpObPCDAnur+6POLk/mU3sy6hr0qtm0+nPeiJBauX3e5v6KYyZVJ8Ka6ZRAlPWsaDH1anB04YFwIWG3lub44I4OeEG+YnpA5XdIF1+95pPnRVoecrHzEDVVVPKyln6hDUnPo66v0Hj+3C+/6t+nOyfqP0/Xf0TBvATjyHIulEQ9VzBsOROxzaJne7TFSU5rhH5Ev2GgZ08pp452MiPqIlPy0lJNBAKugitMOIerdfXjaSy0HUxwcP1prwtQWCtO1eC9np552tsieNmwkeTMmV6SyvHLoVxsnK7z8ODLED74/5+hDQ3DSqt6JKumIo+U6qPCrj6+YajL3/Tewwajp413SsX6exuOufxeIN4BFmSzvmIbUs2NDkmPUKJRnarBaClyB//KBK+EIJDycyExqOD3e6VbsBueKG01b11LQyXIhHoOtsknUzUdCK8sIlwSR5u3SJN5T298EQvtvT3V+7UsCerf8GrqBGHrIe9pp0qqQTFsUxVlAhHCRZxpGFyS0oQ8gDNORzhpkdTdZsM51wdQI9pC4BdZ7Z2QV1HWLoMO5ut6wdXJaZCoVEfi9dnG/WhLo6pLhIsge34Zb2Z5Qqi17bD6XTuHu7JO4eSIZw6HYIjcYFPI6aTHHytvNms7DDWfnkVj9dHl69oFyHQ9pMFKwN1Xo88LQM4z2SPiWo7cY0sbxRykqjKer6c6dkPZS6bEbGM89+1Ax5z+6DPQr2+0b3gnUdaDmDU86FCTjZtxXZMTseTaoLjH0Mc23MRo9O/mOBEI5U/ahrniVc/nYl5XvQjJZIjySW++xwZ+uAI3/TkXihDrklEwKh7/mS6MWXjOJxxz9ig18dg18NZ7CX8MZbzEPjlCo9MIK5JSxLRg4LxcxkOc5Dd0BvGVyLhDbF8HlDXuVgA5ys/vJ5PJBwYVrW7p2SE/GZwvn0c7GDwi646rqYVm6FeXC23M2XSxMPw8Dm5RiEHSGQdY6xM+xsHBy2ijSxGOHfQLNOsZYn1EkwSzLOQN0rdoglwlp6TYmnw1YDt3BDPp0vPJgKwEFQEIQXDwQ/PjYa7eNAzIsAJ9972psjyNngxo9fNQGmVACAWw4EPeHTPdZdEQbKhGPF0r1arf7N7OM40xjjLJJwmuTumxenCUxfDA9Zb69c3SoFoILn66XgYpgaGhgbc3zMC4q5QW6oNWollzf836FvK466YlNv/M3+hlo403Dl1eF/q3xkY9pKBN8bd2f8KwUu1gJhs8Y4e9e87Qq/I3h1NUafShaX7WSzC7LL2AJcJy+enx/LKuuLmGTTdzrYGDYrrw/ze51q3PHhnNYWJ/QMhVTw7eJxjYGQAA+6Tsq7x/DZfGbiZX4D4dy79ug2j/////43xC9MRIJeDgQkkCgCbJBCLeJxjYGRgYDry/xuQfPb/PwMD4xcGoAgKkAQAqdgGsgB4nGP8wgAGjL4ggoGBqYRBg+kBELszqDOdZJBlUgCyGxk4mJ4B2VIMrIzfGKQZnzBIM6kwqDKeZmACiqkyqQHFWID6rzGogjDjHwYRRsX//0FqmY4zaAAA0W0RHgAAACYAJgAmACYAXgCAAJgA0ADgAPwBLAE+AXIBpAHEAd4CBAI6AjoCRgJYApoCvgL4AyB4nGNgZGBgkGTQZmBlAAEmIGZkAIk5gPkMAAmCAI8AAHictVOxahtBEH26kx1CgstULqYXOkuHBcadbCLjVkLXn3RjabF0K/buDK4C+YSUId/gKkXKfFeqvFstRoHgwmAJ7b6dmfdmZncE4ARP6GD/+dVxAXdwGmnAEd5F3wKOcRF/DLiL0/hLwEf4EP8M+Jj2P4zsdN9TaOdZLe7gIuoFHOEk+hpwjF30PeAu9T8HfIRP8Y+Aj2n/DUGKAYY4JxqjgMUCSjzDIyrUxFvugluUWNLrsPNr7n0FEs/b8CuYwmCFNT2VPyl3ZezDQeQSDRUN1YRrG6fca7LaSKGucFfqmJDfebYQt1kLX1FOfE+bfeb833v3yq4kVLivSzDnyTz7ZkT7yMpnL2k9C7XYg15a5YbetjbjoxNA0sHwXMaFXajMHqtat5XclkvrdtbltRaJjDcbmZrVuq5kqpW6B29cNltTiqlETb1WJ7k4XRnynRZSu7zQbe7uxbaeg+PdC6mEgtSSeWna06ymsZK8LM6oYn2WpW3K2hmtWPmcjd/gChlR75+nzPyVG64LDoLimo23F6u81prE2c1VNu/tW8hyZ/LFRq9tudQdvVP/2g2JrQimumo2OcHEi9R+d4xQP6sJp1Vw6d/kdeXs2SlG6PtfO/8p/wGY2LKeWLdSSZOBXMpLZdOdjvqjfjpIh292M5mfo4p066dx6LtHpq4ytpRhMnir1H8BICH8ZAAAeJxtzTkSglAURNF3PyqKE45V7OI/nENUyFmGCZnrV0s7tKu6Tngt2Hev1kr7t+JzLFhCIKFHnwEpQ0ZkjJkwZcacnAVLVqzZsE2f3aOO8Spv8i5r2fz0KF2Wcif38iCP8iTP8iIrqb6r7+q7+t68AaBLMRM=')format("woff");
                }

                .ff3 {
                    font-family: ff3;
                    line-height: 0.718000;
                    font-style: normal;
                    font-weight: normal;
                    visibility: visible;
                }

                @font-face {
                    font-family: ff4;
                    src: url('data:application/font-woff;base64,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')format("woff");
                }

                .ff4 {
                    font-family: ff4;
                    line-height: 0.972168;
                    font-style: normal;
                    font-weight: normal;
                    visibility: visible;
                }

                .m1 {
                    transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
                    -ms-transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
                    -webkit-transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
                }

                .m0 {
                    transform: matrix(0.261029, 0.000000, 0.000000, 0.250000, 0, 0);
                    -ms-transform: matrix(0.261029, 0.000000, 0.000000, 0.250000, 0, 0);
                    -webkit-transform: matrix(0.261029, 0.000000, 0.000000, 0.250000, 0, 0);
                }

                .m2 {
                    transform: matrix(0.287582, 0.000000, 0.000000, 0.250000, 0, 0);
                    -ms-transform: matrix(0.287582, 0.000000, 0.000000, 0.250000, 0, 0);
                    -webkit-transform: matrix(0.287582, 0.000000, 0.000000, 0.250000, 0, 0);
                }

                .m3 {
                    transform: matrix(0.317435, 0.000000, 0.000000, 0.250000, 0, 0);
                    -ms-transform: matrix(0.317435, 0.000000, 0.000000, 0.250000, 0, 0);
                    -webkit-transform: matrix(0.317435, 0.000000, 0.000000, 0.250000, 0, 0);
                }

                .v0 {
                    vertical-align: 0.000000px;
                }

                .ls4 {
                    letter-spacing: -3.600000px;
                }

                .ls1 {
                    letter-spacing: -1.200000px;
                }

                .ls2 {
                    letter-spacing: -0.576000px;
                }

                .ls3 {
                    letter-spacing: -0.107324px;
                }

                .ls0 {
                    letter-spacing: 0.000000px;
                }

                .sc_ {
                    text-shadow: none;
                }

                .sc0 {
                    text-shadow: -0.015em 0 transparent, 0 0.015em transparent, 0.015em 0 transparent, 0 -0.015em transparent;
                }

                @media screen and (-webkit-min-device-pixel-ratio:0) {
                    .sc_ {
                        -webkit-text-stroke: 0px transparent;
                    }

                    .sc0 {
                        -webkit-text-stroke: 0.015em transparent;
                        text-shadow: none;
                    }
                }

                .ws3 {
                    word-spacing: -1.968000px;
                }

                .ws6 {
                    word-spacing: -1.911682px;
                }

                .ws5 {
                    word-spacing: -1.678550px;
                }

                .ws0 {
                    word-spacing: 0.000000px;
                }

                .ws4 {
                    word-spacing: 0.107324px;
                }

                .ws2 {
                    word-spacing: 0.576000px;
                }

                .ws1 {
                    word-spacing: 1.200000px;
                }

                .ws7 {
                    word-spacing: 3.600000px;
                }

                ._10 {
                    margin-left: -771.946678px;
                }

                ._d {
                    margin-left: -18.298742px;
                }

                ._2 {
                    margin-left: -15.979974px;
                }

                ._f {
                    margin-left: -14.157772px;
                }

                ._e {
                    margin-left: -12.771556px;
                }

                ._c {
                    margin-left: -10.947048px;
                }

                ._4 {
                    margin-left: -7.817955px;
                }

                ._3 {
                    margin-left: -6.316409px;
                }

                ._5 {
                    margin-left: -4.241158px;
                }

                ._0 {
                    margin-left: -2.768778px;
                }

                ._1 {
                    margin-left: -1.107511px;
                }

                ._8 {
                    width: 1.200000px;
                }

                ._b {
                    width: 2.592000px;
                }

                ._9 {
                    width: 80.256000px;
                }

                ._a {
                    width: 99.123511px;
                }

                ._6 {
                    width: 156.675511px;
                }

                ._7 {
                    width: 336.449158px;
                }

                .fc0 {
                    color: rgb(35, 31, 32);
                }

                .fs7 {
                    font-size: 26.880800px;
                }

                .fs6 {
                    font-size: 34.885600px;
                }

                .fs8 {
                    font-size: 35.345600px;
                }

                .fs2 {
                    font-size: 36.959600px;
                }

                .fs9 {
                    font-size: 40.000000px;
                }

                .fsa {
                    font-size: 46.626400px;
                }

                .fs1 {
                    font-size: 47.522800px;
                }

                .fs3 {
                    font-size: 48.000000px;
                }

                .fs5 {
                    font-size: 53.662000px;
                }

                .fs4 {
                    font-size: 53.986400px;
                }

                .fs0 {
                    font-size: 61.528400px;
                }

                .y13 {
                    bottom: 31.170900px;
                }

                .y0 {
                    bottom: 52.000000px;
                }

                .y12 {
                    bottom: 55.985400px;
                }

                .y2d {
                    bottom: 55.986832px;
                }

                .y2c {
                    bottom: 73.751490px;
                }

                .y11 {
                    bottom: 73.754800px;
                }

                .y2b {
                    bottom: 91.026572px;
                }

                .y10 {
                    bottom: 91.034800px;
                }

                .y2a {
                    bottom: 107.590600px;
                }

                .yf {
                    bottom: 107.594800px;
                }

                .y29 {
                    bottom: 125.588391px;
                }

                .ye {
                    bottom: 125.594800px;
                }

                .y28 {
                    bottom: 142.863472px;
                }

                .yd {
                    bottom: 142.874800px;
                }

                .y27 {
                    bottom: 159.427500px;
                }

                .yc {
                    bottom: 159.434800px;
                }

                .y26 {
                    bottom: 177.425291px;
                }

                .yb {
                    bottom: 177.434800px;
                }

                .y31 {
                    bottom: 225.438826px;
                }

                .y25 {
                    bottom: 225.951717px;
                }

                .y38 {
                    bottom: 225.965200px;
                }

                .y33 {
                    bottom: 226.079939px;
                }

                .y30 {
                    bottom: 246.875314px;
                }

                .y37 {
                    bottom: 246.905200px;
                }

                .y32 {
                    bottom: 247.015193px;
                }

                .y24 {
                    bottom: 247.388204px;
                }

                .y36 {
                    bottom: 267.845200px;
                }

                .y34 {
                    bottom: 267.950446px;
                }

                .y2f {
                    bottom: 268.440024px;
                }

                .y23 {
                    bottom: 268.952914px;
                }

                .y2e {
                    bottom: 288.372810px;
                }

                .y22 {
                    bottom: 288.769134px;
                }

                .y35 {
                    bottom: 288.785200px;
                }

                .y21 {
                    bottom: 288.885700px;
                }

                .y9 {
                    bottom: 314.030800px;
                }

                .y3a {
                    bottom: 349.529200px;
                }

                .y20 {
                    bottom: 349.546200px;
                }

                .y8 {
                    bottom: 349.550800px;
                }

                .y39 {
                    bottom: 368.933200px;
                }

                .y6 {
                    bottom: 368.950200px;
                }

                .ya {
                    bottom: 368.954800px;
                }

                .y7 {
                    bottom: 390.556600px;
                }

                .y1f {
                    bottom: 417.630400px;
                }

                .y1 {
                    bottom: 436.995600px;
                }

                .y1c {
                    bottom: 444.803980px;
                }

                .y5 {
                    bottom: 459.339800px;
                }

                .y1b {
                    bottom: 465.414834px;
                }

                .y1a {
                    bottom: 475.716900px;
                }

                .y19 {
                    bottom: 486.018967px;
                }

                .y18 {
                    bottom: 496.321034px;
                }

                .y17 {
                    bottom: 506.623100px;
                }

                .y16 {
                    bottom: 516.925167px;
                }

                .y1e {
                    bottom: 518.009300px;
                }

                .y4 {
                    bottom: 518.023920px;
                }

                .y15 {
                    bottom: 527.227233px;
                }

                .y1d {
                    bottom: 531.438500px;
                }

                .y3 {
                    bottom: 532.280760px;
                }

                .y14 {
                    bottom: 537.529300px;
                }

                .y2 {
                    bottom: 546.537600px;
                }

                .h9 {
                    height: 19.381057px;
                }

                .h8 {
                    height: 25.152518px;
                }

                .ha {
                    height: 25.484178px;
                }

                .h4 {
                    height: 26.647872px;
                }

                .hb {
                    height: 30.253906px;
                }

                .hc {
                    height: 33.617634px;
                }

                .h5 {
                    height: 34.608000px;
                }

                .h3 {
                    height: 35.642100px;
                }

                .h7 {
                    height: 37.992696px;
                }

                .h6 {
                    height: 38.222371px;
                }

                .h2 {
                    height: 44.361976px;
                }

                .h1 {
                    height: 529.000000px;
                }

                .h0 {
                    height: 595.276000px;
                }

                .w1 {
                    width: 393.500000px;
                }

                .w0 {
                    width: 420.945000px;
                }

                .x0 {
                    left: 15.000000px;
                }

                .x1 {
                    left: 18.435100px;
                }

                .x5 {
                    left: 21.233900px;
                }

                .x4 {
                    left: 22.234400px;
                }

                .xe {
                    left: 34.154800px;
                }

                .x12 {
                    left: 71.705100px;
                }

                .x11 {
                    left: 85.566900px;
                }

                .xf {
                    left: 176.288100px;
                }

                .x10 {
                    left: 190.100600px;
                }

                .xb {
                    left: 229.910400px;
                }

                .xd {
                    left: 236.714400px;
                }

                .x6 {
                    left: 237.794400px;
                }

                .x2 {
                    left: 257.538600px;
                }

                .x13 {
                    left: 258.711934px;
                }

                .xc {
                    left: 264.098400px;
                }

                .x3 {
                    left: 269.538600px;
                }

                .x7 {
                    left: 273.062400px;
                }

                .x8 {
                    left: 278.414400px;
                }

                .x15 {
                    left: 283.878533px;
                }

                .x9 {
                    left: 290.630400px;
                }

                .xa {
                    left: 291.842400px;
                }

                .x1b {
                    left: 295.157000px;
                }

                .x14 {
                    left: 298.251121px;
                }

                .x16 {
                    left: 368.995026px;
                }

                .x1a {
                    left: 369.997494px;
                }

                .x17 {
                    left: 377.446061px;
                }

                .x18 {
                    left: 383.425897px;
                }

                .x19 {
                    left: 395.385569px;
                }

                @media print {
                    .v0 {
                        vertical-align: 0.000000pt;
                    }

                    .ls4 {
                        letter-spacing: -4.800000pt;
                    }

                    .ls1 {
                        letter-spacing: -1.600000pt;
                    }

                    .ls2 {
                        letter-spacing: -0.768000pt;
                    }

                    .ls3 {
                        letter-spacing: -0.143099pt;
                    }

                    .ls0 {
                        letter-spacing: 0.000000pt;
                    }

                    .ws3 {
                        word-spacing: -2.624000pt;
                    }

                    .ws6 {
                        word-spacing: -2.548910pt;
                    }

                    .ws5 {
                        word-spacing: -2.238067pt;
                    }

                    .ws0 {
                        word-spacing: 0.000000pt;
                    }

                    .ws4 {
                        word-spacing: 0.143099pt;
                    }

                    .ws2 {
                        word-spacing: 0.768000pt;
                    }

                    .ws1 {
                        word-spacing: 1.600000pt;
                    }

                    .ws7 {
                        word-spacing: 4.800000pt;
                    }

                    ._10 {
                        margin-left: -1029.262238pt;
                    }

                    ._d {
                        margin-left: -24.398323pt;
                    }

                    ._2 {
                        margin-left: -21.306633pt;
                    }

                    ._f {
                        margin-left: -18.877030pt;
                    }

                    ._e {
                        margin-left: -17.028741pt;
                    }

                    ._c {
                        margin-left: -14.596064pt;
                    }

                    ._4 {
                        margin-left: -10.423940pt;
                    }

                    ._3 {
                        margin-left: -8.421878pt;
                    }

                    ._5 {
                        margin-left: -5.654877pt;
                    }

                    ._0 {
                        margin-left: -3.691704pt;
                    }

                    ._1 {
                        margin-left: -1.476682pt;
                    }

                    ._8 {
                        width: 1.600000pt;
                    }

                    ._b {
                        width: 3.456000pt;
                    }

                    ._9 {
                        width: 107.008000pt;
                    }

                    ._a {
                        width: 132.164682pt;
                    }

                    ._6 {
                        width: 208.900682pt;
                    }

                    ._7 {
                        width: 448.598877pt;
                    }

                    .fs7 {
                        font-size: 35.841067pt;
                    }

                    .fs6 {
                        font-size: 46.514133pt;
                    }

                    .fs8 {
                        font-size: 47.127467pt;
                    }

                    .fs2 {
                        font-size: 49.279467pt;
                    }

                    .fs9 {
                        font-size: 53.333333pt;
                    }

                    .fsa {
                        font-size: 62.168533pt;
                    }

                    .fs1 {
                        font-size: 63.363733pt;
                    }

                    .fs3 {
                        font-size: 64.000000pt;
                    }

                    .fs5 {
                        font-size: 71.549333pt;
                    }

                    .fs4 {
                        font-size: 71.981867pt;
                    }

                    .fs0 {
                        font-size: 82.037867pt;
                    }

                    .y13 {
                        bottom: 41.561200pt;
                    }

                    .y0 {
                        bottom: 69.333333pt;
                    }

                    .y12 {
                        bottom: 74.647200pt;
                    }

                    .y2d {
                        bottom: 74.649109pt;
                    }

                    .y2c {
                        bottom: 98.335321pt;
                    }

                    .y11 {
                        bottom: 98.339733pt;
                    }

                    .y2b {
                        bottom: 121.368762pt;
                    }

                    .y10 {
                        bottom: 121.379733pt;
                    }

                    .y2a {
                        bottom: 143.454134pt;
                    }

                    .yf {
                        bottom: 143.459733pt;
                    }

                    .y29 {
                        bottom: 167.451187pt;
                    }

                    .ye {
                        bottom: 167.459733pt;
                    }

                    .y28 {
                        bottom: 190.484629pt;
                    }

                    .yd {
                        bottom: 190.499733pt;
                    }

                    .y27 {
                        bottom: 212.570001pt;
                    }

                    .yc {
                        bottom: 212.579733pt;
                    }

                    .y26 {
                        bottom: 236.567054pt;
                    }

                    .yb {
                        bottom: 236.579733pt;
                    }

                    .y31 {
                        bottom: 300.585102pt;
                    }

                    .y25 {
                        bottom: 301.268955pt;
                    }

                    .y38 {
                        bottom: 301.286933pt;
                    }

                    .y33 {
                        bottom: 301.439919pt;
                    }

                    .y30 {
                        bottom: 329.167085pt;
                    }

                    .y37 {
                        bottom: 329.206933pt;
                    }

                    .y32 {
                        bottom: 329.353590pt;
                    }

                    .y24 {
                        bottom: 329.850939pt;
                    }

                    .y36 {
                        bottom: 357.126933pt;
                    }

                    .y34 {
                        bottom: 357.267262pt;
                    }

                    .y2f {
                        bottom: 357.920031pt;
                    }

                    .y23 {
                        bottom: 358.603885pt;
                    }

                    .y2e {
                        bottom: 384.497079pt;
                    }

                    .y22 {
                        bottom: 385.025512pt;
                    }

                    .y35 {
                        bottom: 385.046933pt;
                    }

                    .y21 {
                        bottom: 385.180933pt;
                    }

                    .y9 {
                        bottom: 418.707733pt;
                    }

                    .y3a {
                        bottom: 466.038933pt;
                    }

                    .y20 {
                        bottom: 466.061600pt;
                    }

                    .y8 {
                        bottom: 466.067733pt;
                    }

                    .y39 {
                        bottom: 491.910933pt;
                    }

                    .y6 {
                        bottom: 491.933600pt;
                    }

                    .ya {
                        bottom: 491.939733pt;
                    }

                    .y7 {
                        bottom: 520.742133pt;
                    }

                    .y1f {
                        bottom: 556.840533pt;
                    }

                    .y1 {
                        bottom: 582.660800pt;
                    }

                    .y1c {
                        bottom: 593.071974pt;
                    }

                    .y5 {
                        bottom: 612.453067pt;
                    }

                    .y1b {
                        bottom: 620.553112pt;
                    }

                    .y1a {
                        bottom: 634.289201pt;
                    }

                    .y19 {
                        bottom: 648.025289pt;
                    }

                    .y18 {
                        bottom: 661.761378pt;
                    }

                    .y17 {
                        bottom: 675.497467pt;
                    }

                    .y16 {
                        bottom: 689.233556pt;
                    }

                    .y1e {
                        bottom: 690.679067pt;
                    }

                    .y4 {
                        bottom: 690.698560pt;
                    }

                    .y15 {
                        bottom: 702.969645pt;
                    }

                    .y1d {
                        bottom: 708.584667pt;
                    }

                    .y3 {
                        bottom: 709.707680pt;
                    }

                    .y14 {
                        bottom: 716.705733pt;
                    }

                    .y2 {
                        bottom: 728.716800pt;
                    }

                    .h9 {
                        height: 25.841409pt;
                    }

                    .h8 {
                        height: 33.536690pt;
                    }

                    .ha {
                        height: 33.978903pt;
                    }

                    .h4 {
                        height: 35.530495pt;
                    }

                    .hb {
                        height: 40.338542pt;
                    }

                    .hc {
                        height: 44.823513pt;
                    }

                    .h5 {
                        height: 46.144000pt;
                    }

                    .h3 {
                        height: 47.522800pt;
                    }

                    .h7 {
                        height: 50.656928pt;
                    }

                    .h6 {
                        height: 50.963162pt;
                    }

                    .h2 {
                        height: 59.149302pt;
                    }

                    .h1 {
                        height: 705.333333pt;
                    }

                    .h0 {
                        height: 793.701333pt;
                    }

                    .w1 {
                        width: 524.666667pt;
                    }

                    .w0 {
                        width: 561.260000pt;
                    }

                    .x0 {
                        left: 20.000000pt;
                    }

                    .x1 {
                        left: 24.580133pt;
                    }

                    .x5 {
                        left: 28.311867pt;
                    }

                    .x4 {
                        left: 29.645867pt;
                    }

                    .xe {
                        left: 45.539733pt;
                    }

                    .x12 {
                        left: 95.606800pt;
                    }

                    .x11 {
                        left: 114.089200pt;
                    }

                    .xf {
                        left: 235.050800pt;
                    }

                    .x10 {
                        left: 253.467467pt;
                    }

                    .xb {
                        left: 306.547200pt;
                    }

                    .xd {
                        left: 315.619200pt;
                    }

                    .x6 {
                        left: 317.059200pt;
                    }

                    .x2 {
                        left: 343.384800pt;
                    }

                    .x13 {
                        left: 344.949245pt;
                    }

                    .xc {
                        left: 352.131200pt;
                    }

                    .x3 {
                        left: 359.384800pt;
                    }

                    .x7 {
                        left: 364.083200pt;
                    }

                    .x8 {
                        left: 371.219200pt;
                    }

                    .x15 {
                        left: 378.504711pt;
                    }

                    .x9 {
                        left: 387.507200pt;
                    }

                    .xa {
                        left: 389.123200pt;
                    }

                    .x1b {
                        left: 393.542667pt;
                    }

                    .x14 {
                        left: 397.668161pt;
                    }

                    .x16 {
                        left: 491.993369pt;
                    }

                    .x1a {
                        left: 493.329992pt;
                    }

                    .x17 {
                        left: 503.261415pt;
                    }

                    .x18 {
                        left: 511.234530pt;
                    }

                    .x19 {
                        left: 527.180758pt;
                    }
                }
            </style>
            <script>
                /*
 Copyright 2012 Mozilla Foundation 
 Copyright 2013 Lu Wang <coolwanglu@gmail.com>
 Apachine License Version 2.0 
*/
                (function() {
                    function b(a, b, e, f) {
                        var c = (a.className || "").split(/\s+/g);
                        "" === c[0] && c.shift();
                        var d = c.indexOf(b);
                        0 > d && e && c.push(b);
                        0 <= d && f && c.splice(d, 1);
                        a.className = c.join(" ");
                        return 0 <= d
                    }
                    if (!("classList" in document.createElement("div"))) {
                        var e = {
                            add: function(a) {
                                b(this.element, a, !0, !1)
                            },
                            contains: function(a) {
                                return b(this.element, a, !1, !1)
                            },
                            remove: function(a) {
                                b(this.element, a, !1, !0)
                            },
                            toggle: function(a) {
                                b(this.element, a, !0, !0)
                            }
                        };
                        Object.defineProperty(HTMLElement.prototype, "classList", {
                            get: function() {
                                if (this._classList) return this._classList;
                                var a = Object.create(e, {
                                    element: {
                                        value: this,
                                        writable: !1,
                                        enumerable: !0
                                    }
                                });
                                Object.defineProperty(this, "_classList", {
                                    value: a,
                                    writable: !1,
                                    enumerable: !1
                                });
                                return a
                            },
                            enumerable: !0
                        })
                    }
                })();
            </script>
            <script>
                (function() {
                    /*
                     pdf2htmlEX.js: Core UI functions for pdf2htmlEX 
                     Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> and other contributors 
                     https://github.com/coolwanglu/pdf2htmlEX/blob/master/share/LICENSE 
                    */
                    var pdf2htmlEX = window.pdf2htmlEX = window.pdf2htmlEX || {},
                        CSS_CLASS_NAMES = {
                            page_frame: "pf",
                            page_content_box: "pc",
                            page_data: "pi",
                            background_image: "bi",
                            link: "l",
                            input_radio: "ir",
                            __dummy__: "no comma"
                        },
                        DEFAULT_CONFIG = {
                            container_id: "page-container",
                            sidebar_id: "sidebar",
                            outline_id: "outline",
                            loading_indicator_cls: "loading-indicator",
                            preload_pages: 3,
                            render_timeout: 100,
                            scale_step: 0.9,
                            key_handler: !0,
                            hashchange_handler: !0,
                            view_history_handler: !0,
                            __dummy__: "no comma"
                        },
                        EPS = 1E-6;

                    function invert(a) {
                        var b = a[0] * a[3] - a[1] * a[2];
                        return [a[3] / b, -a[1] / b, -a[2] / b, a[0] / b, (a[2] * a[5] - a[3] * a[4]) / b, (a[1] * a[4] - a[0] * a[5]) / b]
                    }

                    function transform(a, b) {
                        return [a[0] * b[0] + a[2] * b[1] + a[4], a[1] * b[0] + a[3] * b[1] + a[5]]
                    }

                    function get_page_number(a) {
                        return parseInt(a.getAttribute("data-page-no"), 16)
                    }

                    function disable_dragstart(a) {
                        for (var b = 0, c = a.length; b < c; ++b) a[b].addEventListener("dragstart", function() {
                            return !1
                        }, !1)
                    }

                    function clone_and_extend_objs(a) {
                        for (var b = {}, c = 0, e = arguments.length; c < e; ++c) {
                            var h = arguments[c],
                                d;
                            for (d in h) h.hasOwnProperty(d) && (b[d] = h[d])
                        }
                        return b
                    }

                    function Page(a) {
                        if (a) {
                            this.shown = this.loaded = !1;
                            this.page = a;
                            this.num = get_page_number(a);
                            this.original_height = a.clientHeight;
                            this.original_width = a.clientWidth;
                            var b = a.getElementsByClassName(CSS_CLASS_NAMES.page_content_box)[0];
                            b && (this.content_box = b, this.original_scale = this.cur_scale = this.original_height / b.clientHeight, this.page_data = JSON.parse(a.getElementsByClassName(CSS_CLASS_NAMES.page_data)[0].getAttribute("data-data")), this.ctm = this.page_data.ctm, this.ictm = invert(this.ctm), this.loaded = !0)
                        }
                    }
                    Page.prototype = {
                        hide: function() {
                            this.loaded && this.shown && (this.content_box.classList.remove("opened"), this.shown = !1)
                        },
                        show: function() {
                            this.loaded && !this.shown && (this.content_box.classList.add("opened"), this.shown = !0)
                        },
                        rescale: function(a) {
                            this.cur_scale = 0 === a ? this.original_scale : a;
                            this.loaded && (a = this.content_box.style, a.msTransform = a.webkitTransform = a.transform = "scale(" + this.cur_scale.toFixed(3) + ")");
                            a = this.page.style;
                            a.height = this.original_height * this.cur_scale + "px";
                            a.width = this.original_width * this.cur_scale +
                                "px"
                        },
                        view_position: function() {
                            var a = this.page,
                                b = a.parentNode;
                            return [b.scrollLeft - a.offsetLeft - a.clientLeft, b.scrollTop - a.offsetTop - a.clientTop]
                        },
                        height: function() {
                            return this.page.clientHeight
                        },
                        width: function() {
                            return this.page.clientWidth
                        }
                    };

                    function Viewer(a) {
                        this.config = clone_and_extend_objs(DEFAULT_CONFIG, 0 < arguments.length ? a : {});
                        this.pages_loading = [];
                        this.init_before_loading_content();
                        var b = this;
                        document.addEventListener("DOMContentLoaded", function() {
                            b.init_after_loading_content()
                        }, !1)
                    }
                    Viewer.prototype = {
                        scale: 1,
                        cur_page_idx: 0,
                        first_page_idx: 0,
                        init_before_loading_content: function() {
                            this.pre_hide_pages()
                        },
                        initialize_radio_button: function() {
                            for (var a = document.getElementsByClassName(CSS_CLASS_NAMES.input_radio), b = 0; b < a.length; b++) a[b].addEventListener("click", function() {
                                this.classList.toggle("checked")
                            })
                        },
                        init_after_loading_content: function() {
                            this.sidebar = document.getElementById(this.config.sidebar_id);
                            this.outline = document.getElementById(this.config.outline_id);
                            this.container = document.getElementById(this.config.container_id);
                            this.loading_indicator = document.getElementsByClassName(this.config.loading_indicator_cls)[0];
                            for (var a = !0, b = this.outline.childNodes, c = 0, e = b.length; c < e; ++c)
                                if ("ul" === b[c].nodeName.toLowerCase()) {
                                    a = !1;
                                    break
                                } a || this.sidebar.classList.add("opened");
                            this.find_pages();
                            if (0 != this.pages.length) {
                                disable_dragstart(document.getElementsByClassName(CSS_CLASS_NAMES.background_image));
                                this.config.key_handler && this.register_key_handler();
                                var h = this;
                                this.config.hashchange_handler && window.addEventListener("hashchange",
                                    function(a) {
                                        h.navigate_to_dest(document.location.hash.substring(1))
                                    }, !1);
                                this.config.view_history_handler && window.addEventListener("popstate", function(a) {
                                    a.state && h.navigate_to_dest(a.state)
                                }, !1);
                                this.container.addEventListener("scroll", function() {
                                    h.update_page_idx();
                                    h.schedule_render(!0)
                                }, !1);
                                [this.container, this.outline].forEach(function(a) {
                                    a.addEventListener("click", h.link_handler.bind(h), !1)
                                });
                                this.initialize_radio_button();
                                this.render()
                            }
                        },
                        find_pages: function() {
                            for (var a = [], b = {}, c = this.container.childNodes,
                                    e = 0, h = c.length; e < h; ++e) {
                                var d = c[e];
                                d.nodeType === Node.ELEMENT_NODE && d.classList.contains(CSS_CLASS_NAMES.page_frame) && (d = new Page(d), a.push(d), b[d.num] = a.length - 1)
                            }
                            this.pages = a;
                            this.page_map = b
                        },
                        load_page: function(a, b, c) {
                            var e = this.pages;
                            if (!(a >= e.length || (e = e[a], e.loaded || this.pages_loading[a]))) {
                                var e = e.page,
                                    h = e.getAttribute("data-page-url");
                                if (h) {
                                    this.pages_loading[a] = !0;
                                    var d = e.getElementsByClassName(this.config.loading_indicator_cls)[0];
                                    "undefined" === typeof d && (d = this.loading_indicator.cloneNode(!0),
                                        d.classList.add("active"), e.appendChild(d));
                                    var f = this,
                                        g = new XMLHttpRequest;
                                    g.open("GET", h, !0);
                                    g.onload = function() {
                                        if (200 === g.status || 0 === g.status) {
                                            var b = document.createElement("div");
                                            b.innerHTML = g.responseText;
                                            for (var d = null, b = b.childNodes, e = 0, h = b.length; e < h; ++e) {
                                                var p = b[e];
                                                if (p.nodeType === Node.ELEMENT_NODE && p.classList.contains(CSS_CLASS_NAMES.page_frame)) {
                                                    d = p;
                                                    break
                                                }
                                            }
                                            b = f.pages[a];
                                            f.container.replaceChild(d, b.page);
                                            b = new Page(d);
                                            f.pages[a] = b;
                                            b.hide();
                                            b.rescale(f.scale);
                                            disable_dragstart(d.getElementsByClassName(CSS_CLASS_NAMES.background_image));
                                            f.schedule_render(!1);
                                            c && c(b)
                                        }
                                        delete f.pages_loading[a]
                                    };
                                    g.send(null)
                                }
                                void 0 === b && (b = this.config.preload_pages);
                                0 < --b && (f = this, setTimeout(function() {
                                    f.load_page(a + 1, b)
                                }, 0))
                            }
                        },
                        pre_hide_pages: function() {
                            var a = "@media screen{." + CSS_CLASS_NAMES.page_content_box + "{display:none;}}",
                                b = document.createElement("style");
                            b.styleSheet ? b.styleSheet.cssText = a : b.appendChild(document.createTextNode(a));
                            document.head.appendChild(b)
                        },
                        render: function() {
                            for (var a = this.container, b = a.scrollTop, c = a.clientHeight, a = b - c, b =
                                    b + c + c, c = this.pages, e = 0, h = c.length; e < h; ++e) {
                                var d = c[e],
                                    f = d.page,
                                    g = f.offsetTop + f.clientTop,
                                    f = g + f.clientHeight;
                                g <= b && f >= a ? d.loaded ? d.show() : this.load_page(e) : d.hide()
                            }
                        },
                        update_page_idx: function() {
                            var a = this.pages,
                                b = a.length;
                            if (!(2 > b)) {
                                for (var c = this.container, e = c.scrollTop, c = e + c.clientHeight, h = -1, d = b, f = d - h; 1 < f;) {
                                    var g = h + Math.floor(f / 2),
                                        f = a[g].page;
                                    f.offsetTop + f.clientTop + f.clientHeight >= e ? d = g : h = g;
                                    f = d - h
                                }
                                this.first_page_idx = d;
                                for (var g = h = this.cur_page_idx, k = 0; d < b; ++d) {
                                    var f = a[d].page,
                                        l = f.offsetTop + f.clientTop,
                                        f = f.clientHeight;
                                    if (l > c) break;
                                    f = (Math.min(c, l + f) - Math.max(e, l)) / f;
                                    if (d === h && Math.abs(f - 1) <= EPS) {
                                        g = h;
                                        break
                                    }
                                    f > k && (k = f, g = d)
                                }
                                this.cur_page_idx = g
                            }
                        },
                        schedule_render: function(a) {
                            if (void 0 !== this.render_timer) {
                                if (!a) return;
                                clearTimeout(this.render_timer)
                            }
                            var b = this;
                            this.render_timer = setTimeout(function() {
                                delete b.render_timer;
                                b.render()
                            }, this.config.render_timeout)
                        },
                        register_key_handler: function() {
                            var a = this;
                            window.addEventListener("DOMMouseScroll", function(b) {
                                if (b.ctrlKey) {
                                    b.preventDefault();
                                    var c = a.container,
                                        e = c.getBoundingClientRect(),
                                        c = [b.clientX - e.left - c.clientLeft, b.clientY - e.top - c.clientTop];
                                    a.rescale(Math.pow(a.config.scale_step, b.detail), !0, c)
                                }
                            }, !1);
                            window.addEventListener("keydown", function(b) {
                                var c = !1,
                                    e = b.ctrlKey || b.metaKey,
                                    h = b.altKey;
                                switch (b.keyCode) {
                                    case 61:
                                    case 107:
                                    case 187:
                                        e && (a.rescale(1 / a.config.scale_step, !0), c = !0);
                                        break;
                                    case 173:
                                    case 109:
                                    case 189:
                                        e && (a.rescale(a.config.scale_step, !0), c = !0);
                                        break;
                                    case 48:
                                        e && (a.rescale(0, !1), c = !0);
                                        break;
                                    case 33:
                                        h ? a.scroll_to(a.cur_page_idx - 1) : a.container.scrollTop -=
                                            a.container.clientHeight;
                                        c = !0;
                                        break;
                                    case 34:
                                        h ? a.scroll_to(a.cur_page_idx + 1) : a.container.scrollTop += a.container.clientHeight;
                                        c = !0;
                                        break;
                                    case 35:
                                        a.container.scrollTop = a.container.scrollHeight;
                                        c = !0;
                                        break;
                                    case 36:
                                        a.container.scrollTop = 0, c = !0
                                }
                                c && b.preventDefault()
                            }, !1)
                        },
                        rescale: function(a, b, c) {
                            var e = this.scale;
                            this.scale = a = 0 === a ? 1 : b ? e * a : a;
                            c || (c = [0, 0]);
                            b = this.container;
                            c[0] += b.scrollLeft;
                            c[1] += b.scrollTop;
                            for (var h = this.pages, d = h.length, f = this.first_page_idx; f < d; ++f) {
                                var g = h[f].page;
                                if (g.offsetTop + g.clientTop >=
                                    c[1]) break
                            }
                            g = f - 1;
                            0 > g && (g = 0);
                            var g = h[g].page,
                                k = g.clientWidth,
                                f = g.clientHeight,
                                l = g.offsetLeft + g.clientLeft,
                                m = c[0] - l;
                            0 > m ? m = 0 : m > k && (m = k);
                            k = g.offsetTop + g.clientTop;
                            c = c[1] - k;
                            0 > c ? c = 0 : c > f && (c = f);
                            for (f = 0; f < d; ++f) h[f].rescale(a);
                            b.scrollLeft += m / e * a + g.offsetLeft + g.clientLeft - m - l;
                            b.scrollTop += c / e * a + g.offsetTop + g.clientTop - c - k;
                            this.schedule_render(!0)
                        },
                        fit_width: function() {
                            var a = this.cur_page_idx;
                            this.rescale(this.container.clientWidth / this.pages[a].width(), !0);
                            this.scroll_to(a)
                        },
                        fit_height: function() {
                            var a = this.cur_page_idx;
                            this.rescale(this.container.clientHeight / this.pages[a].height(), !0);
                            this.scroll_to(a)
                        },
                        get_containing_page: function(a) {
                            for (; a;) {
                                if (a.nodeType === Node.ELEMENT_NODE && a.classList.contains(CSS_CLASS_NAMES.page_frame)) {
                                    a = get_page_number(a);
                                    var b = this.page_map;
                                    return a in b ? this.pages[b[a]] : null
                                }
                                a = a.parentNode
                            }
                            return null
                        },
                        link_handler: function(a) {
                            var b = a.target,
                                c = b.getAttribute("data-dest-detail");
                            if (c) {
                                if (this.config.view_history_handler) try {
                                    var e = this.get_current_view_hash();
                                    window.history.replaceState(e,
                                        "", "#" + e);
                                    window.history.pushState(c, "", "#" + c)
                                } catch (h) {}
                                this.navigate_to_dest(c, this.get_containing_page(b));
                                a.preventDefault()
                            }
                        },
                        navigate_to_dest: function(a, b) {
                            try {
                                var c = JSON.parse(a)
                            } catch (e) {
                                return
                            }
                            if (c instanceof Array) {
                                var h = c[0],
                                    d = this.page_map;
                                if (h in d) {
                                    for (var f = d[h], h = this.pages[f], d = 2, g = c.length; d < g; ++d) {
                                        var k = c[d];
                                        if (null !== k && "number" !== typeof k) return
                                    }
                                    for (; 6 > c.length;) c.push(null);
                                    var g = b || this.pages[this.cur_page_idx],
                                        d = g.view_position(),
                                        d = transform(g.ictm, [d[0], g.height() - d[1]]),
                                        g = this.scale,
                                        l = [0, 0],
                                        m = !0,
                                        k = !1,
                                        n = this.scale;
                                    switch (c[1]) {
                                        case "XYZ":
                                            l = [null === c[2] ? d[0] : c[2] * n, null === c[3] ? d[1] : c[3] * n];
                                            g = c[4];
                                            if (null === g || 0 === g) g = this.scale;
                                            k = !0;
                                            break;
                                        case "Fit":
                                        case "FitB":
                                            l = [0, 0];
                                            k = !0;
                                            break;
                                        case "FitH":
                                        case "FitBH":
                                            l = [0, null === c[2] ? d[1] : c[2] * n];
                                            k = !0;
                                            break;
                                        case "FitV":
                                        case "FitBV":
                                            l = [null === c[2] ? d[0] : c[2] * n, 0];
                                            k = !0;
                                            break;
                                        case "FitR":
                                            l = [c[2] * n, c[5] * n], m = !1, k = !0
                                    }
                                    if (k) {
                                        this.rescale(g, !1);
                                        var p = this,
                                            c = function(a) {
                                                l = transform(a.ctm, l);
                                                m && (l[1] = a.height() - l[1]);
                                                p.scroll_to(f, l)
                                            };
                                        h.loaded ?
                                            c(h) : (this.load_page(f, void 0, c), this.scroll_to(f))
                                    }
                                }
                            }
                        },
                        scroll_to: function(a, b) {
                            var c = this.pages;
                            if (!(0 > a || a >= c.length)) {
                                c = c[a].view_position();
                                void 0 === b && (b = [0, 0]);
                                var e = this.container;
                                e.scrollLeft += b[0] - c[0];
                                e.scrollTop += b[1] - c[1]
                            }
                        },
                        get_current_view_hash: function() {
                            var a = [],
                                b = this.pages[this.cur_page_idx];
                            a.push(b.num);
                            a.push("XYZ");
                            var c = b.view_position(),
                                c = transform(b.ictm, [c[0], b.height() - c[1]]);
                            a.push(c[0] / this.scale);
                            a.push(c[1] / this.scale);
                            a.push(this.scale);
                            return JSON.stringify(a)
                        }
                    };
                    pdf2htmlEX.Viewer = Viewer;
                })();
            </script>
            <script>
                try {
                    pdf2htmlEX.defaultViewer = new pdf2htmlEX.Viewer({});
                } catch (e) {}
            </script>
            <title></title>
        </head>

        <body>
            <div id="sidebar">
                <div id="outline">
                </div>
            </div>
            <div id="page-container">
                <div id="pf1" class="pf w0 h0" data-page-no="1">
                    <div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAxMAAAQiCAIAAABfuTeBAAAACXBIWXMAABYlAAAWJQFJUiTwAAAgAElEQVR42uzdebyVc+LA8S/1w40atwU1jUo3RUMoRQsNpW1kGQpZixhKy2BQmpkUM5gWhrFM1gnJWCKVbcxMN0pFCdFtwaWoe28p97Tcc8/vj6eO0906habM+/26r15nec72nHs7n9f3ec732SORSIQfXmLThvjX+cmzlapV3+P/9g4AALuVyjvnYYoL135185nFG9aHEBJ7Vjrgusf2rneYtQ8A7F723DkPs/6jWZvWr48Xh6LiEC+KFzx/T2LTBmsfAFBOJRV/s2bNP5/anE3Foag4fLNwdtGaPGsfAFBOJcUL136z6N14cSKeSMSLE/HixKYNsfi6NdY+AKCctpIoLl6TPSl1wCleHOLFYcUzdxfbYAcAKKdUmwq+WvX6xHhKNhUVJ+LFibUfzDbsBAAop60k4ps2rskv2rKdLp5IRAm1aUNs0+pV3gAAYDfyw85KULxpQ+6jf4wXh0QIIRES4dsTIYTPJv4lq9+fKlWpusP3X1BQEIutX7J06UEHHlilSpXowgMPPKBSpUre2mjlhBAyM/fPyMiwQgBgVy+noq/zC+a9mSgOm3tpSzMlEiERQv68N4ti67a3nOLx+JtvzXzzzbeeeHJCBYude07PS/tckpmZuc07/OKL5fPmz985q7tL506xWKygYPUO3DYjY590Xk5yLfU4p1deXl4IoVXLln+95y6/6wCwq5fT1wvnxuNF0SzlZQw7FcfXfDj3gLbd0r/DKVOnjRo9NgqCij3x5IQnnpzw2+uu6dnj7OSFNw65KYRQULC6e/dfduncKbpw3vz5Q4YO22nl9Ma//r1jD9e50ym3jLw5zYXfW7AguZZmzppVUFCQfnUBAOX5Afdz2ljwVe5zD8aLQzyxZd/wRPTFum+nJ8id+uSm9PYTf3fevJ7n9hoydFg62ZT0p9vuuP+BccmzU6e9PHXayzNnzfrRv6+vvPJa6tmXX3nV7zoAfHc/5JhTIqz9ZFE03pS6e1NyCCqRCKs/em/TN1//334/qfie7n9g3L333V/BAuee0/PnP2+aPLtgwfvJbXnRDfte1icWi+3Y62jVsmVm5v6LlyxZtCinvGU6dzolhFBQsHqbWdb+xBNenPRcCGH8409UvMEx+ejdu/+ydu2D6h18cJpPOB6Pl7jnZ559LnXsDQDYtcopURz/5Nm/xROJEpvqks20+YKioi9nvNLgjN47lk2tWra8/PJLj2rWrMTlXTp36nfVrx/7++PRDe+97/533nl3e2vp8ssvrXfwwcmNXFOmTqtgK1tyO1o8Hl+6dNmcuXP/dNsdZS6ZkZER7a997TWDzzj9tF9f1b+CUbQaNWqM+vNt27t/95tvzSxxyaJFOTk5i7OyGvqNB4D/Tjnl5uaWvrBKlSrVq1cPIWxYtWL59Kmp36oLIZFIiadkSOX+84WD2nbJqFV7u7KpRo0ajzw0rk6d2uU9vYyMjL6X9Tn7rDOjHaXT30LXqmXLW0YO3+G9gipVqpSV1TArq2G7tm0vuqRPxdsWs7IaHtui+dRpL5e3wO233boDX4sbP/6J0he+/s83lBMAfEc7uJ9Tbm5u+7btSv/c/Ps/hBBihYUb161ZvyY/ZQ6nRFFxiG/ezynEU06vXvZxfOP6Mh9levaM8kabnnpyfAXZlJSZmfnUk+Nr1KhRwTKffZabmk1/uWvM97IzdZ06tSc9949WLVtWvFi7dm0ruDb9LXRJsViszEyc+PQ/4vG433gA2HnlNGf27EFXD4gXFVWwTLyoqP0JJ/7txkHJPNqqmRLf7h6+5URY/MLjieKSH+rxePwPw0eU+RAjR2zHmFBmZuYjD42rYIFly5YlT/9m8MDvcS6ojIyMv9w1JrXbtndfqx1ouDf+9e8yL8/Ly3tvwQK/8QCwk8opPz+/36+vfGHSpN4XXzx3zpwQQs1aNXOWLY1+Lrz44hDCIQ0b3jJyZN6qVfe89fGitfF4cahUdf8qP8tK7aT4ViEV4sVh6bRnC1euKPFw5c0+0KhRVnJCgTTVqVP7isv7prNkgwb1v9/1W6lSpcGDBiTPlp7J6T//mf79PuLDjzxa3lVPPfW033gA2BnllJ+f361T55UrV4YQsqdnDx4wMIRw3PHHhxDef//9oqKi/Py8EMLst2c98tDD0U3uXLx+5fr4wZ3PqfuL7t92UqmJCeKJxMb1hRvWbpUUBQUF5X3v7OKLLtyB19mn98UVb7MLIXTudMoPMfl4+xNP2GlvZ0FBQQVfAJw67eUd/oIhAJBuOSWzqWatmqPGjKlZq2Z0ecOGDV9/7bUzu59205Ah0SXZ07NDCK3btImWuXPJhp8cf0q9jmcW77Hn1hvpSoRUmP/wXRu/WZt8xIlPP1PekzmlY4cdeJ0lxn52pp155JNtzts0Z+47fukB4Acsp3hR0YXn9YpGmyZPndr99NMmT536twcfnP/B+/0HDFjw3oJ4PD777dnDR4xIRtXoO8dOnjq1Zq2aa4sSZ/Q4N7Zx4/6HHllcYiPd1ns75b49PbFl/+VYLFbejuGNGmXt8LDQzhz7KSGa7Wkn+Nu4hype4K6/3O2XHgB22LZnJbhm8G8WLlwYQhgwaGC0watGjRrtT/rFRwsXvjxt2pIli5sc1uSGIUOqVavW/fTTup9+Wl5eXrTY0888275du7y8/P4DBo8aeu3LA84tPSXBt7NixuMfT/nHET37hArHRVo0b77DLzUjI+Pcc3qW3gh4y8ib0z+qyY7ZCQ8RQsjJWbzNCdYXLcr5Ho/EUlBQkJeXvygnZ8GC9wsKCurXr/+zn9VtlJVVo0b1HXiIeDx+bKvWIYRzz+l57TWD/XECsFuW002//91bb765cuXKsaPHtG7TpnmLFnl5ed06d161clVymbxVmz+wZ82cWb9+/RBCUVHRjddfH104YNDAfTJr7bF3RtH6WKlmSiRPL3r5+ayOp2VUr/nmm2+V92RSJwrfAccff1w603bvpl7/5xvpLPbyK69+9/nEY7HYzSNuqWAmqmgq0f323S+a6vPFSc9tcxaJ5Ff/nnhywuBBA36Ifc4A4Dva9ta66tWrT542tU3bNiGEnmed/fXXX1/Y6/wom5L7M0W++vLLq6/q1+EXJ3315ZfT//2fGdnZIYQJT09s3qJFRvWadY47qcSO4SV2eFq1+OMN676OPjh/oFfb/Jijf6xvZDwen/j0P6LTFe8Lv80tets04amJbdq1T82mRo2yfnvdNXeOHX3F5X0bNcoKIcycNat3n749zjkv/eMMph5rzwQKAOx+5RQvKsrNzc3NzV351cpoVKnrL7v1+/WVHy1cGCXRo+P/fmW/fiGE11/f/Jm3adOmTZs2vfrKqy2PaxVdcueYMXeNvXPylKm1Op65eT+nRMnpnYqLE/HiRHEiMfuRu+MbN/xwrzYjI2PkiOEjRwyvXfugH9kb+d6CBclG+evdd1WwZF5eXk7O4h1+oClTp6UeWKZRo6zXXpk64YnxPXuc3bZN676X9ZnwxPg054BIFYvFUov5vvv+5o8TgN2snJavWBHNDN6tc+doV6cuXbqmjiSFEE466eSze/Y4u0ePoqKiAw488IKLLty0adOwoUNDCK3btAkhZE/PHjt69OABAxcs/LjKAT+NJxLFic2dFE8kirf+kl3Ov1/7+ssVP+gL7tK5U5fOnUof6m53lxywOfecnllZDSueu/zZ557fsUfJyVlc4uB9F190Yeldmvpe1ufOsaO3655L7Nw2c9YsEygAsJuVU6rWbdoMGDQwJ2dRdLp5ixZFRUVdTunUtVOniROeuuj8C37R7oR3332339VXR9vv7rjt9iE3DR01ZsyoMWMaN2kSQti76k8OO+3ckvMRJFJmFU8kNsYKCz5dus8++5T3NBYseN97Vlo8Hk8O2Jxx+mkhhF69zq1g+SeenLBjR2L586gxqWdr1KhR3iQRbdu03q5vFJY+1t6kF170zgKwO5XTN+u+2TzSsGzpo+P/3n/AgMWLF4cQzjr77BDCa6+8uujjjwsLC6Nlli9ffsWll1WuXPnuv/41hPDoww83btIk+rZdo0MbhRD22HPPQ07sVLz15rnksFPxlpaa9ei953TvWt5TKigo8J6V9uZbM5MpEx3W9/gtW0vLs2M7EqV/4OQQwk1Db9zm7KORMo+198yzz3lnAdidyumjjxaGLRvdSvvdTTeVuKSwsHDZsmUHHljuLkR771f1gKbHlNrVKWzefleciCcSufPnnH7GGd6Y7ZIcsLm0zyXRiUqVKp17Ts8KbrIDOxJ98cXyEpfk5eUlo620jIyM5POpWJnDS4sW5ZR+RADYdcspUr1G9bI/F6tklC6nJUuWVHBX+1Tb/4gze3077JTYPOz0bUslQrw4fPT8E0c1O8J7k6bUAZvup/4yeXm02a4839eORHf95e4K+ib1+VSgvOGlFye/5P0FYDcrp0UfL5r03PO5n+UWFhY2bNgwhHDfvfeGEC7re3mJJWvXrt23d5+xY8aEEKJZDB595JGBV1/91ptvJpf5abMWe+6VUbx5qCnEi0Nxcfh2t/HiRDyReHfS0xef/SvvTZre+Ne/oxOdO52SeqSXrKyGFW8sS94wTXXq1C59h4sW5fyy++k3DrmpzH6KZh+t+G4rONZecp4FANhtyumjhQsHDxzYvl27cQ88cMaZv4ouyf0st8c5PRscckhysZ/85Cd77LlnCOHZf2z+tIsXFc2dM/fFSS+kzplZJbN6naOPTd0rPJ5IbE6oxOacWl9YWDUUVbCfOKkefuTR6ESPHmeVuKrijWXJG6avvP3Bp057+ZfdT//1lf2nZ88oMZR17TWD586eWcE0mNExChs1yir9fcC8vLx3583zFgOwe5TTMc2bjxo75tTu3Zs0aRJCWLx4cd2f1Y2+KHfj9ddv3Ljxlddfe3zCkyd36DB02LD/vDnj9X+9cfXAgSGEPffcM3t6du+LLz79jNNHjR0zauyYCU9PbHlE0zXLP1+/ds2hJ3baMtSU3DE8mVDRnuNh7lOP9Ti1q7dnm5IDNjVq1Cg91ULFR0fegR2JOnY8uYJrZ86adfWAQW3atY8SKs2v70UDS/37XXX55ZeWvjZ1ekwA+K+r6OgrdevWrVu3brdu3aJD1+Xn5YcQRo0Z3a1zlxnZ2SedeOKNQ4Z2/WW3Aw48MDriSgjhyCOPHDrsprVr144dPSZ7evbHH308edrU6tWrx75ePWFQ39z5c0MIiUR05LoQUo5bF7Yczy6EkAiJT96d3ePyQeOfeX7HvjxfgXfnzVu+fMVnn+W2bNniRzCr08uvvBqdKHN4KTMzs1XLlhV8Ie7FyS/1vaxP+g/X+NBDa9Sosc1pwWfOmjVz1qwaNWoMHjTglI4dKjiOSvJYe+V9GfCJJyf0u+rXqVshAeC/aBtb6z5a+FHb41u/MGnSt5+dTZpMeHpiCGHVylWDBw7s2+fSjr846fXXNg8MtD/pFxf37t1/wIBomZUrV3br1HnO7NlFGzZ8Om9OfMuQ0rc7OSVKfrcuufHu/ecmHNn08BLP5+3Zc77jC772uhuGDB127333L1++4kfw/iUPpbJmzddTpk4r/ZOZuX8FN9/eHYkyMjKeenJ8mnMN5OXlDRk6rHPXUyuYSyI61t4Vl/etVKlSpUqVypx8vIIjQAPATraNI/7uu9++K1euDCHUrFXz0fF/jy5s3qLF/A/eH/fAA2NHj5kze3Yikbh15C0nnXzylthaWLNWreYtWsycM7tV8xYrV67sedbZvz2tY7w4hC2DSinDS8nzqSNPiRDCgn++fNOjz5553oUlPoy/y6stKCj4jvewS0kO2IQQ7r3v/h24h2hHou0ae8vMzHzqyfG33zGqgsP9lniIHuf0eurJ8aWnGo/H49HT/mW3zVtmT/pF+9IvZPz4J9q2ae1vFYBdwTbGnOrWrZscYbpr7NjNYwCzZ4974IHzzj9//gfvP/7UhKpVqz7/4gvR5d06d+nWucvjf/97CCH6N4Rw+WWXHtLksA4Dftv7oaf6PPRUn4cmXnLf+Gq1f7pl5GnLlJhbZiuIBqI2FMY+eGVKnYO+zwPMvf/Bhz+mNy8asPmOdmBHoszMzFtG3vzipOe2+b25ZDzdfseo0pdHs3E2apSV3H88K6thdMDgVDNnzTIDKgC7iMrbXKJ5ixYDBg0aO3r02NFjjjjiyKrVqvY86+wQwtjRYxo3aTJ56pR33psfQujWuUt0JODoqoKC1Y8+/HAIYcCgQf0HXF36bjtcdc2EGwcmyh552jzwNPf5p888o9dfxj1cYqAlmiZ7B7z55ls/mncuHo9H29pq1KhxbIvm0YXNmh1ZrVq1Ekt+/fXXqcfoLeGJJycMHjSggl2RylOnTu1rrxk8eNCA9xYseOWV11KP11va1Gkv97vqyhLfsIuirX+/q1IvPPOM00s/25dfebVnj7P9ufKjl1W/gZUAu305hRD6D7h6yeLFL0yadGnv3tFh6SLJVEpq3abNoo8/XrlyZcXZFEKof3TzPffO2BSLJb7dQLc5oZJnV32e27Fe3X322Wf9+vXJGz740MO3jLx5B15qQUFBxZ/uu5f3FiyINtX9btjQbW7MeubZ58qbMymE8OZbM9PZHHbjkJsyMzOvvWZw6oWVKlU6qlmzo5o1ixLqvvv+Vt4O6fPmz08tp1gsFr0d48c/8dJLU1LeptVlPn/lBMBuU04hhDtG/Tk/Py97evaqlatq1ap1621/uvSS3qkLNDq00UcLF57V4+w1q9f84Xe/qzibQghVa9RqcdpZ0594NGz5Vl0iWU0pFTVj/MO/OrXr+InPVDx6kY4yNxjtvp566unoRPNjjt7mwjdcf13vPn3LuzbNHYmiHZs6djy5zP2iooT66z135eQs/vVV/UvvT7ZgwftdOndKnk3u953OsfAWLcr5LmONsHvJWbbUSoBdUDQqvGeaS1eqXHn0nXfWqlUrhDB52tSsRo2iywdefXX0k5wo/Kyzz9pmNoUQKu+9d4fL+5c4EktxIpE6JWZxIuTMebvjCW1LbEv6y933bPf/RDmL09yjebcQi8Wil1Ni3vDyHNWsWQVfiNuuHYlu/eNt2/jFymp4+223bvN+omPtPTju/hcnPVfiZ+SI4aWX/1526gKA72jP9BetXr36xGefmfD0xOrVvz2S3YuTXoh+khOFZ1SpMnnq1IqzKZIoLj4gq3FySsziRPh2P/FvT4S3n36ydatjSwx+TM+ekf4zLygo+PVV/b/jmvr66693nbftsb8/Hp1o165tmjcZPGhABdcm54XapkWLcra58ssMtZ//vGny9BdfLJ85a1arli2PatasTp3aJX66dO5Uej/xe++7/3uf3AsAfsByCiHUrVu3eYsWIYTM/fc/96S2zfdJRD+tq+878ubho8aOOaZ58xBC4yaN07m3qjVqZrVoVZzaSVtVVIjGot5+6YWLzy35Ha6rBwxKc5ikoKCgxzm9vvtkBPPmzd9F3rNYLJb86n6jrKw0b9X+xBMquDY5L1Q6/jB8xDZXfunpy5sdeWTy9PjHnwghdO9e7vGAS+w2Hom+iwcAu005fato06b3Zv+0cqhTOdSpFA6ustcpHU7qftppdevW3Y7HrlSpTuPD4ymdtHVFJaKriorib0984ugjf17i5j3O6bXNz+935807uWPn72UOp8VLllRw7fYexmSHxePxwb+5Lnl23Tfr0rxhRkZG6QPDJW3XEeLy8vJuHDKsghGgeDxeYmf8GjVqJHdNS+4bXkH2lTml+DY3FALArlhO69et/cctv19fGNsy/VLi6/y89evWbe/9xNZ+vfCtGSmb5749kl1xIqRW1JxXpt50/W9L7O0UTbFY3ud9LBa7/Y5RqbtFV9AN236qsVgF300LIcybvyMjUgUFBRXvfVWiTuLxeL/+A1N3qb7vvr+l/3AVzye+zS5J3YI2c9asfv0Hlji4b1LpbX+PPDSudPktyil3lVaqVKn0+7UDB9oDgP9aOa1ft3Zdft6ar75c+cmyuVNeiDauJUPnnit653/x+dr8vOinuPwBiWiB1V+u+OzDD2a99MLmTipObLWT05YBp+jf9YWx+wf8+ulHH+x/yYWndjx5n332ScZT7z59b79j1Lvz5kWf4gUFBdOzZ9z/wLg27dqnDntccXnfv95zV5m7HlccLl98sTwnZ3HqME+ZhgwdNmXqtC++WJ7+R3ssFutxTq+Kl+nXf2ByXK2goKBENkUFk+ZY0fTsGRVX2qJFOT3P7TVl6rTyeqjhIYeUeOjup/8qJ2dxibzLyVk8avTY1EseHHd/nTq1Y7HYu/Pmpb6EUaPHlj4wcLTOp2fPKPM7dxdd0mfCUxPLe4YA8EPbY/McAGlYvuije6/onQgh/4vc5BRMqQfr3bNSpf0Pqh1C+Hn7k08fdG1G1Wpl3s+rjzz47wlPxL5Zm/d5bth6GsyUs4mtz26+dr/q1Tucf9FDr09fvnw7xh5Gjhie/D58x05do413qReW6Ysvlv+y++k7tlpfnPRcefMmfPHF8r/cfc/iJUsqHsRKddhhTQoKVq9YUe6B9jp3OqVZsyPLnPHoxiE3hRDenj1nuzZZXnF53wvOP6/Et/ZuHHJT1F6ljyLcqmXL9u1P+PTTz5YsWZp6VaNGWTdcf91RzZpNmTptyNBh5T351Am6ko+yw2sYdl/Rd57NSgC78l9o5fRvEFu3duXnn4WUVEqkxE1IJOJFRStzP0uEsG716vKyKYSw+N25n330YYnbbnW2jIkxN1famry85dvzf0qjRlmj/3xH6kfspX0uqWBC7Z1g3vz52zs/wocfLqx4ganTXp467eUyy2nH5mK49777f9mta4lyatbsyBBCjx5nHdWsWUFBwcSnn5n49D+iIJs5a1aJlqpRo8btt92anPmpdu2DOnc6pczHiu42qWvXLuk8w4yMffwNA7DzbUc5JRKhOOXYKN9mTamKqngcqziEeMp4VXmdFLYe0Eq988f//uiEpyYmP7bLa6aLL7qw9KjSKR07RN+SS/2q185UQUOUV1rLl6/Y4YdL/7GSE0SV11s9e5ydjLPMzMy+l/Xpe1mfWCxWULD6q5VfRU+ydu2DDqh1wIEHHlBip7RonvF0nkbbNq0d3xeAXdZ2bK3L++LzZ+/4Y4mlt2TTVhc3+0WH48rfzjVj0nPvvPbKVvew9YmwVUhtPpO89pgOHduddkZ0+t158z766OOohKZOezn61G/Xru1xrVp++umn36xb17pNG+8xsLuwtQ52/b/Q7SinH1osFiuxeaj0JWmakZ19Ya/zQwhX9us3+JrffPfnFi8qqlS58na/osLCjCpVfvD1tlMe5Yd7YvGiohDCDqxeUE7Azv8L3b5ZCR4fP/6onx+RvH2Jn+NaHPvpJ59Epy86//wzunc/6udHHHNks1hhYXRhCKH/VVed1/OcEnf74QcfnNfznCMOO/y4Fse+MGlSvKjo008+ufyyy4447PAjmzZ9+MGH4kVFj48fn1W/QaywMDpR4qdp4yZZ9Rv87qZh0Qf27X/6U3TPL77wQqywMPlsQwj5+fmpNyzvtSSvnZGd3eNXZzXOanRci2NnZGd/9dVX0eXJZR5+8KHobPKJxYuK7hp755FNmx5xeNPLL7vs008+SS4QQrjo/PMvOv/80s8h9T7vGntn6n0e1+LYO267PfnaQwi5ublZ9Rvk5uZedP75Rxze9NSu3aInVuKnx6/OSq78Ml9dUonVUuZi0V3NyM5OvoroV6L0TR5+8KHjWhx7xOFNz+t5zocffBAtf2rXbtH9PPzgQ00bN8nNzY0VFt7w2+sbZzU6sunPb/jt9bHCwuh1ZdVv8MKkSSXel9LvlL9hAHa+7SunO0ePWbduXfRZWMIlffqsXbv2ir59twwXrX9v/nvr1q0b/+QTyYGHeFHRlMkvzZo5M6qZ5IWndu22aNHHV1x55cH16t342+vz8vO7nNJpxvTsK6688vjWrUcMH37P3fds3LAxhNDnkt7RiRKqVavWpVvX8Y89NiM7+6ILLnxv/ntn9+x5ds+ey7/44ldnnJG6ZGHKQ6czanJhr/M//eSTAYMGVatW7crLr1j51VcllhkxfHj0cpJP7J677xk7evTxrVtfceWVM6Znd+vcJRpWiRaIxdbHYusrftyxo0fn5+cnb1KpcuV777mn9Gtfs3p19vTsg+vVW/nVV+tLfVH/tNNPnztnzvA/pDURQzqr5dVXXw0hPPLww6mvosy3Y8Tw4Yc0bHjFlVcuWvTxqV27xYuKYrH1H37wwbSpU2OFhSOGD9+wYUMI4aILLnzumWfO7tmz++mnT5ww4aILLkzew+1//JM/TgB2QduxiSQ3N3fVqlUhhHvuvvuuu++OLnxj+n+K4/GTTmx/0SUXr1ix/I3X/5l6k14XXHDY4YeX+OgNITz77LPn9do8ldFjjz4WQpj26qvJw+HNyM7esGHD6/964+B69UIIl1922f333vuba68NIcyaOXPjxo0hhJxlS3Nzc9u3bZezbGmPX5315YoVf7j55imTX3p/wftz58wZOmzYxb0vCSG0btN60NUDogpJ9cb0/4QQah90UHQ2Z9nS5CB5dOKN6f+pUqXK3X+5O4Twz3//K6NKlehIfLm5ucl/k/pc0jv17P333ntyxw73PfBACKFHzx4nndh+5syZZa7S6FHKvOqKy76dw/Oyvn2jHPnFSSelLvOT/fc/8KCDPv3kk14XXPDTn/409cm3b9tu0DW/eW/+/H//61+lH7HlMc3Le5ffmP6f2gcdVKly5dJbDf54y60hhNdeeTVWKrNSV+BxLY49uF69xyc8GULofWmflsc0nzBh88RagwcMbHbUUcnsmztnzvCRI6LfhMaNG48YPnzN6tXRtXl5ebHyYy56kv56Adilx5zuvusv0Ykpk1+KBlFCCO3btjvpxPbRiSmTX0txw7oAABaiSURBVDrnvPO2GqV45ZXkkiGEP992e3LsKnnhRx99FEL4SbVvZzGYNnVaCKFWrVrR2UaNDo3FYps2bQohZGRkvPvOO6Wf26pVq6IaaHJYkxBC0y0Hl83KygohLPzwwxLLt2/brn3bdo2zGpX3Ytu3bdfymOaLFn1cZd8qpXfWad+2XfL0yR07zNo6jGKxWKNGh0ano1cxo5xD5EaPUuYQ2tw5c1IvObTxoSGE1atLHm1mwtMTBwwaNP6xx5J1ktTp5A5LliwZ9vvfpfOIqQuUuVry8/O/3DKhVLKAS4sXFa1atarhlsOqRG/re/PfCyHst99+GzZsmDVzZrVq1UIIOTk5IYSjjz46WjJ6yz5Z9kkI4Y5RozZs2BBl63Y9SQDYVcopXlT04qRJhxxyyIBBg1I/O3OWLY3Gb+rUqRNCOPNXZyZvUmXfKl+uWHHP3fckL1myZEmbtm26dOu6atWq5LDNVf37hRD+eOsfY4WFM7KzR9484prrrg0hXHfttbHCwrdnzXpo3Lgu3br+3//9Xwjhvr89UObTiz6MD218aLsTTqhZs+aQ62/49JNPcnNzB/TrX2XfKqW/YZezbGn0U97rja4dOGhQ4TeFd429Mz8/f0Z29h1byi/1hoN/c02J3dhP7tjhoXHj3p41K1ZYeN2114YQrup3VQhhzpzZ+fn5c+fMOfCgA1MfpfSjX9KnT82aNZNn35s//9rfXFOzZs02bduGED784IO33nwzhDBm1KiunTpdetmlGRkZ/3rjjRJ3Eq2xE044ofTrquCNLm+BB/82LoQwdNiwzOqZf7zl1szqmQsXfpifn//S5MmpL79S5cpn9+w5ccKEGdnZscLC6665NvkWH9q4cZduXTMyMi7p0yeE0LxFiyr7VhnQr39ubu6nn3wy5PobataseeRRzUII+1d4lJh0XgUA/JfLaebMmbFYbOQfb+0/4OqaNWsmR4+SHnjwwb333vvS3n2SlzRpctjJHTuMHT062kU6cu/99992++2pI1h169btdcEFD40bd8ThTS/sdf5LkyevWbPmkj59pkx+6YjDm57bo2fVqlWvvW7zwU9at2lzTPOyh0yGjxzx8UcfvzBp0h9G3Lx8+fKTTmzfvm27zz//fOSttyaXyarfIBou2uZextG1hx1+eMtWrcaOHt3ymOYX9jr/5alTV5SaWmnf/fYt0XNDhg4NIZzbo+cJbdtOmzI1hPDOO+/0uuCCKZNfisZ7fnvDDamPUvrRq1at+tCjjyTPPv/cc1+vWTNq7JhWrVpV2bfKqV27XX/tdXXq1Ll6wIDCbwqPOLxpLBa76OKLS9zJqDFjQqktiaX3ti7zhZd+So889FDLVq0u7n3JsN///ssVKy6+5JLCbwpbHtN87pw50YbUpGG/G1azZs0Le51/xOFNn3/uuV4XXJA8DvRtt9/+1D+erlq1anR25K23fv7559Gw5fLly4cMuym6/NJLeidzM/1nDgA7Qbr7OWVmZg4fOeLYli1DCPeN+9v7CxYMGzI0uqpG9epDhw07+OCfPf3sMzPfmjli+PAQwsDBg0IIrVq1euzRx7788stoydF3jo22fD06/u9r165N3vkfbh5+/Q3XP/vss23bto32bRpy09DBvxn86quvZmVlRXtKnXTySXvtvVcI4d4H7p86ZUpI2Utp4OBBy5Yti3aX2WuvvTp17tyhQ4do16JWrVp9x6+7Pz7hyVhh4YQnJ3Q4pWPdunVTNz5GYzA1qlevW7fu6DvHNmvWLHrtB9erN//9BY2zGhV+U1hcXBxC2He//f5w8/A+l/aZN29ehw4dKv6u/vCRI6L1EN3nXnvvdfTRRyd3F3tn3rzopUUDabPmzpn03PPdTz8tuZdY8h05vvXxj47/+7Jly2aVs5dVqop3G4oVFt4wdEjbtm1DCB06dBg6bNjPDj74vQ/eT66W1IUzqlR5a/bbH37wQU5OTvLFRr8PGVWqHHb44fvuu2/0JE/t3r1r166p71SssHDosGF77b3XGWecsWtOtQDA/7hdaD6nH5nc3Nwa1avH1q8vLCws0RYAZTKfE+z6f6GmH/yhRLWUUaVK6mgQALBb29MqAABQTgAAygkAQDkBACgnAADlBACgnAAAKJP5nGB39c0336xaucp6SFWvfj0rAVBOQBk2bthYUJBvPSgnQDkB6donI+PAAw78H18JGzZuWLF8uV8GQDkB2yqnffbJrJ75P74SNm7cqJyAncMe4gAAygkAQDkBACgnAADlBACgnAAAlBMAAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAADKCQAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAACUEwCAcgIAUE4AAMoJAEA5AQCgnAAAlBMAgHICAFBOAADKCQBAOQEAoJwAAJQTAIByAgBQTgAAygkAQDkBAKCcAACUEwCAcgIAUE4AALu+ylYB7NZWFxS8W1BgPQDsHMacAADSZcwJdlc/2f8nh+/X1HoAUE7Atu2555577bWX9QCwU//vtQoAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAoJwAAFBOAADfi8pWAcAuJat+AysBdlnGnAAA0rVHIpGwFgAA0mHMCQBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAADKCQAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAACUEwCAcgIAUE4AAMoJAEA5AQCgnAAAlBMAgHICAFBOAADKCQBAOQEAoJwAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAAOUEAKCcAABQTgAAygkAQDkBACgnAADlBACgnAAAUE4AAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAFBOAAAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AAMoJAADlBACgnAAAlBMAgHICAFBOAADKCQAA5QQAoJwAAJQTAIByAgBQTgAAygkAQDkBAKCcAAC+H3s0rFffWgAAKE/OsqXJ08acAADSVbl0TAHADyGrfgOfOOyOv7SpjDkBAKRLOQEAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAAAoJwAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAACUEwCAcgIAUE4AAMoJAADlBACgnAAAlBMAgHICAFBOAADKCQBAOQEAoJwAAJQTAIByAgBQTgAAygkAQDkBAJBqj4b16lsLAADlyVm2NHnamBMAQLoql44p/ouy6jfwdoA/QGsYdqlf2lTGnAAA0qWcAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAAOUEAKCcAABQTgAAygkAQDkBACgnAADlBACgnAAASLVHw3r1rQUAgPLkLFuaPG3MCQAgXZVLxxT/RVn1G3g7wB+gNQy71C9tKmNOAADpUk4AAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBAOQEAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAACk2qNhvfrWAgBAeXKWLU2eNuYEAJCuPRKJhLUAAJAOY04AAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAgHICAKB8ezSsV99aAAAoT86ypcnTxpwAANJVuXRMsU1Z9RtYacCu/B+C/6asQL7H34RUxpwAANKlnAAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAADlBACgnAAAUE4AAMoJAEA5AQAoJwAA5QQAoJwAAFBOAAA7Yo+G9epbCwAA5clZtjR52pgTAEC6KpeOKbYpq34DKw3Ylf9D8N+UFcj3+JuQypgTAEC6lBMAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAoJwAAFBOAADKCQBAOQEAKCcAAOUEAKCcAABQTgAAygkAQDkBACgnAADlBACgnAAAlBMAAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAAAoJwAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAACUEwCAcgIAUE4AAMoJAADlBACgnAAAlBMAgHICAFBOAADKCQBAOQEAoJwAAJQTAIByAgBQTgAAygkAQDkBAKCcAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAADlBACgnAAAUE4AAMoJAEA5AQAoJwAA5QQAoJwAAFBOAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAAMoJAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAFBOAAAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AAMoJAADlBACgnAAAlBMAgHICAFBOAADKCQAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAACUEwCAcgIAUE4AAMoJAEA5AQCgnAAAlBMAgHICAFBOAADKCQBAOQEAoJwAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEA/Pjs0bBe/RBCzrKl1gUAQKqs+g1KZFLl1CsAAKiArXUAAOmqbDsdAJRQehsN/8u/CamMOQEApEs5AQAoJwAA5QQAoJwAAJQTAIByAgBQTgAAKCcAAOUEAKCcAACUEwCAcgIAUE4AACgnAADlBACgnAAAlBMAgHICAFBOAADKCQAA5QQAoJwAAJQTAIByAgBQTgAAygkAAOUEAKCcAAB+KJWtAgAoU1b9BlYCJRhzAgBIlzEnAChbzrKlVsL/uNLjjsacAADSpZwAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwCAH5vKVgEAlCmrfgMrgRKMOQEApMuYEwCULWfZUivhf1zpcUdjTgAA6VJOAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAAMoJAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAdheVrQIAKFNW/QZWAiUYcwIASJcxJwAoW86ypVbC/7jS447GnAAA0qWcAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAADlBACAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAgB+bylYBAJQpq34DK4ESjDkBAKTLmBMAlC1n2VIr4X9c6XFHY04AAOlSTgAAygkAQDkBACgnAADlBACgnAAAlBMAAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwCAcgIAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAHYXla0CAChTVv0GVgIlGHMCAEiXMScAKFvOsqVWwv+40uOOxpwAANKlnAAAlBMAgHICAFBOAADKCQBAOQEAKCcAAJQTAIByAgBQTgAAygkAQDkBACgnAACUEwCAcgIAUE4AAMoJAEA5AQAoJwAA5QQAgHICAFBOAADKCQBAOQEAKCcAAOUEAIByAgBQTgAAygkAQDkBACgnAIAfm8pWAQCUKat+AyuBEow5AQCky5gTAJQtZ9lSK+F/XOlxR2NOAADpUk4AAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAP6/HTu2ARgEgiCYUAhI339FSHYp5PDBp9gzJVy0OuUEAKCcAABQTgAAygkAQDkBACgnAIBbNBMAQCr6MAIbnxMAQJXPCQBy832M8HPn7+hzAgCoUk4AAMoJAEA5AQAoJwAA5QQAoJwAAJQTAADKCQBAOQEAKCcAAOUEAKCcAACUEwAAygkAQDkBACgnAADlBACgnAAAlBMAgHICAEA5AQAoJwAA5QQAoJwAAJQTAIByAgBAOQEAKCcAAOUEAKCcAACUEwDA1zQTAEAq+jACG58TAEDVAkv3qYAA0SwoAAAAAElFTkSuQmCC" />

                        <div class="t m1 x5 h9 y14 ff1 fs7 fc0 sc0 ls0 ws0">Abidjan Cocody Danga </div>
                        <div class="t m1 x5 h9 y15 ff1 fs7 fc0 sc0 ls0 ws0">17 BP 768 ABIDJAN 17 </div>
                        <div class="t m1 x5 h9 y16 ff1 fs7 fc0 sc0 ls0 ws0">Email : info@actia-sa.com / www.actia-sa.com</div>
                        <div class="t m1 x5 h9 y17 ff1 fs7 fc0 sc0 ls0 ws0">TEL: (+225) 27 22 52 21 71 / 25 22 002112</div>
                        <div class="t m1 x5 h9 y18 ff1 fs7 fc0 sc0 ls0 ws0">N° RCCM: CI-ABJ-2019-B-12720</div>
                        <div class="t m1 x5 h9 y19 ff1 fs7 fc0 sc0 ls0 ws0">CC N° :1935717 J</div>
                        <div class="t m1 x5 h9 y1a ff1 fs7 fc0 sc0 ls0 ws0">Régime du réel Normal</div>
                        <div class="t m1 x5 h9 y1b ff1 fs7 fc0 sc0 ls0 ws0">Centre des Impôts: Direction des Grandes entreprise-DGI</div>

                        <div class="t m1 xf ha y1d ff1 fs8 fc0 sc0 ls0 ws0">Sticker DGI</div>
                        <div class="t m1 x10 h5 y1e ff1 fs3 fc0 sc0 ls0 ws0">ICI</div>

                        <div class="t m0 x1 h2 y1 ff1 fs0 fc0 sc0 ls0 ws0">Facture N° SCO2021204405 </div>
                        <div class="t m1 x2 h3 y2 ff2 fs1 fc0 sc0 ls0 ws0">REFERENCE: <?php echo $immat; ?></div>
                        <div class="t m1 x2 h3 y3 ff2 fs1 fc0 sc0 ls0 ws0"><?php echo $proprietaire; ?> </div>
                        <div class="t m1 x2 h3 y4 ff2 fs1 fc0 sc0 ls0 ws0"></div>
                        <div class="t m1 x3 h4 y5 ff1 fs2 fc0 sc0 ls0 ws0">Abidjan le <?php echo date_format($date, 'd-m-Y'); ?> </div>

                        <div class="t m2 x5 h6 y7 ff3 fs4 fc0 sc0 ls0 ws0"><span class="_ _2"></span><span class="_ _3"></span><span class="_ _0"></span><span class="_ _3"></span><span class="_ _4"></span><span class="_ _4"></span><span class="_ _4"></span><span class="_ _4"></span><span class="_ _5"></span><span class="_ _3"></span><span class="_ _4"></span><span class="_ _4"></span><span class="_ _4"></span></div>

                        <div class="t m1 x4 h5 y6 ff1 fs3 fc0 sc0 ls0 ws0">N° Chassis :</div>
                        <div class="t m1 x11 h5 y6 ff1 fs3 fc0 sc0 ls0 ws0"><?php echo $nSerie; ?></div>
                        <div class="t m1 x4 h5 y8 ff1 fs3 fc0 sc0 ls0 ws0">Puissance :</div>
                        <div class="t m1 x11 h5 y20 ff1 fs3 fc0 sc0 ls0 ws0"><?php echo $puisFisc; ?></div>
                        <div class="t m1 x6 h5 y8 ff1 fs3 fc0 sc0 ls0 ws0">Energie :</div>
                        <div class="t m1 x1b h5 y3a ff1 fs3 fc0 sc0 ls0 ws0"><?php echo $energie; ?></div>
                        <div class="t m1 x6 h5 ya ff1 fs3 fc0 sc0 ls0 ws0">Marque :</div>
                        <div class="t m1 x1b h5 y39 ff1 fs3 fc0 sc0 ls4 ws7"><?php echo $marque; ?></div>


                        <div class="t m1 x1 h5 y9 ff1 fs3 fc0 sc0 ls0 ws0">CODE <span class="_ _6"> </span>DESIGNATION<span class="_ _7"> </span><span class="ls1 ws1">QTE<span class="_ _9"> </span></span>PU.HT<span class="_ _a"> </span>MONTANT</div>

                        <div class="t m1 x4 h5 y35 ff1 fs3 fc0 sc0 ls0 ws0">RDV</div>
                        <div class="t m1 x12 hc y21 ff1 fsa fc0 sc0 ls0 ws5">VISITE VIP</div>
                        <div class="t m1 x13 hc y22 ff1 fsa fc0 sc0 ls0 ws0">1</div>
                        <div class="t m1 x7 hc y21 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $_visite_vip; ?></div>
                        <div class="t m1 x17 hc y2e ff1 fsa fc0 sc0 ls0 ws0"><?php echo $_visite_vip; ?></div>

                        <div class="t m1 x4 h5 y36 ff1 fs3 fc0 sc0 ls0 ws0">SCV</div>
                        <div class="t m1 x13 hc y34 ff1 fsa fc0 sc0 ls0 ws0">1<span class="_ _10"></span>Sécurisation</div>
                        <div class="t m1 x7 hc y23 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $_securisation; ?></div>
                        <div class="t m1 x18 hc y2f ff1 fsa fc0 sc0 ls0 ws0"><?php echo $_securisation; ?></div>

                        <div class="t m1 x4 h5 y37 ff1 fs3 fc0 sc0 ls0 ws0">VIG</div>
                        <div class="t m1 x12 hc y32 ff1 fsa fc0 sc0 ls0 ws0">Vignette - ( Non soumis à la TVA)</div>
                        <div class="t m1 x13 hc y32 ff1 fsa fc0 sc0 ls0 ws0">1</div>
                        <div class="t m1 x7 hc y24 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $prix_vignette; ?></div>
                        <div class="t m1 x1a hc y30 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $prix_vignette; ?></div>

                        <div class="t m1 x4 h5 y38 ff1 fs3 fc0 sc0 ls0 ws0">VL2-TP2</div>
                        <div class="t m1 x12 hc y33 ff1 fsa fc0 sc0 ls0 ws6">Visite VL2 - TP2</div>
                        <div class="t m1 x13 hc y33 ff1 fsa fc0 sc0 ls0 ws0">1</div>
                        <div class="t m1 x7 hc y25 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $prix_visiteHT; ?></div>
                        <div class="t m1 x1a hc y31 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $prix_visiteHT; ?></div>

                        <div class="t m1 x5 h9 y1c ff1 fs7 fc0 sc0 ls0 ws0"> </div>
                        <div class="t m1 x0 hb y1f ff4 fs9 fc0 sc0 ls0 ws0">Opération de caisse du : <?php echo date_format($date, 'd/m/Y'); ?> - CAISSE - Mode de réglement : Espèce -</div>

                        <div class="t m1 x7 h5 yb ff1 fs3 fc0 sc0 ls0 ws0">Total HT</div>
                        <div class="t m1 x16 hc y26 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $totalHT; ?></div>
                        <div class="t m1 x3 h5 yc ff1 fs3 fc0 sc0 ls0 ws0">TVA 18%</div>
                        <div class="t m1 x17 hc y27 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $mtTva; ?></div>
                        <div class="t m1 x8 h5 yd ff1 fs3 fc0 sc0 ls0 ws0">Timbre</div>
                        <div class="t m1 x18 hc y28 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $_timbre; ?></div>
                        <div class="t m1 x9 h5 ye ff1 fs3 fc0 sc0 ls0 ws0">RMC</div>
                        <div class="t m1 x19 hc y29 ff1 fsa fc0 sc0 ls0 ws0"><?php echo $RMC; ?></div>
                        <div class="t m1 xa h5 yf ff1 fs3 fc0 sc0 ls2 ws2">TPM</div>
                        <div class="t m1 x19 hc y2a ff1 fsa fc0 sc0 ls0 ws0"><?php echo $TPM; ?></div>
                        <div class="t m1 xb h5 y10 ff1 fs3 fc0 sc0 ls0 ws3">TOTAL TTC ACTIA</div>
                        <div class="t m1 x16 hc y2b ff1 fsa fc0 sc0 ls0 ws0"><?php echo $t_actia; ?></div>
                        <div class="t m1 xc h5 y11 ff1 fs3 fc0 sc0 ls0 ws0">VIGNETTE</div>
                        <div class="t m1 x16 hc y2c ff1 fsa fc0 sc0 ls0 ws0"><?php echo $t_vign; ?> </div>
                        <div class="t m3 xd h7 y12 ff3 fs5 fc0 sc0 ls3 ws4"><span class="_ _c"></span><span class="_ _d"></span><span class="_ _e"></span><span class="_ _e"></span><span class="_ _c"></span><span class="_ _4"></span><span class="_ _2"></span><span class="_ _e"></span><span class="_ _2"></span><span class="_ _f"></span><span class="_ _e"></span><span class="_ _e"></span></div>
                        <div class="t m1 x16 hc y2d ff1 fsa fc0 sc0 ls0 ws0"><?php echo $t_to_pay; ?></div>

                        <div class="t m1 xe h8 y13 ff1 fs6 fc0 sc0 ls0 ws0">Arrêtée la présente facture à la somme de cinquante trois mille cent Francs CFA </div>

                    </div>
                    <div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div>
                </div>
            </div>
            <div class="loading-indicator">
                <img alt="" src="data:image/png;base64,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" />
            </div>

            <script>
                window.addEventListener("load", window.print());
            </script>

        </body>


        </html>

<?php
    } else {
        header('Location: restriction.php');
    }
}
?>