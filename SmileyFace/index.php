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
    <title>Vote Élève</title>
</head>
<body>
    <?php
        if ( $_SESSION["connexion"] == true)
        {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = "table vote";
            $erreur = false;

            // Create connection
            $conn =new mysqli($servername, $username, $password, $db);
            $conn->query('SET NAMES utf8');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //echo "CONNECTED";

            if ($_SERVER["REQUEST_METHOD"] == "GET") 
                if(isset($_GET['id']))
                    $id = $_GET['id'];
                else 
                    header("Location: even.php");

            if(isset($_GET['action'])) {
                $sql = "UPDATE evenement SET ". $_GET['action'] . " = " . $_GET['action'] . " + 1 WHERE id = '$id'" ;
                echo $sql;
                if (mysqli_query($conn, $sql)) {
                    //header("Location: index.php");
                    } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                mysqli_close($conn);
            }
        

            if($_SERVER["REQUEST_METHOD"] != "POST"){  
                echo "  <div class=\"container-fluid\" style=\"display: flex;justify-content: space-evenly;\"> 
                            <div class=\"row\">
                                <div class=\"col-6\"> 
                                    <button type=\"button\" class=\"btn btn-link btn-outline-primary btn-lg\"><a href='nip.php?action=retour'> Retour </a></button>
                                </div>
                                <div class=\"col-6\"> 
                                    <button type=\"button\" class=\"btn btn-link btn-outline-primary btn-lg\"><a href='nip.php?action=decon'> Déconnexion </a></button>
                                </div>
                            </div>
                        </div>
                    ";
    ?>
                <div class="container-fluid"> 
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <fieldset class="row"> 
                            <div class="col-12 text-center">
                                <p> Qu'elle est votre niveau de satisfaction ? </p>
                            </div>

                            <div class="col-12 text-center align-items-center">
                                <div class="row">

                                    <button type="button" name="Choix" class="col-4" style="background-color: inherit; border: none;">
                                        <a href="index.php?id=<?php echo $id ?>&action=satisfait">
                                            <div>
                                                <p>Satisfait</p>
                                                <label><i class="fa-regular fa-face-smile fa-6x" style="color: green;"></i> </label>
                                            </div> 
                                        </a>
                                    </button>

                                    <button type="button" name="Choix" class="col-4" style="background-color: inherit; border: none;">
                                        <a href="index.php?action=neutre&id=<?php echo $id ?>">
                                            <div>
                                                <p>Neutre</p>
                                                <label><i class="fa-regular fa-face-meh fa-6x" style="color: #ffea00;"></i> </label>
                                            </div>
                                        </a>
                                    </button>

                                    <button type="button" name="Choix" class="col-4" style="background-color: inherit; border: none;">
                                        <a href="index.php?action=insatisfait&id=<?php echo $id ?>">
                                            <div>
                                                <p>Insatisfait</p>
                                                <label><i class="fa-regular fa-face-frown fa-6x" style="color: red;"></i></label>
                                            </div>
                                        </a>
                                    </button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
    <?php
            }
        }
        else {
            header("Location: connexion.php");
        }

    ?>
    <script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>