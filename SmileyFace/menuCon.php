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
    <link rel="stylesheet" href="CSS/connexion.css" type="text/css">
    <title>Menu</title>
</head>
<body>
<?php
        if ( $_SESSION["connexion"] == true)
        {
?>
            <div class="container-fluid menuCon">
                <div class="row titreMenu" >
                    <h1 id="titreMenu"> Menu </h1>
                </div> 
                <div class="container-fluid optionCon">
                    <div class="row rowMenuOption">
                        <div class="col-12">
                            <i class="fa-solid fa-user"></i>
                            <a href="admin.php">
                                <h4> Administrateurs </h4>
                            </a>
                        </div>
                        <div class="col-12">
                            <i class="fa-solid fa-calendar-days"></i>
                            <a href="even.php">
                                <h4> Évènements </h4>
                            </a>
                        </div>
                                <div class="col-12">
                                    
                                    <a href="dep.php">
                                        <h4> Departement </h4>
                                    </a>
                                </div>
                    </div>
                </div> 
                <div class="row buttonAdmin">
                    <button type="button" class="btn btn-link btn-outline-primary btn-lg btnDecon"><a href='nip.php?action=decon'> Déconnexion </a></button>
                </div>
            </div>

<?php
            }
        else {
            header("Location: connexion.php");
        }
    ?>

    <script src="https://kit.fontawesome.com/b60c3f0b8b.js" crossorigin="anonymous"></script>
</body>
</html>