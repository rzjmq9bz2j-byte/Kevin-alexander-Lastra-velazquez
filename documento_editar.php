<?php
include 'conexion.php';

// Cargar documento
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conexion->query("SELECT * FROM documentospacientes WHERE id_documentos='$id'");
    $doc = $res->fetch_assoc();
}

// Guardar cambios
if (isset($_POST['actualizar'])) {

    $id = $_POST['id_documentos'];

    $sql = "UPDATE documentospacientes SET
            tipo          = '{$_POST['tipo']}',
            descripcion   = '{$_POST['descripcion']}',
            ruta_archivos = '{$_POST['ruta_archivos']}',
            fecha_subida  = '{$_POST['fecha_subida']}'
            WHERE id_documentos='$id'";

    if ($conexion->query($sql)) {
        header("Location: documentos_personas.php?editado=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Documento</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar Documento</h2>

<form method="POST">
<input type="hidden" name="id_documentos" value="<?= $doc['id_documentos'] ?>">

<label>Tipo:</label>
<input type="text" name="tipo" value="<?= $doc['tipo'] ?>" required>

<label>Descripción:</label>
<input type="text" name="descripcion" value="<?= $doc['descripcion'] ?>" required>

<label>Ruta archivo:</label>
<input type="text" name="ruta_archivos" value="<?= $doc['ruta_archivos'] ?>" required>

<label>Fecha subida:</label>
<input type="datetime-local" name="fecha_subida" value="<?= date('Y-m-d\TH:i', strtotime($doc['fecha_subida'])) ?>" required>

<button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
