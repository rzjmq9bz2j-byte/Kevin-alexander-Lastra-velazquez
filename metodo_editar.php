<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* GUARDAR CAMBIOS */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE metidos_anticonceptivos SET
        nombre = '$nombre',
        tipo = '$tipo',
        descripcion = '$descripcion'
        WHERE id_metodo = '$id'
    ";

    if ($conexion->query($sql)) {
        header("Location: metodos.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR DATOS */
$consulta = $conexion->query("SELECT * FROM metidos_anticonceptivos WHERE id_metodo = '$id'");
$datos = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Método</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar Método Anticonceptivo</h2>

<form method="POST">

<label>Nombre:</label>
<input type="text" name="nombre" value="<?= $datos['nombre'] ?>" required>

<label>Tipo:</label>
<select name="tipo" required>
    <option value="hormonales" <?= $datos['tipo']=='hormonales'?'selected':'' ?>>Hormonales</option>
    <option value="barreras" <?= $datos['tipo']=='barreras'?'selected':'' ?>>Barreras</option>
    <option value="naturales" <?= $datos['tipo']=='naturales'?'selected':'' ?>>Naturales</option>
    <option value="quirurgicos" <?= $datos['tipo']=='quirurgicos'?'selected':'' ?>>Quirúrgicos</option>
    <option value="Otros" <?= $datos['tipo']=='Otros'?'selected':'' ?>>Otros</option>
</select>

<label>Descripción:</label>
<input type="text" name="descripcion" value="<?= $datos['descripcion'] ?>" required>

<button type="submit">Guardar cambios</button>


</form>

</body>
</html>
