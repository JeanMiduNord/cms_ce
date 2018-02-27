
<?php
    date_default_timezone_set("Europe/Paris");
    session_start();

    include_once 'Salarie.php';
    include_once 'SalarieManager.php';
    include_once 'configSite.php';
    include_once 'fonction.php';
    include_once 'configSite.php';



   /*
      Paramètres de session :
      soit page demandée sans paramètre => on ejecte
      soit page demandée avec paramètre
            => depuis liste des salariés pour consultation ou maj  => affichage des informations du salarié> mode lecture
            => depuis liste des salariés pour ajout => affichage des informations => mode ajout
            => depuis ce formulaire pour ajouter => mode ajout
            => depuis ce formulaire après un ajout => mode lecture

     en mode lecture :
            affichage de la photo si elle existe

    */
    $bdd = getConnexion();
    $listeContrat = getAllContrat($bdd);
    $listePays = getAllPays($bdd);
    $listeStatut = getAllStatut($bdd);
    $listeProfil = getAllProfil($bdd);
    $typeImageAccepte = getAllImageAccepte($typeMimePhoto);
    $salarieManager= new SalarieManager($bdd);
    $salarie= new Salarie();
    $message = "";

  //  $pageMere = $_SERVER['HTTP_REFERER'];
    $profil = isset($_SESSION['profil']) ? $_SESSION['profil'] : "";
    $pkSalarie = isset($_SESSION['pkSalarie']) ? $_SESSION['pkSalarie'] : "";
    $ajout = isset($_POST['ajout']) ? $_POST['ajout'] : "";
    $supImg = isset($_POST['supImg']) ? $_POST['supImg'] : "";
    $nbPost = count($_POST);

    // on quitte le formulaire si paramètre manquants ou si la personne n'a pas le droit de mettre à jour les informations
    if (($profil=="") || ($profil !=2)) {
        die;
    }

    if ($ajout=="1") {
        $pkSalarie = "";
        $_SESSION['pkSalarie']="";
    }
    if ($pkSalarie!=""){
        $salarie = $salarieManager->getSalarie($pkSalarie, $bdd);
        $message = "Mode Consultation";
    }
    if ($supImg=="1") {
        $salarie->setPhotoTMP("");
        $salarie->setPhoto("");
    }

    if ($pkSalarie==""){
        $salarie->setDateCreation(date("Y-m-d H:i"));
        $salarie->setMotPasse(getidUnique());

        $message = "Mode ajout";
    }
    else{
        if (($nbPost >0 && $ajout=="")) {
            $salarie->setMatricule(isset($_POST['matricule']) ? $_POST['matricule'] : "");
            $salarie->setCivilite(isset($_POST['civilite']) ? $_POST['civilite'] : "");
            $salarie->setNom(isset($_POST['nom']) ? $_POST['nom'] : "");
            $salarie->setPrenom(isset($_POST['prenom']) ? $_POST['prenom'] : "");
            $salarie->setEtablissement(isset($_POST['etablissement']) ? $_POST['etablissement'] : "");
            $salarie->setDirection(isset($_POST['direction']) ? $_POST['direction'] : "");
            $salarie->setSecteur(isset($_POST['secteur']) ? $_POST['secteur'] : "");
            $salarie->setEmploi(isset($_POST['emploi']) ? $_POST['emploi'] : "");
            $salarie->setDateAnciennete(isset($_POST['dateAnciennete']) ? $_POST['dateAnciennete'] : "");
            $salarie->setDateDebutContrat(isset($_POST['dateDebutContrat']) ? $_POST['dateDebutContrat'] : "");
            $salarie->setDateFinContrat(isset($_POST['dateFinContrat']) ? $_POST['dateFinContrat'] : "");
            $salarie->setFkStatut(isset($_POST['fkStatut']) ? $_POST['fkStatut'] : "");
            $salarie->setFkContrat(isset($_POST['fkContrat']) ? $_POST['fkContrat'] : "");
            $salarie->setAdresse1(isset($_POST['adresse1']) ? $_POST['adresse1'] : "");
            $salarie->setAdresse2(isset($_POST['adresse2']) ? $_POST['adresse2'] : "");
            $salarie->setCodePostal(isset($_POST['codePostal']) ? $_POST['codePostal'] : "");
            $salarie->setVille(isset($_POST['ville']) ? $_POST['ville'] : "");
            $salarie->setFkPays(isset($_POST['fkPays']) ? $_POST['fkPays'] : "");
            $salarie->setTelephone(isset($_POST['telephone']) ? $_POST['telephone'] : "");
            $salarie->setEmail(isset($_POST['email']) ? $_POST['email'] : "");
            $salarie->setFkProfil(isset($_POST['fkProfil']) ? $_POST['fkProfil'] : "");
            $supImg = isset($_POST['fkProfil']) ? $_POST['fkProfil'] : "";

            /*
             *  Mise à jour de la bdd si les saisies sont Ok
             */
            $message = verifSaisie($salarie, $_FILES['photo'],$typeMimePhoto, $tailleMaxiPhoto);
            if ($message=="" || $message=="image") {
                if ($message=="image") {
                    $salarie->setPhotoTMP($_FILES['photo']['tmp_name']);
                    $salarie->setPhoto(getidUnique() . "_" . $_FILES['photo']['name']);
                }
                if ($_SESSION['pkSalarie'] == "") {
                    // on est en mode ajout
                    $resultat = $salarieManager->add($salarie, $repertoirePhoto);
                } else {
                    // on est en mode mise à jour
                    $salarie->setDateMaj(date("Y-m-d H:i"));
                    $resultat = $salarieManager->update($salarie, $repertoirePhoto);
                }
                /*
                 *  si l'enregistrement s'est bien passé, récupére le matricule du salarie
                 */
                if ($resultat[0][0] != 0) {
                    $salarie->setPkSalarie($resultat[0][0]);
                    $_SESSION['pkSalarie'] = $resultat[0][0];
                }
                /*else {
                    $_SESSION['pkSalarie'] = "";
                    $salarie->setPkSalarie("");
                }*/
                $message = $resultat[0][0].$resultat[0][1];
            }
        }
    }
    $ajout="";
    $supImg="";

