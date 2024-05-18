<?php
$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';
$donnees_publication = [];
connexion_db();

foreach ($_POST as $cle => $valeur) {
    $donnees[$cle] = strip_tags($valeur);
}

if (empty($_POST['publication'])) {
    $erreurs['publication'] = 'Le champ publication est obligatoire.';
}
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Vérifier la taille maximale du fichier (3 Mo)
    $maxFileSize = 3000000;
    if ($_FILES['image']['size'] <= $maxFileSize) {
        // Créer le dossier de destination s'il n'existe pas
        $uploadDirectory = 'uploads/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Crée le dossier récursivement avec les permissions 0777
        }
        // Vérifier l'extension et le type MIME du fichier
        $fileInfo = pathinfo($_FILES['image']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($extension, $allowedExtensions) && in_array($_FILES['image']['type'], $allowedMimeTypes)) {
            // Valider le nom de fichier (par exemple, en utilisant une expression régulière)
            $validFilename = preg_match('/^[a-zA-Z0-9_-]+\.(jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG)$/', $_FILES['image']['name']);
            if ($validFilename) {
                // Stocker le fichier de manière sécurisée
                $uploadPath = $uploadDirectory . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Maintenant, nous pouvons enregistrer les données dans la base de données
                    $donnees_publication = [
                        'publication' => $donnees['publication'],
                        'image' => $uploadPath
                    ];
                    // Obtenir l'ID de l'utilisateur connecté
                    $id_utilisateur = obtenir_id_utilisateur_connecte();
                    // modifier la publication dans la base de données
                    if (modifier_publication($donnees_publication)) {
                        $success = "L'envoi a bien été effectué et la publication a été ajoutée !";
                    } else {
                        $erreur = "Erreur lors de la modification de la publication dans la base de données.";
                    }
                    // die(var_dump($donnees_publication));
                } else {
                    $erreur = "Erreur lors du déplacement du fichier vers le dossier de téléchargement.";
                }
            } else {
                $erreur = "Le nom de fichier n'est pas valide !";
            }
        } else {
            $erreur = "Seuls les fichiers JPG, JPEG, GIF et PNG sont autorisés !";
        }
    } else {
        $erreur = "Le fichier est trop volumineux !";
    }




   

    // die(var_dump(ajout_publication($donnees_publication)));
} else {
    // Aucune image n'a été envoyée, tu peux continuer avec le reste du traitement.
    // Obtenir l'ID de l'utilisateur connecté
    $id_utilisateur = obtenir_id_utilisateur_connecte(); // Obtient l'ID de l'utilisateur connecté
    if ($id_utilisateur !== null) { // Vérifie si l'ID de l'utilisateur est valide
        modifier_publication($donnees_publication); // Appelle la fonction avec l'ID de l'utilisateur
    } 
    // Ton code pour la validation des autres champs et la modificationde la publication dans la base de données...
    // Par exemple :
    $donnees_publication = [
        'publication' => $donnees['publication'],
        'image' => null, // On laisse le champ image vide dans ce cas
    ];
    // Ajoute la publication dans la base de données
    if ( modifier_publication($donnees_publication)) {
        $success = "La publication a été modifier avec succès !";
    } else {
        $erreur = "Erreur lors de la modification de la publication dans la base de données.";
    }
}

// Redirection après le traitement
if (empty($erreur)) {
    header('Location: index.php?page=actualite&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);
} else {
    header('Location: index.php?page=modifier&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);
}
