<?php
include('phpqrcode/qrlib.php'); //On inclut la librairie au projet
$lien = 'https://google.com'; // Vous pouvez modifier le lien selon vos besoins
QRcode::png($lien, 'image-qrcode.png'); // On crée notre QR Code
?>

<Div>
    <img src="<?php
                QRcode::png($lien);
                ?>" alt="">
    <?php
    QRcode::png($lien);
    ?>
</Div>

<?php
?>