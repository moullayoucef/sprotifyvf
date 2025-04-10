<?php
    //endpoint pour inscrire un utilisateur dans la base de données
    require_once "../includes/auth.php";
    //echo "je suis ";
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if (empty($_POST["email"]) || empty($_POST["email"]) || empty($_POST["email"]) || empty($_POST["email"])){
            header("Location: ../../signup.html?erreur=params");
            exit();
        }
        
        
        $email = htmlspecialchars($_POST["email"]);
        $nom = htmlspecialchars($_POST["nom"]);
        $password = htmlspecialchars($_POST["password"]);
        $confirmpassword = htmlspecialchars($_POST["confirm-password"]);
        //echo $password ."   ------------   ". $confirmpassword;
        if ($password !== $confirmpassword){
            header("Location: ../../signup.html?erreur=password");
            exit();
        }
        if(registerUser($nom, $email , $password)){
            header("Location: ../../inscription.html?success=registerer");
        }else{
            header("Location: ../../signup.html?erreur=erreur");
        }
        exit();

        
    }
    
?>