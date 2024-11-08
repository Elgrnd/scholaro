<?php
namespace App\Sae\Modele\DataObject;

class Agregation extends AbstractDataObject{
    private ?int $idAgregation;
    private string $nomAgregation;


    /**
     * @param int|null $idAgregation
     * @param string $nomAgregation
     */
    public function __construct(?int $idAgregation, string $nomAgregation)
    {
        $this->idAgregation = $idAgregation;
        $this->nomAgregation = $nomAgregation;
        //$this->etudiants = ;
    }

    public function getIdAgregation(): ?int
    {
        return $this->idAgregation;
    }

    public function setIdAgregation(?int $idAgregation): void
    {
        $this->idAgregation = $idAgregation;
    }

    public function getNomAgregation(): string
    {
        return $this->nomAgregation;
    }

    public function setNomAgregation(string $nomAgregation): void
    {
        $this->nomAgregation = $nomAgregation;
    }

}
