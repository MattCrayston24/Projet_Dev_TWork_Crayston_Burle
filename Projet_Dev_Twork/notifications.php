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
            
        </li>
            </ul>
        </nav>
    </header>

    <?php
    
    include 'includes/databasetwork.php';
    global $db;

    ?>

    <section class="wally">
        <div class="notifs-container">
            <h2 class="textechatt">Notifications :</h2>
            <div class="line4"></div>
            <section id="notifs" class="message">
                
            </section>
        </div>
    </section>

    <?php
    $adminPassword = 'adminmatt'; 
    $formVisible = false; 

    if(isset($_POST['checkPass'])){
        if(!empty($_POST['admin_pass']) && $_POST['admin_pass'] === $adminPassword){
            $formVisible = true; 
        }else{
            $errorMessage = "Mot de passe administrateur incorrect";
        }
    }

    if(isset($_POST['Envoyer'])){
        if(!empty($_POST['prenom']) && !empty($_POST['notif'])){
            $prenom = htmlspecialchars($_POST['prenom']);
            $notif = nl2br(htmlspecialchars($_POST['notif']));
            $insererNotif = $db->prepare('INSERT INTO notifications(prenom, notif) VALUES(?, ?)');
            $insererNotif->execute(array($prenom, $notif));
        }else{
            echo "Veuillez compléter tous les champs";
        }
    }
    ?>

    <section class="wallpap">
        <div class="blockmpp">
            <?php if(!$formVisible): ?>
                <form method="POST" action="">
                    <h3 class="tex">Mot de passe admin :</h3>
                    <input class="tttt" type="password" name="admin_pass" placeholder="Entrez le mot de passe admin">
                    <br>
                    <?php if(isset($errorMessage)): ?>
                        <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
                    <?php endif; ?>
                    <input class="buttonsubmitt" type="submit" name="checkPass" value="Vérifier">
                </form>
            <?php else: ?>
                <form class="chat" method="POST" action="">
                    <h3 class="tex">Titre :</h3>
                    <input class="tttt" type="text" name="prenom" placeholder="Titre du sujet">
                    <br>
                    <h3 class="tex">Sujet :</h3>
                    <textarea class="ttttt" name="notif" placeholder="Sujet"></textarea>
                    <br>
                    <input class="buttonsubmitt" type="submit" name="Envoyer" value="Envoyer">
                </form>
            <?php endif; ?>
        </div>
    </section>


    <script>
            setInterval('load_notifs()', 500);
            function load_notifs(){
                $('#notifs').load('loadNotifs.php');
            }
    </script>

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