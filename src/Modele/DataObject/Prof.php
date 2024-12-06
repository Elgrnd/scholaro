<?php
namespace App\Sae\Modele\DataObject;

class Prof extends AbstractDataObject
{
    private string $loginProf;
    private string $nomProf;
    private string $prenomProf;
    private string $mailUniversitaire;
    private bool $estAdmin;

    /**
     * @param string $loginProf
     * @param string $nomProf
     * @param string $prenomProf
     * @param string $mailUniversitaire
     * @param bool $estAdmin
     */
    public function __construct(string $loginProf, string $nomProf, string $prenomProf, string $mailUniversitaire, bool $estAdmin)
    {
        $this->loginProf = $loginProf;
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->mailUniversitaire = $mailUniversitaire;
        $this->estAdmin = $estAdmin;
    }

    public function getLoginProf(): string
    {
        return $this->loginProf;
    }

    public function setLoginProf(string $loginProf): void
    {
        $this->loginProf = $loginProf;
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

    public function getMailUniversitaire(): string
    {
        return $this->mailUniversitaire;
    }

    public function setMailUniversitaire(string $mailUniversitaire): void
    {
        $this->mailUniversitaire = $mailUniversitaire;
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