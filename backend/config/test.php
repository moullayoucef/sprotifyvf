<?php
    $userAgent = $_SERVER["HTTP_USER_AGENT"]; 

    if(stripos($userAgent,'Windows')!==false){
        $password = "";
    }else{
        $password = "root";
    }
    $host = "localhost";
    $login = "root";

    try{
        $connexion = new PDO("mysql:host=$host",$login,$password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

        $connexion->exec("Create database if not exists sportifyyf");
        $connexion->exec("use sportifyyf");
        $sql = " 
        create table if not exists utilisateurs (
            id int(11) auto_increment primary key , 
            nom varchar(100) not null , 
            email varchar(100) unique not null , 
            password varchar(255) not null , 
            telephone varchar(20), 
            adresse varchar(255),
            date_inscription datetime default current_timestamp , 
            token_reset varchar(255) , 
            expire_token datetime
        ); 
        create table if not exists cours (
            id int(11) auto_increment primary key  , 
            nom varchar(100) not null , 
            description text ,
            duree varchar(20) not null , 	
            participants_max int(11) ,
            niveaux varchar(100), 
            coach varchar(100) ,
            image varchar(255) ,
            prix decimal(10,2)
        );
        create table if not exists reservations(
            id int(11) auto_increment primary key , 
            user_id int(11)	not null , 
            cours_id int(11) not null , 
            date_cours date not null,
            heure_cours time not null, 
            date_reservation datetime default current_timestamp, 
            foreign key (user_id) references utilisateurs(id), 
            foreign key (cours_id) references cours(id)
        ); 
        insert into cours (nom , description , duree , participants_max , niveaux , coach , image , prix) values 
        ('Yoga','Cours collectif de yoga','1h',5,'Débutant/Intermédiaire/Avancé','Michelle Legrand','img/yoga.jpg',0.99),
        ('Pilates','Cours collectif de pilates','1h',3,'Débutant/Intermédiaire/Avancé','Marion May','img/pilates.jpg',1.20),
        ('Renforcement musculaire','Cours de renforcement musculaire','45min',5 ,'Tous niveaux','Camille Lemont','img/renforcement.jpg',0.95),
        ('Cycling','Cours de cycling avec vélo d\'appartement','45min', 3 ,'Tous niveaux','Amy Taylor','img/cycling.jpg',1.33),
        ('Fitness','Cours de fitness','45min',5,'Tous niveaux','Laura Jones','img/fitness.png',1.00),
        ('Programme personnalisé','Coaching individuel avec suivi hebdomadaire','Variable',1,'Personnalisé','Laura Marins','img/salle.png',1.99);
        ";
        $connexion->exec($sql);
        $connexion= null ; 
        echo "data base est créé et les table et mme inseré";
        header("Location: ../../index.html");
        exit();
    }catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }
    

?>