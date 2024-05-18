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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Vérification du code
                    </div>
                    <div class="card-body">
                        <form action="index.php?page=formulaire-traitement" method="post">
                            <!-- <form action="" method="post"> -->
                            <div class="form-group">
                                <label for="code">Code reçu par e-mail :</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                                <p class="text-danger">
                                    <?= (isset($erreurs['code']) && !empty($erreurs['code'])) ? $erreurs['code'] : '' ?>
                                </p>
                            </div>
                            <button type="submit" class="btn btn-primary">Vérifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>