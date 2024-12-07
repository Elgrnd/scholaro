<?php

namespace App\Sae\Modele\DataObject;

use App\Sae\Modele\DataObject\AbstractDataObject;

class Ecole extends AbstractDataObject
{
    private string $siret;

    private string $nomEcole;
    private string $villeEcole;

    private string $tel;
    private string $mailEcole;
    private ?string $emailAValider;
    private ?string $nonce;
    private bool $estValide;
    private string $mdpHache;

    /**
     * @param string $siret
     * @param string $nomEcole
     * @param string $villeEcole
     * @param string $tel
     * @param string $mailEcole
     * @param string|null $emailAValider
     * @param string|null $nonce
     * @param bool $estValide
     * @param string $mdpHache
     */
    public function __construct(string $siret, string $nomEcole, string $villeEcole, string $tel, string $mailEcole, ?string $emailAValider, ?string $nonce, bool $estValide, string $mdpHache)
    {
        $this->siret = $siret;
        $this->nomEcole = $nomEcole;
        $this->villeEcole = $villeEcole;
        $this->tel = $tel;
        $this->mailEcole = $mailEcole;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
        $this->estValide = $estValide;
        $this->mdpHache = $mdpHache;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function getMailEcole(): string
    {
        return $this->mailEcole;
    }

    public function setMailEcole(string $mailEcole): void
    {
        $this->mailEcole = $mailEcole;
    }

    public function getEmailAValider(): ?string
    {
        return $this->emailAValider;
    }

    public function setEmailAValider(?string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    public function getNonce(): ?string
    {
        return $this->nonce;
    }

    public function setNonce(?string $nonce): void
    {
        $this->nonce = $nonce;
    }

    public function isEstValide(): bool
    {
        return $this->estValide;
    }

    public function setEstValide(bool $estValide): void
    {
        $this->estValide = $estValide;
    }

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }



    public function getSiret(): string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): void
    {
        $this->siret = $siret;
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