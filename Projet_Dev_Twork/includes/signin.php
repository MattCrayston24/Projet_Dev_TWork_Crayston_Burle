<?php
    
    if(isset($_POST['formsend'])){

            extract($_POST);

            if(!empty($password) && !empty($cpassword) && !empty($email)){
                if($password == $cpassword){
                    $options = [
                        'cost' => 12,
                    ];

                    $hashpass = password_hash($password, PASSWORD_BCRYPT, $options);

                    $c = $db->prepare("SELECT email FROM utilisateur WHERE email = :email");
                    $c->execute([
                        'email'=> $email
                    ]);
                    $result = $c->rowCount();

                    if($result == 0){
                        $q = $db->prepare("INSERT INTO utilisateur(email,password) VALUES(:email,:password)");
                        $q -> execute([
                            'email' => $email,
                            'password' => $hashpass
                        ]);
                        echo "Le compte a été créé";
                    }else{
                        echo "Email déjà existant !";
                    }
                }
            }else{
                echo "Les champs ne sont pas tous remplis ou les mots de passe ne sont pas les mêmes";
            }
        }
?>