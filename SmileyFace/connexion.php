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
    <link rel="stylesheet" href="CSS/conn.css" type="text/css">
    <title>Connexion</title>
</head>
<body>
    <?php
            if(isset($_GET['action'])){
                if($_GET['action'] == "decon"){
                    session_unset();

                    session_destroy(); 
                }
                else if($_GET['action'] == "retour"){
                    header("Location: menuCon.php");
                }
            }
            $userU = ""; $nomErreur = "";
            $passwordU = ""; $passwordUE = ""; $name = "";
            $erreur = ""; $nip = ""; $SesCon = ""; $Erreur = "";

            //Fichier pour connexion local
            REQUIRE('connServeur.php');

            // Create connection
            $conn = new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(empty($_POST['email'])){
                    $nomErreur = "Le email est requis.";
                    $erreur = true;
                }
                else {
                    $userU = test_input($_POST["email"]);
                }
                if(empty($_POST['password'])){
                    $passwordUE = "Le mot de passe est requis.";
                    $erreur = true;
                }
                else {
                    $passwordU = test_input($_POST["password"]);
                }

                $passwordU = sha1($passwordU, false);

                $sql = "SELECT * FROM compteadmin WHERE email='$userU' AND code='$passwordU'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION["connexion"] = true;
                    header("Location: menuCon.php");
                } 
                else {
                    $erreur = true;
                    $Erreur = "Nom d'usager ou Mot de passe Invalide.";
                }
                    
                $conn->close();
            }
            if ($_SERVER["REQUEST_METHOD"] != "POST"  || $erreur == true) {   
    ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="styleFormCon">
                <div class="container-fluid">
                    <div class="row">
                        <div class="All col-12">
                            <span style="color:red"> <?php echo $Erreur; ?> </span>
                        </div>
                        <div class="All col-12">
                            <label for="email"> Email : </label>
                            <input type="email" id="email" name="email" placeholder="email" value="<?php echo $nomErreur; ?>"><br>
                            <span style="color:red"> <?php echo $nomErreur; ?> </span>
                        </div>
                        
                        <div class="All col-12">
                            <label for="email"> Mot de passe : </label>
                            <input type="password" id="password" name="password" placeholder="mot de passe" value="<?php echo $passwordUE; ?>"><br>
                            <span style="color:red"> <?php echo $passwordUE; ?> </span>
                        </div>

                        <div class="All col-12">
                            <input type="submit">
                        </div>
                    </div>
                </div>
            </form>

    <?php
            } 

        function test_input($data){
            $data = trim($data);
            $data = addslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>
</body>
</html>