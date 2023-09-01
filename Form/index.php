<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
    <title>Exercice BD</title>
</head>
<body>
   

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "tableexercice";
        // Create connection
        $conn =new mysqli($servername, $username, $password, $db);
        $conn->query('SET NAMES utf8');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";

        $sql = "SELECT * FROM cours";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "  <div class=\"table-responsive\">
                        <table class=\"table table-dark table-striped table-hover\">
                            <thead class=\"thead-dark\"> 
                                <tr>
                                    <th scope=\"col\">ID</th>
                                    <th scope=\"col\">Nom</th>
                                    <th scope=\"col\">Prenom</th>
                                    <th scope=\"col\">Character</th>
                                    <th scope=\"col\">Image</th>
                                </tr>
                            </thead>
                            <tbody>
                ";
            while($row = $result->fetch_assoc()) {
                    echo "      <tr>
                                    <td scope=\"row\">" . $row["id"]  . "</td>
                                    <td>" . $row["nom"] . "</td>
                                    <td>" . $row["prenom"] . "</td>
                                    <td>" . $row["perso"] . "</td>
                                    <td> <img class=\"img-fluid rounded float-left\" src=\"" . $row["imagePerso"]  . "\"' width=\"200px\" height=\"200px\"></td>
                                    <td> <a href=\"modifier.php?id=" . $row["id"] . "\"> Modifier </a></td>
                                    <td> <a href=\"supprimer.php?id=" . $row["id"] . "\"> Supprimer </a></td>
                                </tr>      
                   ";
             }
            echo "          </tbody>
                        </table>
                    </div>
            ";
        } else {
                echo "0 results";
        }

        $conn->close();

        echo "<a href='ajouter.php' > Ajouter </a>";
    ?>

</body>
</html>