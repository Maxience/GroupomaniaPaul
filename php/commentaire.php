<?php
$db = connexion_db();

$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

$sessionid = obtenir_id_utilisateur_connecte();
$auteur= $_SESSION['utilisateur_connecter']['nom'];

if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getidcom = htmlspecialchars($_GET['id']);

    $publication = $db->prepare('SELECT * FROM publication  WHERE id = ? ');
    $publication->execute(array($getidcom));
    $publication = $publication->fetch();
?>
    <h2>publication</h2>
    <p><?= $publication["publication"] ?></p>
<?php

    if (isset($_POST['submit_commentaire'])) {
        if (isset($_POST['commentaire']) and !empty(isset($_POST['commentaire']))) {
            $commentaire = ($_POST['commentaire']);
            if ($commentaire != 0) {
                $ins = $db->prepare('INSERT INTO commentaire (commentaire, id_publication, id_utilisateur, auteur_commentaire) VALUES (?,?,?,?) ');
                $ins->execute(array($commentaire, $getidcom, $sessionid, $auteur ));
                
            } else {
                $erreurs = 'le champs commentaire ne doit pas etre vide';
            }
        } else {
            $erreurs = "Veillez remplir correctement le champs";
        }
    }
}
header('location: index.php?page=actualite&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs));
