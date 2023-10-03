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
    <title>Statistiques par Évènement</title>
</head>
<body>
    <?php
        if ( $_SESSION["connexion"] == true)
        {
            $id =""; $nom = "";
            
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";
            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $id = $_GET['id'];
            } 
            else 
                $id = $_POST['id'];

            $sql = "SELECT nom, satisfait, neutre, insatisfait, satis_Em, neutre_Em, insatis_Em FROM evenement WHERE id = '$id'";
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
    ?>  
                <div class="container-fluid">
                    <div class="row titre">
                        <h1> Statistiques de l'Événement </h1>
                    </div>
                    <div>
                        <table>
                            <thead> 
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Satisfait Élève</th>
                                    <th scope="col">Neutre Élève</th>
                                    <th scope="col">Insatisfait Élève</th>
                                    <th scope="col">Satisfait Employeur</th>
                                    <th scope="col">Neutre Employeur</th>
                                    <th scope="col">Insatisfait Employeur</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php  
            while($row = $result->fetch_assoc()) {
    ?>
                                <tr>
                                    <td scope="row"><?php echo $id ?></td>
                                    <td><?php  echo $row["nom"] ?></td>
                                    <td><?php  echo $row['satisfait']?></td>
                                    <td><?php  echo $row['neutre']?></td>
                                    <td><?php  echo $row['insatisfait']?></td>
                                    <td><?php  echo $row['satis_Em']?></td>
                                    <td><?php  echo $row['neutre_Em']?></td>
                                    <td><?php  echo $row['insatis_Em']?></td>
                                </tr>      
    <?php                  
            }
    ?>
                            </tbody>
                        </table>
                        <div class="row buttonAdmin">
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg btnRetour"> <a href='even.php' > Retour </a></button>
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

</body>
</html>