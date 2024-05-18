<?php
if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
} 

function connexion_action_db()
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
$db = connexion_action_db();
// die(var_dump($_GET['action']));
// if (isset($_GET['page']) AND (isset($_GET['id']))){
//     $getid = (int) $_GET['id'];
//     $gett = (int) $_GET['page'];
// }

if (isset($_GET['page'], $_GET['id']) and (!empty($_GET['page'])) and (!empty($_GET['id']))) {
    $getid = (int) $_GET['id'];
    $gett = (int) $_GET['page'];

    // $sessionid = 5;

    $requette = $db->prepare('SELECT id FROM publication WHERE id = ?');
    $requette->execute(array($getid));

    if ($requette->rowCount() == 1) {
        if ($gett == 'action') {
            $check_like = $db->prepare('SELECT id FROM likes WHERE  id_publication = ? AND id_utilisateur = ?');
            $check_like->execute(array($getid, $sessionid));

            if ($check_like->rowCount() == 1) {
                $del = $db->prepare('DELETE FROM likes WHERE  id_publication = ? AND id_utilisateur = ?');
                $del->execute(array($getid, $sessionid));
            } else {
                $ins = $db->prepare('INSERT INTO likes (id_publication, id_utilisateur) VALUES (?,?) ');
                $ins->execute(array($getid, $sessionid));
            }
        }
        $likes = $db->prepare('SELECT id FROM likes WHERE id_publication = ?');
        $likes->execute(array($getid));
        $likes = $likes->rowCount();



        header('Location: index.php?page=action&id=' . $publication['id']);
    } else {
        exit('Erreur fatal');
    }
}

