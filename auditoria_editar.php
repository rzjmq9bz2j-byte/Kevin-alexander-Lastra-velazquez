<?php
include 'conexion.php';

// Cargar datos
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = $conexion->query("SELECT * FROM auditoria WHERE id_log = '$id'");
    $dato = $resultado->fetch_assoc();
}

// Guardar cambios
if (isset($_POST['actualizar'])) {
    $id          = $_POST['id_log'];
    $accionarial = $_POST['accionarial'];
    $detalles    = $_POST['detalles'];
    $fecha_hora  = $_POST['fecha_hora'];

    $sql = "UPDATE auditoria 
            SET accionarial='$accionarial',
                detalles='$detalles',
                fecha_hora='$fecha_hora'
            WHERE id_log='$id'";

    if ($conexion->query($sql)) {
        header("Location: auditoria.php?editado=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Auditoría</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar Auditoría</h2>

<form method="POST">
    <input type="hidden" name="id_log" value="<?= $dato['id_log'] ?>">

    <label>Acción:</label>
    <input type="text" name="accionarial" value="<?= $dato['accionarial'] ?>" required>

    <label>Detalles:</label>
    <input type="text" name="detalles" value="<?= $dato['detalles'] ?>" required>

    <label>Fecha y hora:</label>
    <input type="datetime-local" name="fecha_hora" value="<?= $dato['fecha_hora'] ?>" required>

    <button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
