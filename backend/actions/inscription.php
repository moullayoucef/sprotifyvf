

<?php

    //endpoint pour s'inscrire a une seance
    
    require_once "../config/database.php";
    require_once "../includes/auth.php";
    session_start();
    $data = getUserInfo();
    $user_id = $data["id"];
    $courid = htmlspecialchars($_POST["activite_id"]);
    $date = htmlspecialchars($_POST["date"]);
    $heure = htmlspecialchars($_POST["heure"]);
    echo $courid.$heure;
    print_r($date);
    try{
    $sql = $connexion->prepare("insert into reservations (user_id,cours_id,date_cours,heure_cours) values( ? , ? , ? , ?)");
    $sql->execute([$user_id,$courid , $date , $heure]);
    header("Location: ../../dashboard.php");
    }catch(Exception $e){
        header("Location: ../../activites.php?error=notinsrit");
    }
    exit();
?>