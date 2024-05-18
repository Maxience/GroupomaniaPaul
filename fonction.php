<?php

require_once (__DIR__) . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function mailSendin(string $destination, string $recipient, string $subject, string $body): bool
{
    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {

        // Server settings
        // for detailed debug output
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'dossoumaxime888@gmail.com';
        $mail->Password = 'tfgqlngebwnnhwsr';

        // Sender and recipient settings
        $mail->setFrom('dossoumaxime888@gmail.com', htmlspecialchars_decode('Groupomania'));
        $mail->addAddress($destination, $recipient);
        $mail->addReplyTo('dossoumaxime888@gmail.com', htmlspecialchars_decode('Groupomania'));

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = htmlspecialchars_decode($subject);
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {

        return false;
    }
}
// Fonction pour générer un code aléatoire
function generateRandomCode($length = 6)
{
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


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

/**
 * Cette fonction permet d'inscrire un utilisateur.
 * 
 * @param array $utilisateur Les informtion de l'utilisateur.
 * @return bool $inscrire_utilisateur Es ce que l'utilisateur a pu etre inscrit.
 */

function inscrire_utilisateur($utilisateur): bool
{
    $inscrire_utilisateur = false;


    $db = connexion_db();
    if (is_object($db)) {
        $requetteSql = 'INSERT INTO utilisateur(`nom`, `prenoms`, `sexe`, `email`, `mot-de-passe`) VALUES (:nom,:prenoms,:sexe,:email,:mot_de_passe)';
        $requette = $db->prepare($requetteSql);

        try {
            $inscrire_utilisateur = $requette->execute($utilisateur);
        } catch (Exception $e) {
            $inscrire_utilisateur = false;
        }
    }

    return $inscrire_utilisateur;
}

/**
 * Cette fonction permet de verifier si un utilisateur existe dans la base de données grace a son adresse email.
 * 
 * @param string $email L'adresse email de l'utilisateur.
 * @return bool
 */
function chercher_utilisateur_par_son_email(string $email)
{
    $utilisateur = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `utilisateur` WHERE email = :email';
        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute(['email' => $email]);
            $utilisateur = $requette->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gérer l'exception
        }
    }

    return $utilisateur;
}



/**
 * Cette fonction permet de verifier si un utilisateur existe dans la base de données grace a son adresse email et son mot de passe.
 * 
 * @param string $email L'adresse email de l'utilisateur.
 * @param string $mot_de_passe Le mot de passe de l'utilisateur.
 * @return bool
 */
function chercher_utilisateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe): array
{
    $utilisateur_est_trouver = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `utilisateur` WHERE `email`=:email and `mot-de-passe`=:mot_de_passe';
        $requette = $db->prepare($requetteSql);
        try {

            $requette->execute(
                [
                    'email' => $email,
                    'mot_de_passe' => $mot_de_passe
                ]
            );
            $utilisateur = $requette->fetch(PDO::FETCH_ASSOC);
            if (is_array($utilisateur)) {
                $utilisateur_est_trouver =  $utilisateur;
            }
        } catch (Exception $e) {
            $utilisateur_est_trouver = [];
        }
    }


    return $utilisateur_est_trouver;
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
        $est_connecter = chercher_utilisateur_par_son_email($_SESSION['utilisateur_connecter']['email']);
        if ($est_connecter) {
            return true;
        } else {
            session_destroy();
        }
    }

    return $est_connecter;
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
 * Cette fonction permet d'ajouter une publication dans la base de données.
 * 
 * @param int $id_utilisateur L'ID de l'utilisateur qui publie la publication.
 * @param array $donnees_publication Les données de la publication à créer.
 * @return bool Indique si l'ajout de la publication a réussi.
 */
function ajout_publication(int $id_utilisateur, array $donnees_publication): bool
{
    $est_ajoute = false;

    $db = connexion_db();

    if ($db !== null) {
        try {
            // Préparation de la requête SQL
            $requeteSql = 'INSERT INTO publication (`id_utilisateur`, `publication`, `image`,`nom_auteur`) VALUES (:id_utilisateur, :publication, :image, :nom_auteur)';
            $requete = $db->prepare($requeteSql);

            // Liaison des valeurs aux paramètres de la requête
            $requete->bindParam(':id_utilisateur', $id_utilisateur);
            $requete->bindParam(':publication', $donnees_publication['publication']);
            $requete->bindParam(':image', $donnees_publication['image']);
            $requete->bindParam(':nom_auteur', $_SESSION['utilisateur_connecter']['nom']);

            // Exécution de la requête
            $est_ajoute = $requete->execute();

            if (!$est_ajoute) {
                // En cas d'échec de l'exécution, affiche un message d'erreur
                $errorInfo = $requete->errorInfo();
                error_log("Erreur lors de l'ajout de la publication dans la base de données : " . $errorInfo[2]);
            }
        } catch (PDOException $e) {
            // Capture des exceptions PDO (erreurs de connexion, etc.)
            error_log("Erreur PDO lors de l'ajout de la publication dans la base de données : " . $e->getMessage());
        }
    }

    return $est_ajoute;
}



