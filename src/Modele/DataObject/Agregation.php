<?php
namespace App\Sae\Modele\DataObject;

use App\Sae\Modele\Repository\AgregationRepository;

class Agregation extends AbstractDataObject{
    private ?int $idAgregation;
    private string $nomAgregation;
    private string $loginCreateur;


    /**
     * @param int|null $idAgregation
     * @param string $nomAgregation
     */
    public function __construct(?int $idAgregation, string $nomAgregation, string $loginCreateur)
    {
        $this->idAgregation = $idAgregation;
        $this->nomAgregation = $nomAgregation;
        $this->loginCreateur = $loginCreateur;
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

    public function getLoginCreateur(): string
    {
        return $this->loginCreateur;
    }

    public function setLoginCreateur(string $loginCreateur): void
    {
        $this->loginCreateur = $loginCreateur;
    }
}
