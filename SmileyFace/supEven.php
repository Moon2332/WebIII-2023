<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une donnée</title>
</head>
<body>
<?php

    if ( $_SESSION["connexion"] == true)
        {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";

            $id =""; $nom = ""; $date = ""; $lieu = ""; $desc = ""; $erreur = false;
            $idErr =""; $nomErr = ""; $dateErr = ""; $lieuErr = ""; $descErr = "";
            
            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $id = $_GET['id'];

                $sql = "SELECT * FROM evenement WHERE id = '$id'" ;
        
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id = $row['id']; 
                    $nom = $row['nom'];     
                    $date = $row['date'];    
                    $lieu = $row['lieu'];       
                    $desc = $row['description'];  
                } else {
                    echo "0 results";
                }
            } 
            else 
                $id = $_POST['id'];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $sql = "DELETE FROM evenement WHERE id = '$id'";

                if (mysqli_query($conn, $sql)) {

                    header("Location: even.php?action=reussi");

                    } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                }

                echo "<h3>Formulaire pour supprimer un Événement</h3>";
                echo "<button type=\"button\" class=\"btn btn-link btn-outline-primary btn-lg retour\" ><a href='connexion.php?action=retour'> Retour </a></button>";

            if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
    ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="container-fluid">
                    <div class="row">
                        <div class="All">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </div>
                        <div class="All">
                            <h4>Nom : <input type="text" name="nom" value="<?php echo $nom; ?>"></h4><br>
                        </div>
                        <div class="All">
                            <h4>Date :  <input type="text" name="date" value="<?php echo $date; ?>"></h4><br>
                        </div>
                        <div class="All">
                            <h4>Lieu : <input type="text" name="lieu" value="<?php echo $lieu; ?>"></h4><br>
                        </div>
                        <div class="All">
                            <h4>Description : <input type="text" name="description" value="<?php echo $desc; ?>"></h4><br>
                        </div>
                        <div class="All col-12">
                            <input type="submit">
                        </div>
                    </div>
                </div>
            </form>

        
    <?php
            }
        }
        else {
            header("Location: connexion.php");
        }
        
        function test_input($data){
            $data = trim($data);
            $data = addslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
        
</body>
</html>