function verifSaisie(Salarie $salarie, $photo,$typeMimePhoto, $tailleMaxiPhoto){
    /*
     * Controle des zones obligatoires
     */
    if ($salarie->getDateCreation()==""){
        return "La date de création est obligatoire !";
    }else{
        if (!isDate($salarie->getDateCreation())){
            return "le format de la date de création n'est pas valide";
        }
    }
    if ($salarie->getMatricule()==""){
        return "La saisie du matricule est obligatoire !";
    }
    if ($salarie->getNom()==""){
        return "La saisie du Nom est obligatoire !";
    }
    if ($salarie->getPrenom() ==""){
        return "La saisie du Prénom est obligatoire !";
    }
    if ($salarie->getMotPasse()==""){
        return "La saisie du mot de passe est obligatoire !";
    }
    if ($salarie->getFkProfil()==""){
        return "La saisie du profil est obligatoire !";
    }
    if ($salarie->getEmail()==""){
        return "La saisie de l'email est obligatoire !";
    }
    if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$salarie->getEmail())){

        return "l'email est incorrect !";
    }
    /*     else{
             $toto = 5;
             if ($toto && !preg_match ('^[0-9]^', $salarie->getEmail()){
                 $titi = 4;
             }
         }*/
    if ($photo['name']!=""){
        if ($photo['size'] > $tailleMaxiPhoto){
            return "La taille de la photo doit être inférieure à 1 Mo !";
        }
        if ($photo['error']!=0){
            return "Problème de chargement de la photo, veuillez la recharger SVP !";
        }
        if (!array_search($photo['type'], $typeMimePhoto, true)) {
            return "Le format de la photo n'est pas pris en charge !";
        }
        return"image";
    }
    /*
    * Controle des zones non obligatoires
    */
    if ($salarie->getDateMaj()!=""){
        if (!isDate($salarie->getDateMaj())){
            return "le format de la date de création n'est pas valide !";
        }
    }
    if ($salarie->getDateAnciennete()!=""){
        if (!isDate($salarie->getDateAnciennete())){
            return "le format de la date d'ancienneté n'est pas valide !";
        }
    }
    if ($salarie->getDateDebutContrat()!=""){
        if (!isDate($salarie->getDateDebutContrat())){
            return "le format de la date de début de contrat n'est pas valide !";
        }
        if ($salarie->getDateAnciennete()!=""){
            $retour = compareDate($salarie->getDateAnciennete(),$salarie->getDateDebutContrat(),"Date d'ancienneté", "Date de début de contrat");
            if (($retour[0][0] == 3) || ($retour[0][0] == 0)){
                return $retour[0][1];
            }
        }
    }
    if ($salarie->getDateFinContrat()!=""){
        if (!isDate($salarie->getDateFinContrat())){
            return "le format de la date de création n'est pas valide !";
        }
        if ($salarie->getDateDebutContrat()==""){
            return "La date de début de contrat est obligatoire ! ";
        }

        $retour = compareDate($salarie->getDateDebutContrat(),$salarie->getDateFinContrat(),"Date début de contrat", "Date de fin de contrat" );
        if ($retour[0] == 3 || $retour[0] == 0){
            return $retour[1];
        }
    }


    return "";
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Mise à jour Salarié</title>
    <!-- Metatags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="Jean-Michel Quetelart" />
    <meta name="publisher" content="kreatic.com" />
    <meta name="robots" content="index, follow, all" />
    <meta name="Updated" content="daily" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="revisit-after" content="10 days" />
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
<!--    <style>-->
<!--        p {-->
<!--            background-color: #32ff9f;-->
<!--            text-align: center;-->
<!--        }-->
<!--        /*#adresse1{*/-->
<!--            /*width:600px;*/-->
<!--        /*}*/-->
<!--    /*</style>*/-->
    <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head>

