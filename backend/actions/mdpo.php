<?php
//endpoint pour le mot de passe oublie
    require_once "../includes/sendMail.php";
    require_once "../config/database.php";

    date_default_timezone_set("Europe/Paris");
    if(empty($_POST["email"])){
        header("Location: ../../reset.html?error=email");
        exit();
    }

    try{
        $sql = $connexion->prepare("Select * from utilisateurs where email = ? ");
        $sql->execute([$_POST["email"]]);
        $result = $sql->fetch();
        if($result){
            $token = bin2hex(random_bytes(32));

            $expire = date("Y-m-d H:i:s", strtotime("+10 minutes"));
            $sql = $connexion->prepare("update utilisateurs set token_reset = ? ,
            expire_token = ?
            where email= ?");
            $sql->execute([$token,$expire,$_POST["email"]]);
            $url = "http://localhost:8888/Sportify13/reset_mdps.html?token=".$token;
            $message =$message = "
            <html>
            <head>
                <title>Réinitialisation de votre mot de passe</title>
            </head>
            <body>
                <h2>Bonjour,</h2>
                <p>Nous avons bien reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
                <p>Si c'est bien vous qui avez fait cette demande, veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
                <p><a href='".$url."'>Réinitialiser votre mot de passe</a></p>
                <p><strong>Attention :</strong> Ce lien est valable pendant 10 minutes. Passé ce délai, il expirera.</p>
                <p><strong>Date d'expiration :</strong> ".$expire."</p>
                <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
                <br>
                <p>Cordialement,</p>
                <p>Sportify</p>
            </body>
            </html>
            ";
            
            echo $message;
            sendMail("RESET PASSWORD " ,$_POST["email"], $message );
            header("location: ../../inscription.html?succuss=true");
            exit();
        }else{
            header("Location: ../../reset.html?error=emailNotFound");
            exit();
        }
    }catch(Exception $e){
        header("Location : ../../reset.html?error:emailNotFound");
        exit();
    }

?>