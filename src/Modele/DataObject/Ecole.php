<?php

namespace App\Sae\Modele\DataObject;

use App\Sae\Modele\DataObject\AbstractDataObject;

class Ecole extends AbstractDataObject
{
    private int $idEcole;

    private string $nomEcole;
    private string $villeEcole;

    public function __construct(int $idEcole, string $nomEcole, string $villeEcole)
    {
        $this->idEcole = $idEcole;
        $this->nomEcole = $nomEcole;
        $this->villeEcole = $villeEcole;

    }

    public function getIdEcole(): int
    {
        return $this->idEcole;
    }

    public function setIdEcole(int $idEcole): void
    {
        $this->idEcole = $idEcole;
    }

    public function getNomEcole(): string
    {
        return $this->nomEcole;
    }

    public function setNomEcole(string $nomEcole): void
    {
        $this->nomEcole = $nomEcole;
    }

    public function getVilleEcole(): string
    {
        return $this->villeEcole;
    }

    public function setVilleEcole(string $villeEcole): void
    {
        $this->villeEcole = $villeEcole;
    }



}