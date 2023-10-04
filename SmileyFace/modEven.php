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

    <title>Modifier un Événement</title>
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
                //echo "Connected successfully";
                
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    $id = $_GET['id'];

                    $sql = "SELECT * FROM evenement WHERE id = '$id'";
            
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
                    if(empty($_POST['nom'])){
                        $nomErr = "Le nom est requis.";
                        $erreur = true;
                    }
                    else {
                        $nom = test_input($_POST["nom"]);
                    }
                    if(empty($_POST['date'])){
                        $dateErr = "La date est requise.";
                        $erreur = true;
                    }
                    else{
                        $date = test_input($_POST["date"]);
                    }
                    if(empty($_POST['lieu'])){
                        $lieuErr = "Le lieu est requis";
                        $erreur = true;
                    }
                    else{
                        $lieu = test_input($_POST["lieu"]);
                    }
                    if(empty($_POST['desc'])){
                        $descErr = "La description est requise.";
                        $erreur = true;
                    }
                    else{
                        $desc = $_POST['desc'];
                    }
                    //FAIRE LA MODIFICATION DES CHANGEMENTS DE L'UTILISATEUR
                    $sql = "UPDATE evenement SET nom='$nom', date='$date', lieu='$lieu', description='$desc' WHERE id='$id' ";

                    $result = $conn->query($sql);
                
                    if(empty($_POST['deps'])){
                        $depErr = "Choisir au moin un departement";
                        $erreur = true;
                    }
                    else{
                        //Pour supprimer tous les département associés à cet événement
                        $sql = "DELETE FROM depart_even WHERE id_even = '$id'";
                        $result = $conn->query($sql);

                        foreach($_POST['deps'] as $valeur){
                            //Trim et prend le id_depart du departement
                            $valeur = str_replace("/","",$valeur);

                            //Get le id du dep de la table département
                            $sql = "SELECT id FROM departement WHERE id_D = '$valeur'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $id_dep = $row['id'];

                                //INSÉRER LES NOUVELLES DONNÉES
                                $sql = "INSERT INTO depart_even (id_depart, id, id_even ) VALUES ('$valeur','$id_dep','$id')"; 
                                $result = $conn->query($sql);
                            } else {
                                echo "0 results";
                            }
                        }
                    }
                    //RENVOIE ENSUITE À LA PADE ÉVÉNEMENT
                    header("Location: even.php");
                }

                if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {       
    ?>
                    <div class="container-fluid" id="FormAjouterCom">
                        <div class="row titre">
                            <h1> Formulaire pour modifier un événement</h1>
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
                                            <h4>Date :  <input type="date" name="date" value="<?php echo $date; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $dateErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                            <h4>Lieu : <input type="text" name="lieu" value="<?php echo $lieu; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $lieuErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                        <h4>Description : <input type="text" name="desc" value="<?php echo $desc; ?>"></h4><br>
                                            <span style="color:red"> <?php echo $descErr; ?> </span>
                                        </div>
                                        <div class="All col-6">
                                                    <h4><label for="deps">Departement Associé : </label><br></h4>
    <?php
                    //POUR AVOIR LA LISTE DE TOUS LES DÉPARTEMENTS
                    $sql = "SELECT id_D, nom FROM departement";
                    $result= $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
    ?>
                                        <h4>
                                            <input type="checkbox" id="<?php echo $row["id_D"]; ?>" name="deps[]" value="<?php echo $row["id_D"]?>">
                                            <label for="<?php echo $row["id_D"]; ?>"><?php echo $row["id_D"] . " - " . $row["nom"]; ?></label>
                                        </h4>
    <?php                  
                        }
                    }
    ?>
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