<?php
include 'conexion.php';

// Cargar cita
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conexion->query("SELECT * FROM citas WHERE id_cita='$id'");
    $cita = $res->fetch_assoc();
}

// Guardar cambios
if (isset($_POST['actualizar'])) {
    $id     = $_POST['id_cita'];
    $fecha  = $_POST['fecha'];
    $hora   = $_POST['hora'];
    $motivo = $_POST['motivo'];
    $estado = $_POST['estado'];

    $sql = "UPDATE citas SET 
            fecha='$fecha',
            hora='$hora',
            motivo='$motivo',
            estado='$estado'
            WHERE id_cita='$id'";

    if ($conexion->query($sql)) {
        header("Location: citas.php?editado=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Cita</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar Cita</h2>

<form method="POST">
<input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">

<label>Fecha:</label>
<input type="date" name="fecha" value="<?= $cita['fecha'] ?>" required>

<label>Hora:</label>
<input type="time" name="hora" value="<?= $cita['hora'] ?>" required>

<label>Motivo:</label>
<input type="text" name="motivo" value="<?= $cita['motivo'] ?>" required>

<label>Estado:</label>
<select name="estado" required>
  <option value="pendiente" <?= $cita['estado']=='pendiente'?'selected':'' ?>>Pendiente</option>
  <option value="confirmada" <?= $cita['estado']=='confirmada'?'selected':'' ?>>Confirmada</option>
  <option value="realizada" <?= $cita['estado']=='realizada'?'selected':'' ?>>Realizada</option>
  <option value="cancelada" <?= $cita['estado']=='cancelada'?'selected':'' ?>>Cancelada</option>
</select>

<button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
