<?php

require("Db.class.php");

// Creates the instance
$db = new Db();

$arreglo = [ 
htmlspecialchars($_GET["temp"]),
htmlspecialchars($_GET["humr"]),
htmlspecialchars($_GET["hums"]),
htmlspecialchars($_GET["radi"]),
htmlspecialchars($_GET["idar"])
];
var_dump($arreglo);
foreach($i as $arreglo){
    if (isset($i) && ($i=="")) {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=Error en los datos ingresados');
    }
}

$db->bind("dato_tem",$arreglo[0]);
$db->bind("dato_hum_r",$arreglo[1]);
$db->bind("dato_hum_s",$arreglo[2]);
$db->bind("dato_rad",$arreglo[3]);
$db->bind("id_arduino",$arreglo[4]);
$db->bind("fecha_hora",date('Y-m-d H:i:s'));

// Insert
$insert   =  $db->query("INSERT INTO registros(fecha_hora,dato_hum_s,dato_hum_r,dato_rad,dato_tem,id_arduino) VALUES(:fecha_hora,:dato_hum_s,:dato_hum_r,:dato_rad,:dato_tem,:id_arduino)");

// Do something with the data 
if($insert > 0 ) {
  return 'Succesfully created a new registro !';
}
