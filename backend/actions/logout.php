<?php
//endpoint pour la deconnection de l'utilisateur 
        session_start();
        $_SESSION = array();
        session_destroy();
        echo "<script>
                localStorage.setItem('utilisateurConnecte','false');
                window.location.href= '../../index.html?deconnecté=true';
        </script>;
        ";
        exit();
?>