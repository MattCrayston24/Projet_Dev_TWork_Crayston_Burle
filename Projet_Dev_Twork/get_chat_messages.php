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

    $stmt = $db->prepare("SELECT * FROM chatprojet WHERE projet_id = :projet_id ORDER BY date ASC");
    $stmt->bindParam(':projet_id', $projetId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        echo '<div>';
        echo '<strong>' . htmlspecialchars($message['user_id']) . ':</strong> ' . htmlspecialchars($message['messagemembre']);
        echo '<br><small>' . htmlspecialchars($message['date']) . '</small>';
        echo '</div>';
    }
}
?>
