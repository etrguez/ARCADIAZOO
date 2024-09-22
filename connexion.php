<?php
session_start();

if (isset($_POST['Se_connecter'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = ($_POST['username']);
        $password = $_POST['password'];

        $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
        $statement = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = :username');
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'] = $user['role_id'];
            $_SESSION['message_connexion'] = 'Bonjour ' . $user['prenom'] . ' ' . $user['nom'] . ', Vous êtes connecté !';

            if ($_SESSION['role'] == 1) {
                header('Location: espace_admin.php');
            } elseif ($_SESSION['role'] == 2) {
                header('Location: espace_employe.php');
            } else  { header('Location: espace_veterinaire.php');
            }
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-3" id="menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span class="text-success fs-5 fw-bold">Arcadia</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Nos Animaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="habitats_page.php">Nos Habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="page_services.php">Nos Services</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <button class="btn btn-outline-success" type="submit"><a href="connexion.php">connexion</a></button>
                </form>
            </div>
        </div>
    </nav>
</header>

<main class="container my-5">
    <h2 class="text-center text-success mb-4">Connexion</h2>
    <p class="text-center text-muted">Cet espace est réservé au personnel du parc.</p>
    <?php if (isset($message)): ?>
        <div class="alert alert-danger text-center"><?php echo ($message); ?></div>
    <?php endif; ?>
    <form method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="Se_connecter" class="btn btn-success w-100">Se connecter</button>
    </form>
</main>

<footer>
    <div class="text-center text-lg-start bg-body-tertiary text-muted">
        <section class="d-flex justify-content-center justify-content-lg-around p-4 border-bottom">
            <div class="me-5 d-none d-lg-block text-success">
                <span>Retrouvez-nous sur les réseaux sociaux:</span>
            </div>
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </section>
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-success">
                            <i class="fas fa-gem me-3 text-success"></i>Arcadia
                        </h6>
                        <p>
                            Un lieu où la nature et la durabilité sont au cœur de tout.
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-success">
                            Notre Zoo
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Animaux</a>
                        </p>
                        <p>
                            <a href="habitats_page.php" class="text-reset">Habitats</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Rejoignez-nous</a>
                        </p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-success">
                            Services
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Billeterie</a>
                        </p>
                        <p>
                            <a href="page_services.php" class="text-reset">Restauration</a>
                        </p>
                        <p>
                            <a href="page_services.php" class="text-reset">Visite du zoo avec un guide</a>
                        </p>
                        <p>
                            <a href="page_services.php" class="text-reset">Visite du zoo en petit train</a>
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-success">Contact</h6>
                        <p><i class="fas fa-home me-3 text-success"></i> Forêt de Brocéliande, 35380 Paimpont</p>
                        <p>
                            <i class="fas fa-envelope me-3 text-success"></i>
                            info@arcadia.com
                        </p>
                        <p><i class="fas fa-phone me-3 text-success"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3 text-success"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="fw-bold text-success" href="#">ARCADIA</a>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>