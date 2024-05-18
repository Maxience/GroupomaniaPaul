
<?php


$erreur = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];

    // Chercher l'administrateur dans la base de données
    $administrateur = chercher_administrateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe);

    if (!empty($administrateur)) {
        // L'administrateur est trouvé, le connecter en enregistrant ses informations dans la session
        unset($administrateur['mot_de_passe']); // Ne pas stocker le mot de passe dans la session
        $_SESSION['administrateur_connecte'] = $administrateur;
        
        header("Location: indexadmin.php?page=dashbord&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs). '&success=' . $success"); // Rediriger vers la page du tableau de bord
        exit();
    } else {
        // L'administrateur n'est pas trouvé ou le mot de passe est incorrect
        $erreur = "Adresse email ou mot de passe incorrect.";
        header("Location: indexadmin.php?page=connexion&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs). '&success=' . $success");
    }
}
?>
