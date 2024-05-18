<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
}


if (!empty($_GET['message'])) {
?>
    <div class="alert alert-info" role="alert">
        <?= $_GET['message']; ?>
    </div>
<?php

}


if (!empty($_GET['success'])) {
?>
    <div class="alert alert-success" role="alert">
        <?= $_GET['success']; ?>
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
$db = connexion_db();
$id_utilisateur = obtenir_id_utilisateur_connecte();
$publication = recupererPublicationsUtilisateur($db, $id_utilisateur);
$publications = publications($_SESSION['utilisateur_connecter']['id']);


// die(var_dump($publication));

?>

<div class="row d-flex align-items-center">
    <div class="col-md-6">
        <h3>
            Mes publication
        </h3>
    </div>

    <div class="col-md-6 d-flex justify-content-end">
        <a href="index.php?page=ajouter" style="background-color: #fd4907; padding:1rem; color:white; " class=" btn fw-bold ">
            Ajouter une publication
        </a>
    </div>
</div>

<div class="row d-flex align-items-center">
    <div class="col-md-12">
        <?php

        if (empty($publication)) { ?>
            <p>
                Aucune publication n'est disponible pour le moment.
            </p>
        <?php } else { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Publication</th>
                        <th scope="col" style="color:#0734fd; ;">N. Like</th>
                        <th scope="col" style="color:#fd4907;">N. Commentaire</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $indexadmin => $publication) {
                        $likeTotal = recupererNombreTotalLikesPublication($db, $publication["id"]);
                        $commentaireTotal = recupererNombreTotalCommentairesPublication($db, $publication["id"]);
                        // $likeTotal = recupererNombreTotalLikesPublication($db, $publication);
                    ?>

                        <tr>
                            
                            <th scope="row"> <?php echo $indexadmin + 1; ?> 

                            </th>

                            <td>
                                <?= $publication['publication']; ?>
                            </td>
                            <td>
                                <span style="color:#0734fd;"><?= $likeTotal  ?></span>
                            </td>
                            <td style="color:#fd4907;">
                                <?= $commentaireTotal; ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#details-publication-<?= $publication['id']; ?>">
                                    Détails
                                </a>

                                <a href="index.php?page=modifier&id=<?= $publication['id']; ?>" class="btn btn-warning">
                                    Modifier
                                </a>

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
                                            <?php if (!empty($publication['image'])) : ?>
                                                <img src="<?= $publication['image']; ?>" class="card-img-top" style="height: 200px;width: 100%;object-fit: cover;" alt="Image">
                                            <?php else : ?>
                                        <div style="height: 200px; background-color: #ccc;"></div>
                                    <?php endif; ?></p>
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


                        <!-- Modal : details publication -->
                        <div class="modal fade" id="supprimer-publication-<?= $publication['id']; ?>" tabindex="-1" aria-labelledby="effacer" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Etes vous sur de vouloir supprimer cette publication ?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="index.php?page=supprimer-publication&id=<?= $publication['id']; ?>" method="post">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Oui</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal : details publication -->
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
                                        <form action="index.php?page=supprimer-publication&id=<?= $publication['id']; ?>" method="post">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Oui</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>