<body>
    <header>
HEADER
    </header>
    <div id="Message1" class="message">
        <p id="message1"><?php echo $message ?> </p>
    </div>

    <div id="idEnregistrement" class="container">

        <form  method="POST" id="formulaire" class="form-inline" action="" enctype="multipart/form-data">
            <div  id="btnAjout" >
                <?php
                echo ' <img src="'.$repertoireImage.'ajout.jpg" width=20 height=20 onclick="initForm();"/>';
                ?>
            </div>
            <div  class="form-group">
<!--                <label for="ajout">Ajout:</label>-->
                <input readonly  type="hidden"  id="ajout" name="ajout" class="form-control" value="<?php echo $ajout ?>">
            </div>
            <div id="divPkSalarie" class="form-group">
                <label for="pkSalarie">N° salarié       </label>
                <input readonly type="text"  id="pkSalarie" name="pkSalarie" class="form-control" value="<?php echo $salarie->getPkSalarie(); ?>">
            </div>
            <div id="divDateCreation" class="form-group">
                <label for="dateCreation">date création </label>
                <input readonly type="text" id="dateCreation"  name="dateCreation"  class="form-control"  value="<?php echo  $salarie->getDateCreation(); ?>">
            </div>

            <div id="divDateMaj" class="form-group">
                <label for="dateMaj">date Maj </label>
                <input  readonly type="text" id="dateMaj"  name="dateMaj" class="form-control"  value="<?php echo $salarie->getDateMaj(); ?>">
            </div>
    </div>

    <div id="idIdentification" class="container">
        <div class="form-inline">
            <div id="divMatricule" class="form-group">
                <label for="matricule">Matricule </label>
                <input required type="text" id="matricule"  name="matricule" class="form-control"  value="<?php echo $salarie->getMatricule(); ?>">
            </div>

            <div id="divCivilite" class="form-group">
                <label for="civilite">Civilité </label>
                <select id = "civilite" name="civilite" class="form-control" />
                    <option></option>
                    <option <?php if ($salarie->getCivilite()=="Mr") {echo "selected";} ?> >Mr</option>
                    <option <?php if ($salarie->getCivilite()=="Mme") {echo "selected";} ?> >Mme</option>
                </select>
            </div>
            <div id="divNom" class="form-group">
                <label for="nom">Nom </label>
                <input required type="text" id="nom"  name="nom" class="form-control" value="<?php echo $salarie->getNom(); ?>" >
            </div>
            <div id="divPrenom" class="form-group">
                <label for="prenom">Prénom </label>
                <input required type="text" id="prenom"  name="prenom" class="form-control"  value="<?php echo $salarie->getPrenom(); ?>" >
            </div>
            <div id="divAdresse1" class="form-group">
                <label for="adresse1">Adresse 1 </label>
                <input type="text" id="adresse1"  name="adresse1" class="form-control adresse"  value="<?php echo $salarie->getAdresse1(); ?>" >
            </div>
            <div id="divAdresse2" class="form-group">
                <label for="adresse2">Adresse 2 </label>
                <input type="text" id="adresse2"  name="adresse2" class="form-control"  value="<?php echo $salarie->getAdresse2(); ?>" >
            </div>
            <div id="divCodePostal" class="form-group">
                <label for="codePostal">Code postal </label>
                <input type="text" id="codePostal"  name="codePostal" class="form-control"  value="<?php echo $salarie->getCodePostal(); ?>" >
            </div>
            <div id="divVille" class="form-group">
                <label for="ville">Ville </label>
                <input type="text" id="ville"  name="ville" class="form-control"  value="<?php echo $salarie->getVille(); ?>" >
            </div>
            <div id="divPays" class="form-group">
                <label for="pays">Pays </label>
                <select id = "fkPays" name="fkPays" class="form-control"/>
                    <option></option>
                <?php
                    $pays = $salarie->getFkPays();
                    for ($i=0; $i < count($listePays);$i++){
                        $selected = "";
                        if (($pays !="") && ($pays == $listePays[$i][0])){
                            $selected = "selected";
                        }
                        echo "<option value='".$listePays[$i][0]."' ".$selected.">".$listePays[$i][1]."</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="divTelephone" class="form-group">
                <label for="telephone">Téléphone </label>
                <input type="text" id="telephone"  name="telephone" class="form-control"  value="<?php echo $salarie->getTelephone(); ?>" >
            </div>
            <div id="divEmail" class="form-group">
                <label for="email">Email </label>
                <input required pattern = "(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)" type="text" id="email"  name="email" class="form-control"  value="<?php echo $salarie->getEmail(); ?>" >
            </div>
        </div>
    </div>
    <div id="idPhoto" class="container" >
<!--        <div class="form-inline">-->
        <div class="form-inline moncadre">

            <div id="divFilePhoto" class="form-group">
                <label for="photo">Photo </label>
                <input type="file" id="photo"  name="photo" class="form-control"  value="<?php echo $salarie->getPhoto(); ?>"  <?php echo $typeImageAccepte; ?> >
            </div>
            <div id="divBtnSupPhoto" class="form-group" id="btnSupImg">
                <?php
                if ($salarie->getPhoto()!="" && $pkSalarie !=""){
                    echo "<button type='button' onclick='supImage();'>Supprimer la photo</button>";
                }
                ?>
            </div>
            <div id="divPhotoAffiche" class="form-group" id="photoAffiche">
                <?php
                    if ($salarie->getPhoto()!=""){
                        echo ' <img src="'.$repertoirePhoto.$salarie->getPhoto().'" width=150 height=150/>';
                    }
                ?>
            </div>

            <input type="hidden" id="supImg" name = "supImg" value="">
        </div>
    </div>
        <div id="idEntreprise" class="container">
            <div class="form-inline">
            <div id="divDateAnciennete" class="form-group">
                <label for="dateAnciennete">Date ancienneté </label>
                <input type="date" id="dateAnciennete"  name="dateAnciennete" class="form-control"  value="<?php echo $salarie->getDateAnciennete(); ?>" >
            </div>
            <div id="divDateDebutContrat" class="form-group">
                <label for="dateDebutContrat">Date début contrat </label>
                <input type="date" id="dateDebutContrat"  name="dateDebutContrat" class="form-control"  value="<?php echo $salarie->getDateDebutContrat(); ?>" >
            </div>
            <div id="divDateFinContrat" class="form-group">
                <label for="dateFinContrat">Date fin contrat </label>
                <input type="date" id="dateFinContrat"  name="dateFinContrat" class="form-control"  value="<?php echo $salarie->getDateFinContrat(); ?>" >
            </div>
            <div id="divDirection" class="form-group">
                <label for="direction">Direction </label>
                <input type="text" id="direction"  name="direction" class="form-control"  value="<?php echo $salarie->getDirection(); ?>" >
            </div>
            <div id="divEtablissement" class="form-group">
                <label for="etablissement">Etablissement </label>
                <input type="text" id="etablissement"  name="etablissement" class="form-control"  value="<?php echo $salarie->getEtablissement(); ?>" >
            </div>
            <div id="divSecteur" class="form-group">
                <label for="secteur">Secteur </label>
                <input type="text" id="secteur"  name="secteur" class="form-control"  value="<?php echo $salarie->getSecteur(); ?>" >
            </div>
            <div id="divEmploi" class="form-group">
                <label for="emploi">Emploi </label>
                <input type="text" id="emploi"  name="emploi" class="form-control"  value="<?php echo $salarie->getEmploi(); ?>" >
            </div>
            <div id="divStatut" class="form-group">
                <label for="fkStatut">Statut </label>
                <select id = "fkStatut" name="fkStatut" class="form-control"/>
                    <option></option>
                    <?php
                        $statut = $salarie->getFkStatut();
                        for ($i=0; $i < count($listeStatut);$i++){
                            $selected = "";
                            if (($statut !="") && ($statut == $listeStatut[$i][0])){
                                 $selected = "selected";
                            }
                            echo "<option value='".$listeStatut[$i][0]."' ".$selected.">".$listeStatut[$i][1]."</option>";
                        }
                    ?>
                </select>
            </div>
            <div id="divContrat" class="form-group">
                <label for="fkContrat">Contrat </label>
                <select id = "fkContrat" name="fkContrat" class="form-control"/>
                <option></option>
                <?php
                    $contrat = $salarie->getFkContrat();
                    for ($i=0; $i < count($listeContrat);$i++){
                        $selected = "";
                        if (($contrat !="") && ($contrat == $listeContrat[$i][0])){
                            $selected = "selected";
                        }
                        echo "<option value='".$listeContrat[$i][0]."' ".$selected.">".$listeContrat[$i][1]."</option>";
                    }
                ?>
                </select>
            </div>
            <div id="divMotPasse" class="form-group">
                <label for="motPasse">Mot de passe </label>
                <input readonly type="password" id="motPasse"  name="motPasse" class="form-control"  value="<?php echo $salarie->getMotPasse(); ?>" >
            </div>
            <div id="divProfil" class="form-group">
                <label for="fkProfil">Profil </label>
                <select required id = "fkProfil" name="fkProfil" class="form-control"/>
                    <option></option>
                    <?php
                        $profil = $salarie->getFkProfil();
                        for ($i=0; $i < count($listeProfil);$i++){
                            $selected = "";
                            if (($profil !="") && ($profil == $listeProfil[$i][0])){
                                $selected = "selected";
                            }
                            echo "<option value='".$listeProfil[$i][0]."' ".$selected.">".$listeProfil[$i][1]."</option>";
                        }
                    ?>
                </select>
            </div>
        </div class="btnSubmit">
            <button id="divEnregistrer" type="submit" class="btn btn-default">Enregistrer</button>
        </form>

    </div>
    <p id="message2"><?php echo $message ?> </p>
    <div>
        <?php
            echo ' <img src="'.$repertoireImage.'accueil.jpg" width=50 height=50 onclick="gotoPage();"/>';
        ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script>
        $("#formulaire").on('submit', function(e) {
            var dateDebut = $("#dateAnciennete").val();
            var dateFin = $("#dateDebutContrat").val();
            var saisieOk = true;
            var resultat;
            if ((dateDebut !="") && (dateFin !="")) {
                resultat = compareDate(dateDebut,dateFin,"Ancienneté", "Début de contrat");
                if ((resultat[0][0] == 0) || (resultat[0][0] == 3) ) {
                    saisieOk = false;
                }
            }
            var dateDebut = $("#dateDebutContrat").val();
            var dateFin = $("#dateFinContrat").val();

            if ((dateDebut !="") && (dateFin !="")) {
                resultat = compareDate(dateDebut,dateFin,"Début contrat", "Fin de contrat");
                if ((resultat[0][0] == 0) || (resultat[0][0] == 3) ) {
                    saisieOk = false;
                }
            }

            if (!saisieOk){
                alert("Problème : " + resultat[0][1]);
                e.preventDefault();
            }

        });

        function compareDate(dateA, dateB, libDateA, libDateB){
            //  Idem que la fonction compareDate en php
            // *  +0 = egalité         => code retour  1
            //            *  sinon : 1er car
            //            *   + = date 1 < date 2 => code retour 2
            //            *   - = date 1 > date 2 => code retour 3
            //            *
            //            *  si pb                => code retour 0

            var date1 = new Date();
            var date2 = new Date();
            var arrayDateA = dateA.split("-");
            var arrayDateB = dateB.split("-");

            var resultat = new Array();
            try {
                    date1.setFullYear(arrayDateA[0]);
                    date1.setMonth(arrayDateA[1]);
                    date1.setDate(arrayDateA[2]);

                    date2.setFullYear(arrayDateB[0]);
                    date2.setMonth(arrayDateB[1]);
                    date2.setDate(arrayDateB[2]);

                    var calculDate = date2-date1;
                    if (isNaN(calculDate)){
                        resultat.push(([0, "A_Problème de format de date ("  + libDateA + " " +  libDateB + ")"]));
                    }
                    else{
                        switch (true) {
                            case(calculDate === 0) :
                                resultat.push(([1, "La date " + libDateA + " est égale à la date "+ libDateB]));
                                break;
                            case(calculDate < 0) :
                                resultat.push(([3, "La date " + libDateA + " est supérieure à la date "+ libDateB]));
                                break;
                            case(calculDate > 0) :
                                resultat.push(([2, "La date " + libDateA + " est inférieure à la date "+ libDateB]));
                                break;
                            default :
                                resultat.push(([10, "Cas inconnu, veuillez contacter l'administrateur de base"]));
                                break;
                        }
                    }
            }
            catch(error){
                resultat.push(array([0, "_B_Problème de format de date ("  + libDateA + " " +  libDateB] + ")"));
            }
            return resultat;
        }

        function supImage(){
            if (confirm("Etes-vous sûr de vouloir supprimer la photo ?")) {
                var photo = $("#divPhotoAffiche");
                var btnSupImg = $("#divBtnSupPhoto");
                photo.hide();
                btnSupImg.hide();
                $("#supImg").val("1");
            }
        }
        function initForm() {
             $("#ajout").val("1");
             $("#formulaire").submit();
        }
        function gotoPage(page) {
            location.href="index.php";
        }

    </script>
</body>
</html>