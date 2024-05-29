<?php

define('HOST','localhost');
define('DB_NAME','ProjetDev');
define('USER','root');
define('PASS','lualmalualma888');

$db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);

$recupNotifs = $db->query('SELECT * FROM notifications');

while($notif = $recupNotifs->fetch()){
    ?>

    <div class="notif">
        <h4><?= htmlspecialchars($notif['prenom']); ?></h4>
        <p><?= nl2br(htmlspecialchars($notif['notif'])); ?></p>
    </div>

    <?php
}
?>