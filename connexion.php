<?php
$erreurs = [];
$donnees = [];
$erreur = '';
$success = '';


if (est_connecteAdmin()) {
    $message = "Vous êtes déja connecté. Veuillez poursuivre votre navigation.";
    header('location:indexadmin.php?page=dashbord&message=' . $message);
}

if (isset($_GET['erreurs']) && !empty($_GET['erreurs'])) {
    $erreurs = json_decode($_GET['erreurs'], true);
}
if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
    $erreur = $_GET['erreur'];
}
if (isset($_GET['donnees']) && !empty($_GET['donnees'])) {
    $donnees = json_decode($_GET['donnees'], true);
}
if (isset($_GET['success']) && !empty($_GET['success'])) {
    $success = $_GET['success'];
}

?>

<div class="row g-3 d-flex ">

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <!-- Inclure Bootstrap CSS -->
        <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h3 class="text-center">Connexion Administeur</h3>

                            <div class="card-body">
                                <form action="indexadmin.php?page=traitement" method="post">
                                    <div class="form-group">
                                        <label for="email">Email :</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?= (isset($donnees['email']) && !empty($donnees['email'])) ? $donnees['email'] : '' ?>">
                                        <?= (isset($erreurs['email']) && !empty($erreurs['email'])) ? $erreurs['email'] : '' ?>

                                    </div>
                                    <div class="form-group">
                                        <label for="password">Mot de passe :</label>
                                        <input type="password" class="form-control mb-2" id="password" name="password" required value="<?= (isset($donnees['password']) && !empty($donnees['password'])) ? $donnees['password'] : '' ?>">
                                        <?= (isset($erreurs['password']) && !empty($erreurs['password'])) ? $erreurs['password'] : '' ?>

                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inclure Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>