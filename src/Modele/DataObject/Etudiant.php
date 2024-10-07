<?php
namespace App\Sae\Modele\DataObject;

class Etudiant extends AbstractDataObject{
    private int $etudid;
    private string $codenip;
    private string $civ;
    private string $nom;
    private string $prenom;
    private string $bac;
    private string $specialite;
    private int $rgadmis;
    private string $avis;

    /**
     * @param int $etudid
     * @param string $codenip
     * @param string $civ
     * @param string $nom
     * @param string $prenom
     * @param string $bac
     * @param string $specialite
     * @param int $rgadmis
     * @param string $avis
     */
    public function __construct(int $etudid, string $codenip, string $civ, string $nom, string $prenom, string $bac, string $specialite, int $rgadmis, string $avis)
    {
        $this->etudid = $etudid;
        $this->codenip = $codenip;
        $this->civ = $civ;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->bac = $bac;
        $this->specialite = $specialite;
        $this->rgadmis = $rgadmis;
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
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
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

    public function getRgadmis(): int
    {
        return $this->rgadmis;
    }

    public function setRgadmis(int $rgadmis): void
    {
        $this->rgadmis = $rgadmis;
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