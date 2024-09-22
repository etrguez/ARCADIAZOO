<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('Location: connexion_utilisateur.php');
    exit();
}

$role_utilisateur = $_SESSION['role'];

try {
    $base_de_donnees = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $base_de_donnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['creer_service'])) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        $sql = "INSERT INTO services (nom, description) VALUES (:nom, :description)";
        $statement = $base_de_donnees->prepare($sql);
        $statement->execute([
            ':nom' => $nom,
            ':description' => $description
        ]);

        $service_id = $base_de_donnees->lastInsertId();

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            $sql = "INSERT INTO images (service_id, image_data) VALUES (:service_id, :image_data)";
            $statement = $base_de_donnees->prepare($sql);
            $statement->execute([
                ':service_id' => $service_id,
                ':image_data' => $image_data
            ]);
        }

        echo "Service créé avec succès.";
    } elseif (isset($_POST['modifier_service'])) {
        $service_id = $_POST['service_id'];
        $description = $_POST['description'];

        $sql = "UPDATE services SET description = :description WHERE service_id = :service_id";
        $statement = $base_de_donnees->prepare($sql);
        $statement->execute([
            ':description' => $description,
            ':service_id' => $service_id
        ]);

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_data = file_get_contents($_FILES['image']['tmp_name']);
            $sql = "SELECT * FROM images WHERE service_id = :service_id";
            $statement = $base_de_donnees->prepare($sql);
            $statement->execute([':service_id' => $service_id]);
            $image = $statement->fetch(PDO::FETCH_ASSOC);

            if ($image) {
                $sql = "UPDATE images SET image_data = :image_data WHERE service_id = :service_id";
                $statement = $base_de_donnees->prepare($sql);
                $statement->execute([
                    ':image_data' => $image_data,
                    ':service_id' => $service_id
                ]);
            } else {
                $sql = "INSERT INTO images (service_id, image_data) VALUES (:service_id, :image_data)";
                $statement = $base_de_donnees->prepare($sql);
                $statement->execute([
                    ':service_id' => $service_id,
                    ':image_data' => $image_data
                ]);
            }
        }

        echo "Service modifié avec succès.";
    } elseif (isset($_POST['supprimer_service'])) {
        $service_id = $_POST['service_id'];

        $sql = "DELETE FROM images WHERE service_id = :service_id";
        $statement = $base_de_donnees->prepare($sql);
        $statement->execute([':service_id' => $service_id]);

        $sql = "DELETE FROM services WHERE service_id = :service_id";
        $statement = $base_de_donnees->prepare($sql);
        $statement->execute([':service_id' => $service_id]);

        echo "Service supprimé avec succès.";
    }
}

$sql = "SELECT services.*, images.image_data FROM services LEFT JOIN images ON services.service_id = images.service_id";
$services = $base_de_donnees->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
    <h2 class="text-center text-success mb-4">Gestion des Services</h2>
    <p class="text-center text-muted">Connecté en tant que : <?php echo ($role_utilisateur == 1 ? 'Administrateur' : 'Utilisateur'); ?></p>

    <h3>Créer un nouveau service</h3>
    <form action="" method="post" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        <input type="hidden" name="creer_service" value="1">
        <div class="mb-3">
            <label for="nom_nouveau" class="form-label">Nom:</label>
            <input type="text" class="form-control" id="nom_nouveau" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="description_nouveau" class="form-label">Description:</label>
            <textarea class="form-control" id="description_nouveau" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image_nouveau" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image_nouveau" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success w-100">Créer Service</button>
    </form>
    <hr>

    <h3>Liste des services existants</h3>
    <?php if (count($services) > 0): ?>
        <?php foreach ($services as $service): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo ($service['nom']); ?></h5>
                    <p class="card-text"><strong>Description:</strong> <?php echo ($service['description']); ?></p>
                    <?php if ($service['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($service['image_data']); ?>" class="img-fluid mb-3" alt="Image du service">
                    <?php endif; ?>
                    <h4>Modifier le service</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="modifier_service" value="1">
                        <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                        <div class="mb-3">
                            <label for="description_<?php echo $service['service_id']; ?>" class="form-label">Description:</label>
                            <textarea class="form-control" id="description_<?php echo $service['service_id']; ?>" name="description" rows="4" required><?php echo ($service['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_<?php echo $service['service_id']; ?>" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="image_<?php echo $service['service_id']; ?>" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">Modifier Service</button>
                    </form>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                        <input type="hidden" name="supprimer_service">
                        <button type="submit" class="btn btn-danger mt-2">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">Aucun service disponible.</p>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>