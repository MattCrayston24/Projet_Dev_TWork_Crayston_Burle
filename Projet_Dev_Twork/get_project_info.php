<?php
include 'includes/databasetwork.php';
global $db;

if (isset($_POST['projet_id'])) {
    $projetId = $_POST['projet_id'];

    $stmt = $db->prepare("SELECT * FROM projets WHERE id = :id");
    $stmt->bindParam(':id', $projetId);
    $stmt->execute();
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($projet) {
        echo "<p class='texte3477'>Nom du Projet : " . $projet['nom'] . "</p>";

        $stmt = $db->prepare("SELECT utilisateur.email FROM membres_projet JOIN utilisateur ON membres_projet.user_id = utilisateur.id WHERE membres_projet.projet_id = :projet_id");
        $stmt->bindParam(':projet_id', $projetId);
        $stmt->execute();
        $membres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<p class='texte347'>Membres : ";
        foreach ($membres as $membre) {
            echo $membre['email'] . ", ";
        }
        echo "</p>";
    } else {
        echo "<p>Projet non trouvé.</p>";
    }
}
?>