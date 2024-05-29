<?php
define('HOST', 'localhost');
define('DB_NAME', 'ProjetDev');
define('USER', 'root');
define('PASS', 'lualmalualma888');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if (isset($_POST['projet_id'])) {
    $projetId = $_POST['projet_id'];

    $stmt = $db->prepare("SELECT * FROM fichiers_projet WHERE projet_id = :projet_id");
    $stmt->bindParam(':projet_id', $projetId);
    $stmt->execute();
    $fichiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fichiers as $fichier) {
        echo '<div>';
        echo '<a href="' . htmlspecialchars($fichier['path']) . '" target="_blank">' . htmlspecialchars($fichier['name']) . '</a>';
        echo '</div>';
    }
}
?>
