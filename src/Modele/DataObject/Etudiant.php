<?php
namespace App\Sae\Modele\DataObject;

class Etudiant extends AbstractDataObject{
    private int $etudid;
    private string $codenip;
    private string $civ;
    private string $nomEtu;
    private string $prenomEtu;
    private string $bac;
    private string $specialite;
    private int $rg_admis;
    private string $avis;

    /**
     * @param int $etudid
     * @param string $codenip
     * @param string $civ
     * @param string $nom
     * @param string $prenom
     * @param string $bac
     * @param string $specialite
     * @param int $rg_admis
     * @param string $avis
     */
    public function __construct(int $etudid, string $codenip, string $civ, string $nomEtu, string $prenomEtu, string $bac, string $specialite, int $rg_admis, string $avis)
    {
        $this->etudid = $etudid;
        $this->codenip = $codenip;
        $this->civ = $civ;
        $this->nomEtu = $nomEtu;
        $this->prenomEtu = $prenomEtu;
        $this->bac = $bac;
        $this->specialite = $specialite;
        $this->rg_admis = $rg_admis;
        $this->avis = $avis;
    }

    public function getEtudid(): int
    {
        return $this->etudid;
    }

    public function setEtudid(int $etudid): void
    {
        $this->etudid = $etudid;
    }

    public function getCodenip(): string
    {
        return $this->codenip;
    }

    public function setCodenip(string $codenip): void
    {
        $this->codenip = $codenip;
    }

    public function getCiv(): string
    {
        return $this->civ;
    }

    public function setCiv(string $civ): void
    {
        $this->civ = $civ;
    }

    public function getNom(): string
    {
        return $this->nomEtu;
    }

    public function setNom(string $nomEtu): void
    {
        $this->nomEtu = $nomEtu;
    }

    public function getPrenom(): string
    {
        return $this->prenomEtu;
    }

    public function setPrenom(string $prenomEtu): void
    {
        $this->prenomEtu = $prenomEtu;
    }

    public function getBac(): string
    {
        return $this->bac;
    }

    public function setBac(string $bac): void
    {
        $this->bac = $bac;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getRg_admis(): int
    {
        return $this->rg_admis;
    }

    public function setRg_admis(int $rg_admis): void
    {
        $this->rg_admis = $rg_admis;
    }

    public function getAvis(): string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): void
    {
        $this->avis = $avis;
    }


}