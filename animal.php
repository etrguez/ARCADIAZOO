<?php
class Animal {
    protected $animal_id;
    protected $prenom;
    protected $etat;
    

    public function __construct($animal_id, $prenom, $etat) {
        $this->animal_id = $animal_id;
        $this->prenom = $prenom;
        $this->etat = $etat;
  
    }

    public function getAnimalId(): int {
        return (int) $this->animal_id;
    }

    public function setAnimalId(int $animal_id): void {
        $this->animal_id = $animal_id;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $newPrenom): void {
        $this->prenom = $newPrenom;
    }

    public function getEtat(): string {
        return $this->etat;
    }

    public function setEtat(string $newEtat): void {
        $this->etat = $newEtat;
    }

}
?>