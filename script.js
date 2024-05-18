// var likes = 0;
// var liked = false;

// function likePost(button, id_publication,id_utilisateur) {
//     if (!liked) {
//         // Augmenter le compteur de likes
//         likes++;
//         // Mettre à jour l'icône et le compteur de likes
//         button.querySelector("#likeIcon").classList.remove("fa-regular");
//         button.querySelector("#likeIcon").classList.add("fa-solid");
//         button.querySelector("#likeCount").innerHTML = likes;
//         liked = true;

//         // Exécute la requête SQL pour ajouter un like dans la base de données
//         ajouterLike(id_utilisateur, id_publication);
//     } else {
//         // Diminuer le compteur de likes
//         likes--;
//         // Mettre à jour l'icône et le compteur de likes
//         button.querySelector("#likeIcon").classList.remove("fa-solid");
//         button.querySelector("#likeIcon").classList.add("fa-regular");
//         button.querySelector("#likeCount").innerHTML = likes;
//         liked = false;

//         // Exécute la requête SQL pour supprimer le like de la base de données
//         supprimerLike(id_utilisateur, id_publication);
//     }
// }

// function ajouterLike(id_utilisateur, id_publication) {
//     // Exécute la requête SQL pour insérer une nouvelle ligne dans la table "like"
//     // Assure-toi d'échapper les valeurs pour éviter les injections SQL (utilise des requêtes préparées)
//     const query = `
//         INSERT INTO like (id_utilisateur, id_publication)
//         VALUES (?, ?);
//     `;

//     // Exécute la requête avec les valeurs appropriées
//     // Remplace "taConnexion" par ton objet de connexion à la base de données
//     taConnexion.query(query, [id_utilisateur, id_publication], (erreur, resultats) => {
//         if (erreur) {
//             console.error("Erreur lors de l'ajout du like :", erreur);
//         } else {
//             console.log("Like ajouté avec succès !");
//         }
//     });
// }

// function supprimerLike(id_utilisateur, id_publication) {
//     // Exécute la requête SQL pour supprimer le like de la table "like"
//     const query = `
//         DELETE FROM like
//         WHERE id_utilisateur = ? AND id_publication = ?;
//     `;

//     // Exécute la requête avec les valeurs appropriées
//     // Remplace "taConnexion" par ton objet de connexion à la base de données
//     taConnexion.query(query, [id_utilisateur, id_publication], (erreur, resultats) => {
//         if (erreur) {
//             console.error("Erreur lors de la suppression du like :", erreur);
//         } else {
//             console.log("Like supprimé avec succès !");
//         }
//     });
// }

// // Exemple d'utilisation :
// const utilisateurActuel = 123; // Remplace par l'id de l'utilisateur actuel
// const publicationAimee = 456; // Remplace par l'id de la publication aimée
// // Appelle cette fonction lorsque l'utilisateur appuie sur le bouton "J'aime"
// likePost(monBouton, id_publication, id_utilisateur);

function toggleCommentField(button) {
    var commentField = button.parentNode.querySelector(".commentField");
    if (commentField.style.display === "none") {
        commentField.style.display = "block";
    } else {
        commentField.style.display = "none";
    }
}

function submitComment(button) {
    var commentText = button.parentNode.querySelector(".commentText").value;
    // Enregistrez le commentaire dans votre base de données ou effectuez toute autre action nécessaire ici
    console.log("Commentaire enregistré:", commentText);
    // Réinitialiser le champ de commentaire après l'envoi
    button.parentNode.querySelector(".commentText").value = "";
}
