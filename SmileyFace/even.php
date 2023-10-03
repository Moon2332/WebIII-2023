<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/even.css" type="text/css">
    <title>Évènements</title>
</head>
<body>
    <?php
        if ( $_SESSION["connexion"] == true)
        {
                //Fichier pour connexion local
                REQUIRE('connLocal.php');
                
                // Create connection
                $conn =new mysqli($servername, $username, $password, $db);
                $conn->query('SET NAMES utf8');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, nom, date, lieu, description FROM evenement";

                $result = $conn->query($sql);

                
                if ($result->num_rows > 0) {
    ?>  
                    <div class="container-fluid">
                        <div class="row titre">
                            <h1> Événement </h1>
                        </div>
                        <div >
                            <table class="table-responsive">
                                <thead> 
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Lieu</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Departement</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php  
                while($row = $result->fetch_assoc()) {
?>
                                    <tr>
                                        <td scope="row"><?php echo $row["id"] ?></td>
                                        <td><?php  echo $row["nom"] ?></td>
                                        <td><?php  echo $row["date"]?></td>
                                        <td><?php  echo$row["lieu"]?></td>
                                        <td><?php  echo $row["description"]?></td>
<?php 
                    $id = $row["id"];

                    $sqlD = "SELECT id_depart FROM depart_even INNER JOIN evenement ON evenement.id = depart_even.id_even WHERE depart_even.id_even = '$id' " ;
//echo $sqlD;
                    $resultD = $conn->query($sqlD);

                    $Tdepart = "";
                    if ($resultD->num_rows > 0) {
                        while($rowD = $resultD->fetch_assoc()) {
                            $Tdepart .= $rowD["id_depart"] . "<br>";
                        }
                    }      
?>
                                        <td><?php echo $Tdepart ?> </td>
                                        <td> <a href="index.php?page=PageEven&id=<?php echo $row["id"] ?>" > Vote Élève </a></td>
                                        <td> <a href="employeur.php?page=PageEven&id=<?php echo $row["id"] ?>" > Vote Employeur </a></td>
                                        <td> <a href="stats.php?action=PageEven&id=<?php echo $row["id"] ?>" > Statistiques </a></td>
                                        <td> <a href="modEven.php?action=PageEven&id=<?php echo $row["id"] ?>" > Modifier </a></td>
                                        <td> <a href="supEven.php?action=PageEven&id=<?php echo $row["id"] ?>" > Supprimer </a></td>
                                    </tr>      
<?php                  
        }
?>
                            </tbody>
                        </table>
                        <div class="row buttonAdmin">
                                <button type="button" class="btn btn-link btn-outline-primary btn-lg"> <a href='ajouterEve.php?action=PageEven'> <i class="fa-solid fa-user-plus"></i> Ajouter </a></button>
                                
                                <button type="button" class="btn btn-link btn-outline-primary btn-lg btnRetour"> <a href='connexion.php?action=retour'> <i class="fa-solid fa-arrow-left"></i> Retour </a></button>
                                
                                <button type="button" class="btn btn-link btn-outline-primary btn-lg btnDecon"><a href='connexion.php?action=decon'> <i class="fa-solid fa-right-from-bracket"></i> Déconnexion </a></button>
                        </div>
                    </div>
<?php
                } else {
                        echo "0 results";
                }

                $conn->close();
        }
    else {
        header("Location: connexion.php");
    }


?>
<script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>

</body>
</html>