<?php
// Assure-toi que la session est démarrée et que la fonction de connexion à la base de données est disponible

$erreurs = [];
$success = '';
$erreur = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si le champ du nouveau mot de passe est vide
    if (empty($_POST['nouveau_mot_de_passe'])) {
        $erreurs['nouveau_mot_de_passe'] = 'Veuillez saisir votre nouveau mot de passe.';
    } elseif (strlen($_POST['nouveau_mot_de_passe']) < 8) {
        $erreurs['nouveau_mot_de_passe'] = 'Le nouveau mot de passe doit avoir au moins 8 caractères.';
    }

    // Vérifier s'il n'y a pas d'erreurs
    if (empty($erreurs)) {
        // Récupérer l'utilisateur par son email
        $email = $_POST['email']; 
        $utilisateur = chercher_utilisateur_par_son_email($email);
        // die(var_dump($utilisateur));
        if ($utilisateur) {
            // Mettre à jour le mot de passe de l'utilisateur dans la base de données
            $nouveau_mot_de_passe= sha1($_POST['nouveau_mot_de_passe']);
            $est_mis_a_jour = modifier_mot_de_passe_utilisateur($utilisateur['id'], $nouveau_mot_de_passe);
           die(var_dump($utilisateur['id']));
            if ($est_mis_a_jour) {
                $success = 'Le mot de passe a été mis à jour avec succès.';
                
            } else {
                $erreur = 'Une erreur est survenue lors de la mise à jour du mot de passe. Veuillez réessayer.';
            }
        } else {
            $erreur = 'Aucun utilisateur trouvé avec cet email.';
        }
    }
}

// Redirection vers la page appropriée en fonction du résultat
if (empty($success)) {
    header('Location: index.php?page=modifier-mot-de-passe&erreur=' .$erreur . '&erreurs=' . json_encode($erreurs));
} else {
    header('Location: index.php?page=connexion&success=' . $success);
}
?>
