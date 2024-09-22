<?php

class Race extends Animal
{
    private $race_id;
    private $label;

    public function __construct($animal_id, $prenom, $etat, $race_id, $label)
    {
        parent::__construct($animal_id, $prenom, $etat);
        $this->race_id = $race_id;
        $this->label = $label;
    }

    public function getRaceId(): string
    {
        return $this->race_id;
    }

    public function setRaceId(string $newRaceId): void
    {
        $this->race_id = $newRaceId;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $newLabel): void
    {
        $this->label = $newLabel;
    }
}
?>