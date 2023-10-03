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

    <title>Modifier un Compte</title>
</head>
<body>
    <?php
        if ( $_SESSION["connexion"] == true)
        {
           if(isset($_GET["action"])){
                $_SESSION["action"] =  $_GET["action"];
                }
            
            if ($_SESSION["action"] == 'PageAdmin')
            {
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $db = "table vote";

                $id =""; $nom = ""; $email = ""; $code= ""; $nip = ""; $erreur = false;
                $idErr =""; $nomErr = ""; $emailErr = ""; $codeErr = ""; $nipErr = ""; 

                // Create connection
                $conn =new mysqli($servername, $username, $password, $db);
                $conn->query('SET NAMES utf8');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //GET LE ID DU COMPTE À MODIFIER
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    if(isset($_GET['id']))
                        $id = $_GET['id'];
                    else 
                        header("Location: nip.php?action=admin");

                    $sql = "SELECT * FROM compteadmin WHERE id = '$id'";
            
                    $result = $conn->query($sql);
            
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $nom = $row['user'];     
                        $email = $row['email'];    
                        $nip = $row['nip'];       
                    } else {
                        echo "0 results";
                    }
                } 
                else 
                    $id = $_POST['id'];

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(empty($_POST['nom'])){
                        $nomErr = "Le nom est requis.";
                        $erreur = true;
                    }
                    else {
                        $nom = test_input($_POST["nom"]);
                    }
                    if(empty($_POST['email'])){
                        $emailErr = "Le email est requis.";
                        $erreur = true;
                    }
                    else{
                        $email = test_input($_POST["email"]);
                    }
                    if(empty($_POST['nip'])){
                        $nipErr = "Le NIP est requis";
                        $erreur = true;
                    }
                    else{
                        $nip = test_input($_POST["nip"]);
                    }

                    $sql = "UPDATE compteadmin SET user='$nom', email='$email', nip='$nip' WHERE id='$id' ";

                    if (mysqli_query($conn, $sql)) {
                        header("Location: admin.php");
                        } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                        mysqli_close($conn);
                    }

                if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
    ?>
                    <div class="container-fluid" id="FormAjouterCom">
                        <div class="row titre">
                            <h1> Formulaire pour modifier un compte admin </h1>
                        </div>
                        <div class="row" id="formAjCom">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <div class="container-fluid allofem">
                                    <div class="row">
                                        <div class="All col-12">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        </div>
                                        <div class="All col-6">
                                            <h4>Nom : <input type="text" name="nom" value="<?php echo $nom; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $nomErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                            <h4>Email :  <input type="email" name="email" value="<?php echo $email; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $emailErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                            <h4>NIP : <input type="password" name="nip" value="<?php echo $nip; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $nipErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                            <input type="submit" class="btn btn-link btn-outline-primary btn-lg">
                                            <button type="button" class="btn btn-link btn-outline-primary btn-lg retour" ><a href='admin.php'> Retour </a></button>
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