<?php

/**
 * Cette fonction permet de se connecter la base de données.
 * @return PDO | string L'instance de la base de données ou le message d'erreur.
 */
function connexion_db()
{
    try {
        $dns = 'mysql:host=localhost;dbname=entreprises;charset=utf8';
        $user_name = 'root';
        $password = '';
        return new PDO($dns, $user_name, $password);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
$db = connexion_db();
/**
 * Cette fonction permet de verifier si un administrateur existe dans la base de données grace a son adresse email.
 * 
 * @param string $email L'adresse email de l'administrateur.
 * @return bool
 */
function chercher_administrateur_par_son_email(string $email): bool
{
    $administrateur_est_trouver = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `administrateur` WHERE email =:email';
        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute(['email' => $email]);
            if (is_array($requette->fetch(PDO::FETCH_ASSOC))) {
                $administrateur_est_trouver = true;
            }
        } catch (Exception $e) {
            $administrateur_est_trouver = false;
        }
    }

    return $administrateur_est_trouver;
}


/**
 * Cette fonction permet de verifier si un administrateur existe dans la base de données grace a son adresse email et son mot de passe.
 * 
 * @param string $email L'adresse email de l'administrateur.
 * @param string $mot_de_passe Le mot de passe de l'administrateur.
 * @return bool
 */
function chercher_administrateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe): array
{
    $administrateur_est_trouve = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requeteSql = 'SELECT * FROM `administrateur` WHERE `email`=:email and `mot_de_passe`=:mot_de_passe';
        $requete = $db->prepare($requeteSql);
        try {

            $requete->execute(
                [
                    'email' => $email,
                    'mot_de_passe' => $mot_de_passe
                ]
            );
            $administrateur = $requete->fetch(PDO::FETCH_ASSOC);
            if (is_array($administrateur)) {
                $administrateur_est_trouve =  $administrateur;
            }
        } catch (Exception $e) {
            $administrateur_est_trouve = [];
        }
    }

    return $administrateur_est_trouve;
}
/**
 * Cette fonction me permet de verifier si un administrateur est connecté.
 * 
 * @return bool
 */
function est_connecteAdmin(): bool
{
    $est_connecte = false;
    if (isset($_SESSION['administrateur_connecte']) && !empty($_SESSION['administrateur_connecte'])) {
        $administrateur = chercher_administrateur_par_son_email($_SESSION['administrateur_connecte']['email']);
        if ($administrateur) {
            return true;
        } else {
            session_destroy();
        }
    }

    return $est_connecte;

}

function countUsers($db) {
    if (!$db) {
        // Gérer l'erreur de connexion à la base de données
        return -1;
    }

    $sql = "SELECT COUNT(*) AS total_users FROM utilisateur";
    $result = $db->query($sql);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row["total_users"];
    } else {
        return 0;
    }
}


function countPublication($db) {
    if (!$db) {
        // Gérer l'erreur de connexion à la base de données
        return -1;
    }

    $sql = "SELECT COUNT(*) AS total_users FROM publication";
    $result = $db->query($sql);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row["total_users"];
    } else {
        return 0;
    }
}

function countCommentaire($db) {
    if (!$db) {
        // Gérer l'erreur de connexion à la base de données
        return -1;
    }

    $sql = "SELECT COUNT(*) AS total_users FROM commentaire";
    $result = $db->query($sql);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row["total_users"];
    } else {
        return 0;
    }
}


function countLikes($db) {
    if (!$db) {
        // Gérer l'erreur de connexion à la base de données
        return -1;
    }

    $sql = "SELECT COUNT(*) AS total_users FROM likes";
    $result = $db->query($sql);

    if ($result) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row["total_users"];
    } else {
        return 0;
    }
}



