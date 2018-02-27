<?php
    class SalarieManager
    {
        private $bdd; // Instance de PDO

        public function __construct($bdd)
        {
            $this->setDb($bdd);
         //   $this->$bbd->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        }

        public function setDb(PDO $bd)
        {
            $this->bdd = $bd;
        }

        public function update(Salarie $salarie, $repertoirePhoto)
        {
            $sql = 'UPDATE ce_salarie
                        SET 
                            Matricule = :matricule,
                            MotPasse = :motPasse,
                            DateCreation = :dateCreation,
                            DateMaj = :dateMaj,
                            Civilite =:civilite,
                            Nom =:nom,
                            Prenom = :prenom,
                            Photo = :photo,
                            Etablissement = :etablissement,
                            Direction = :direction,
                            Secteur = :secteur,
                            Emploi = :emploi,
                            DateAnciennete = :dateAnciennete,
                            DateDebutContrat = :dateDebutContrat,
                            DateFinContrat = :dateFinContrat,
                            FkStatut = :fkStatut,
                            FkContrat = :fkContrat,
                            Adresse1 = :adresse1,
                            Adresse2 = :adresse2,
                            CodePostal = :codePostal,
                            Ville = :ville,
                            FkPays = :fkPays,
                            Telephone = :telephone,
                            Email = :email,
                            FkProfil = :fkProfil
                        WHERE PkSalarie =:pkSalarie;';
            $resultat =  $this->save($salarie, $sql,"maj", $repertoirePhoto);
            return $resultat;
        }


        public function add(Salarie $salarie, $repertoirePhoto)
        {
            $sql = 'INSERT INTO ce_salarie(
                        PkSalarie,
                        Matricule,
                        MotPasse,
                        DateCreation,
                        DateMaj,
                        Civilite,
                        Nom,
                        Prenom,
                        Photo,
                        Etablissement,
                        Direction,
                        Secteur,
                        Emploi,
                        DateAnciennete,
                        DateDebutContrat,
                        DateFinContrat,
                        FkStatut,
                        FkContrat,
                        Adresse1,
                        Adresse2,
                        CodePostal,
                        Ville,
                        FkPays,
                        Telephone,
                        Email,
                        FkProfil)
                   VALUES (
                        :pkSalarie,
                        :matricule,
                        :motPasse,
                        :dateCreation,
                        :dateMaj,
                        :civilite,
                        :nom,
                        :prenom,
                        :photo,
                        :etablissement,
                        :direction,
                        :secteur,
                        :emploi,
                        :dateAnciennete,
                        :dateDebutContrat,
                        :dateFinContrat,
                        :fkStatut,
                        :fkContrat,
                        :adresse1,
                        :adresse2,
                        :codePostal,
                        :ville,
                        :fkPays,
                        :telephone,
                        :email,
                        :fkProfil);';
            $resultat =  $this->save($salarie, $sql,"ajout", $repertoirePhoto);
            return $resultat;
        }

        public function save(Salarie $salarie, $sql, $mode, $repertoirePhoto){
            $resultat = [];
            try{
                $requete = $this->bdd->prepare($sql);
                $result = $requete->execute(array(
                    'pkSalarie' => $salarie->getPkSalarie()=="" ? null : $salarie->getPkSalarie(),
                    'matricule' => $salarie->getMatricule(),
                    'motPasse' => $salarie->getMotPasse(),
                    'dateCreation' => $salarie->getDateCreation(),
                    'dateMaj'  =>  $salarie->getDateMaj()=="" ? null : $salarie->getDateMaj(),
                    'civilite'  => $salarie->getCivilite(),
                    'nom' => $salarie->getNom(),
                    'prenom' => $salarie->getPrenom(),
                    'photo'  => $salarie->getPhoto(),
                    'etablissement'  => $salarie->getEtablissement()  == "" ? null : $salarie->getEtablissement(),
                    'direction' => $salarie->getDirection(),
                    'secteur' => $salarie->getSecteur() == "" ? null : $salarie->getSecteur(),
                    'emploi'  => $salarie->getEmploi(),
                    'dateAnciennete' => $salarie->getDateAnciennete() == "" ? null : $salarie->getDateAnciennete(),
                    'dateDebutContrat' => $salarie->getDateDebutContrat() =="" ? null : $salarie->getDateDebutContrat(),
                    'dateFinContrat'  =>  $salarie->getDateFinContrat() == "" ? null : $salarie->getDateFinContrat() ,
                    'fkStatut' => $salarie->getFkStatut() == "" ? null : $salarie->getFkStatut(),
                    'fkContrat'  => $salarie->getFkContrat() == "" ? null :  $salarie->getFkContrat(),
                    'adresse1' => $salarie->getAdresse1(),
                    'adresse2' => $salarie->getAdresse2(),
                    'codePostal' => $salarie->getCodePostal(),
                    'ville' => $salarie->getVille(),
                    'fkPays'  => $salarie->getFkPays() == "" ? null : $salarie->getFkPays() ,
                    'telephone' => $salarie->getTelephone() == "" ? null : $salarie->getTelephone(),
                    'email' => $salarie->getEmail(),
                    'fkProfil' => $salarie->getFkProfil()));
                    if ($salarie->getPhotoTMP()!=""){
                        move_uploaded_file($salarie->getPhotoTMP(), $repertoirePhoto.$salarie->getPhoto());
                        if ($salarie->getPhotoOld()!="" && $salarie->getPhotoOld()!=$salarie->getPhoto()){
                            unlink($repertoirePhoto.$salarie->getPhotoOld());
                        }
                    }

                    if ($mode=="ajout") {
                        $resultat[] = [$this->bdd->lastInsertId(), "Salarié ajouté avec succès !"];
                    }
                    else{
                        $resultat[] = [$salarie->getPkSalarie(), "Mise à jour effectuée avec succès !"];
                    }

                return $resultat;
                // var_dump("dernier numero".$this->bdd->lastInsertId());
            }
            catch(Exception  $e)
            {
                $resultat[] = [0,  "Anomalie :".$e->getMessage()];
                return $resultat;
            }

        }

        public function count()
        {
            return $this->bdd->query('SELECT COUNT(*) FROM ce_salarie')->fetchColumn();
        }

        public function delete($pkSalarie)
        {
            // $this->$bdd->exec('DELETE FROM personne WHERE personne_email = ' . $perso->email());
        }

        public function exists($info)
        {
        /*    if (is_int($info)) {
                return (bool)$this->_db->query('SELECT COUNT(*) FROM personne WHERE personne_id = ' . $info)->fetchColumn();
            }

            $q = $this->_db->prepare('SELECT COUNT(*) FROM personne WHERE personne_text = :text');
            $q->execute([':text' => $info]);

            return (bool)$q->fetchColumn();*/
        }

        public function getSalarie($pkSalarie, $bdd){
            $salarie = new Salarie();
            if (is_numeric($pkSalarie)){
                $requete = $bdd->query('SELECT * FROM ce_salarie WHERE pkSalarie='.$pkSalarie);
                $donnees = $requete->fetch(PDO::FETCH_ASSOC);

                $salarie->setPkSalarie($donnees['PkSalarie']);
                $salarie->setMatricule($donnees['Matricule']);
                $salarie->setMotPasse($donnees['MotPasse']);
                $salarie->setDateCreation($donnees['DateCreation']);
                $salarie->setDateMaj($donnees['DateMaj']);
                $salarie->setCivilite($donnees['Civilite']);
                $salarie->setNom($donnees['Nom']);
                $salarie->setPrenom($donnees['Prenom']);
                $salarie->setPhoto($donnees['Photo']);
                $salarie->setPhotoOld($donnees['Photo']);
                $salarie->setEtablissement($donnees['Etablissement']);
                $salarie->setDirection($donnees['Direction']);
                $salarie->setSecteur($donnees['Secteur']);
                $salarie->setEmploi($donnees['Emploi']);
                $salarie->setDateAnciennete($donnees['DateAnciennete']);
                $salarie->setDateDebutContrat($donnees['DateDebutContrat']);
                $salarie->setFkStatut($donnees['FkStatut']);
                $salarie->setFkContrat($donnees['FkContrat']);
                $salarie->setAdresse1($donnees['Adresse1']);
                $salarie->setAdresse2($donnees['Adresse2']);
                $salarie->setCodePostal($donnees['CodePostal']);
                $salarie->setVille($donnees['Ville']);
                $salarie->setFkPays($donnees['FkPays']);
                $salarie->setTelephone($donnees['Telephone']);
                $salarie->setEmail($donnees['Email']);
                $salarie->setFkProfil($donnees['FkProfil']);
            }
            return $salarie;
        }

        public function get($info)
        {
   /*         if (is_int($info)) {
                $q = $this->$bdd->query('SELECT personne_text,
        personne_email,
        personne_number,
        personne_date,
        personne_password,
        personne_color,
        personne_hidden,
        personne_select,
        personne_select_multiple,
        personne_checkbox,
        personne_civilite,
        personne_monfichier,
        personne_textarea FROM personne WHERE personne_id = ' . $info);
                $donnees = $q->fetch(PDO::FETCH_ASSOC);

                return new Personne($donnees['personne_text'],
                    $donnees['personne_email'],
                    $donnees['personne_number'],
                    $donnees['personne_date'],
                    $donnees['personne_password'],
                    $donnees['personne_color'],
                    $donnees['personne_hidden'],
                    $donnees['personne_select'],
                    $donnees['personne_select_multiple'],
                    $donnees['personne_checkbox'],
                    $donnees['personne_civilite'],
                    $donnees['personne_monfichier'],
                    $donnees['personne_textarea']);
            } else {
                $q = $this->$bdd->prepare('SELECT personne_text,
        personne_email,
        personne_number,
        personne_date,
        personne_password,
        personne_color,
        personne_hidden,
        personne_select,
        personne_select_multiple,
        personne_checkbox,
        personne_civilite,
        personne_monfichier,
        personne_textarea FROM personne WHERE personne_email = :email');
                $q->execute([':email' => $info]);

                return new Personne($q->fetch(PDO::FETCH_ASSOC));
            }*/
        }

        public function getList($nom)
        {
     /*       $personnes = [];

            $q = $this->$bdd->prepare('SELECT personne_text,
        personne_email,
        personne_number,
        personne_date,
        personne_password,
        personne_color,
        personne_hidden,
        personne_select,
        personne_select_multiple,
        personne_checkbox,
        personne_civilite,
        personne_monfichier,
        personne_textarea FROM personne WHERE  <> :email ORDER BY $nom');
            $q->execute([':email' => $nom]);

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                $personnes[] = new Personne($donnees);
            }

            return $personnes;*/
        }




    }
