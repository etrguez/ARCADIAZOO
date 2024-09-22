<?php

require_once 'utilisateur.php';

class Veterinaire extends Utilisateur {
    private $role_id = 3; 
    private $label;

    public function __construct($bdd, $username, $password, $nom, $prenom, $label) {
        parent::__construct($bdd, $username, $password, $nom, $prenom, $this->role_id);
        $this->label = $label;
    }

    public function getRoleId() {
        return $this->role_id;
    }

    public function setRoleId(string $role_id): void {
        $this->role_id = $role_id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel(string $label): void {
        $this->label = $label;
    }

    public function save() {
        $statement = $this->bdd->prepare('INSERT INTO utilisateurs (username, password, nom, prenom, role_id) VALUES (:username, :password, :nom, :prenom, :role)');
        $statement->bindValue(':username', $this->username);
        $statement->bindValue(':password', $this->password);
        $statement->bindValue(':nom', $this->nom);
        $statement->bindValue(':prenom', $this->prenom);
        $statement->bindValue(':role', $this->role_id);

        if ($statement->execute()) {
            return 'Vétérinaire inscrit';
        } else {
            return 'Erreur lors de l\'inscription du vétérinaire';
        }
    }
}
?>