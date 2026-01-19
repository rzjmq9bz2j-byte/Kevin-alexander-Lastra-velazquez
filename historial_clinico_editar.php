<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conexion->query("SELECT * FROM historial_clinico WHERE id_historial='$id'");
    $h = $res->fetch_assoc();
}

if (isset($_POST['actualizar'])) {

    $sql = "UPDATE historial_clinico SET
        grupo_sanginio         = '{$_POST['grupo_sanginio']}',
        alergias                = '{$_POST['alergias']}',
        enfermedades_cronicas   = '{$_POST['enfermedades_cronicas']}',
        cirugias                = '{$_POST['cirugías']}',
        antecedentes_familiares = '{$_POST['antecedentes_familiares']}',
        madicamentos_actuales   = '{$_POST['madicamentos_actuales']}',
        notas                   = '{$_POST['notas']}'
        WHERE id_historial='{$_POST['id_historial']}'";

    if ($conexion->query($sql)) {
        header("Location: historial_clinico.php?editado=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Historial Clínico</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar historial clínico</h2>

<form method="POST">
<input type="hidden" name="id_historial" value="<?= $h['id_historial'] ?>">
<label>Grupo sanguíneo:</label>
<select name="grupo_sanginio"value="<?= $h['grupo_sanginio'] ?>" required>
    <option value="">Seleccione...</option>
    <option value="A+">A+</option>
    <option value="A-">A-</option>
    <option value="B+">B+</option>
    <option value="B-">B-</option>
    <option value="AB+">AB+</option>
    <option value="AB-">AB-</option>
    <option value="O+">O+</option>
    <option value="O-">O-</option>
</select>



<label>Alergias:</label>
<input type="text" name="alergias" value="<?= $h['alergias'] ?>" required>

<label>Enfermedades crónicas:</label>
<input type="text" name="enfermedades_cronicas" value="<?= $h['enfermedades_cronicas'] ?>" required>

<label>Cirugías:</label>
<input type="text" name="cirugias" value="<?= $h['cirugías'] ?>" required>

<label>Antecedentes familiares:</label>
<input type="text" name="antecedentes_familiares" value="<?= $h['antecedentes_familiares'] ?>" required>

<label>Medicamentos actuales:</label>
<input type="text" name="madicamentos_actuales" value="<?= $h['madicamentos_actuales'] ?>" required>

<label>Notas:</label>
<input type="text" name="notas" value="<?= $h['notas'] ?>">

<button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
