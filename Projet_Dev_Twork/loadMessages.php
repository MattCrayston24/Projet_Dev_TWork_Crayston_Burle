<?php

define('HOST','localhost');
define('DB_NAME','ProjetDev');
define('USER','root');
define('PASS','lualmalualma888');

$db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);

$recupMessages = $db->query('SELECT * FROM messages');

while($message = $recupMessages->fetch()){
    ?>

    <div class="message">
        <h4><?= htmlspecialchars($message['pseudo']); ?></h4>
        <p><?= nl2br(htmlspecialchars($message['message'])); ?></p>
    </div>

    <?php
}
?>