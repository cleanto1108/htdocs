<?php
include 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_computadora']);
    $tipo = $conn->real_escape_string($_POST['tipo_computadora']);
    $anio = intval($_POST['anio_fabricacion']);
    $ultimo = $conn->real_escape_string($_POST['ultimo_mantenimiento']);
    $obs = $conn->real_escape_string($_POST['observaciones']);
    $prox = $conn->real_escape_string($_POST['fecha_proximo_mantenimiento']);
    $gerencia = $conn->real_escape_string($_POST['gerencia']);

$sql = "UPDATE computadorasdelaempresa SET 
        tipo_computadora='$tipo',
        gerencia='$gerencia',
        anio_fabricacion=$anio,
        ultimo_mantenimiento='$ultimo',
        observaciones='$obs',
        fecha_proximo_mantenimiento='$prox'
        WHERE id_computadora=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}

$conn->close();
?>