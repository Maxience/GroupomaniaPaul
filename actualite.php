<?php

$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

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

<?php
$c_erreur = "";
require_once(__DIR__ . '/php/action.php');

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
} ?>


<?php




if (!empty($_GET['message'])) {
?>
    <div class="alert alert-info" role="alert">
        <?= $_GET['message']; ?>
    </div>
<?php

}

if (!empty($_GET['erreur'])) {
?>
    <div class="alert alert-danger" role="alert">
        <?= $_GET['erreur']; ?>
    </div>
<?php
}
$nombre_de_publication_total = nombre_de_publication_dans_la_base_de_donnees();

$nombre_de_publication_par_page = (isset($_GET['nombre_de_publication_par_page']) && !empty($_GET['nombre_de_publication_par_page'])) ? $_GET['nombre_de_publication_par_page'] : 12;
$numero_de_page =  (isset($_GET['numero_de_page']) && !empty($_GET['numero_de_page'])) ? $_GET['numero_de_page'] : 1;

$numero_de_page_total = round($nombre_de_publication_total / $nombre_de_publication_par_page, 0);

$publications = publications(null, $nombre_de_publication_par_page, $numero_de_page);

?>

<?php

// if (isset($_GET['page'], $_GET['id']) and (!empty($_GET['page'])) and (!empty($_GET['id']))) {
$likes = '';

// // if($publication->rowCount()==1){

//     $likes= $db->prepare('SELECT id FROM likes WHERE id_publication = ?');
//     $likes->execute(array($getid));
//     $likes=$likes->rowCount();
// // }

?>

<h3 class="position-relative">
    Actualité
</h3>

<div class="row">
    <?php if (empty($publications)) { ?>
        <p>
            Aucune publication n'est disponible pour le moment.
        </p>
        <?php } else {
        foreach ($publications as $publication) {

            $getid = $publication['id'];

            $likes = recupererNombreLikes($db, $getid);
            $id_utilisateur = obtenir_id_utilisateur_connecte();
            $commentaire = recupererNombreCommentaire($db, $getid);

        ?>

            <div class="col-md-3">

                <div class="card mb-4">
                    <?php if (!empty($publication['image'])) : ?>
                        <img src="<?= $publication['image']; ?>" class="card-img-top" style="height: 200px;width: 100%;object-fit: cover;" alt="Image">
                    <?php else : ?>
                        <div style="height: 200px; background-color: #ccc;"></div>
                    <?php endif; ?> <div class="card-body">

                        <p class="card-text"><?= $publication['publication']; ?></p>
                        <!-- Bouton de like -->
                        <!-- <form action="index.php?page=action&id=<?= $publication['id']; ?>" method='post'> -->

                        <a class="btn btn-outline-primary likeButton" href="index.php?id=<?= $getid; ?>&page=1">
                            <?php
                            if ($likes < 1) { ?>
                                <i id="likeIcon" class="fa-regular fa-heart "></i>
                            <?php } else { ?>

                                <i id="likeIcon" class="fa-solid fa-heart"></i>
                            <?php } ?>

                            <span id="likeCount" class="ml-1"> <?= $likes ?></span>
                        </a>
                        </form>
                        <!-- Bouton de commentaire -->
                        <a class="btn btn-outline-secondary commentButton" onclick="toggleCommentField(this)">

                            <?php
                            if ($commentaire < 1) { ?>
                                <i class="fa-regular fa-comment"></i>
                            <?php } else { ?>

                                <i id="commentaireIcon" class="fa-solid fa-comment"></i>
                            <?php } ?>

                            <span id="commentCount" class="ml-1"><?= $commentaire; ?></span>
                        </a>
                        <form action="index.php?page=commentaire&id=<?= $publication['id']; ?>" method='post'>
                            <!-- Champ de commentaire -->
                            <div class="commentField mt-3" style="display: none;">
                                <textarea class="form-control" name="commentaire" placeholder="Ajouter un commentaire"></textarea>
                                <button class="btn btn-primary mt-2" type="submit" name="submit_commentaire" onclick="submitComment(this)">Commenter</button>
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
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
</div>

</div>
<?php

    }
?>
</div>


<div class="mt-3 d-flex justify-content-end">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($numero_de_page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>
            <li class="page-item">
                <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page; ?>">
                    <?= $numero_de_page; ?>
                </a>
            </li>
            <?php if ($numero_de_page < $numero_de_page_total) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
<?php

// header('Location: index.php?page=action&id=' . $publication['id']);

?>

<script src="script.js"></script>