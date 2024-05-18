

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Groupomania</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <style>
        /* Custom styles for this template */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #fd4907;
        }

        .navbar-brand {
            color: #fff;
        }

        .sidebar {
            background-color: #fd4907;
            color: #fff;
        }

        .TotalUsers {
            background-color: #fd4907;
            color: #fff;
        }

        .sidebar a {
            color: #fff;
        }

        .sidebar-heading {
            padding: 1rem;
        }

        .main-content {
            padding: 2rem;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Administeur Dashboard</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="indexadmin.php?page=dashbord">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="indexadmin.php?page=utilisateur">
                                Utilisateur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="indexadmin.php?page=publication"">
                                Publication
                            </a>
                        </li>
                        <li class=" nav-item">
                                <a class="nav-link" href="indexadmin.php?page=parametre">
                                    Parametre
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="indexadmin.php?page=deconnexionAdmin">
                                Deconnecter
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


                <?php


                $erreurs = [];
                $donnees = [];
                $erreur = '';
                $success = '';

                if (isset($_GET['erreurs']) && !empty($_GET['erreurs'])) {
                    $erreurs = json_decode($_GET['erreurs'], true);
                }

                if (isset($_GET['donnees']) && !empty($_GET['donnees'])) {
                    $donnees = json_decode($_GET['donnees'], true);
                }

                if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
                    $erreur = $_GET['erreur'];
                }

                if (isset($_GET['success']) && !empty($_GET['success'])) {
                    $success = $_GET['success'];
                }

                // $donnees = array_merge($_SESSION['utilisateur_connecter'], $donnees);

                ?>

                <h1 class="h1 mt-3">
                    Mon profil
                </h1>

                <?php

                if (!empty($erreur)) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $erreur; ?>
                    </div>
                <?php
                }


                if (!empty($success)) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success; ?>
                    </div>
                <?php
                }
                ?>

                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Mettre a jour son mot de passe
                            </div>
                            <div class="card-body">
                                <form action="indexadmin.php?page=mise-a-jour-mot-de-passe-traitement" method="POST" novalidate>
                                    <p class="fw-bold">
                                        Les champs avec <span class="text-danger">(*)</span> sont obligatoire.
                                    </p>

                                    <div class="mb-3">
                                        <label for="mise-a-jour-mot-de-passe-mot-de-passe-actuel" class="form-label">
                                            Mot de passe actuel :
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="mot-de-passe-actuel" class="form-control mise-a-jour-mot-de-passe-mot-de-passe-actuel" id="mise-a-jour-mot-de-passe-mot-de-passe-actuel" placeholder="Veuillez entrer votre mot de passe actuel." required value="<?= (isset($donnees['mot-de-passe-actuel']) && !empty($donnees['mot-de-passe-actuel'])) ? $donnees['mot-de-passe-actuel'] : '' ?>">
                                        <p class="text-danger">
                                            <?= (isset($erreurs['mot-de-passe-actuel']) && !empty($erreurs['mot-de-passe-actuel'])) ? $erreurs['mot-de-passe-actuel'] : '' ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mise-a-jour-mot-de-passe-nouveau-mot-de-passe" class="form-label">
                                            Nouveau mot de passe :
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="nouveau-mot-de-passe" class="form-control mise-a-jour-mot-de-passe-nouveau-mot-de-passe" id="mise-a-jour-mot-de-passe-nouveau-mot-de-passe" placeholder="Veuillez entrer votre nouveau mot de passe." required value="<?= (isset($donnees['nouveau-mot-de-passe']) && !empty($donnees['nouveau-mot-de-passe'])) ? $donnees['nouveau-mot-de-passe'] : '' ?>">
                                        <p class="text-danger">
                                            <?= (isset($erreurs['nouveau-mot-de-passe']) && !empty($erreurs['nouveau-mot-de-passe'])) ? $erreurs['nouveau-mot-de-passe'] : '' ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" class="form-label">
                                            Confirmer nouveau mot de passe :
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="confirmer-nouveau-mot-de-passe" class="form-control mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" id="mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" placeholder="Veuillez entrer confirmer le nouveau mot de passe." required value="<?= (isset($donnees['confirmer-nouveau-mot-de-passe']) && !empty($donnees['confirmer-nouveau-mot-de-passe'])) ? $donnees['confirmer-nouveau-mot-de-passe'] : '' ?>">
                                        <p class="text-danger">
                                            <?= (isset($erreurs['confirmer-nouveau-mot-de-passe']) && !empty($erreurs['confirmer-nouveau-mot-de-passe'])) ? $erreurs['confirmer-nouveau-mot-de-passe'] : '' ?>
                                        </p>
                                    </div>

                                    <button type="submit" class="btn" style="background-color:#fd4907; color:white;">Modifier mes coordonnées</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>