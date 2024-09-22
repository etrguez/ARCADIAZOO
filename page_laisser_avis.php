<?php

try {
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['laisser_avis'])) {
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['commentaire'];

    if (!empty($pseudo) && !empty($commentaire)) {
        $sql = "INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (:pseudo, :commentaire, FALSE)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':pseudo' => $pseudo,
            ':commentaire' => $commentaire
        ]);
        $message = "Votre avis a été soumis et est en attente de validation.";
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
    <title>Laisser un avis</title>
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
    <h2 class="text-center text-success mb-4">Laisser un avis</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" required>
        </div>
        <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire</label>
            <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
        </div>
        <button type="submit" name="laisser_avis" class="btn btn-success w-100">Soumettre</button>
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
                            <a href="habitats.php" class="text-reset">Habitats</a>
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