<?php
$totalUsers = countUsers($db);
$countPublication=countPublication($db);
$countCommentaire=countCommentaire($db);
$countLikes=countLikes($db);
if (!est_connecteAdmin()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:indexadmin.php?page=connexion&erreur=' . $message);
} 
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
        /* styles for this template */
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
                            <a class="nav-link active" href="#">
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
                    <h1 class="h2">Dashboard</h1>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card TotalUsers ">
                            <div class="card-body">
                                <h5 class="card-title">All Utulisateur</h5>
                                <p class="card-text"><?= $totalUsers ?></p>
                                <a href="indexadmin.php?page=utilisateur" class="btn btn-primary fw-bold">View Users</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card TotalUsers">
                            <div class="card-body">
                                <h5 class="card-title">All Publication</h5>
                                <p class="card-text"><?= $countPublication?></p>
                                <a href="indexadmin.php?page=publication"" class="btn btn-primary fw-bold">View Posts</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card TotalUsers">
                            <div class="card-body">
                                <h5 class="card-title">All commentaires</h5>
                                <p class="card-text"><?=$countCommentaire?></p>
                                <a href="#" class="btn btn-primary fw-bold">View Comments</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card TotalUsers">
                            <div class="card-body">
                                <h5 class="card-title">All Likes</h5>
                                <p class="card-text"><?=$countLikes?></p>
                                <a href="#" class="btn btn-primary fw-bold">View Comments</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row mt-5">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">User Details</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                <a href="#" class="btn btn-warning">Edit User</a>
                                <a href="#" class="btn btn-danger">Delete User</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Post Details</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                <a href="#" class="btn btn-warning">Edit Post</a>
                                <a href="#" class="btn btn-danger">Delete Post</a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>