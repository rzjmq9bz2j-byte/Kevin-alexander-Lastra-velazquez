<?php
include 'conexion.php';

// Cargar historial
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conexion->query("SELECT * FROM historial_andrologico WHERE id_andro='$id'");
    $h = $res->fetch_assoc();
}

// Guardar cambios
if (isset($_POST['actualizar'])) {

    $id = $_POST['id_andro'];

    $sql = "UPDATE historial_andrologico SET
        problema_fertilidad   = '{$_POST['problema_fertilidad']}',
        ets_previas           = '{$_POST['ets_previas']}',
        problemas_prostata    = '{$_POST['problemas_prostata']}',
        medicamentos_actulales = '{$_POST['medicamentos_actulales']}',
        notas                 = '{$_POST['notas']}'
        WHERE id_andro='$id'";

    if ($conexion->query($sql)) {
        header("Location: historial_andrologico.php?editado=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Historial Andrológico</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<h2>Editar historial andrológico</h2>

<form method="POST">
<input type="hidden" name="id_andro" value="<?= $h['id_andro'] ?>">

<label>Problema de fertilidad:</label>
<select name="problema_fertilidad" required>
    <option value="1" <?= $h['problema_fertilidad']==1?'selected':'' ?>>Sí</option>
    <option value="0" <?= $h['problema_fertilidad']==0?'selected':'' ?>>No</option>
</select>

<label>ETS previas:</label>
<input type="text" name="ets_previas" value="<?= $h['ets_previas'] ?>" required>

<label>Problemas de próstata:</label>
<input type="text" name="problemas_prostata" value="<?= $h['problemas_prostata'] ?>" required>

<label>Medicamentos actuales:</label>
<input type="text" name="medicamentos_actulales" value="<?= $h['medicamentos_actulales'] ?>" required>

<label>Notas:</label>
<input type="text" name="notas" value="<?= $h['notas'] ?>">

<button type="submit" name="actualizar">Actualizar</button>
</form>

</body>
</html>
