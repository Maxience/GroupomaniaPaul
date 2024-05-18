<?php
// Création de la connexion
$db = connexion_db();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le code saisi par l'utilisateur
    $code_saisi = $_POST["code"];

    // Requête pour vérifier si le code saisi par l'utilisateur est présent dans la table
    $sql_check = "SELECT * FROM code WHERE code='$code_saisi'";
    $result = $db->query($sql_check);

    if ($result) {
        // Utilisation de la méthode rowCount() pour obtenir le nombre de lignes résultantes
        if ($result->rowCount() > 0) {
            // Le code saisi par l'utilisateur a été trouvé dans la table
            // Vous pouvez faire quelque chose ici, par exemple rediriger l'utilisateur vers une autre page
            header("Location: index.php?page=modifier-mot-de-passe");
            exit;
        } else {
            // Le code saisi par l'utilisateur n'a pas été trouvé dans la table
            // Vous pouvez afficher un message d'erreur par exemple

            $erreurs = "Le code saisi est incorrect.";
            header("Location: index.php?page=formulaire&erreurs:" . json_encode($erreurs));
        }
    } else {
        // Erreur lors de l'exécution de la requête
        echo "Erreur";
    }
}