function recupererUtilisateurs()
{
    $db = connexion_db();
    try {
        // Prépare la requête SQL pour récupérer tous les utilisateurs
        $requete = $db->prepare("SELECT * FROM utilisateur");

        // Exécute la requête
        $requete->execute();

        // Récupère les résultats
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        // Retourne les utilisateurs
        return $resultats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function recupererPublication()
{
    $db = connexion_db();
    try {
        // Prépare la requête SQL pour récupérer tous les utilisateurs
        $requete = $db->prepare("SELECT * FROM publication");

        // Exécute la requête
        $requete->execute();

        // Récupère les résultats
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        // Retourne les utilisateurs
        return $resultats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}



function obtenir_id_utilisateur_connecte()
{
    // Vérifier si la session est démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si l'utilisateur est connecté (par exemple, vérifier si une variable de session utilisateur existe)
    if (isset($_SESSION['utilisateur_connecter'])) {
        // Utilisateur connecté, renvoyer l'ID de l'utilisateur
        return  $_SESSION['utilisateur_connecter']['id'];
    } else {
        // Utilisateur non connecté, renvoyer une valeur par défaut (par exemple, null)
        return null;
    }
}

/**
 * Cette fonction permet de recupere une publication grace a son id.
 * 
 * @param int $id_publication L'id de la publication.
 * @return array $publication Les informations d'une publication.
 */
function publication(int $id_publication): array
{
    $publication = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `publication` WHERE `id`=:id_publication';

        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute([
                'id_publication' => $id_publication
            ]);
            $publication = $requette->fetch(PDO::FETCH_ASSOC);
            if (is_array($publication)) {
                $publication =  $publication;
            } else {
                $publication = [];
            }
        } catch (Exception $e) {
            $publication = [];
        }
    }

    return $publication;
}

/**
 * Cette fonction permet de recupere une publication grace a son id.
 * 
 * @param int $id_publication L'id de la publication.
 * @return array $publication Les informations d'une publication.
 */
function utilisateur(int $id_utilisateur): array
{
    $utilisateur = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `utilisateur` WHERE `id`=:id_publication';

        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute([
                'id_utilisateur' => $id_utilisateur
            ]);
            $utilisateur = $requette->fetch(PDO::FETCH_ASSOC);
            if (is_array($utilisateur)) {
                $utilisateur =  $utilisateur;
            } else {
                $utilisateur = [];
            }
        } catch (Exception $e) {
            $utilisateur = [];
        }
    }

    return $utilisateur;
}


