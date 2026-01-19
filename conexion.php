<?php
$conexion = new mysqli("localhost", "root","", "salud_reproductiva_2");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>