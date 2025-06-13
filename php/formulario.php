<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo_computadora'];
    $anio = $_POST['anio_fabricacion'];
    $ultimo = $_POST['ultimo_mantenimiento'];
    $observaciones = $_POST['observaciones'];
    $proximo = $_POST['fecha_proximo_mantenimiento'];
    $gerencia = $_POST['gerencia']; // AGREGADO

    // Insertar en la base de datos
    $sql = "INSERT INTO computadorasdelaempresa (tipo_computadora, anio_fabricacion, ultimo_mantenimiento, observaciones, fecha_proximo_mantenimiento, gerencia)
            VALUES ('$tipo', '$anio', '$ultimo', '$observaciones', '$proximo', '$gerencia')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos insertados correctamente.";
    } else {
        echo "Error al insertar: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Computadoras</title>
    <link rel="stylesheet" type="text/css" href="../css/bcomputadora.css">
</head>
<body>
    <li class="boton-atras-li"> <a href="../index.html">ATRAS</a></li>
    <h2>Agregar computadora</h2>
    <form method="post" action="">
<select name="tipo_computadora" required>
    <option value="">-- Seleccionar --</option>
    <option value="PC DE ESCRITORIO">PC DE ESCRITORIO</option>
    <option value="NOTEBOOK">NOTEBOOK</option>
    <option value="ALL IN ONE ">ALL IN ONE</option>
    
</select><br><br>
        <label>Año de fabricación:</label><br>
        <input type="number" name="anio_fabricacion" min="1990" max="2099" required><br><br>

        <label>Último mantenimiento:</label><br>
        <input type="date" name="ultimo_mantenimiento"><br><br>

        <label>Observaciones:</label><br>
        <textarea name="observaciones" rows="4" cols="40"></textarea><br><br>

<label>Gerencia:</label><br/>
<select name="gerencia" id="gerencia" required>
    <option value="">-- Seleccionar --</option>
    <option value="Gerencia General">Gerencia General</option>
    <option value="Gerencia Administrativa">Gerencia Administrativa</option>
    <option value="Gerencia Ventas">Gerencia Ventas</option>
    <option value="Gerencia Producto">Gerencia Producto</option>
</select><br/><br/>


        <label>Fecha probable del próximo mantenimiento:</label><br>
        <input type="date" name="fecha_proximo_mantenimiento"><br><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
