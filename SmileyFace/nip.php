<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIP</title>
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

            echo $_SESSION["action"];
            $nomErreur = ""; $name = "";$erreur = ""; 
            $nip = ""; $nipErreur = ""; 

            /*$servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";*/

            //Fichier pour connexion local
            REQUIRE('connLocal.php');

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(empty($_POST['user'])){
                    $nomErreur = "Le username est requis.";
                    $erreur = true;
                }
                else {
                    $name = test_input($_POST["user"]);
                }
                if(empty($_POST['nip'])){
                    $nipErreur = "Le NIP est requis.";
                    $erreur = true;
                }
                else {
                    $nip = test_input($_POST["nip"]);
                }

                $sql = "SELECT * FROM compteadmin WHERE user='$name' AND nip='$nip'";
            
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if($_SESSION["action"]  == "decon"){
                        header("Location: connexion.php?action=decon");
                    }
                    else if($_SESSION["action"]  == "retour"){
                        header("Location: connexion.php?action=retour");
                    }
                    else if($_SESSION["action"]  == "admin"){
                        echo "ADMIN";
                        //header("Location: admin.php");
                    }
                }else {
                    //echo "<h2>Nom d'usager ou mot de passe invalide</h2>";
                    header("Location: connexion.php");
                }
                $conn->close();
            }
            if ($_SERVER["REQUEST_METHOD"] != "POST") {   
    ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="container-fluid allofem">
                        <div class="row">
                            <div class="col-12">
                                <h4>Entrez le username :  <input type="text" name="user" value="<?php echo $name; ?>"></h4>
                            </div>
                            <div class="col-12">
                                <h4>Entrez le NIP :  <input type="password" name="nip" value="<?php echo $nip; ?>"></h4>
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