/**
 * Cette fonction permet de recupere la liste des publications diponible u ceux appartenant a un utilisateur.
 * 
 * @param int|null $id_utilisateur L'id de l'utilisateur.
 * @param int $nombre_de_publication_par_page Le nombre de publication par page.
 * @param int $numero_de_page Le numero de la page.
 * @return array $publications La liste des publications.
 */
function publications(int $id_utilisateur = null, int $nombre_de_publication_par_page = 10, int $numero_de_page = 1): array
{
    $publications = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `publication`';

        if (!is_null($id_utilisateur)) {
            $requetteSql = $requetteSql . ' WHERE `id_utilisateur`=:id_utilisateur';
        }

        $requetteSql = $requetteSql . ' limit ' . $nombre_de_publication_par_page . ' offset ' . ($nombre_de_publication_par_page * ($numero_de_page - 1));

        $requette = $db->prepare($requetteSql);

        try {
            $donnees = [];

            if (!is_null($id_utilisateur)) {
                $donnees['id_utilisateur'] = $id_utilisateur;
            }

            $requette->execute($donnees);
            $publications = $requette->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($publications)) {
                $publications =  $publications;
            }
        } catch (Exception $e) {
            $publications = [];
        }
    }

    return $publications;
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
 * Cette fonction permet de compter le nombre de publication qu'il y a dans la base de donnees.
 * 
 * @param int|null $id_utilisateur L'id de l'utilisateur.
 * @return int $nombre_de_publication_dans_la_base_de_donnees Le nombre de publication dans la base de donnees.
 */
function nombre_de_publication_dans_la_base_de_donnees(int $id_utilisateur = null): int
{
    $nombre_de_publication_dans_la_base_de_donnees = 0;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT count(*) as total FROM `publication`';

        if (!is_null($id_utilisateur)) {
            $requetteSql = $requetteSql . ' WHERE `id_utilisateur`=:id_utilisateur';
        }

        $requette = $db->prepare($requetteSql);

        try {
            $donnees = [];

            if (!is_null($id_utilisateur)) {
                $donnees['id_utilisateur'] = $id_utilisateur;
            }

            $requette->execute($donnees);
            $requetteTotal = $requette->fetch(PDO::FETCH_ASSOC);

            if (is_array($requetteTotal)) {
                $nombre_de_publication_dans_la_base_de_donnees =  $requetteTotal['total'];
            }
        } catch (Exception $e) {
            $nombre_de_publication_dans_la_base_de_donnees = 0;
        }
    }

    return $nombre_de_publication_dans_la_base_de_donnees;
}

/**
 * Cette fonction permet de compter le nombre de likes qu'il y a dans la base de donnees.
 
 */
function recupererNombreLikes($db, $getid)
{
    // Prépare la requête SQL pour compter le nombre de likes pour une publication donnée
    $requete = $db->prepare("SELECT COUNT(*) AS nombre_likes FROM likes WHERE id_publication = :id_publication");
    $requete->bindParam(':id_publication', $getid, PDO::PARAM_INT);

    // Exécute la requête
    $requete->execute();

    // Récupère le nombre de likes
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Retourne le nombre de likes
    return $resultat['nombre_likes'];
}
/**
 * Cette fonction permet de compter le nombre de commentaire qu'il y a dans la base de donnees.
 
 */
