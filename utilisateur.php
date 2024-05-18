<?php

$totalUsers = countUsers($db);
$countPublication = countPublication($db);
$countCommentaire = countCommentaire($db);
$countLikes = countLikes($db);
// Exemple d'utilisation
$utilisateurs = recupererUtilisateurs();

?>

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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Utilisateurs</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénoms</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $indexadmin => $utilisateur) : ?>
                            <tr>
                                <th scope="row"><?php echo $indexadmin + 1; ?></th>
                                <td><?php echo $utilisateur['nom']; ?></td>
                                <td><?php echo $utilisateur['prenoms']; ?></td>
                                <td><?php echo $utilisateur['email']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#details-utilisateur-<?= $utilisateur['id'] ?>">
                                        Détails</a>
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer-utilisateur-<?= $utilisateur['id']; ?>">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal : details publication -->
                            <div class="modal fade" id="details-utilisateur-<?= $utilisateur['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Profil de l'utilisateur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- <p><span class="fw-bold">Image</span> :</p> -->
                                            <!-- <p class="text-center">
                                                <img style="height: 200px;width: 100%;object-fit: cover;" src="<?= $utilisateur['avatar']; ?>" class="card-img-top" alt="Image de la l'utilisateur">
                                            </p> -->
                                            <p><span class="fw-bold" style="color: #fd4907;">Nom</span> : <?= $utilisateur['nom']; ?></p>
                                            <p><span class="fw-bold" style="color: #fd4907;">Prénom le</span> : <?= $utilisateur['prenoms']; ?></p>
                                            <p><span class="fw-bold" style="color: #fd4907;">Sexe</span> : <?= $utilisateur['sexe']; ?></p>
                                            <p><span class="fw-bold" style="color: #fd4907;">Inscrit le </span> : <?= $utilisateur['creer-le']; ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal : confirmer suppression -->
                            <div class="modal fade" id="supprimer-utilisateur-<?= $utilisateur['id']; ?>" tabindex="-1" aria-labelledby="effacer" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="effacer">
                                                Suppression de l'utilisateur ?>"
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Etes vous sûr de vouloir supprimer cette utilisateur ?
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="indexadmin.php?page=supprimer-utilisateur&id=<?= $utilisateur['id']; ?>" method="post">
                                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Oui</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </main>