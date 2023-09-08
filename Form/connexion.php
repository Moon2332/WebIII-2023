<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <?php
        if(isset($_GET['action'])){
            if($_GET['action'] == "decon"){
                session_unset();

                session_destroy();  

                ?><script>alert("Déconnexion réussie.");</script><?php
            }
        }
        $userU = ""; $nomErreur = "";
        $passwordU = "";
        $erreur = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if(empty($_POST['email'])){
                $nomErreur = "Le email est requis.";
                $erreur = true;
            }
            else {
                $userU = test_input($_POST["email"]);
            }
            if(empty($_POST['password'])){
                $nomErreur = "Le mot de passe est requis.";
                $erreur = true;
            }
            else {
                $passwordU = test_input($_POST["password"]);
            }

            $userU = $_POST['email'];
            $passwordU = $_POST['password'];

            $passwordU = sha1($passwordU, false);
            //echo $password;
        
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "linge";

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            echo "Connected successfully";

            $sql = "SELECT * FROM usagers WHERE email='$userU' AND password='$passwordU'";
            echo $sql;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h1>Connecté</h1>";
                $_SESSION["connexion"] = true;
                header("Location: index.php?");
            } else {
                echo "<h2>Nom d'usager ou mot de passe invalide</h2>";
            }
            $conn->close();
        }
        if ($_SERVER["REQUEST_METHOD"] != "POST") {   
    ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="container-fluid">
                    <div class="row">
                        <div class="All col-12">
                            <input type="email" name="email" placeholder="email"><br>
                        </div>
                        
                        <div class="All col-12">
                            <input type="password" name="password" placeholder="mot de passe"><br>
                        </div>

                        <div class="All col-12">
                            <input type="submit">
                        </div>

                        <button type="button" class="btn btn-link btn-outline-primary btn-lg"> <a href='ajouterCompte.php' > Ajouter </a></button>

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

</body>
</html>