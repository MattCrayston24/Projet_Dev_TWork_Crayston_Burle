<?php

    if(isset($_POST['formlogin']))
    {
        extract($_POST);

        if(!empty($lemail) && !empty($lpassword))
        {
            $q = $db->prepare("SELECT * FROM utilisateur WHERE email = :email");
            $q->execute(['email' => $lemail]);
            $result = $q->fetch();

            if($result == true)
            {
                if(password_verify($lpassword, $result['password']))
                {
                    echo "Mot de passe correct, connexion en cours";

                    $_SESSION['email'] = $result['email'];
                    $_SESSION['date'] = $result['date'];
                    header('Location: user.php');
                } else {
                    echo "Mot de passe incorrect";
                }
            } else {
                echo "Le compte portant l'email : " . $lemail." n'existe pas";
            }
        } else {
            echo "Veuillez completer l'ensemble des champs";
        }
    }

?>