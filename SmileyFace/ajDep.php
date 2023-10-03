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
    <title>Ajouter une information</title>
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
        
        if ($_SESSION["action"] == 'PageDep')
        {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";
    
            $id =""; $nom = ""; $coor = ""; $erreur = false;
            $idErr =""; $nomErr = ""; $coorErr = "";

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "Connected successfully";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(empty($_POST['id'])){
                    $idErr = "Le ID est requis.";
                    $erreur = true;
                }
                else {
                    $id = test_input($_POST["id"]);
                }
                if(empty($_POST['nom'])){
                    $nomErr = "Le nom est requis.";
                    $erreur = true;
                }
                else {
                    $nom = test_input($_POST["nom"]);
                }
                if(empty($_POST['coord'])){
                    $coorErr = "Le coordonateur est requise.";
                    $erreur = true;
                }
                else{
                    $coor = test_input($_POST["coord"]);
                }
        
                $sql = "INSERT INTO departement (id_D, nom, coordonateur) VALUES ('$id', '$nom', '$coor')";
        
                if (mysqli_query($conn, $sql)) {
                    header("Location: dep.php");
                    } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                mysqli_close($conn);
            }
            
            if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
?>
                <div class="container-fluid" id="FormAjouterDep">
                    <div class="row titre">
                        <h1> Formulaire pour ajouter un Departement </h1>
                    </div>
                    <div class="row" id="formAjDep">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
                            <div class="container-fluid allofem">
                                <div class="row">
                                    <div class="All col-6">
                                        <h3>ID : <input type="text" name="id" value="<?php echo $id; ?>"></h3><br>
                                        <span style="color:red"> <?php echo $idErr; ?> </span>
                                    </div>
                                    <div class="All col-6">
                                        <h3>Nom :  <input type="text" name="nom" value="<?php echo $nom; ?>"></h3><br>
                                        <span style="color:red"> <?php echo $nomErr; ?> </span>
                                    </div>
                                    <div class="All col-6">
                                        <h3>Coordonateur : <input type="text" name="coord" value="<?php echo $coor; ?>"></h3><br>
                                        <span style="color:red"> <?php echo $coorErr; ?> </span>
                                    </div>
                                    <div class="All col-12">
                                        <input type="submit" class="btn btn-link btn-outline-primary btn-lg">
                                        <button type="button" class="btn btn-link btn-outline-primary btn-lg retour" ><a href='dep.php'> Retour </a></button>
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