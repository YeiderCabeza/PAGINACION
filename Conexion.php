<?php
$password = "";
$usuario = "root";
//$nombre_base_de_datos = "ventas";
$host ="mysql:host=localhost;dbname=MI_TERRAZA;port=3309";
try {
    $c = new PDO($host, $usuario, $password);
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $c->exec("set names utf8");
    $c->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    
} catch (Exception $e) {
    echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
?>