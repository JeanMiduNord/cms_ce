<?php
    function getConnexion(){
        $dbName= "cms_ce";
        $userPassword ="cecms";
        $mysqlHost = "localhost";
        $conn =new PDO('mysql:host='.$mysqlHost.';dbname='.$dbName, $dbName, $userPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $conn->exec('SET NAMES utf8');
        return $conn;
    }
    
    function getAllStatut($bdd){
        $sql = "SELECT PkStatut, Statut FROM ce_statut ORDER BY statut";
        $reponse = $bdd->query($sql);

        $listeStatut = [];
        while($donnees = $reponse->fetch()) {
            $listeStatut[] = [$donnees['PkStatut'], $donnees['Statut']];
        }
        return $listeStatut;
    }

    function getAllPays($bdd){
        $sql = "SELECT PkPays, Pays FROM ce_pays ORDER BY Pays";
        $reponse = $bdd->query($sql);

        $listePays = [];
        while($donnees = $reponse->fetch()) {
            $listePays[] = [$donnees['PkPays'], $donnees['Pays']];
        }
        return $listePays;
    }

    function getAllContrat($bdd){
        $sql = "SELECT PkContrat, Contrat FROM ce_contrat ORDER BY Contrat";
        $reponse = $bdd->query($sql);

        $listeContrat = [];
        while($donnees = $reponse->fetch()) {
            $listeContrat[] = [$donnees['PkContrat'], $donnees['Contrat']];
        }
        return $listeContrat;
    }

    function getAllProfil($bdd){
        $sql = "SELECT PkProfil, Profil FROM ce_profil ORDER BY Profil";
        $reponse = $bdd->query($sql);

        $listeProfil = [];
        while($donnees = $reponse->fetch()) {
            $listeProfil[] = [$donnees['PkProfil'], $donnees['Profil']];
        }
        return $listeProfil;
    }

    function getAllImageAccepte($typeMimePhoto){
       // accept="image/png, image/jpeg"
            $accept = "";
        for ($i=0; $i <count($typeMimePhoto); $i++){
            if ($accept==""){
                $accept = ' accept="';
            }
            else{
                $accept.=",";
            }
            $accept.=$typeMimePhoto[$i];
        }
        $accept.='"';
        return $accept;
    }

    function getidUnique(){
        return uniqid();
    }

    function isDate($str){
        try{
            $date = new DateTime($str);
        }
        catch(Exception  $e){
            return false;
        }
        return true;
    }
    function compareDate($date1, $date2, $libDate1, $libDate2)
    {
        /*
         * avec le paramètre R a => jour, valeurs possible pour $diff
         *  +0 = egalité         => code retour  1
         *  sinon : 1er car
         *   + = date 1 < date 2 => code retour 2
         *   - = date 1 > date 2 => code retour 3
         *
         *  si pb                => code retour 0
         */
        var_dump("test");

        try {
            $datetime1 = new DateTime($date1);
            $datetime2 = new DateTime($date2);
            $interval = $datetime1->diff($datetime2);
            $diff = $interval->format('%R%a');
            if ($diff == "+0") {
                $resultat[] = [1, "La ".$libDate1." est égale à la ". $libDate2];
            } else {
                switch(substr($diff, 0, 1) ){
                    case "+" : {
                        $resultat[] = [2, "La ".$libDate1." est inférieure à la ".$libDate2];
                        break;
                    }
                    case "-" : {
                        $resultat[] = [3, "La ".$libDate1." est Supérieure à la ". $libDate2];
                        break;
                    }
                    default:
                        // par sécurité
                        $resultat[] = [10, "Inconnu"];
                }
            }
        }    catch(Exception  $e){
                $resultat[] = [0, "Anomalie sur le format de date, veuillez corriger svp ? (".$libDate1. " ".$libDate2.")"];
        }
        return $resultat;
    }



?>