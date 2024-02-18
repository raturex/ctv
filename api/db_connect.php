<?php
  $server = "localhost";
  $username = "root";
  $password = "";
  $db = "actia";
  $dsn = 'mysql:dbname='.$db.';host='.$server;

  
  $conn = mysqli_connect($server, $username, $password, $db);
  mysqli_query ($conn,"SET NAMES UTF8");
  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  try {
    $db_PDO = new PDO($dsn, $username,$password);
    $db_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}$db_PDO->query("SET NAMES UTF8");//Solution encodage UTF8

?>
