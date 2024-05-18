<?php



if (empty($_GET['id'])) {
    $message = "L'utilisateur que vous souhaitez supprimée n'existe pas.";
    header('location:indexadmin.php?page=utilisateur&erreur=' . $message);
}

$utilisateur = utilisateur($_GET['id']);

if (empty($utilisateur)) {
    $message = "L'utilisateur que vous souhaitez supprimée n'existe pas.";
    header('location:indexadmin.php?page=utilisateur&erreur=' . $message);
}

$supprimer_utilisateur = supprimer_utilisateur($_GET['id']);

$success = "";
$erreur = "";
if ($supprimer_publication) {
    $success = "utilisateur supprimer avec succès.";
} else {
    $erreur = "Oups!!! une erreur inatendue s'est produite lors de la suppression de la utilisateur.";
}

header('location: indexadmin.php?page=utilisateur&erreur=' . $erreur . '&success=' . $success);