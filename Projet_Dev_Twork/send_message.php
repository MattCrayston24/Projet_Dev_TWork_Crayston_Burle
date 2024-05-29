<?php
define('HOST', 'localhost');
define('DB_NAME', 'ProjetDev');
define('USER', 'root');
define('PASS', 'lualmalualma888');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit; 
}

if (isset($_SESSION['user_id']) && isset($_POST['projet_id']) && isset($_POST['message'])) {
    $projetId = $_POST['projet_id'];
    $message = $_POST['message'];
    $userId = $_SESSION['user_id'];

    try {
        $stmt = $db->prepare("INSERT INTO chatprojet (messagemembre, date, projet_id, user_id) VALUES (:message, NOW(), :projet_id, :user_id)");
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':projet_id', $projetId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        echo "Message envoyé avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
} else {
    echo "Veuillez vous connecter et sélectionner un projet pour envoyer un message.";
}
?>