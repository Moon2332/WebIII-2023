<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une information</title>
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "tableexercice";

        $nomErreur = "";
        $prenomErr = "";
        $persoErr = "";
        $imagePersoErr = "";
        $erreur = false;

        // Create connection
        $conn =new mysqli($servername, $username, $password, $db);
        $conn->query('SET NAMES utf8');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";
        
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $id = $_GET['id'];

            $sql = "SELECT * FROM cours WHERE id = " . $id;
    
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nom = $row['nom'];     
                $prenom = $row['prenom'];    
                $perso = $row['perso'];       
                $imagePerso = $row['imagePerso'];  
            } else {
                echo "0 results";
            }
        } 
        else 
            $id = $_POST['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST['nom'])){
                $nomErreur = "Le nom est requis.";
                $erreur = true;
            }
            else {
                $nom = test_input($_POST["nom"]);
            }
            if(empty($_POST['prenom'])){
                $prenomErr = "Le prenom est requis.";
                $erreur = true;
            }
            else{
                $prenom = test_input($_POST["prenom"]);
            }
            if(empty($_POST['perso'])){
                $persoErr = "Le caractère est requis";
                $erreur = true;
            }
            else{
                $perso = test_input($_POST["perso"]);
            }
            if(empty($_POST['imagePerso'])){
                $imagePersoErr = "Le URL de l'image est requis.";
                $erreur = true;
            }
            else{

                $imagePerso = $_POST['imagePerso'];
            }

            $sql = "UPDATE cours SET nom='$nom', prenom='$prenom', perso='$perso', imagePerso='$imagePerso' WHERE id='$id' ";

            if (mysqli_query($conn, $sql)) {
                echo "Enregistrement réussi";
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
            }

            echo "<a href='index.php'> Retour </a>";

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
                        <span style="color:red"> <?php echo $nomErreur; ?> </span>
                    </div>
                    <div class="All">
                        <h4>Prenom :  <input type="text" name="prenom" value="<?php echo $prenom; ?>"></h4><br>
                        <span style="color:red"> <?php echo $prenomErr; ?> </span>
                    </div>
                    <div class="All">
                        <h4>Caractère: <input type="text" name="perso" value="<?php echo $perso; ?>"></h4><br>
                        <span style="color:red"> <?php echo $persoErr; ?> </span>
                    </div>
                    <div class="All">
                        <h4>Image : <input type="url" name="imagePerso" value="<?php echo $imagePerso; ?>"></h4><br>
                        <span style="color:red"> <?php echo $imagePersoErr; ?> </span>
                    </div>
                    <div class="All">
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