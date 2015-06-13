<?php

require("Db.class.php");

// Creates the instance
$db = new Db();

$arreglo = [
htmlspecialchars($_POST["nickname"]),
htmlspecialchars($_POST["contrasena"])
];

foreach($arreglo as $i){
    if ($i=='') {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=Error en los datos ingresados');
    }
}

$db->bind("nickname",$arreglo[0]);
$contra = hash("sha256",$arreglo[1],false);
// Insert
$select   =  $db->query("SELECT COUNT(*) AS number FROM usuarios WHERE nickname = :nickname AND contrasena='$contra';");
// Do something with the data
if($select > 0 ) {
    $token = hash("sha256",rand(0, 1023),false);
    $db->bind("token",$token);
    $expiracion = date("F j, Y, H:i", strtotime('+1 hour'));
    $db->bind("expiracion",$expiracion);     
    $db->bind("nickname",$arreglo[0]);
    $update = $db->query("UPDATE usuarios SET token = :token , expiracion = :expiracion WHERE nickname = :nickname");
    header('Location: http://' . $_SERVER['REMOTE_ADDR'] . '/?token=' . $token);
    return 'Exito';
}

header('Location: ' . $_SERVER['HTTP_REFERER']);