function recupererNombreCommentaire($db, $getid)
{
    // Prépare la requête SQL pour compter le nombre de likes pour une publication donnée
    $requete = $db->prepare("SELECT COUNT(*) AS nombre_commentaire FROM commentaire WHERE id_publication = :id_publication");
    $requete->bindParam(':id_publication', $getid, PDO::PARAM_INT);

    // Exécute la requête
    $requete->execute();

    // Récupère le nombre de likes
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Retourne le nombre de likes
    return $resultat['nombre_commentaire'];
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
?>

<?php
function recupererCommentairesPublication($db, $id_publication)
{
    try {
        $db = connexion_db();

        // Prépare la requête SQL pour récupérer les commentaires pour une publication
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

        // Retourne les commentaires pour cette publication
        return $resultats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

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
/**
 * Cette fonction permet de mettre a jour une publication dans la base de données.
 * 
 * @param array $donnees_publication Les données de la publication a mettre a jour.
 * @return bool
 */
function modifier_publication(array $donnees_publication): bool
{
    $est_modifier = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'UPDATE `publication` SET `publication`=:publication,`image`=:image WHERE `id` = :id_publication';
        $requette = $db->prepare($requetteSql);
        try {
            $est_modifier = $requette->execute($donnees_publication);
        } catch (Exception $e) {
            $est_modifier = false;
        }
    }

    return $est_modifier;
}




/**
 * Cette fonction permet de mettre a jour un utilisateur dans la base de données.
 * 
 * @param array $donnees_utilisateur Les données de l'utilisateur a mettre a jour.
 * @return bool
 */
function modifier_utilisateur(array $donnees_utilisateur): bool
{
    $est_modifier = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'UPDATE `utilisateur` SET `nom`=:nom, `prenoms`=:prenoms,`sexe`=:sexe WHERE`id` = :id_utilisateur';

        $requette = $db->prepare($requetteSql);
        try {
            $est_modifier = $requette->execute($donnees_utilisateur);
        } catch (Exception $e) {
            $est_modifier = false;
        }
    }

    return $est_modifier;
}

/**
 * Cette fonction permet de mettre à jour le mot de passe d'un utilisateur dans la base de données.
 * 
 * @param int $id_utilisateur L'identifiant de l'utilisateur dont le mot de passe doit être mis à jour.
 * @param string $nouveau_mot_de_passe_hash Le nouveau mot de passe hashé.
 * @return bool Retourne true si la mise à jour a réussi, sinon false.
 */
function modifier_mot_de_passe_utilisateur(int $id_utilisateur, $nouveau_mot_de_passe): bool
{
    $est_mis_a_jour = false;

    // Assure-toi d'avoir une connexion à la base de données disponible
    $db = connexion_db();

    if (is_object($db)) {
        // Prépare la requête SQL pour mettre à jour le mot de passe de l'utilisateur
        $requeteSql = 'UPDATE utilisateur SET mot_de_passe = :nouveau_mot_de_passe WHERE id = :id_utilisateur';
        $requete = $db->prepare($requeteSql);

        // Liaison des valeurs aux paramètres de la requête
        $requete->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
        $requete->bindParam(':id_utilisateur', $id_utilisateur);
       
        try {
            // Exécute la requête SQL
            $est_mis_a_jour = $requete->execute();
        } catch (PDOException $e) {
            // Gère les erreurs éventuelles
            $est_mis_a_jour = false;
        }
    }

    return $est_mis_a_jour;
}


// Cette fonction vérifie si un code de réinitialisation de mot de passe est valide
function verifier_code_reset_mot_de_passe($code)
{
    $db = connexion_db();
    // Préparation de la requête
    $requete = $db->prepare("SELECT * FROM code WHERE code = :code AND expiration > NOW()");
    $requete->bindParam(':code', $code);

    // Exécution de la requête
    $requete->execute();

    // Récupération du résultat
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Si un résultat est trouvé, le code est valide
    return $resultat ? true : false;
}



// Cette fonction récupère l'identifiant de l'utilisateur associé à un code de réinitialisation de mot de passe
function obtenir_utilisateur_id_par_code_reset_mot_de_passe($code)
{
    $db = connexion_db();

    // Préparation de la requête
    $requete = $db->prepare("SELECT id_utilisateur FROM code WHERE code = :code AND expiration > NOW()");
    $requete->bindParam(':code', $code);

    // Exécution de la requête
    $requete->execute();

    // Récupération du résultat
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Retourne l'identifiant de l'utilisateur associé au code de réinitialisation de mot de passe
    return $resultat ? $resultat['id_utilisateur'] : null;
}


// Cette fonction met à jour le mot de passe de l'utilisateur dans la base de données en utilisant son identifiant
function modifier_mot_de_passe_utilisateur_par_id($id_utilisateur, $nouveau_mot_de_passe)
{
    $db = connexion_db();
    // Préparation de la requête
    $requete = $db->prepare("UPDATE utilisateur SET mot_de_passe = :nouveau_mot_de_passe WHERE id = :id_utilisateur");
    $requete->bindParam(':nouveau_mot_de_passe', $nouveau_mot_de_passe);
    $requete->bindParam(':id_utilisateur', $id_utilisateur);

    // Exécution de la requête
    return $requete->execute();
}


// Cette fonction supprime un code de réinitialisation de mot de passe de la base de données
function supprimer_code_reset_mot_de_passe($code)
{
    $db = connexion_db();
    // Préparation de la requête
    $requete = $db->prepare("DELETE FROM code WHERE code = :code");
    $requete->bindParam(':code', $code);

    // Exécution de la requête
    return $requete->execute();
}
