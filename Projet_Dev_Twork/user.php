<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Allison&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet"> 
    <title>TWork</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .file-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
        }
        .message {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
        .file-name {
            color: green;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
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

<div class="banderole">
        <h1 class="titretdb">Tableau de bord</h1>
        <div class="linetdb"></div>
</div>

<div class="backprincipal">
    <div class="blockfichier" id="uploadBlock">
        <?php
        include 'includes/databasetwork.php';
        global $db;

        if (!isset($_SESSION['email'])) {
            echo "Vous devez être connecté pour uploader un fichier.";
            exit;
        }

        $userEmail = $_SESSION['email'];
        $stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $userEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Utilisateur introuvable.";
            exit;
        }

        $userId = $user['id'];

        $uploadMessage = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $uploadDirectory = 'uploads/';
            $uploadPath = $uploadDirectory . basename($fileName);

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $stmt = $db->prepare("INSERT INTO fichiers (name, type, size, user_id, date) VALUES (:name, :type, :size, :user_id, NOW())");
                $stmt->bindParam(':name', $fileName);
                $stmt->bindParam(':type', $fileType);
                $stmt->bindParam(':size', $fileSize);
                $stmt->bindParam(':user_id', $userId);

                if ($stmt->execute()) {
                    $uploadMessage = "Fichier partagé.";
                } else {
                    $uploadMessage = "Erreur lors de l'enregistrement des informations du fichier.";
                }
            } else {
                $uploadMessage = "Erreur lors du déplacement du fichier téléchargé.";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadMessage = "Aucun fichier téléchargé ou une erreur est survenue.";
        }
        ?>

        <form class="menufichier" action="user.php" method="post" enctype="multipart/form-data">
            <label class="mainfichiertxt" for="file">Vos fichiers :</label>
            <label class="btnfichier" for="file">Choisir un fichier</label>
            <input type="file" name="file" id="file" required style="display: none;">
            <span class="file-name" id="file-name"></span>
            <input class="buttonsubmitfichier" type="submit" value="Partager">
            <?php if ($uploadMessage): ?>
                <div class="message"><?php echo $uploadMessage; ?></div>
            <?php endif; ?>
            <div class="button-container">
            <button id="searchUserBtn" class="buttonsubmitfichiert">Rechercher utilisateur</button>
            </div>
        </form>

        <div class="file-container">
            <?php
            $stmt = $db->prepare("SELECT * FROM fichiers WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($files as $file): ?>
                <div class="file-box">
                    <h3><?php echo $file['name']; ?></h3>
                    <p>Taille: <?php echo $file['size']; ?> KB</p>
                    <p>Type: <?php echo $file['type']; ?></p>
                    <p>Date: <?php echo $file['date']; ?></p>
                    <a class="buttonsubmitfichierr" href="uploads/<?php echo $file['name']; ?>" target="_blank">Visualiser</a>
                    <a class="buttonsubmitfichierr" href="download.php?file=<?php echo $file['name']; ?>">Télécharger</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="blockfichier" id="searchBlock" style="display:none;">
        <div class="menufichier2">
            <form class="searchform" action="user.php" method="get">
                <label class="texte31" for="search-email">Rechercher un email :</label>
                <input class="recherchemail" type="email" name="search-email" id="search-email" required>
                <input class="buttonsubmitfichier2" type="submit" value="Rechercher">
            </form>
            <div class="button-container">
            <button id="backBtn" class="buttonsubmitfichier2">Retour</button>
        </div>
        </div>

        <div class="file-container2">
            <?php
            if (isset($_GET['search-email'])) {
                $searchEmail = $_GET['search-email'];
                echo "<p class='search-email-info'>Fichier(s) de : $searchEmail</p>";
                $stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = :email");
                $stmt->bindParam(':email', $searchEmail);
                $stmt->execute();
                $searchUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($searchUser) {
                    $searchUserId = $searchUser['id'];
                    $stmt = $db->prepare("SELECT * FROM fichiers WHERE user_id = :user_id");
                    $stmt->bindParam(':user_id', $searchUserId);
                    $stmt->execute();
                    $searchFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($searchFiles) {
                        foreach ($searchFiles as $file): ?>
                            <div class="file-box">
                                <h3><?php echo $file['name']; ?></h3>
                                <p>Taille: <?php echo $file['size']; ?> KB</p>
                                <p>Type: <?php echo $file['type']; ?></p>
                                <p>Date: <?php echo $file['date']; ?></p>
                                <a class="buttonsubmitfichierr" href="uploads/<?php echo $file['name']; ?>" target="_blank">Visualiser</a>
                                <a class="buttonsubmitfichierr" href="download.php?file=<?php echo $file['name']; ?>">Télécharger</a>
                            </div>
                        <?php endforeach;
                    } else {
                        echo "<p>Aucun fichier trouvé pour cet utilisateur.</p>";
                    }
                } else {
                    echo "<p>Utilisateur introuvable.</p>";
                }
            }
            ?>
        </div>
    </div>

    <script>
    document.getElementById('searchUserBtn').addEventListener('click', function() {
        document.getElementById('uploadBlock').style.display = 'none';
        document.getElementById('searchBlock').style.display = 'flex';
    });

    document.getElementById('backBtn').addEventListener('click', function() {
        document.getElementById('searchBlock').style.display = 'none';
        document.getElementById('uploadBlock').style.display = 'flex';
    });

    <?php if (isset($_GET['search-email'])): ?>
    document.getElementById('uploadBlock').style.display = 'none';
    document.getElementById('searchBlock').style.display = 'flex';
    <?php endif; ?>
    </script>

    <div class="blockfichierproj" id="projetBlock">
        <form class="menufichier3" action="user.php" method="post">
            <label class="texte339" for="nom-projet">Nom du projet :</label>
            <input class="recherchemail" type="text" id="nom-projet" name="nom-projet" required>
            <input class="buttonsubmitfichier2" type="submit" value="Créer Projet" name="creer-projet">
        </form>

        <?php
        if (isset($_POST['creer-projet'])) {
            $nomProjet = $_POST['nom-projet'];

            $stmt = $db->prepare("INSERT INTO projets (nom, user_id) VALUES (:nom, :user_id)");
            $stmt->bindParam(':nom', $nomProjet);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            $projetId = $db->lastInsertId();

            $stmt = $db->prepare("INSERT INTO membres_projet (projet_id, user_id) VALUES (:projet_id, :user_id)");
            $stmt->bindParam(':projet_id', $projetId);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            echo "<p class='search-email-info'>Projet '$nomProjet' créé avec succès!</p>";
        }
        ?>

        <form class="menufichier7" action="user.php" method="post">
            <label class="texte339" for="projet-id">Vos projets :</label>
            <select class="aberrant" name="projet-id" id="projet-id" required onchange="displayProjectInfo()">
                <option class="aberrantt" value="">Sélectionner un projet</option>
                <?php
                $stmt = $db->prepare("SELECT * FROM projets WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($projets as $projet) {
                    echo "<option value='" . $projet['id'] . "'>" . $projet['nom'] . "</option>";
                }
                ?>
            </select>
            <div id="project-info">
            </div>
            <label class="texte3399" for="email-membre">Adresse Email du Membre :</label>
            <input class="recherchemail2" type="email" id="email-membre" name="email-membre" required>
            <input class="buttonsubmitfichier2" type="submit" value="Ajouter Membre" name="ajouter-membre">
        </form>

        <?php
        if (isset($_POST['ajouter-membre'])) {
            $projetId = $_POST['projet-id'];
            $emailMembre = $_POST['email-membre'];

            $stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = :email");
            $stmt->bindParam(':email', $emailMembre);
            $stmt->execute();
            $membre = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($membre) {
                $membreId = $membre['id'];
                $stmt = $db->prepare("SELECT * FROM membres_projet WHERE projet_id = :projet_id AND user_id = :user_id");
                $stmt->bindParam(':projet_id', $projetId);
                $stmt->bindParam(':user_id', $membreId);
                $stmt->execute();
                $existingMember = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$existingMember) {
                    $stmt = $db->prepare("INSERT INTO membres_projet (projet_id, user_id) VALUES (:projet_id, :user_id)");
                    $stmt->bindParam(':projet_id', $projetId);
                    $stmt->bindParam(':user_id', $membreId);
                    $stmt->execute();

                    echo "<p class='search-email-info'>Membre ajouté au projet avec succès!</p>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<p class='search-email-info'>Le membre est déjà ajouté à ce projet.</p>";
                }
            } else {
                echo "<p class='search-email-info'>Aucun utilisateur trouvé avec cette adresse email.</p>";
            }
        }
        ?>
    </div>

    <script>
    function displayProjectInfo() {
        var projectId = document.getElementById('projet-id').value;
        var projectInfoDiv = document.getElementById('project-info');

        if (projectId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_project_info.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    projectInfoDiv.innerHTML = xhr.responseText;
                }
            };
            xhr.send('projet_id=' + projectId);
        } else {
            projectInfoDiv.innerHTML = '';
        }
    }
    </script>

