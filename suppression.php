<?php



if (empty($_GET['id'])) {
    $message = "La publication que vous souhaitez supprimée n'existe pas.";
    header('location:indexadmin.php?page=publication&erreur=' . $message);
}

$publication = publication($_GET['id']);

if (empty($publication)) {
    $message = "La publication que vous souhaitez supprimée n'existe pas.";
    header('location:indexadmin.php?page=publication&erreur=' . $message);
} else if ($publication['id_utilisateur'] != $_SESSION['utilisateur_connecter']['id']) {
    $message = "La publication que vous souhaitez supprimée ne vous appartient pas.";
    header('location:indexadmin.php?page=publication&erreur=' . $message);
}

$supprimer_publication = supprimer_publication($_GET['id']);

$success = "";
$erreur = "";
if ($supprimer_publication) {
    $success = "publication supprimer avec succès.";
} else {
    $erreur = "Oups!!! une erreur inatendue s'est produite lors de la suppression de la publication.";
}

header('location: indexadmin.php?page=publication&erreur=' . $erreur . '&success=' . $success);