function recupererPublicationsUtilisateur($db, $id_utilisateur)
{
    $db = connexion_db();
    $id_utilisateur = obtenir_id_utilisateur_connecte();
    try {
        // Prépare la requête SQL pour récupérer les publications de l'utilisateur
        $requete = $db->prepare("SELECT * FROM publication WHERE id_utilisateur = :id_utilisateur");
        $requete->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);

        // Exécute la requête
        $requete->execute();

        // Récupère les résultats
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        // Retourne les publications
        return $resultats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
/**
 * Cette fonction me permet de verifier si un utilisateur est connecté.
 * 
 * @return bool
 */
function est_connecter(): bool
{
    $est_connecter = false;
    if (isset($_SESSION['utilisateur_connecter']) && !empty($_SESSION['utilisateur_connecter'])) {
        $est_connecter = chercher_administrateur_par_son_email($_SESSION['utilisateur_connecter']['email']);
        if ($est_connecter) {
            return true;
        } else {
            session_destroy();
        }
    }

    return $est_connecter;
}

/**
 * Cette fonction permet de verifier si un utilisateur existe dans la base de données grace a son adresse email.
 * 
 * @param string $email L'adresse email de l'utilisateur.
 * @return bool
 */
// function chercher_administrateur_par_son_email(string $email): bool
// {
//     $administrateur_est_trouver = false;

//     $db = connexion_db();

//     if (is_object($db)) {
//         $requetteSql = 'SELECT * FROM `administrateur` WHERE email =:email';
//         $requette = $db->prepare($requetteSql);
//         try {
//             $requette->execute(['email' => $email]);
//             if (is_array($requette->fetch(PDO::FETCH_ASSOC))) {
//                 $administrateur_est_trouver = true;
//             }
//         } catch (Exception $e) {
//             $administrateur_est_trouver = false;
//         }
//     }

//     return $administrateur_est_trouver;
// }
function recupererNombreTotalLikesPublication($db,  $id_publication)
{
    $db = connexion_db();
    $id_utilisateur = obtenir_id_utilisateur_connecte();
    try {
        // Prépare la requête SQL pour récupérer le nombre total de likes pour une publication de l'utilisateur
        $requete = $db->prepare("
            SELECT COUNT(*) AS total_likes
            FROM likes
            WHERE id_publication = :id_publication
        ");
        $requete->bindParam(':id_publication', $id_publication, PDO::PARAM_INT);

        // Exécute la requête
        $requete->execute();

        // Récupère le résultat
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        // Retourne le nombre total de likes pour cette publication
        return $resultat['total_likes'];
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function recupererNombreTotalCommentairesPublication($db, $id_publication)
{
    $db = connexion_db();
    try {
        // Prépare la requête SQL pour récupérer le nombre total de commentaires pour une publication
        $requete = $db->prepare("
            SELECT COUNT(*) AS total_commentaires
            FROM commentaire
            WHERE id_publication = :id_publication
        ");
        $requete->bindParam(':id_publication', $id_publication, PDO::PARAM_INT);

        // Exécute la requête
        $requete->execute();

        // Récupère le résultat
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        // Retourne le nombre total de commentaires pour cette publication
        return $resultat['total_commentaires'];
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function recupererCommentairesPublication($db, $id_publication) {
    try {
        $db = connexion_db();

        // Prépare la requête SQL pour récupérer les commentaires pour une publication avec l'auteur du commentaire
        $requete = $db->prepare("
            SELECT commentaire, auteur_commentaire
            FROM commentaire 
            WHERE id_publication = :id_publication
        ");
        $requete->bindParam(':id_publication', $id_publication, PDO::PARAM_INT);

        // Exécute la requête
        $requete->execute();

        // Récupère les résultats
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

        // Retourne les commentaires pour cette publication avec l'auteur du commentaire
        return $resultats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


// function recupererPublicationsAvecAuteurs($db)
// {
//     try {
//         // Prépare la requête SQL pour récupérer les publications avec les noms des auteurs
//         $requete = $db->prepare("SELECT publication.*, utilisateur.nom AS nom_auteur, utilisateur.prenoms AS prenom_auteur FROM publication INNER JOIN utilisateur ON publication.id_utilisateur = utilisateur.id");

//         // Exécute la requête
//         $requete->execute();

//         // Récupère les résultats
//         $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

//         // Retourne les publications avec les noms des auteurs
//         return $resultats;
//     } catch (PDOException $e) {
//         echo "Erreur : " . $e->getMessage();
//     }
// }

function supprimer_publication(int $id_publication): bool
{
    $est_supprimer = false;

    $db = connexion_db();

    if (is_object($db)) {
        $db->beginTransaction(); // Commence une transaction

        try {
            // Supprimer les commentaires de la publication
            $requetteSqlCommentaires = 'DELETE FROM `commentaire` WHERE `id_publication` = :id_publication';
            $requetteCommentaires = $db->prepare($requetteSqlCommentaires);
            $requetteCommentaires->execute(['id_publication' => $id_publication]);

            // Supprimer les likes de la publication
            $requetteSqlLikes = 'DELETE FROM `likes` WHERE `id_publication` = :id_publication';
            $requetteLikes = $db->prepare($requetteSqlLikes);
            $requetteLikes->execute(['id_publication' => $id_publication]);

            // Supprimer la publication elle-même
            $requetteSqlPublication = 'DELETE FROM `publication` WHERE `id` = :id_publication';
            $requettePublication = $db->prepare($requetteSqlPublication);
            $est_supprimer = $requettePublication->execute(['id_publication' => $id_publication]);

            if ($est_supprimer) {
                $db->commit(); // Valide la transaction
            } else {
                $db->rollBack(); // Annule la transaction
            }
        } catch (Exception $e) {
            $db->rollBack(); // Annule la transaction en cas d'erreur
            $est_supprimer = false;
        }
    }

    return $est_supprimer;
}

function supprimer_utilisateur(int $id_utilisateur): bool
{
    $est_supprimer = false;

    $db = connexion_db();

    if (is_object($db)) {
        $db->beginTransaction(); // Commence une transaction

        try {
            // Supprimer l'utilisateur
            $requeteSqlUtilisateur = 'DELETE FROM `utilisateur` WHERE `id` = :id_utilisateur';
            $requeteUtilisateur = $db->prepare($requeteSqlUtilisateur);
            $requeteUtilisateur->execute(['id_utilisateur' => $id_utilisateur]);

            // Supprimer les commentaires de l'utilisateur
            $requeteSqlCommentaires = 'DELETE FROM `commentaire` WHERE `id_utilisateur` = :id_utilisateur';
            $requeteCommentaires = $db->prepare($requeteSqlCommentaires);
            $requeteCommentaires->execute(['id_utilisateur' => $id_utilisateur]);

            // Supprimer les likes de l'utilisateur
            $requeteSqlLikes = 'DELETE FROM `likes` WHERE `id_utilisateur` = :id_utilisateur';
            $requeteLikes = $db->prepare($requeteSqlLikes);
            $requeteLikes->execute(['id_utilisateur' => $id_utilisateur]);

            // Supprimer les publications de l'utilisateur
            $requeteSqlPublications = 'DELETE FROM `publication` WHERE `id_utilisateur` = :id_utilisateur';
            $requetePublications = $db->prepare($requeteSqlPublications);
            $requetePublications->execute(['id_utilisateur' => $id_utilisateur]);

            // Valide la transaction
            $db->commit();
            $est_supprimer = true;
        } catch (Exception $e) {
            // Annule la transaction en cas d'erreur
            $db->rollBack();
            $est_supprimer = false;
        }
    }

    return $est_supprimer;
}
