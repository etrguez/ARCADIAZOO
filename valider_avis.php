<?php

try {
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avis_id = $_POST['avis_id'];
    if (isset($_POST['valider'])) {
        $sql = "UPDATE avis SET isVisible = TRUE WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            echo "Avis validé avec succès.";
        } else {
            echo "Erreur lors de la validation de l'avis.";
        }
    } elseif (isset($_POST['refuser'])) {
        $sql = "DELETE FROM avis WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            echo "Avis refusé et supprimé avec succès.";
        } else {
            echo "Erreur lors du refus de l'avis.";
        }
    }
}

$sql = "SELECT * FROM avis WHERE isVisible = FALSE";
$avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider les avis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container my-5">
    <h2 class="text-center text-success mb-4">Valider les avis</h2>
    <?php if (count($avis) > 0): ?>
        <?php foreach ($avis as $un_avis): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>Pseudo:</strong> <?php echo ($un_avis['pseudo']); ?></p>
                    <p><strong>Commentaire:</strong> <?php echo ($un_avis['commentaire']); ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="avis_id" value="<?php echo $un_avis['avis_id']; ?>">
                        <button type="submit" name="valider" class="btn btn-success">Valider</button>
                        <button type="submit" name="refuser" class="btn btn-danger">Refuser</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">Aucun avis à valider.</p>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
<script src="script.js"></script>
</body>
</html>