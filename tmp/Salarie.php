<?php
/**
 * Created by PhpStorm.
 * User: Jean-Michel
 * Date: 15/02/2018
 * Time: 14:51
 */

class Salarie
{
    private $pkSalarie;
    private $matricule;
    private $cotPasse;
    private $compteActif;
    private $validiteCompte;
    private $dateCreation;
    private $dateMaj;
    private $civilite;
    private $nom;
    private $prenom;
    private $photo;
    private $etablissement;
    private $direction;
    private $section;
    private $emploi;
    private $dateAnciennete;
    private $dateDebutContrat;
    private $fkStatut;
    private $contrat;
    private $adresse1;
    private $adresse2;
    private $codePostal;
    private $ville;
    private $fkPays;
    private $email;
    private $fkSyndicat;
    private $fkCE;
    private $dp;
    private $ds;
    private $chsct;
    private $fkProfil;

    /**
     * Salarie constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getPkSalarie()
    {
        return $this->pkSalarie;
    }

    /**
     * @param mixed $pkSalarie
     * @return Salarie
     */
    public function setPkSalarie($pkSalarie)
    {
        $this->pkSalarie = $pkSalarie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param mixed $matricule
     * @return Salarie
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCotPasse()
    {
        return $this->cotPasse;
    }

    /**
     * @param mixed $cotPasse
     * @return Salarie
     */
    public function setCotPasse($cotPasse)
    {
        $this->cotPasse = $cotPasse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompteActif()
    {
        return $this->compteActif;
    }

    /**
     * @param mixed $compteActif
     * @return Salarie
     */
    public function setCompteActif($compteActif)
    {
        $this->compteActif = $compteActif;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValiditeCompte()
    {
        return $this->validiteCompte;
    }

    /**
     * @param mixed $validiteCompte
     * @return Salarie
     */
    public function setValiditeCompte($validiteCompte)
    {
        $this->validiteCompte = $validiteCompte;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     * @return Salarie
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateMaj()
    {
        return $this->dateMaj;
    }

    /**
     * @param mixed $dateMaj
     * @return Salarie
     */
    public function setDateMaj($dateMaj)
    {
        $this->dateMaj = $dateMaj;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param mixed $civilite
     * @return Salarie
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return Salarie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     * @return Salarie
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     * @return Salarie
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param mixed $etablissement
     * @return Salarie
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $direction
     * @return Salarie
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     * @return Salarie
     */
    public function setSection($section)
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmploi()
    {
        return $this->emploi;
    }

    /**
     * @param mixed $emploi
     * @return Salarie
     */
    public function setEmploi($emploi)
    {
        $this->emploi = $emploi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAnciennete()
    {
        return $this->dateAnciennete;
    }

    /**
     * @param mixed $dateAnciennete
     * @return Salarie
     */
    public function setDateAnciennete($dateAnciennete)
    {
        $this->dateAnciennete = $dateAnciennete;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateDebutContrat()
    {
        return $this->dateDebutContrat;
    }

    /**
     * @param mixed $dateDebutContrat
     * @return Salarie
     */
    public function setDateDebutContrat($dateDebutContrat)
    {
        $this->dateDebutContrat = $dateDebutContrat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkStatut()
    {
        return $this->fkStatut;
    }

    /**
     * @param mixed $fkStatut
     * @return Salarie
     */
    public function setFkStatut($fkStatut)
    {
        $this->fkStatut = $fkStatut;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param mixed $contrat
     * @return Salarie
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * @param mixed $adresse1
     * @return Salarie
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * @param mixed $adresse2
     * @return Salarie
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     * @return Salarie
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     * @return Salarie
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPays()
    {
        return $this->fkPays;
    }

    /**
     * @param mixed $fkPays
     * @return Salarie
     */
    public function setFkPays($fkPays)
    {
        $this->fkPays = $fkPays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Salarie
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkSyndicat()
    {
        return $this->fkSyndicat;
    }

    /**
     * @param mixed $fkSyndicat
     * @return Salarie
     */
    public function setFkSyndicat($fkSyndicat)
    {
        $this->fkSyndicat = $fkSyndicat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkCE()
    {
        return $this->fkCE;
    }

    /**
     * @param mixed $fkCE
     * @return Salarie
     */
    public function setFkCE($fkCE)
    {
        $this->fkCE = $fkCE;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDp()
    {
        return $this->dp;
    }

    /**
     * @param mixed $dp
     * @return Salarie
     */
    public function setDp($dp)
    {
        $this->dp = $dp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDs()
    {
        return $this->ds;
    }

    /**
     * @param mixed $ds
     * @return Salarie
     */
    public function setDs($ds)
    {
        $this->ds = $ds;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChsct()
    {
        return $this->chsct;
    }

    /**
     * @param mixed $chsct
     * @return Salarie
     */
    public function setChsct($chsct)
    {
        $this->chsct = $chsct;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkProfil()
    {
        return $this->fkProfil;
    }

    /**
     * @param mixed $fkProfil
     * @return Salarie
     */
    public function setFkProfil($fkProfil)
    {
        $this->fkProfil = $fkProfil;
        return $this;
    }


}
?>