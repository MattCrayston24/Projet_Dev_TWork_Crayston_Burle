<?php

    define('HOST','localhost');
    define('DB_NAME','ProjetDev');
    define('USER','root');
    define('PASS','lualmalualma888');

    try{
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connexion > nickel chrome !";
    } catch(PDOException $e){
        echo $e;
    }