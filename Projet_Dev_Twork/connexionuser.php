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

    <section class="wallppp">
        <div class="profilpres">
            <h1 class="profil">Bienvenue sur votre profil,</h1>
            <div class="line">

            </div>
            <?php
                if(isset($_SESSION['email']) && (isset($_SESSION['date'])))
                {
                    ?>

                    <p class="profilt">Votre email :</p>
                    <p class="profiltt"><?= $_SESSION['email'] ?></p>

                    <p class="profilt">Date de création du compte :</p>
                    <p class="profiltt"><?= $_SESSION['date'] ?></p>

                    <?php
                } else {
                    echo "Veuillez vous connecter à votre compte";
                }
            ?>

            <div class="line2">

            </div>
        </div>
    </section>

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