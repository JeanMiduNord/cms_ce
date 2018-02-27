<?php

    $date1  = '2018-02-01';
    $date2  = '2018-02-01';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";

    $date1  = '2018-02-01';
    $date2  = '2018-02-02';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";

    $date1  = '2018-02-02';
    $date2  = '2018-02-01';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";
    $date1  = '2018-02-01 15:24:00';
    $date2  = '2018-02-01 15:24:00';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";

    $date1  = '2018-02-01 00:00:00';
    $date2  = '2018-02-01 23:59:59';
    $resultat = compareDate($date1,$date2);
    var_dump( $date1."_".$date2."=".$resultat);
    echo  "</br>";
    
    $date1  = '2018-02-01 16:00:51';
    $date2  = '2018-02-02 17:45:00';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";

    $date1  = '2018-02-02';
    $date2  = '2018-02-01';
    $resultat = compareDate($date1,$date2);
    var_dump($date1."_".$date2."=".$resultat);
    echo  "</br>";





function compareDate($date1,$date2){
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    $diff = $interval->format('%R%a');
    return $diff;
}
    
?>