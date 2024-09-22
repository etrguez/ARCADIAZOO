<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Administrateur</title>
</head>
<body>
    <h2>Créer un Administrateur</h2>
    <form action="creation_admin.php" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>
        
        <input type="submit" value="Créer">
    </form>
</body>
</html>

