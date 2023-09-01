<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        echo "Connected successfully";

        $sql = "SELECT * FROM cours";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "  <table>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Character</th>
                            <th>Image</th>
                        </tr>
                ";
            while($row = $result->fetch_assoc()) {

            echo "      <tr>
                            <td>" . $row["id"]  . "</td>
                            <td>" . $row["nom"] . "</td>
                            <td>" . $row["prenom"] . "</td>
                            <td>" . $row["perso"] . "</td>
                            <td> <img src='" . $row["imagePerso"]  . "'></td>
                        </tr>      
                   ";
             }
            echo "</table>";
        } else {
                echo "0 results";
        }

        $conn->close();

        echo "<a href='ajouter.php' > Ajouter </a>"
    ?>

</body>
</html>