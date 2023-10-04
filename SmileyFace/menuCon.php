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
    <link rel="stylesheet" href="CSS/conn.css" type="text/css">
    <title>Menu</title>
</head>
<body>
<?php
        if ( $_SESSION["connexion"] == true)
        {
            $_SESSION["page"] = "menuCon.php";
?>
            <div class="container-fluid menuCon">
                <div class="row titreMenu" >
                    <h1 id="titreMenu"> Menu </h1>
                </div> 
                <div class="container-fluid optionCon">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                    <div class="col-1">  
                                        <a href="admin.php?page=admin.php"> 
                                            <i class="fa-solid fa-user"> </i>
                                    </div>
                                    <div class="col-11">
                                            <p> Administrateurs</p>
                                        </a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1"> 
                                    <a href="even.php?page=even.php"> 
                                        <i class="fa-solid fa-calendar-days"> </i>
                                </div>
                                <div class="col-11">
                                        <p>Évènements</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1"> 
                                    <a href="dep.php?page=dep.php"> 
                                        <i class="fa-solid fa-building"></i>
                                </div>
                                <div class="col-11">
                                        <p>Département</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1">
                                    <a href="connexion.php?action=decon"> 
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                </div>
                                <div class="col-7">
                                            <p>Déconnexion</p>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
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