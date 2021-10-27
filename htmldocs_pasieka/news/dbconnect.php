<?php
    $host = 'localhost';
    $user = '25513662_shpas';
    $password = 'ShPaSiEkA222!';
    $dbname = '25513662_shpas';

    $sql = new mysqli($host, $user, $password, $dbname);

    $sql->set_charset("utf8");

    if($sql->connect_errno) {
        die('Błąd połączenia: '.$sql->connect_errno);
    }
?>