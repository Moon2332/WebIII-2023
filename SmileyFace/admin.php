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
    <link rel="stylesheet" href="CSS/admin.css" type="text/css">
    <title>Page Administrateur</title>
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
            $_SESSION["admin"] = "PageAdmin";

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "connected";

            $sql = "SELECT * FROM compteadmin";

            $result = $conn->query($sql);
    ?>  
            <div class="container-fluid">
                <div class="row titre">
                    <h1> Administrateurs </h1>
                </div>
    <?php       
            if ($result->num_rows > 0) {
                echo "  <div class=\"row tableAdmin\">
                            <div class=\"table-responsive\">
                                <table>
                                    <thead> 
                                        <tr>
                                            <th scope=\"col\">ID</th>
                                            <th scope=\"col\">Username</th>
                                            <th scope=\"col\">Email</th>
                                            <th scope=\"col\">Mot de passe</th>
                                            <th scope=\"col\">NIP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    ";
                while($row = $result->fetch_assoc()) {
                    echo "              <tr>
                                            <td scope=\"row\">" . $row["id"]  . "</td>
                                            <td>" . $row["user"] . "</td>
                                            <td>" . $row["email"] . "</td>
                                            <td>" . $row["code"] . "</td>
                                            <td>" . $row["nip"] . "</td>
                                            <td> <a href=\"modCompte.php?id=" . $row["id"] . "\"> Modifier </a></td>
                                            <td> <a href=\"supCompte.php?id=" . $row["id"] . "\"> Supprimer </a></td>
                                        </tr>      
                    ";
                }
        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row buttonAdmin">
                            <i class="fa-solid fa-user-plus"></i>
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg"> <a href='ajouterCompte.php'> Ajouter </a></button>
                            <i class="fa-solid fa-arrow-left"></i>
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg btnRetour"> <a href='connexion.php?action=retour' > Retour </a></button>
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <button type="button" class="btn btn-link btn-outline-primary btn-lg btnDecon"><a href='nip.php?action=decon'> Déconnexion </a></button>
                        </div>

                    </div>
                ";
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
        


  


    <script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>