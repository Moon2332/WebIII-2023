<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/css.css">
    <title>Travail BD</title>
</head>
<body>
    <?php

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db = "tableexercice";

        $nom = ""; $nomErreur = "";
        $prenom = ""; $prenomErr = "";
        $perso = ""; $persoErr = "";
        $imagePerso = ""; $imagePersoErr = "";
        $erreur = false;
    ?>
     <script>
        function submitForm(){
            let n = document.getElementById('Choix').submit();
            n.innerHTML = "bitch";
        }
    </script>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(empty($_POST['nom'])){
                $nomErreur = "Le nom est requis.";
                $erreur = true;
            }
            else {
                $nom = test_input($_POST["nom"]);
            }
        }
        // Create connection
        $conn =new mysqli($servername, $username, $password, $db);
        $conn->query('SET NAMES utf8');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";

        //$sql = "INSERT INTO cours (nom, prenom, perso, imagePerso) VALUES ('$nom', '$prenom', '$perso', '$imagePerso')";

        //echo $sql;

        if($_SERVER["REQUEST_METHOD"] != "POST" || $erreur == true) {  

    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="container-fluid h-100">
                <div class="row text-center align-items-center">
                    <p> Qu'elle est votre niveau de satisfaction ? </p>
                </div>

                <div class="row text-center align-items-center buttons">
                    <div class="button col-4" onclick="submitForm()" id="Good" title="Choix">
                        <p>Satisfait</p>
                        <label><i class="fa-regular fa-face-smile fa-6x" style="color: #ffea00;"></i> </label>
                    </div>
                    <div class="button col-4" onclick="submitForm()" id="Neutre" title="Choix">
                        <p>Neutre</p>
                        <label><i class="fa-regular fa-face-meh fa-6x" style="color: #ffea00;"></i> </label>
                    </div>
                    <div class="button col-4" onclick="submitForm()" id="Bad" title="Choix">
                        <p>Insatisfait</p>
                        <label><i class="fa-regular fa-face-frown fa-6x" style="color: #ffea00;"></i></label>
                    </div>

                    <div class="button col-4" onclick='submitForm()' id="Bad" title="Choix">
                        <p id="just">Insatisfait</p>
                    </div>
                </div>
            </div>
        </form>

    <?php
        }

    ?>


  


    <script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>
</body>
</html>