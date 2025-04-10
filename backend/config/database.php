<?php 
    // la connection a la base de données 
    $connexion = null ;
    $login = "root";
    $userAgent = $_SERVER["HTTP_USER_AGENT"]; 

    if(stripos($userAgent,'Windows')!==false){
        $password = "";
    }else{
        $password = "root";
    }
    $host = "localhost";
    $dbname = "sportifyyf";
    
    try{
        $connexion = new PDO("mysql:host=$host;dbname=$dbname",$login, $password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        $connexion->exec("use $dbname");
        //echo "connextion bien faite";
    }catch(PDOException $e){
       // echo "connection a echoé \n".$e->getMessage();
    }

?>