<?php

if (!isset($_SESSION['email'])) {
    exit("Vous devez être connecté pour accéder à cette ressource.");
}

?>

<div class="blockfichierteam" id="teamBlock">
    <!-- Select Project Form -->
    <form id="selectProjectForm" class="menufichier4">
        <label class="texte339" for="team-projet-id">Sélectionnez un projet :</label>
        <select class="aberrant" name="team-projet-id" id="team-projet-id" required>
            <option class="aberrantt" value="">Sélectionner un projet</option>
            <?php
            $stmt = $db->prepare("SELECT * FROM projets WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($projets as $projet) {
                echo "<option value='" . $projet['id'] . "'>" . $projet['nom'] . "</option>";
            }
            ?>
        </select>
    </form>

    <!-- Chat Messages -->
    <div id="projectChat" style="display:none;">
        <div id="chatMessages">
            <?php
            if (isset($_POST['projet_id'])) {
                $projetId = $_POST['projet_id'];
                $stmt = $db->prepare("SELECT * FROM chatprojet WHERE projet_id = :projet_id");
                $stmt->bindParam(':projet_id', $projetId);
                $stmt->execute();
                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($messages as $message) {
                    echo "<p>" . $message['messagemembre'] . "</p>";
                }
            }
            ?>
        </div>
        <form id="sendMessageForm" class="menufichier4" method="post">
            <input type="hidden" name="projet_id" id="chat-projet-id">
            <textarea name="message" id="message" rows="3" placeholder="Entrez votre message..."></textarea>
            <input type="submit" value="Envoyer">
            <?php
            if (isset($_POST['message'])) {
                $projetId = $_POST['projet_id'];
                $message = $_POST['message'];
                $stmt = $db->prepare("INSERT INTO chatprojet (messagemembre, date, projet_id, user_id) VALUES (:message, NOW(), :projet_id, :user_id)");
                $stmt->bindParam(':message', $message);
                $stmt->bindParam(':projet_id', $projetId);
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
                echo "<script>window.location.href = window.location.href;</script>";
            }
            ?>
        </form>
    </div>

    <!-- Project Files -->
    <div id="projectFiles" style="display:none;">
        <div id="fileList">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['projet_id'])) {
                $projetId = $_POST['projet_id'];
                $stmt = $db->prepare("SELECT * FROM fichiers_projet WHERE projet_id = :projet_id");
                $stmt->bindParam(':projet_id', $projetId);
                $stmt->execute();
                $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($files as $file) {
                    echo "<p>" . $file['name'] . "</p>";
                }
            }
            ?>
        </div>
        <form id="uploadFileForm" class="menufichier4" enctype="multipart/form-data">
            <input type="hidden" name="projet_id" id="file-projet-id">
            <label for="project-file">Partager un fichier :</label>
            <input type="file" name="project-file" id="project-file" required>
            <input type="submit" value="Uploader">
        </form>
    </div>
