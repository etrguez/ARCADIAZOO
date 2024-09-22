<?php

class Habitat
{
    private $habitat_id;
    private $nom;
    private $description;
    private $commentaire_habitat;

    public function __construct($habitat_id, $nom, $description, $commentaire_habitat)
    {
        $this->habitat_id = $habitat_id;
        $this->nom = $nom;
        $this->description = $description;
        $this->commentaire_habitat = $commentaire_habitat;
    }

    public function getHabitatId(): int
    {
        return (int) $this->habitat_id;
    }
    public function setHabitatId(int $newHabitatId): void
    {
        $this->habitat_id = $newHabitatId;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
    public function setNom(string $newNom): void
    {
        $this->nom = $newNom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $newDescription): void
    {
        $this->description = $newDescription;
    }

    public function getCommentaireHabitat(): string
    {
        return $this->commentaire_habitat;
    }
    public function setCommentaireHabitats(string $newCommentaireHabitat): void
    {
        $this->commentaire_habitat = $newCommentaireHabitat;
    }
}

