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
            </ul>
        </nav>
    </header>

    <?php
    
    include 'includes/databasetwork.php';
    global $db;

    ?>

    <section class="wallpp">
        <div class="carréé">
            <form method="post">
            <h2 class="texte1">Déjà client ?</h2>
            <h3 class="texte2">Alors connecte-toi avec ton compte</h3>
                <input class="tt" type="email" name="lemail" id="lemail" placeholder="Votre Email" required><br/>
                <input class="tt" type="password" name="lpassword" id="lpassword" placeholder="Votre mot de passe" required><br/>
                <input class="buttonsubmit" type="submit" name="formlogin" id="formlogin" value="Se connecter">
            </form>

            <?php include 'includes/login.php'; ?>
        </div>

        <div class="carréé">
            <form method="post">
            <h2 class="texte1">Pas encore client ?</h2>
            <h3 class="texte2">Rejoins les 25 043 membres déjà actifs.</h3>
                <input class="tt" type="email" name="email" id="email" placeholder="Votre Email" required><br/>
                <input class="tt" type="password" name="password" id="password" placeholder="Votre mot de passe" required><br/>
                <input class="tt" type="password" name="cpassword" id="cpassword" placeholder="Confirmer votre mot de passe" required><br/>
                <input class="buttonsubmit" type="submit" name="formsend" id="formsend" value="S'inscrire">
            </form>

            <?php include 'includes/signin.php'; ?>
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