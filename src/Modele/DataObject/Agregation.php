<?php
namespace App\Sae\Modele\DataObject;

class Agregation extends AbstractDataObject{
    private ?int $idAgregation;
    private string $nomAgregation;
    private float $noteAgregation;
    private Etudiant $etudiant;

    /**
     * @param int|null $idAgregation
     * @param string $nomAgregation
     * @param float $noteAgregation
     * @param Etudiant $etudiant
     */
    public function __construct(?int $idAgregation, string $nomAgregation, float $noteAgregation, Etudiant $etudiant)
    {
        $this->idAgregation = $idAgregation;
        $this->nomAgregation = $nomAgregation;
        $this->noteAgregation = $noteAgregation;
        $this->etudiant = $etudiant;
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

    public function getNoteAgregation(): float
    {
        return $this->noteAgregation;
    }

    public function setNoteAgregation(float $noteAgregation): void
    {
        $this->noteAgregation = $noteAgregation;
    }

    public function getEtudiant(): Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(Etudiant $etudiant): void
    {
        $this->etudiant = $etudiant;
    }



}
