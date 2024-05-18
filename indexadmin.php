<?php
session_start();

require_once(__DIR__ . '/fonctionAdmin.php');
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groupomania Admin</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="styleAdmin.css">
    <link rel="stylesheet" href="fontawesone/css/all.css">
    
</head>

<body class="d-flex flex-column min-vh-100 container">

    <div class="row g-3 mt-3">

        <?php
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            switch ($_GET['page']) {

              
                case 'connexion':
                    include_once(__DIR__ . '/connexion.php');
                    break;

                case 'traitement':
                    include_once(__DIR__ . '/traitement.php');
                    break;

                case 'publication':
                    include_once(__DIR__ . '/publication.php');
                    break;

                case 'utilisateur':
                    include_once(__DIR__ . '/utilisateur.php');
                    break;

                case 'parametre':
                    include_once(__DIR__ . '/parametre.php');
                    break;

                case 'dashbord':
                    include_once(__DIR__ . '/dashbord.php');
                    break;
                case 'supprimer-publication':
                    include_once(__DIR__ . '/suppression.php');
                    break;

                case 'supprimer-utilisateur':
                    include_once(__DIR__ . '/suppressionUser.php');
                    break;
                case 'deconnexionAdmin':
                    include_once(__DIR__ . '/deconnexionAdmin.php');
                    break;

                default:
                if (est_connecteAdmin()) {
                    include_once(__DIR__ . '/dashbord.php');
                    break;
                }else {
                    include_once(__DIR__ . '/connexion.php');
                    break;
                }
                   
            }
        } else {
            include_once(__DIR__ . '/connexion.php');
        }
        ?>
    </div>

    <?php
    require_once(__DIR__ . '/footer.php');
    ?>

    <script src="/bootstrap/bootstrap.min.js"> </script>
    <script src="fontawesone/js/all.js"></script>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
</body>

</html>