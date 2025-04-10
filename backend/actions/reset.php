<?php

    //endpoint  pour changé le mot de passe suite de mot de passe oublie  
    require_once "../config/database.php";
    require_once "../includes/auth.php";

    $token = $_POST["token"];
    if(empty($token)){
        header("Location: ../../reset.html?error=invalide_token");
        exit();
    }
    $password = $_POST["password"];
    $passwordconf = $_POST["confirm"];
    if($password != $passwordconf){
        header("Location: ../../reset_mdps.html?error=motdepasse");
        exit();
    }
    try{
        $sql= $connexion->prepare("select * from utilisateurs where token_reset = ? and expire_token > Now()");
        $sql->execute([$token]);
        $user = $sql->fetch();
        if(empty(user)){
            header("Location: ../../reset.html?error=token_Expired");
            exit();
        }
        $sql = $connexion->prepare("update utilisateurs set password = ? where id = ?");
        $sql->execute([password_hash($password,PASSWORD_BCRYPT) , $user["id"]]);
        if($sql){
            header("Location: ../../inscription.html?password=changer");
            exit();
        }else{
            header("Location: ../../reset_mdps.html?error=passwordnochangé");
            exit();
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>