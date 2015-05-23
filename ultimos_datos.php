<?php

require("Db.class.php");

// Creates the instance
$db = new Db();

// Delete
//$delete   =  $db->query("DELETE FROM Persons WHERE Id = :id", array("id"=>"1"));

// Update
//$update   =  $db->query("UPDATE Persons SET firstname = :f WHERE Id = :id", array("f"=>"Jan","id"=>"32"));

$arreglo = [
    htmlspecialchars($_GET["maximo"])
];
foreach($arreglo as $i){
    if ($i=="") {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?error=Error en los datos ingresados');
    }
}

//$db->bind("contrasena",hash("sha256",$arreglo[0],false));

$registros = $db->query("SELECT * FROM registros WHERE id_arduino=1018438961 order by fecha_hora desc limit " . $arreglo[0]);

// Do something with the data 
if($registros > 0 ) {
    $json_string = json_encode($registros, JSON_PRETTY_PRINT);
    echo $json_string;
}
