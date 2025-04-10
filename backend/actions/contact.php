<?php
    require_once "../includes/sendMail.php";

    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $email = "<html>
        <head>
            <title> Contact </title>
        </head>
        <body>
            <h3> From : " .$email. "</h3>
            <p>".$message. "
        </body>
    </html>";
    try{
    sendMail("Contact ","youcefmoulla7@gmail.com",$email);
    header("Location: ../../contact.html?success=MessageEnvoyerAvecSuccess");
    exit();
}catch(Exception $e){
    header("Location: ../../contact.html?erreur=uneErreurEstSurvenu");
    exit();
}
?>