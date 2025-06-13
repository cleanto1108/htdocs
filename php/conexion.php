<?php
$host = "localhost";     
$usuario = "root";       
$contrasena = "";        
$basededatos = "tecnicoscomputadoras";

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} 
// else {
//     echo "Conexión exitosa a la base de datos.";
// }
?>
