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

if (isset($_GET['code']) && !empty($_GET['code'])) {
    $erreur = $_GET['code'];
}

if (isset($_GET['success']) && !empty($_GET['success'])) {
    $success = $_GET['success'];
}


?>
<form action="index.php?page=traitement-modifier" class="row justify-content-center mt-5" method="post">
    <div class="col-md-6">
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

        <label class="form-label">
            Crée un nouveau mot de passe :
            <span class="text-danger ">(*)</span>
        </label>
        <input type="password" name="nouveau-mot-de-passe" class="form-control mise-a-jour-informations-personnelles-mot-de-passe" id="mise-a-jour-informations-personnelles-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['nouveau-mot-de-passe']) && !empty($donnees['nouveau-mot-de-passe'])) ? $donnees['nouveau-mot-de-passe'] : '' ?>">
        <p class="text-danger">
            <?= (isset($erreurs['nouveau-mot-de-passe']) && !empty($erreurs['nouveau-mot-de-passe'])) ? $erreurs['nouveau-mot-de-passe'] : '' ?>
        </p>

        <!-- <label class="form-label">
            Confirmer le nouveau mot de passe :
            <span class="text-danger">(*)</span>
        </label>
        <input type="password" name="Confirmer-code" class="form-control mise-a-jour-informations-personnelles-mot-de-passe" id="mise-a-jour-informations-personnelles-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['Confirmer-code']) && !empty($donnees['Confirmer-code'])) ? $donnees['Confirmer-code'] : '' ?>">
        <p class="text-danger fs-5">
            <?= (isset($erreurs['Confirmer-code']) && !empty($erreurs['Confirmer-code'])) ? $erreurs['Confirmer-code'] : '' ?>
        </p> -->
        <button type="submit" class="btn btn-primary">Modifier</button>

    </div>

</form>