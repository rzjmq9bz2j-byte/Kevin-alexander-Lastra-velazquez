<?php
include 'conexion.php';

// Cargar consulta
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conexion->query("SELECT * FROM consultas WHERE id_consulta='$id'");
    $consulta = $res->fetch_assoc();
}

// Guardar cambios
if (isset($_POST['actualizar'])) {

    $id = $_POST['id_consulta'];

    $sql = "UPDATE consultas SET
            motivo_consulta   = '{$_POST['motivo_consulta']}',
            signos_vitales    = '{$_POST['signos_vitales']}',
            examen_fisico     = '{$_POST['examen_fisico']}',
            diagnostico       = '{$_POST['diagnostico']}',
            tratamiento       = '{$_POST['tratamiento']}',
            receta            = '{$_POST['receta']}',
            recomendaciones   = '{$_POST['recomendaciones']}'
            WHERE id_consulta='$id'";

    if ($conexion->query($sql)) {
        header("Location: consulta.php?editado=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Consulta</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar Consulta</h2>

<form method="POST">
<input type="hidden" name="id_consulta" value="<?= $consulta['id_consulta'] ?>">

<label>Motivo:</label>
<input type="text" name="motivo_consulta" value="<?= $consulta['motivo_consulta'] ?>" required>

<label>Signos vitales:</label>
<input type="text" name="signos_vitales" value="<?= $consulta['signos_vitales'] ?>" required>

<label>Examen físico:</label>
<input type="text" name="examen_fisico" value="<?= $consulta['examen_fisico'] ?>" required>

<label>Diagnóstico:</label>
<input type="text" name="diagnostico" value="<?= $consulta['diagnostico'] ?>" required>

<label>Tratamiento:</label>
<input type="text" name="tratamiento" value="<?= $consulta['tratamiento'] ?>" required>

<label>Receta:</label>
<input type="text" name="receta" value="<?= $consulta['receta'] ?>" required>

<label>Recomendaciones:</label>
<input type="text" name="recomendaciones" value="<?= $consulta['recomendaciones'] ?>" required>

<button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
