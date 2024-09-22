<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 3) {
    echo 'Accès refusé. Seuls les vétérinaires peuvent accéder à cette page.';
    exit();
}

try {
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

$sql = "SELECT animal_id, prenom FROM animaux";
$statement = $bdd->prepare($sql);
$statement->execute();
$animaux = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['animal_id']) && !empty($_POST['etat_animal']) && !empty($_POST['nourriture_proposee']) && !empty($_POST['grammage_nourriture']) && !empty($_POST['date_passage'])) {
        $animal_id = $_POST['animal_id'];
        $etat_animal = $_POST['etat_animal'];
        $nourriture_proposee = $_POST['nourriture_proposee'];
        $grammage_nourriture = $_POST['grammage_nourriture'];
        $date_passage = $_POST['date_passage'];
        $username = $_SESSION['username'];

        $sql = "INSERT INTO rapports_veterinaires (animal_id, etat_animal, nourriture_proposee, grammage_nourriture, date_passage,username ) VALUES (:animal_id, :etat_animal, :nourriture_proposee, :grammage_nourriture, :date_passage, :username)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':animal_id' => $animal_id,
            ':etat_animal' => $etat_animal,
            ':nourriture_proposee' => $nourriture_proposee,
            ':grammage_nourriture' => $grammage_nourriture,
            ':date_passage' => $date_passage,
            ':username' => $username
        ]);

        $_SESSION['message'] = "Rapport vétérinaire ajouté avec succès.";
    } else {
        $_SESSION['message'] = "Erreur : Tous les champs sont obligatoires.";
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Vétérinaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
    <h2 class="text-center text-success mb-4">Rapport Vétérinaire</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php echo ($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="animal_id" class="form-label">Animal:</label>
            <select class="form-select" id="animal_id" name="animal_id" required>
                <option value="">-- Veuillez choisir un animal --</option>
                <?php foreach ($animaux as $animal): ?>
                    <option value="<?php echo $animal['animal_id']; ?>"><?php echo ($animal['prenom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="etat_animal" class="form-label">État de l'animal:</label>
            <input type="text" class="form-control" id="etat_animal" name="etat_animal" required>
        </div>
        <div class="mb-3">
            <label for="nourriture_proposee" class="form-label">Nourriture proposée:</label>
            <input type="text" class="form-control" id="nourriture_proposee" name="nourriture_proposee" required>
        </div>
        <div class="mb-3">
            <label for="grammage_nourriture" class="form-label">Grammage de la nourriture:</label>
            <input type="number" class="form-control" id="grammage_nourriture" name="grammage_nourriture" required>
        </div>
        <div class="mb-3">
            <label for="date_passage" class="form-label">Date de passage:</label>
            <input type="date" class="form-control" id="date_passage" name="date_passage" required>
        </div>
        <div class="mb-3">
            <label for="detail_etat_animal">Détail de l'état de l'animal (facultatif):</label><br>
            <textarea id="detail_etat_animal" name="detail_etat_animal"></textarea><br><br>
        </div>
        <button type="submit" class="btn btn-success w-100">Ajouter Rapport</button>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>