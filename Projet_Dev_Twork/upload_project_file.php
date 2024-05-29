<?php
session_start();
define('HOST', 'localhost');
define('DB_NAME', 'ProjetDev');
define('USER', 'root');
define('PASS', 'lualmalualma888');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if (isset($_POST['projet_id']) && isset($_FILES['project-file'])) {
    $projetId = $_POST['projet_id'];
    $userId = $_SESSION['user_id']; 

    $fileName = $_FILES['project-file']['name'];
    $fileTmpName = $_FILES['project-file']['tmp_name'];
    $filePath = 'uploads/' . $fileName; 
    if (move_uploaded_file($fileTmpName, $filePath)) {
        $stmt = $db->prepare("INSERT INTO fichiers_projet (name, path, projet_id, user_id) VALUES (:name, :path, :projet_id, :user_id)");
        $stmt->bindParam(':name', $fileName);
        $stmt->bindParam(':path', $filePath);
        $stmt->bindParam(':projet_id', $projetId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    } else {
        echo "Erreur lors du téléchargement du fichier.";
    }
}
?>
