<?php
    //endpoint pour un utilisateur ce connecté a sont espace 
    require_once "../includes/auth.php";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty($_POST["email"])||empty($_POST["password"])){
            header("Location: ../../inscription.html?error=empty");
            exit();
        }
        session_start();
        if(connectionUser($_POST["email"],$_POST["password"])){
            echo "<script> 
                localStorage.setItem('utilisateurConnecte','true');
                window.location.href ='../../dashboard.php';
            </script>";
            exit();
        }else{
            header("Location: ../../inscription.html?error=erreur");
        }
        exit();
        

    }

?>