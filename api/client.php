<?php
  // Se connecter à la base de données
  include("db_connect.php");
  $request_method = $_SERVER["REQUEST_METHOD"];
  
  switch($request_method)
  {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer un seul produit
            $id = intval($_GET["id"]);
            getClient($id);
        }
        else
        {
            // Récupérer tous les produits
            getClients();
        }
        break;

    case 'POST':
        // Ajouter un produit
        AddClient();
        break;

    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
  }

  
  function getClients()
  {
    global $conn;
    $query = "SELECT * FROM client";
    $response = array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

  function getClient($id=0)
  {
    global $conn;
    $query = "SELECT * FROM client";
    if($id != 0)
    {
      $query .= " WHERE id=".$id." LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

  function AddClient()
  {
    global $conn;
      $nom_prenom =isset($_POST['nom_prenom']) ? $_POST['nom_prenom'] : '';
      //$nom_prenom = $_POST["nom_prenom"];
      $tel = $_POST["tel"];
      $id_piece = $_POST["id_piece"];
      $num_piece = $_POST["num_piece"];
      $email = $_POST["email"];
      echo $query="INSERT INTO client(nom_prenom, tel, id_piece, num_piece, email) VALUES('".$nom_prenom."', '".$tel."', '".$id_piece."', '".$num_piece."', '".$email."')";
      if(mysqli_query($conn, $query))
      {
        $response=array(
          'status' => 1,
          'status_message' =>'Nouveau client enregistré.'
        );
      }
      else
      {
        $response=array(
          'status' => 0,
          'status_message' =>'ERREUR!.'. mysqli_error($conn)
        );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
    }

?>