<?php
require_once './backend/config/database.php';
session_start();

// Récupérer les activités depuis la base de données
try {
    $stmt = $connexion->query("SELECT * FROM cours");
    $activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des activités: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos activités - Sportify</title>
    <link rel="icon" type="image/x-icon" href="img/favicon (2).ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./style.css">
    <script src="main.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="img/logo.jpg" alt="sportify" class="logo-navbar me-2">
                <span class="fw-bol text-white"> Sportify</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="index.html">Accueil</a>

                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="devis.html">Devis</a>

                  </li>
                  <li class="nav-item">
                    <a class="nav-link active " href="activites.php">Activites</a>

                </li>
                    


                    
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact </a>

                    </li>
                    <li class="nav-item ">
                        <a id="btnConnexion"class="nav-link " href="inscription.html">Connexion </a>

                    </li>
                    <li  class="nav-item ">
                        <a id="btnCompte" class="nav-link d-none" href="dashboard.php">Mon compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Activités -->
    <main>
        <section class="section-white text-center py-5">
            <div class="container">
                <h2 class="mb-5">Nos Activités Sportives</h2>
                <div class="row justify-content-center">
                    <?php foreach ($activites as $activite): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <img src="<?= htmlspecialchars($activite['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($activite['nom']) ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($activite['nom']) ?></h5>
                                <p class="card-text">
                                    <i class="bi bi-clock"></i> Durée: <?= htmlspecialchars($activite['duree']) ?><br>
                                    <i class="bi bi-people"></i> Max: <?= htmlspecialchars($activite['participants_max']) ?> participants<br>
                                    <?php if(!empty($activite['niveaux'])): ?>
                                        <i class="bi bi-bullseye"></i> Niveaux: <?= htmlspecialchars($activite['niveaux']) ?><br>
                                    <?php endif; ?>
                                    <i class="bi bi-person-video2"></i> Coach: <?= htmlspecialchars($activite['coach']) ?><br>
                                    <?php if(!empty($activite['equipement'])): ?>
                                        <i class="bi bi-activity"></i> <?= htmlspecialchars($activite['equipement']) ?><br>
                                    <?php endif; ?>
                                </p>
                                
                                <?php if(isset($_SESSION['id'])): ?>
                                    <button class="btn btn-primary inscrire-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalReservation"
                                            data-cours-id="<?= $activite['id'] ?>"
                                            data-cours-nom="<?= htmlspecialchars($activite['nom']) ?>">
                                        S'inscrire
                                    </button>
                                <?php else: ?>
                                    <a href="inscription.php" class="btn btn-primary">S'inscrire</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2025 Sportify . Tous droits réservés
                <small>Conçu par MAALI Fatima et MOULLA Youcef</small>
            </p>
        </div>
    </footer>

    <!-- Modal de réservation -->
    <div class="modal fade" id="modalReservation" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="./backend/actions/inscription.php" method="post" id="formReservation" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Réserver un cours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="activite_id" id="coursSelectionne">
                    <div class="mb-3">
                        <label for="dateCours" class="form-label">Date du cours</label>
                        <input type="date" class="form-control" name="date" id="dateCours" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="heureCours" class="form-label">Créneau horaire</label>
                        <select class="form-control" name="heure" id="heureCours" required>
                            <option value="">Choisir une heure</option>
                            <option value="10:00">10:00</option>
                            <option value="14:00">14:00</option>
                            <option value="16:00">16:00</option>
                            <option value="18:00">18:00</option>
                            <option value="20:00">20:00</option>
                            <option value="22:00">22:00</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer l'inscription</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Script pour gérer les réservations
    document.addEventListener('DOMContentLoaded', function() {
        const reservationModal = document.getElementById('modalReservation');
        
        document.querySelectorAll('.inscrire-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Récupérer les données du cours
                const coursId = this.getAttribute('data-cours-id');
                const coursNom = this.getAttribute('data-cours-nom');
                
                // Mettre à jour la modal
                document.getElementById('modalLabel').textContent = 'Réserver : ' + coursNom;
                document.getElementById('coursSelectionne').value = coursId;
                
                // Configurer la date minimum (aujourd'hui)
                const dateInput = document.getElementById('dateCours');
                dateInput.min = new Date().toISOString().split('T')[0];
                dateInput.value = '';
            });
        });
    });
    </script>
</body>
</html>