<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">
    <title>Ajouter une information</title>
</head>
<body>
<?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "linge";
   
        $nom = ""; $nomErreur = "";
        $email = ""; $emailErr = "";
        $mdp = ""; $mdpErr = "";
        $erreur = false;
   
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST['nom'])){
                $nomErreur = "Le nom est requis.";
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
            if(empty($_POST['mdp'])){
                $mdpErr = "Le mot de passe est requis";
                $erreur = true;
            }
            else{
                $mdp = test_input($_POST["mdp"]);
            }

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');
    
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "Connected successfully";
    
            $sql = "INSERT INTO usagers (user, email, password) VALUES ('$nom', '$email', '$mdp')";

            //echo $sql;
    
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php?action=reussi");
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            mysqli_close($conn);
            }

            echo "<h3>Formulaire pour ajouter un utilisateur</h3>";
            echo "<button type=\"button\" class=\"btn btn-link btn-outline-primary btn-lg retour\" ><a href='connexion.php'> Retour </a></button>";

    if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="container-fluid allofem">
                <div class="row">
                    <div class="All col-12">
                        <h4>Nom : <input type="text" name="nom" value="<?php echo $nom; ?>"></h4><br>
                        <span style="color:red"> <?php echo $nomErreur; ?> </span>
                    </div>
                    <div class="All col-12">
                        <h4>Email :  <input type="email" name="email" value="<?php echo $email; ?>"></h4><br>
                        <span style="color:red"> <?php echo $emailErr; ?> </span>
                    </div>
                    <div class="All col-12">
                        <h4>Mot de passe : <input type="password" name="mdp" value="<?php echo $mdp; ?>"></h4><br>
                        <span style="color:red"> <?php echo $mdpErr; ?> </span>
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
</body>
</html>