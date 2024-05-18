<?php
$erreurs = [];
$donnees = [];
$erreur = '';
$success = '';


if (est_connecter()) {
    $message = "Vous êtes déja connecté. Veuillez poursuivre votre navigation.";
    header('location:index.php?page=accueil&message=' . $message);
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
    <?php
    if (!empty($erreur)) {
    ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $erreur; ?>
        </div>
    <?php
    }


    if (!empty($success)) {
    ?>
        <div class="alert alert-success text-center" role="alert">
            <?= $success; ?>
        </div>
    <?php
    }
    ?>
    <div class="col-6 card">
        <form action="index.php?page=traitement-connexion" method="POST" novalidate class="p-3">
            <h3 class="text-center text-danger">
                Connexion
            </h3>

            <p class="text-center">
                Veuillez fournir vos informations afin de vous connectez.
            </p>

            <div class="mb-3">
                <label for="connexion-email" class="form-label">
                    Adresse email :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="email" name="email" class="form-control connexion-email" id="connexion-email" placeholder="Veuillez entrer votre adresse email." required value="<?= (isset($donnees['email']) && !empty($donnees['email'])) ? $donnees['email'] : '' ?>">
                <p class="text-danger">
                    <?= (isset($erreurs['email']) && !empty($erreurs['email'])) ? $erreurs['email'] : '' ?>
                </p>
            </div>

            <div class="mb-3">
                <label for="connexion-mot-de-passe" class="form-label">
                    Mot de passe :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="password" name="mot-de-passe" class="form-control connexion-mot-de-passe" id="connexion-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['mot-de-passe']) && !empty($donnees['mot-de-passe'])) ? $donnees['mot-de-passe'] : '' ?>">
                <p class="text-danger">
                    <?= (isset($erreurs['mot-de-passe']) && !empty($erreurs['mot-de-passe'])) ? $erreurs['mot-de-passe'] : '' ?>
                </p>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="terms-conditions" class="form-check-input connexion-terms-conditions" id="connexion-terms-conditions" <?= (isset($donnees['terms-conditions']) && !empty($donnees['terms-conditions'])) ? 'checked' : '' ?>>
                <label class="form-check-label" for="connexion-terms-conditions">
                    se souvenir de moi
                    <span class="text-danger">(*)</span>
                </label>
                <p class="text-danger">
                    <?= (isset($erreurs['terms-conditions']) && !empty($erreurs['terms-conditions'])) ? $erreurs['terms-conditions'] : '' ?>
                </p>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary ">Se connecter</button>
                <a href="index.php?page=inscription" class="text-decoration-none ;">Je souhaite m'inscrire</a>
            </div>

        </form>
        <a href="index.php?page=oublier" class="text-decoration-none d-flex justify-content-center mt-4">Mot de passe oublier</a>
    </div>

    <div class="col-6">
        <img src="/image/Logos/OIG1.jpeg" style="height: 400px;width: 100%;object-fit: cover; border-radius:10%;" alt="">
    </div>

</div>