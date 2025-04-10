<?php
    //endpoint pour modifié les information de l'utilisateur 
        require_once "../config/database.php";
        require_once "../includes/auth.php";
        session_start();
        if(!isset($_SESSION["id"])){
            header("Location: ../../inscription.html");
            exit();
        }
        if(empty($_POST["nom"])&&empty($_POST["email"])&& empty($_POST["telephone"])&&empty($_POST["adresse"])){
            header("Location: ../../dashboard.php?message:empty");
            exit();
        }
        $data = getUserInfo();
        $nom = !empty($_POST["nom"]) ? $_POST['nom'] : $data["nom"];
        $email = !empty($_POST["email"]) ? $_POST['email'] : $data["email"];
        $adresse = !empty($_POST["adresse"]) ? $_POST['adresse'] : NULL;
        $telephone = !empty($_POST["telephone"]) ? $_POST['telephone'] : NULL;
        try{
            $sql = $connexion->prepare("update utilisateurs set nom = ? , email = ? , adresse = ? , telephone = ? where email = ?"); 
            $sql->execute([$nom, $email , $adresse , $telephone , $data["email"]]);
        }catch(Exception $e){
            header("Location: ../../dashboard.php");
            exit();
        }   
        header("Location: ../../dashboard.php?message=success");
            exit();
    

?>
