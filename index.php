<?php

echo "UTC:".time();
session_start();
    $pkSalarie = 64;
    if (count($_POST)> 0){
        $_SESSION['pkSalarie'] = $_POST['choix']== "lecture" ?  $pkSalarie : "";
        $_SESSION['matriculeConnected'] = "azadf";
        $_SESSION['profil']= 2;
        header('Location: majSalarie.php');
    }
    var_dump(gmdate("Y-m-d\TH:i:s\Z"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>index</title>
    <meta charset="utf-8">

</head>

<body>
    <form  method="POST" action="" enctype="multipart/form-data">
        <select id = "choix" name="choix" required/>
        <option></option>
        <option value ="ajout">Formulaire en mode ajout</option>
        <option value = "lecture">Formulaire en mode consultation du <?php echo $pkSalarie ?></option>
        </select>
        <button type="submit">Envoyer</button></br>
        <?php echo date('Y-m-d H:i:s');?>
    </form>


</body>
</html>
