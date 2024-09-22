<?php
session_start();
if(isset($_SESSION['message_connexion'])){
    echo $_SESSION['message_connexion'];
}
unset($_SESSION['message_connexion']);


if (!isset($_SESSION['role'])) {
    
    header('Location: connexion_utilisateur.php');
    exit();
}


$role_utilisateur = $_SESSION['role'];
$role_label = '';
switch ($role_utilisateur) {
    case 1:
        $role_label = 'Administrateur';
        break;
    case 2:
        $role_label = 'Employé';
        break;
    case 3:
        $role_label = 'Vétérinaire';
        break;
    default:
        $role_label = 'Utilisateur';
        break;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
    <h2 class="text-center text-success mb-4">Espace Administrateur</h2>
    <p class="text-center text-muted">Connecté en tant que : <?php echo $role_label; ?></p>
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gestion des services</h5>
                    <p class="card-text">Gérer les différents services offerts par le parc.</p>
                    <a href="gestion_service.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gestion des utilisateurs</h5>
                    <p class="card-text">Gérer les utilisateurs du système.</p>
                    <a href="inscription_utilisateur.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gestion des animaux</h5>
                    <p class="card-text">Gérer les animaux présents dans le parc.</p>
                    <a href="creation_animal.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gestion des habitats</h5>
                    <p class="card-text">Gérer les habitats des animaux.</p>
                    <a href="gestion_habitat.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gestion des horaires</h5>
                    <p class="card-text">Gérer les horaires</p>
                    <a href="modification_horaire.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Valider un avis</h5>
                    <p class="card-text">Valider les avis laissés par les visiteurs.</p>
                    <a href="valider_avis.php" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>