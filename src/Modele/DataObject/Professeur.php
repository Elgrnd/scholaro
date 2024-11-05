<?php

namespace App\Sae\Modele\DataObject;

use App\Sae\Modele\DataObject\AbstractDataObject;

class Professeur extends AbstractDataObject {
    private int $idProf;
    private string $nomProf;
    private string $prenomProf;
    private string $loginProf;
    private string $mdpHache;
    private bool $estAdmin;


    /**
     * @param int $idProf
     * @param string $nomProf
     * @param string $prenomProf
     * @param string $loginProf
     * @param string $mdpHache
     * @param bool $estAdmin
     */
    public function __construct(int $idProf, string $nomProf, string $prenomProf, string $loginProf, string $mdpHache, bool $estAdmin)
    {
        $this->idProf = $idProf;
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->loginProf = $loginProf;
        $this->mdpHache = $mdpHache;
        $this->estAdmin = $estAdmin;
    }

    public function getIdProf(): int
    {
        return $this->idProf;
    }

    public function setIdProf(int $idProf): void
    {
        $this->idProf = $idProf;
    }

    public function getNomProf(): string
    {
        return $this->nomProf;
    }

    public function setNomProf(string $nomProf): void
    {
        $this->nomProf = $nomProf;
    }

    public function getPrenomProf(): string
    {
        return $this->prenomProf;
    }

    public function setPrenomProf(string $prenomProf): void
    {
        $this->prenomProf = $prenomProf;
    }

    public function getLoginProf(): string
    {
        return $this->loginProf;
    }

    public function setLoginProf(string $loginProf): void
    {
        $this->loginProf = $loginProf;
    }

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }

    public function isEstAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }
}