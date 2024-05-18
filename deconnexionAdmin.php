<?php

if (!est_connecteAdmin()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:indexadmin.php?page=connexion&erreur=' . $message);
}


if (1==1) {
    session_destroy();
}

header('location: indexadmin.php?page=connexion');
