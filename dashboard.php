<?php
  require_once "./backend/includes/auth.php";
  require_once "./backend/config/database.php";
  session_start();
  if (!isset($_SESSION["id"])){
    header("Location: ./inscription.html?error=nonInscrit");
    exit();
  }
  $data  = getUserInfo();
  $cours = getUserCours();
  $nom = $data["nom"];
  $email =$data["email"];
  $address = $data["adresse"] ?? "Non renseigné";
  $telephone = $data["telephone"] ?? "Non renseigné";
  $attaddress = $data["adresse"] ?? "Votre Adresse ";
  $atttelephone = $data["telephone"] ?? "Votre numéro de téléphone";
  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mon espace - Sportify</title>
  <link rel="icon" type="image/x-icon" href="img/favicon (2).ico" />
  <link rel="stylesheet" href="./bootstrap.css" />
  <link rel="stylesheet" href="./style.css" />
  <script>

  </script>
  <script src="main.js" defer></script>
</head>
<body>

<!-- Navbar -->
<div class="page">
<nav class="navbar navbar-expand-lg navbar-dark bg-purple">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.html">
      <img src="img/logo.jpg" alt="sportify" class="logo-navbar me-2">
      <span class="fw-bol text-white"> Sportify</span>
  </a>
    <div class="ms-auto">
    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Accueil</a>

                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="devis.html">Devis</a>

                  </li>
                  <li class="nav-item">
                    <a class="nav-link " href="activites.php">Activites</a>

                </li>
                    


                    
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact </a>

                    </li>
                    <li class="nav-item ">
                        <a id="btnConnexion"class="nav-link " href="inscription.html">Connexion </a>

                    </li>
                    
                    <li>
                    
                    <a class="nav-link" href="./backend/actions/logout.php">Se deconnecter  </a>
                    
      
                    </li>
                </ul>
      
    </div>
  </div>
</nav>

<div class=" wrapper d-flex">

    <!--sidebar-->
    <div class="sidebar bg-dark text-white p-4">
        <h4 class="text-center mb-4">
            Mon espace

        </h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="#infos"class=" nav-link text-white">Mes informations </a></li>
            <li class="nav-item"><a href="#cours"class=" nav-link text-white">Mes cours </a></li>

            

            <li class="nav-item"><a href="activites.php" class="nav-link text-white">Réserver un cours </a></li>
            <li class="nav-item"><a href="./backend/actions/logout.php" class=" nav-link text-white">Se déconnecter </a></li>


        </ul>
    </div>
    <div class="flex-grow p-5">
        <h2 class="text-center mb-4 text-purple">
            Bienvenue dans votre espace  <?php echo $nom ?>
        </h2>
            <!-- Section Mes informations -->
    <section id="infos" class="dashboard-section" style="display: none;">
        <div class="card p-4">
          <h5 class="text-purple">📄 Mes informations</h5>
          <p><strong>Nom :</strong> <span id="affichage-nom"><?php echo $nom?></span></p>
          <p><strong>Email :</strong> <span id="affichage-email"><?php echo $email?></span></p>
          <p><strong>Adresse :</strong> <span id="affichage-adresse"><?php echo $address?></span></p>
          <p><strong>Téléphone:</strong> <span id="affichage-telephone"><?php echo $telephone?></span></p>
          
        <hr class="my-4"/>
        <!--formulaire de modification-->
        <form action="backend/actions/modif.php" method="post" id="form-infos">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom"name="nom" placeholder="<?php echo $nom?>">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Adresse mail </label>
            <input type="email" class="form-control" id="email"name="email" placeholder="<?php echo $email?>">
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse"name="adresse" placeholder="<?php echo $attaddress?>">
          </div>
          <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="tel" class="form-control" id="telephone"name="telephone" placeholder="<?php echo $atttelephone?>">
          </div>
          <button type="submit" class="btn btn-primary"> Enregistrer </button>
        </form>

        </div>
      </section>
  
      <!-- Section Mes cours -->
      <section id="cours" class="dashboard-section" style="display: none;">
        <div class="card p-3">
          <h5 class="text-purple">📚 Mes cours réservés</h5>
          <?php if(empty($cours)):?>
            <li> <?php echo "t'a aucun cours "?></li>
          <?php else :?>
            <?php  foreach($cours as $cour):?>
              <li><?php echo $cour["nom"] ." le ". $cour["date_cours"] . " à ". $cour["heure_cours"]?></li>
            <?php endforeach ?>
          <?php endif?>
        </div>
      </section>
        
    </div>
    
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    &copy; 2025 Sportify – Conçu par MAALI Fatima et MOULLA Youcef
  </footer>
</div>
</body>
</html>