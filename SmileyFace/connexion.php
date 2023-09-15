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
        $userU = ""; $nomErreur = "";
        $passwordU = ""; $name = "";
        $erreur = ""; $nip = "";

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
        //echo "Connected successfully";

        if(isset($_GET['action'])){
    ?>
        <div class="container-fluid allofem">
            <div class="row">
                <div class="col-12">
                    <h4>Entrez le username :  <input type="text" name="user" value="<?php echo $name; ?>"></h4>
                </div>
                <div class="col-12">
                    <h4>Entrez le NIP :  <input type="number" name="nip" value="<?php echo $nip; ?>"></h4>
                </div>
            </div>
        </div>

    <?php
        $sql = "SELECT * FROM compteadmin WHERE user='$name' AND nip='$nip'";
        //echo $sql;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<h2>Nom d'usager ou mot de passe invalide</h2>";
        }
        $conn->close();
            if($_GET['action'] == "decon"){
                session_unset();

                session_destroy();  

    ?>
                <script>alert("Déconnexion réussie.");</script>
    <?php
            }
            else if($_GET['action'] == "retour"){
    ?>
                <div class="container-fluid allofem">
                    <div class="row">
                        <div class="All col-12">
                            <a href="employeur.php">
                                <h4> Affichage Vote pour Employeur</h4>
                            </a>
                        </div>
                        <div class="All col-12">
                            <a href="index.php">
                                <h4> Affichage Vote pour Élève</h4>
                            </a>
                        </div>
                    </div>
                </div>

                <script>alert("Rétour réussie.");</script>
    <?php
            }
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
                $nomErreur = "Le mot de passe est requis.";
                $erreur = true;
            }
            else {
                $passwordU = test_input($_POST["password"]);
            }

            $userU = $_POST['email'];
            $passwordU = $_POST['password'];

            $passwordU = sha1($passwordU, false);

            $sql = "SELECT * FROM compteadmin WHERE email='$userU' AND code='$passwordU'";
            //echo $sql;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION["connexion"] = true;
        {
    ?>
            <div class="container-fluid allofem">
                <div class="row">
                    <div class="All col-12">
                        <a href="employeur.php">
                            <h4> Affichage Vote pour Employeur</h4>
                        </a>
                    </div>
                    <div class="All col-12">
                        <a href="index.php">
                            <h4> Affichage Vote pour Élève</h4>
                        </a>
                    </div>
                </div>
            </div>
    <?php
        }
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