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

    <title>NIP</title>
</head>
<body id="bodyNip">
    <?php
        
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if(isset($_GET["action"])){
                $_SESSION["action"] =  $_GET["action"];
                }
                if(isset($_GET["page"])){
                    $_SESSION["page"] =  $_GET["page"];
                    }
                if(isset($_GET['id_Ev']))
                    $id = $_GET['id_Ev'];
            }

            //echo $_SESSION["action"];
            $nomErreur = ""; $name = "";$erreur = ""; 
            $nip = ""; $nipErreur = ""; 

            /*$servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";*/

            //Fichier pour connexion local
            REQUIRE('connServer.php');

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {


                $id = $_POST['id'];

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

                    header("Location: " . $_SESSION['page']);

                }else {
                    if($_POST["id"] != ""){
                        if($_SESSION["action"] == "index.php")
                            header("Location: index.php?page=PageEven&id=" . $_POST["id"]);
                        else
                            header("Location: employeur.php?page=PageEven&id=" . $_POST["id"]);
                    }
                }
                $conn->close();
            }
            if ($_SERVER["REQUEST_METHOD"] != "POST") {   
    ?>
    <div class="container-fluid" id="FormAjouterCom">
    <div class="row" id="formAjCom">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="">
                    <div class="container-fluid allofem">
                        <div class="row">
                            <div class="All col-12">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            </div>
                            <div class="col-12">
                                <h4>Entrez le username :  <input type="text" name="user" value="<?php echo $name; ?>"></h4>
                            </div>
                            <div class="col-12">
                                <h4>Entrez le NIP :  <input type="password" name="nip" value="<?php echo $nip; ?>"></h4>
                            </div>
                            <div class="All col-12">
                                <input type="submit" class="btn btn-link btn-outline-primary btn-lg">
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                </div>
    <?php
            }

            //header("Location: connexion.php");
        

        function test_input($data){
            $data = trim($data);
            $data = addslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

</body>
</html>