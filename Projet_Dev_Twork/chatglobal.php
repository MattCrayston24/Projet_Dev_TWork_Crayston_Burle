<?php session_start(); 

    setcookie('pseudo','Mattc',time() + (30 * 24 * 3600));
    setcookie('id',18, time() + 60);

    setcookie('pseudo','',time());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Allison&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet"> 
    <title>TWork</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

    <header class="main-head">
        <nav>
            <h1 id="logo">TWork</h1>
            <div class="menu-icon">&#9776;</div>
            <ul class="menu">
                <li><a href="user.php">Tableau de bord</a></li>
                <li><a href="chatglobal.php">Chat Global</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="connexionuser.php">Mon compte</a></li>
            </ul>
        </nav>
    </header>

    <?php
    
    include 'includes/databasetwork.php';
    global $db;

    ?>

    <?php

    if(isset($_POST['valider'])){
        if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $message = nl2br(htmlspecialchars($_POST['message']));
            $insererMessage = $db->prepare('INSERT INTO messages(pseudo, message) VALUES(?, ?)');
            $insererMessage->execute(array($pseudo, $message));
        }else{
            echo "Veuillez compléter tous les champs";
        }
    }
    ?>

    <div class="wallmessage">
        <div class="blockmp">
            <form class="chat" method="POST" action="">
                <h3 class="texte2">Ton pseudo :</h3>
                <input class="tt" type="text" name="pseudo" placeholder="Je suis...">
                <br>
                <h3 class="texte2">Écris ton message :</h3>
                <textarea class="ttt" name="message" placeholder="Je voulais vous dire..."></textarea>
                <br>
                <input class="buttonsubmit" type="submit" name="valider">
            </form>
        </div>

        <div class="message-container">
            <h2 class="textechat">Chat Global :</h2>
            <div class="line3"></div>
            <section id="messages" class="message">
                
            </section>
        </div>

        <script>
            setInterval('load_messages()', 500);
            function load_messages(){
                $('#messages').load('loadMessages.php');
            }
        </script>
    </div>

    <footer class="footer">
        <div class="foot-left">
            <h1 class="txt1">TWork</h1>
            <h3 class="texte5">© 2024 License</h3>
        </div>
        <div class="foot-right">
            <h3 class="texte6">Adresse mail : teamwork@twork.com</h3>
            <h3 class="texte5">Numéro Service : +33 6 34 09 73 12</h3>
        </div>
    </footer>

    <script src="js/script.js"></script>

</body>
</html>