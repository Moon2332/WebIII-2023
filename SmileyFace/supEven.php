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

    <title>Supprimer un évènement</title>
</head>
<body>
<?php

    if ( $_SESSION["connexion"] == true)
        {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if(isset($_GET["action"])){
                $_SESSION["action"] =  $_GET["action"];
                }
            }
            
            if ($_SESSION["action"] == 'PageEven')
            {
                //Fichier pour connexion local
                REQUIRE('connServer.php');

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

                if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
    ?>
                    <div class="container-fluid" id="FormAjouterCom">
                        <div class="row titre">
                            <h1> Formulaire pour supprimer un Évènement </h1>
                        </div>
                        <div class="row" id="formAjCom">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="All">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        </div>
                                        <div class="col-6">
                                            <h4>Nom : <input type="text" name="nom" value="<?php echo $nom; ?>"></h4><br>
                                        </div>
                                        <div class="col-6">
                                            <h4>Date :  <input type="text" name="date" value="<?php echo $date; ?>"></h4><br>
                                        </div>
                                        <div class="col-6">
                                            <h4>Lieu : <input type="text" name="lieu" value="<?php echo $lieu; ?>"></h4><br>
                                        </div>
                                        <div class="col-6">
                                            <h4>Description : <input type="text" name="description" value="<?php echo $desc; ?>"></h4><br>
                                        </div>
                                        <div class="All col-12">
                                            <input type="submit" class="btn btn-link btn-outline-primary btn-lg">

                                            <button type="button" class="btn btn-link btn-outline-primary btn-lg retour" ><a href='even.php'> Retour </a></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    <?php
                }
            }
            else {
                header("Location: connexion.php?action=decon");
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