<?php

class Utilisateur {
    protected $bdd;
    protected $username;
    protected $password;
    protected $nom;
    protected $prenom;
    protected $role;

    public function __construct($bdd, $username, $password, $nom, $prenom, $role) {
        $this->bdd = $bdd;
        $this->username = htmlspecialchars($username);
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->nom = htmlspecialchars($nom);
        $this->prenom = htmlspecialchars($prenom);
        $this->role = htmlspecialchars($role);
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $newPrenom): void {
        $this->prenom = $newPrenom;
    }

    
    public static function connexion($bdd, $username, $password) {
        
        $statement = $bdd->prepare('SELECT * FROM utilisateurs WHERE username = :username');
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'] = $user['role_id'];
            $_SESSION['message_connexion'] = 'Bonjour ' . $user['prenom'] . ' ' . $user['nom'] . ' Vous êtes connecté ! ';

            if ($_SESSION['role'] == 1) {
                header('Location: espace_admin.php');
            } elseif ($_SESSION['role'] == 2) {
                header('Location: espace_employe.php');
            } else {
                header('Location: espace_veterinaire.php');
            }
            exit();
        } else {
            echo 'Identifiants incorrects';
        }
    }
}
?>