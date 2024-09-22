<?php

require_once 'utilisateur.php';
require_once 'employe.php';
require_once 'veterinaire.php';
require_once 'habitat.php';
require_once 'image.php';
class Admin extends Utilisateur
{
    private $role_id;
    private $label;


    public function __construct($bdd, $username, $password, $nom, $prenom, $role_id, $label)
    {
        parent::__construct($bdd, $username, $password, $nom, $prenom, $role_id);
        $this->role_id = $role_id;
        $this->label = $label;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId(string $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public static function creerUtilisateur($bdd, $username, $password, $nom, $prenom, $role_id, $label)
    {
        if ($role_id == 2) {
            $utilisateur = new Employe($bdd, $username, $password, $nom, $prenom, $label);
        } elseif ($role_id == 3) {
            $utilisateur = new Veterinaire($bdd, $username, $password, $nom, $prenom, $label);
        } else {
            return 'Rôle invalide';
        }
        return $utilisateur->save();
    }

    /*  CRUD HABITAT  */
    public static function ajouterHabitat($bdd, Habitat $habitat, array $images): void
    {
        $sql = "INSERT INTO habitats (nom, description, commentaire_habitat) VALUES (:nom, :description, :commentaire_habitat)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':nom' => $habitat->getNom(),
            ':description' => $habitat->getDescription(),
            ':commentaire_habitat' => $habitat->getCommentaireHabitat()
        ]);

      
        $habitat_id = $bdd->lastInsertId();

     
        foreach ($images as $image) {
            $image->setEntityId($habitat_id);
            self::ajouterImage($bdd, $image, 'habitat');
        }
    }

    public static function modifierHabitat($bdd, Habitat $habitat, array $images): void
    {
        $sql = "UPDATE habitats SET nom = :nom, description = :description, commentaire_habitat = :commentaire_habitat WHERE habitat_id = :habitat_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':habitat_id' => $habitat->getHabitatId(),
            ':nom' => $habitat->getNom(),
            ':description' => $habitat->getDescription(),
            ':commentaire_habitat' => $habitat->getCommentaireHabitat()
        ]);

        
        $sql = "DELETE FROM images WHERE entity_id = :entity_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':entity_id' => $habitat->getHabitatId()]);

       
        foreach ($images as $image) {
            $sql = "INSERT INTO images (entity_id, image_data) VALUES (:entity_id, :image_data)";
            $statement = $bdd->prepare($sql);
            $statement->execute([
                ':entity_id' => $habitat->getHabitatId(),
                ':image_data' => $image->getimage_data() 
            ]);
        }
    }

    public static function supprimerHabitat($bdd, $habitat_id): void
    {
     
        $sql = "DELETE FROM images WHERE entity_id = :entity_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':entity_id' => $habitat_id]);

       
        $sql = "DELETE FROM habitats WHERE habitat_id = :habitat_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':habitat_id' => $habitat_id]);
    }
   

// CRUD ANIMAL

    public function ajouterRace(Race $race, array $images): void
    {
        
        $sql = "INSERT INTO races (prenom, etat, label) VALUES (:prenom, :etat, :label)";
        $statement = $this->bdd->prepare($sql);
        $statement->execute([
            ':prenom' => $race->getPrenom(),
            ':etat' => $race->getEtat(),
            ':label' => $race->getLabel()
        ]);

        
        $race_id = $this->bdd->lastInsertId();
        $race->setRaceId($race_id);


      
        foreach ($images as $image) {
            $image->setEntityId($race_id); 
            $sql = "INSERT INTO images (race_id, image_data) VALUES (:race_id, :image_data)";
            $statement = $this->bdd->prepare($sql);
            $statement->execute([
                ':race_id' => $image->getEntityId(),
                ':image_data' => $image->getUrl()
            ]);
        }
    }

    public static function modifierRace($bdd, Race $race): void
    {
        $sql = "UPDATE races SET prenom = :prenom, etat = :etat, label = :label WHERE race_id = :race_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':prenom' => $race->getPrenom(),
            ':etat' => $race->getEtat(),
            ':label' => $race->getLabel(),
            ':race_id' => $race->getRaceId()
        ]);
    }

    public static function supprimerRace($bdd, $race_id): void
    {
        
        $sql = "DELETE FROM images WHERE race_id = :race_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':race_id' => $race_id]);

    
        $sql = "DELETE FROM races WHERE race_id = :race_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':race_id' => $race_id]);
    }

   

//    CRUD IMAGE
    public static function ajouterImage($bdd, Image $image, string $entityType): void
    {

        if ($entityType === 'habitat') {
            $entityColumn = 'habitat_id';
        } else {
            $entityColumn = 'animal_id';
        }
        $sql = "INSERT INTO images ($entityColumn, image_data) VALUES (:entity_id, :image_data)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':entity_id' => $image->getEntityId(),
            ':image_data' => $image->getUrl()
        ]);
    }

    public static function modifierImage($bdd, Image $image, string $entityType): void
    {

        if ($entityType === 'habitat') {
            $entityColumn = 'habitat_id';
        } else {
            $entityColumn = 'animal_id';
        }
        $sql = "UPDATE images SET $entityColumn = :entity_id, image_data = :image_data WHERE image_id = :image_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':image_id' => $image->getImageId(),
            ':entity_id' => $image->getEntityId(),
            ':image_data' => $image->getUrl()
        ]);
    }

    public static function supprimerImage($bdd, $image_id): void
    {
        $sql = "DELETE FROM images WHERE image_id = :image_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':image_id' => $image_id]);
    }
    
}
