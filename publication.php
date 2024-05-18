<?php
$totalUsers = countUsers($db);
$countPublication = countPublication($db);
$countCommentaire = countCommentaire($db);
$countLikes = countLikes($db);
$utilisateurs = recupererUtilisateurs();
$publications = recupererPublication();
// Exemple d'utilisation
// $utilisateurs = recupererUtilisateurs();
// $publications = recupererPublication();
// $recupererPublicationsAvecAuteurs = recupererPublicationsAvecAuteurs($db);
// $id_publication = $publications['id'];
// $recupererNombreTotalCommentairesPublication = recupererNombreTotalCommentairesPublication($db, $id_publication);

// $recupererPublicationsUtilisateur=recupererPublicationsUtilisateur($db, $id_utilisateur);
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
                            <a class="nav-link" href="indexadmin.php?page=publication">
                                Publication
                            </a>
                        </li>
                        <li class="nav-item">
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
                    <h1 class="h2">Publications</h1>
                </div>
                <?php if (empty($publications)) { ?>
                    <p>
                        Aucune publication n'est disponible pour le moment.
                    </p>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Publications</th>
                                <th scope="col">Auteur</th>
                                <th scope="col">N. commentaire</th>
                                <th scope="col">N. Likes</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($publications as $indexadmin => $publication) {

                                $id_publication = $publication['id'];
                                $recupererNombreTotalCommentairesPublication = recupererNombreTotalCommentairesPublication($db, $id_publication);
                                $recupererNombreTotalLikesPublication = recupererNombreTotalLikesPublication($db,  $id_publication);
                            ?>

                                <tr>
                                    <th scope="row"><?php echo $indexadmin + 1; ?></th>
                                    <td><?php echo $publication["publication"]; ?></td>
                                    <td><?php echo $publication["nom_auteur"]; ?></td>
                                    <td><?php echo $recupererNombreTotalCommentairesPublication; ?></td>
                                    <td><?php echo $recupererNombreTotalLikesPublication; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#details-publication-<?= $id_publication ?>">
                                            Détails</a>
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer-publication-<?= $publication['id']; ?>">
                                            Supprimer
                                        </a>
                                    </td>
                                </tr>



                                <!-- Modal : details publication -->
                                <div class="modal fade" id="details-publication-<?= $publication['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Détails sur la publication</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><span class="fw-bold">Image</span> :</p>
                                                <p class="text-center">
                                                    <img style="height: 200px;width: 100%;object-fit: cover;" src="<?= $publication['image']; ?>" class="card-img-top" alt="Image de la publication">
                                                </p>
                                                <p><span class="fw-bold" style="color: #fd4907;">Publication</span> : <?= $publication['publication']; ?></p>
                                                <p><span class="fw-bold" style="color: #fd4907;">Publier le</span> : <?= $publication['creer-le']; ?></p>

                                                <h5>Commentaires :</h5>
                                                <?php
                                                // Récupérer tous les commentaires pour cette publication
                                                $commentaires = recupererCommentairesPublication($db, $publication['id']);
                                                ?>
                                                <?php if (!empty($commentaires)) : ?>
                                                    <ul class="list-group">
                                                        <?php foreach ($commentaires as $commentaire) : ?>
                                                            <li class="list-group-item">
                                                                <span class="badge bg-primary"><?= $commentaire['auteur_commentaire']; ?></span>
                                                                <?= $commentaire['commentaire']; ?>

                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else : ?>
                                                    <p>Aucun commentaire pour cette publication.</p>
                                                <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal : confirmer suppression -->
                                <div class="modal fade" id="supprimer-publication-<?= $publication['id']; ?>" tabindex="-1" aria-labelledby="effacer" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="effacer">
                                                    Suppression de la publication ?>"
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Etes vous sûr de vouloir supprimer cette publication ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="indexadmin.php?page=supprimer-publication&id=<?= $publication['id']; ?>" method="post">
                                                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Oui</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                        </tbody>
                    </table>
                <?php }; ?>
            </main>
            <!-- <script src="/bootstrap/bootstrap.min.js"> </script> -->