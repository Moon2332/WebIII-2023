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
    <link rel="stylesheet" href="CSS/dep.css" type="text/css">
    <title>Vote Élève</title>
</head>
<body>
    <?php
        if ( $_SESSION["connexion"] == true)
        {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";
            $erreur = false;

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "connected";

            $sql = "SELECT id, Nom, Coordonateur FROM departement";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
    ?>  
                <div class="container-fluid">
                    <div class="row titre">
                        <h1> Departement </h1>
                    </div>
                    <div >
                        <table class="table-responsive">
                            <thead> 
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Coordinateur/trice</th>
                                    <th scope="col">Événement</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php  
            while($row = $result->fetch_assoc()) {
    ?>
                                <tr>
                                    <td scope="row"><?php echo $row["id"] ?></td>
                                    <td><?php echo $row["Nom"] ?></td>
                                    <td><?php echo $row["Coordonateur"] ?></td>
    <?php 
                $id = $row["id"];
    
                $sqlD = "SELECT id_even FROM depart_even INNER JOIN departement ON departement.id = depart_even.id_depart WHERE depart_even.id_depart = '$id' " ;
    
                $resultD = $conn->query($sqlD);
    
                $TEven = " ";
    
                if ($resultD->num_rows > 0) {
                    while($rowD = $resultD->fetch_assoc()) {
                        $TEven .= $rowD["id_even"] . "<br>";
                    }
                }      
    ?>
                                    <td><?php echo $TEven ?> </td>
                                    <td> <a href="modDep.php?id=<?php echo $row["id"] ?>" > Modifier </a></td>
                                    <td> <a href="supDep.php?id=<?php echo $row["id"] ?>" > Supprimer </a></td>
                                </tr>      
    <?php                  
            }
    ?>                          
                            </tbody>
                        </table>
                        <div class="row buttonAdmin">
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg"> <a href='ajDep.php' > Ajouter </a></button>
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg btnRetour"> <a href='connexion.php?action=retour' > Retour </a></button>
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg btnDecon"><a href='nip.php?action=decon'> Déconnexion </a></button>
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
    <script src="js/script.js"></script>
</body>
</html>