<?php

try {
    $base_de_donnees = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $base_de_donnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];


    $password_hache = password_hash($password, PASSWORD_BCRYPT);

   
    $sql = "INSERT INTO utilisateurs (username, role_id, password, nom, prenom) VALUES (:username, :role_id, :password, :nom, :prenom)";
    $statement = $base_de_donnees->prepare($sql);
    $statement->execute([
        ':username' => $username,
        ':role_id' => 1, 
        ':password' => $password_hache,
        ':nom' => $nom,
        ':prenom' => $prenom
    ]);

    echo "Utilisateur administrateur créé avec succès.";
}
?>