<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'creer') {
        try {
            if (!empty($_POST['prenom']) && !empty($_POST['race']) && !empty($_POST['description']) && !empty($_POST['etat']) && !empty($_POST['habitat_id'])) {
                $prenom = ($_POST['prenom']);
                $race = ($_POST['race']);
                $description = ($_POST['description']);
                $etat = ($_POST['etat']);
                $habitat_id = (int)$_POST['habitat_id'];
                $image_data = null;

                if (!empty($_FILES['image_data']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
                }

                $stmt = $bdd->prepare('SELECT race_id FROM races WHERE label = :race');
                $stmt->execute([':race' => $race]);
                $race_id = $stmt->fetchColumn();

                if ($race_id === false) {
                    $stmt = $bdd->prepare('INSERT INTO races (label) VALUES (:race)');
                    $stmt->execute([':race' => $race]);
                    $race_id = $bdd->lastInsertId();
                }

                $stmt = $bdd->prepare('INSERT INTO animaux (prenom, race_id, description, etat, habitat_id) VALUES (:prenom, :race_id, :description, :etat, :habitat_id)');
                $stmt->execute([
                    ':prenom' => $prenom,
                    ':race_id' => $race_id,
                    ':description' => $description,
                    ':etat' => $etat,
                    ':habitat_id' => $habitat_id
                ]);

                $animal_id = $bdd->lastInsertId();

                if ($image_data) {
                    $stmt = $bdd->prepare('INSERT INTO images (animal_id, image_data) VALUES (:animal_id, :image_data)');
                    $stmt->execute([
                        ':animal_id' => $animal_id,
                        ':image_data' => $image_data
                    ]);
                }

                $_SESSION['message'] = "Ajout de l'animal confirmé";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } elseif ($action === 'modifier') {
        try {
            if (!empty($_POST['animal_id']) && !empty($_POST['prenom']) && !empty($_POST['race']) && !empty($_POST['description']) && !empty($_POST['etat']) && !empty($_POST['habitat_id'])) {
                $animal_id = (int)$_POST['animal_id'];
                $prenom = ($_POST['prenom']);
                $race = ($_POST['race']);
                $description = ($_POST['description']);
                $etat = ($_POST['etat']);
                $habitat_id = (int)$_POST['habitat_id'];
                $image_data = null;

                if (!empty($_FILES['image_data']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
                }

                $stmt = $bdd->prepare('SELECT race_id FROM races WHERE label = :race');
                $stmt->execute([':race' => $race]);
                $race_id = $stmt->fetchColumn();

                if ($race_id === false) {
                    $stmt = $bdd->prepare('INSERT INTO races (label) VALUES (:race)');
                    $stmt->execute([':race' => $race]);
                    $race_id = $bdd->lastInsertId();
                }

                $stmt = $bdd->prepare('UPDATE animaux SET prenom = :prenom, race_id = :race_id, description = :description, etat = :etat, habitat_id = :habitat_id WHERE animal_id = :animal_id');
                $stmt->execute([
                    ':prenom' => $prenom,
                    ':race_id' => $race_id,
                    ':description' => $description,
                    ':etat' => $etat,
                    ':habitat_id' => $habitat_id,
                    ':animal_id' => $animal_id
                ]);

                if ($image_data) {
                    $stmt = $bdd->prepare('UPDATE images SET image_data = :image_data WHERE animal_id = :animal_id');
                    $stmt->execute([
                        ':image_data' => $image_data,
                        ':animal_id' => $animal_id
                    ]);
                }

                $_SESSION['message'] = "Animal modifié avec succès";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } elseif ($action === 'supprimer') {
        try {
            if (!empty($_POST['animal_id'])) {
                $animal_id = (int)$_POST['animal_id'];

                $stmt = $bdd->prepare('DELETE FROM animaux WHERE animal_id = :animal_id');
                $stmt->execute([':animal_id' => $animal_id]);

                $stmt = $bdd->prepare('DELETE FROM images WHERE animal_id = :animal_id');
                $stmt->execute([':animal_id' => $animal_id]);

                $_SESSION['message'] = "Animal supprimé";
            } else {
                echo 'Erreur : L\'ID de l\'animal est manquant.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$query = '
    SELECT animaux.animal_id, animaux.prenom, races.label, animaux.description, animaux.etat, habitats.nom, images.image_data
    FROM animaux
    LEFT JOIN images ON animaux.animal_id = images.animal_id
    LEFT JOIN races ON animaux.race_id = races.race_id
    LEFT JOIN habitats ON animaux.habitat_id = habitats.habitat_id
';
$animaux = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);

$habitats = $bdd->query('SELECT habitat_id, nom FROM habitats')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
    <h2 class="text-center text-success mb-4">Gestion des Animaux</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php echo ($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h3>Créer un nouvel animal</h3>
    <form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        <input type="hidden" name="action" value="creer">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom:</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
        </div>
        <div class="mb-3">
            <label for="race" class="form-label">Race:</label>
            <input type="text" class="form-control" id="race" name="race" placeholder="Race" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="etat" class="form-label">État:</label>
            <input type="text" class="form-control" id="etat" name="etat" placeholder="État" required>
        </div>
        <div class="mb-3">
            <label for="habitat_id" class="form-label">Habitat:</label>
            <select class="form-select" id="habitat_id" name="habitat_id" required>
                <option value="">-- Veuillez choisir un habitat --</option>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?php echo $habitat['habitat_id']; ?>"><?php echo ($habitat['nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image_data" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image_data" name="image_data">
        </div>
        <button type="submit" class="btn btn-success w-100">Créer</button>
    </form>
    <hr>

    <h3>Liste des animaux</h3>
    <?php if (count($animaux) > 0): ?>
        <?php foreach ($animaux as $animal): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo ($animal['prenom']); ?></h5>
                    <p class="card-text"><strong>Race:</strong> <?php echo ($animal['label']); ?></p>
                    <p class="card-text"><strong>Description:</strong> <?php echo ($animal['description']); ?></p>
                    <p class="card-text"><strong>État:</strong> <?php echo ($animal['etat']); ?></p>
                    <p class="card-text"><strong>Habitat:</strong> <?php echo ($animal['nom']); ?></p>
                    <?php if ($animal['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($animal['image_data']); ?>" class="img-fluid mb-3" alt="Image de l'animal">
                    <?php endif; ?>
                    <h4>Modifier l'animal</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="animal_id" value="<?php echo $animal['animal_id']; ?>">
                        <div class="mb-3">
                            <label for="prenom_<?php echo $animal['animal_id']; ?>" class="form-label">Prénom:</label>
                            <input type="text" class="form-control" id="prenom_<?php echo $animal['animal_id']; ?>" name="prenom" value="<?php echo ($animal['prenom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="race_<?php echo $animal['animal_id']; ?>" class="form-label">Race:</label>
                            <input type="text" class="form-control" id="race_<?php echo $animal['animal_id']; ?>" name="race" value="<?php echo ($animal['label']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description_<?php echo $animal['animal_id']; ?>" class="form-label">Description:</label>
                            <textarea class="form-control" id="description_<?php echo $animal['animal_id']; ?>" name="description" rows="4" required><?php echo ($animal['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="etat_<?php echo $animal['animal_id']; ?>" class="form-label">État:</label>
                            <input type="text" class="form-control" id="etat_<?php echo $animal['animal_id']; ?>" name="etat" value="<?php echo ($animal['etat']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="habitat_id_<?php echo $animal['animal_id']; ?>" class="form-label">Habitat:</label>
                            <select class="form-select" id="habitat_id_<?php echo $animal['animal_id']; ?>" name="habitat_id" required>
                                <option value="">-- Veuillez choisir un habitat --</option>
                                <?php foreach ($habitats as $habitat): ?>
                                    <option value="<?php echo $habitat['habitat_id']; ?>" <?php if (isset($animal['habitat_id']) && $habitat['habitat_id'] == $animal['habitat_id']) echo 'selected'; ?>>
                                        <?php echo ($habitat['nom']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image_data_<?php echo $animal['animal_id']; ?>" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="image_data_<?php echo $animal['animal_id']; ?>" name="image_data">
                        </div>
                        <button type="submit" class="btn btn-success">Modifier Animal</button>
                    </form>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="animal_id" value="<?php echo $animal['animal_id']; ?>">
                        <button type="submit" class="btn btn-danger mt-2">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">Aucun animal disponible.</p>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>