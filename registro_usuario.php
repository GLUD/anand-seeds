<?php

require("Db.class.php");

// Creates the instance
$db = new Db();

// Delete
//$delete   =  $db->query("DELETE FROM Persons WHERE Id = :id", array("id"=>"1"));

// Update
//$update   =  $db->query("UPDATE Persons SET firstname = :f WHERE Id = :id", array("f"=>"Jan","id"=>"32"));

$arreglo = [ htmlspecialchars($_POST["nickname"]),
htmlspecialchars($_POST["correo"]),
htmlspecialchars($_POST["nombres"]),
htmlspecialchars($_POST["apellidos"]),
htmlspecialchars($_POST["contrasena"]) 
];
foreach($arreglo as $i){
    if ($i=="") {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=Error en los datos ingresados');
    }
}

$db->bind("nickname",$arreglo[0]);
$db->bind("correo",$arreglo[1]);
$db->bind("nombres",$arreglo[2]);
$db->bind("apellidos",$arreglo[3]);
$db->bind("contrasena",hash("sha256",$arreglo[4],false));
// Insert
$insert   =  $db->query("INSERT INTO usuarios(nickname,correo,nombres,apellidos,contrasena) VALUES(:nickname,:correo,:nombres,:apellidos,:contrasena)");

// Do something with the data 
if($insert > 0 ) {
  header('Location: ' . $_SERVER['REMOTE_ADDR'] . '?error=Error en la consulta');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);