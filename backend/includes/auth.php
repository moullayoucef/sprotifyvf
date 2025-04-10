<?php 

    //toutes les fonction de l'utilisateur 

    require_once __DIR__."/../config/database.php";
    
    function registerUser($nom , $email , $password){
        global $connexion ; 

        try{
            $hash = password_hash($password , PASSWORD_BCRYPT);
            //echo $hash;

            $sql = $connexion->prepare("insert into utilisateurs (nom , email , password) values(? , ?, ?)");
            $sql->execute([$nom, $email , $hash]);
            return true; 
        }catch(Exception $e){
            echo $e->getMessage();
            return false; 
        }
    }
    
    function connectionUser($email , $password){
        
        global $connexion;
        try{
            $email = $connexion->quote($email);
            $sql = "select * from utilisateurs where email = $email";
            $value = $connexion->query($sql)->fetch();
//            print_r($value);
            if($value && password_verify($password , $value["password"])){
                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["id"]= $value["id"];
                $_SESSION["user"] = $value["nom"]; 
  //              echo "connextion a reussi\n";
                return true ; 
            }
    //        echo "connextion a echo \n";
            return false; 
        }   catch(Exception $e){
            echo $e->getMessage();
        } 
    }

    function estConnecter(){
        if($_SESSION["id"]){
      //      echo "il est connecté\n";
            return true;
        }else{
        //    echo "in n'est pas connecté\n";
            return false; 
        }
    }


    function getUserInfo(){
        global $connexion; 
        $id = $_SESSION["id"];
        try{
            $sql = "select * from utilisateurs where id = $id";
            $data = $connexion->query($sql);
          //  print_r($data->fetch());
            return $data->fetch();
        }catch(Exception $e){
            //echo $e->getMessage();
        }
    }

    function getUserCours() {
        global $connexion;
    
        if (!isset($_SESSION['id'])) {
            return [];
        }
    
        try {
            $stmt = $connexion->prepare("SELECT c.nom, r.date_cours, r.heure_cours 
                                       FROM utilisateurs u
                                       JOIN reservations r ON u.id = r.user_id
                                       JOIN cours c ON c.id = r.cours_id
                                       WHERE u.id = ?");
            $stmt->execute([$_SESSION['id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getUserCours: " . $e->getMessage());
            return [];
        }
    }
    

    //registerUser("youcef","youcefmoulla@gmail.com","nani123");

    //estConnecter();
    //getUserInfo();
?>