<?php

	$mysqli = new mysqli("localhost", "uqrbk7vzc3vz6", "w814M6D?o#3P", "dbtvg1fthgpkyc");

    $id = $_GET['id'];
    $gano = "Si";

    $sql = "UPDATE participante SET gano='$gano' WHERE id='$id'";
    if ($mysqli->query($sql) === true)
    {
        echo "Ok";
    }
    else
    {

    } 

?>