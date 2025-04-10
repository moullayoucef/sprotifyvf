<?php
    require_once "../config/database.php";
    require_once "../includes/sendMail.php";

    $activites = $_POST["activites"];
    try{
    $prix = 0 ;  
    // le message a envoyé par mail : 
    $message ="<html>
    <head>
    <title> Votre Devis </title>
    <style>
    table{
        border-spacing = 30px; 
    }
    </style>
    </head>
    <body>
        <h2> Bonjour ".$_POST["nom"]."</h2>
        <p> veuillez trouvé ci-dessous le detail du devis demandé : </p>
        <table>
        <tr>
            <th>Nom Cours </th>
            <th> Prix Unitaire </th>
        </tr>
    ";
    foreach($_POST["activites"] as $activite){
        echo $activite;
        $sql = $connexion->prepare("Select prix from cours where nom = ?");
        $sql->execute([$activite]);
        $data = $sql->fetch();
        $message = $message . "<tr> <td> ".$activite ."</td> <td> ".$data["prix"]." €</td> </tr>";
        $prix = $prix + $data["prix"];
    }
    $message = $message ."<tr> <td> Total : </td><td>".$prix." €</td></table> 
    <p> Merci pour votre confiance <br> Cordialement <br> <span style='font-size:20px; font-weight:bold ; color:green'>Sportify</span> </p></body> </html>";
    echo $message;
    sendMail("Votre Devis",$_POST["email"],$message);
    header("Location: ../../devis.html?message=operation_reussi");
}catch(Exception  $e){
    header("Location : ../../devis.html?error=operationechoé");
    exit();
}

?>