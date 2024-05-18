<?php
session_start();

require_once(__DIR__ . '/fonction.php');


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groupomania</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/Dashbord-administrateur/css/style.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="fontawesone/css/all.css">
</head>

<body class="d-flex flex-column min-vh-100 container">

    <?php require_once(__DIR__ . '/commun/header.php'); ?>

    <div class="row g-3 mt-3">

        <?php
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            switch ($_GET['page']) {

                case 'accueil':
                    include_once(__DIR__ . '/accueil.php');
                    break;

                case 'connexion':
                    include_once(__DIR__ . '/connexion/index.php');
                    break;

                case 'ajouter':
                    include_once(__DIR__ . '/publication/ajouter/index.php');
                    break;

                case 'modifier':
                    include_once(__DIR__ . '/publication/modifier/index.php');
                    break;

                case 'deconnexion':
                    include_once(__DIR__ . '/deconnexion.php');
                    break;

                case 'traitement-connexion':
                    include_once(__DIR__ . '/connexion/traitement.php');
                    break;

                case 'inscription':
                    include_once(__DIR__ . '/inscription/index.php');
                    break;

                case 'traitement-inscription':
                    include_once(__DIR__ . '/inscription/traitement.php');
                    break;

                case 'publication':
                    include_once(__DIR__ . '/publication/index.php');
                    break;
                case 'action':
                    include_once(__DIR__ . '/php/action.php');
                    break;

                case 'actualite':
                    include_once(__DIR__ . '/actualite.php');
                    break;

                case 'commentaire':
                    include_once(__DIR__ . '/php/commentaire.php');
                    break;

                case 'mes-publications':
                    include_once(__DIR__ . '/mes-publications/index.php');
                    break;

                case 'mon-profil':
                    include_once(__DIR__ . '/mon-profil/index.php');
                    break;

                case 'oublier':
                    include_once(__DIR__ . '/mot-de-passe-oublie/index.php');
                    break;

                case 'modifier-mot-de-passe':
                    include_once(__DIR__ . '/mot-de-passe-oublie/modifier-mot-de-passe.php');
                    break;

                case 'traitement-modifier':
                    include_once(__DIR__ . '/mot-de-passe-oublie/traitement-modifier-mot-de-passe.php');
                    break;

                case 'formulaire':
                    include_once(__DIR__ . '/mot-de-passe-oublie/formulaire.php');
                    break;

                case 'traitement-index':
                    include_once(__DIR__ . '/mot-de-passe-oublie/traitement.php');
                    break;
                
                case 'formulaire-traitement':
                    include_once(__DIR__ . '/mot-de-passe-oublie/formulaire-traitement.php');
                    break;

                case 'supprimer-publication':
                    include_once(__DIR__ . '/mes-publications/supprime.php');
                    break;

                case 'traitement-ajouter-publication':
                    include_once(__DIR__ . '/publication/ajouter/traitement.php');
                    break;

                case 'traitement-modifier-publication':
                    include_once(__DIR__ . '/publication/modifier/traitement.php');
                    break;

                default:
                    if (est_connecter()) {
                        include_once(__DIR__ . '/actualite.php');
                        break;
                    } else {
                        include_once(__DIR__ . '/connexion/index.php');
                        break;
                    }
            }
        } else {
            include_once(__DIR__ . '/accueil.php');
        }
        ?>
    </div>

    <?php
    require_once(__DIR__ . '/commun/footer.php');
    ?>

    <script src="bootstrap.js"> </script>
    <script src="fontawesone/js/all.js"></script>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</body>

</html>