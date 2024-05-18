<?php
$erreurs = [];
$success = '';
$erreur = '';

$db = connexion_db();

// Générer un code temporaire
$code_temporaire = generateRandomCode();

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $erreurs['email'] = 'Ce champ est obligatoire et doit contenir une adresse email valide';
} else {
    $email = $_POST['email'];

    // Vérifier si l'utilisateur existe dans la base de données
    $utilisateur = chercher_utilisateur_par_son_email($email);

    if ($utilisateur) {
        // Insérer le code temporaire dans la table "code" avec l'ID de l'utilisateur
        $requeteSql = 'INSERT INTO code (code, id_utilisateur) VALUES (:code_temporaire, :id_utilisateur)';
        $requete = $db->prepare($requeteSql);
        
        // Liaison des valeurs aux paramètres de la requête
        $requete->bindParam(':code_temporaire', $code_temporaire);
        $requete->bindParam(':id_utilisateur', $utilisateur['id']);
        
        // Exécuter la requête
        if ($requete->execute()) {
            // Envoyer l'e-mail avec le code temporaire
            if (mailSendin($email, $email, 'Mot de passe oublié', 'Voici le code de réinitialisation de votre mot de passe : ' . $code_temporaire)) {
                $success = 'Un e-mail vient d\'être envoyé à votre adresse email.';
            } else {
                $erreur = 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail.';
            }
        } else {
            $erreur = 'Une erreur s\'est produite lors de la génération du code temporaire.';
        }
    } else {
        $erreur = 'Aucun utilisateur n\'a été trouvé avec cette adresse email.';
    }
}

header('location: index.php?page=formulaire&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs) . '&success=' . $success);
?>