</div>

<!-- Script JavaScript pour gérer l'envoi de fichier -->
<script>
    document.getElementById('uploadFileForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var projetId = document.getElementById('file-projet-id').value;

        formData.append('projet_id', projetId); // Ajout de l'ID du projet aux données du formulaire

        fetch('upload_project_file.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Mettre à jour la liste des fichiers après l'envoi réussi
            loadProjectFiles(projetId);
            this.reset();
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi du fichier:', error);
        });
    });

    function loadProjectFiles(projetId) {
        fetch('get_project_files.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'projet_id=' + projetId
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('fileList').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement des fichiers:', error);
        });
    }

    document.getElementById('team-projet-id').addEventListener('change', function() {
        var projetId = this.value;
        document.getElementById('chat-projet-id').value = projetId;
        document.getElementById('file-projet-id').value = projetId;

        if (projetId) {
            document.getElementById('projectChat').style.display = 'block';
            document.getElementById('projectFiles').style.display = 'block';
            loadProjectFiles(projetId);
            loadChatMessages(projetId);
        } else {
            document.getElementById('projectChat').style.display = 'none';
            document.getElementById('projectFiles').style.display = 'none';
        }
    });

    document.getElementById('sendMessageForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this); 
        fetch('send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            loadChatMessages(document.getElementById('chat-projet-id').value);
            this.reset();
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi du message :', error);
        });
    });

    function loadChatMessages(projetId) {
        fetch('get_chat_messages.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'projet_id=' + projetId
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('chatMessages').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement des messages du chat :', error);
        });
    }
</script>

<script>
    document.getElementById('team-projet-id').addEventListener('change', function() {
        var projetId = this.value;
        document.getElementById('chat-projet-id').value = projetId;
        document.getElementById('file-projet-id').value = projetId;

        if (projetId) {
            document.getElementById('projectChat').style.display = 'block';
            document.getElementById('projectFiles').style.display = 'block';
        } else {
            document.getElementById('projectChat').style.display = 'none';
            document.getElementById('projectFiles').style.display = 'none';
        }
    });
</script>


</body>
</html>




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

<script>
    document.getElementById('file').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name').textContent = fileName;
    });
</script>

</body>
</html>