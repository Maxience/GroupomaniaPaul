<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
}

$erreurs = [];
$donnees = [];
$erreur = '';
$success = '';

connexion_db();

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
} ?>

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

<div class="row align-center ">

    <form action="index.php?page=traitement-modifier-publication" class=" " method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="ajout-publication-publication" class="form-label">
                Publication :
                <span class="text-danger">(*)</span>
            </label>
            <textarea name="publication" class="form-control ajout-publication-publication" id="ajout-publication-publication" rows="5"><?= (isset($donnees['publication']) && !empty($donnees['publication'])) ? $donnees['publication'] : '' ?></textarea>
            <p class="text-danger">
                <?= (isset($erreurs['publication']) && !empty($erreurs['publication'])) ? $erreurs['publication'] : '' ?>
            </p>
        </div>
        <div class="mb-3">
            <label for="ajout-publication-image" class="form-label">
                Image :
            </label>
            <input class="form-control ajout-publication-image" name="image" type="file" id="ajout-publication-image">
            <p class="text-danger">
                <?= (isset($erreurs['image']) && !empty($erreurs['image'])) ? $erreurs['image'] : '' ?>
            </p>
        </div>
        <div class="modal-footer">
            <button type="resert" class="btn btn-danger mx-3 ">Annuler</button>
            <button type="Submit" class="btn btn-primary">Publié</button>
        </div>
    </form>
</div>

</div>