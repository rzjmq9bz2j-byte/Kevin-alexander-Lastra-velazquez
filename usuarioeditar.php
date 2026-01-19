<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

/* ACTUALIZAR */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_usuario = $_POST['nombre_usuario'];
    $nombre_completa = $_POST['nombre_completa'];
    $correo = $_POST['correo'];
    $id_rol = $_POST['id_rol'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    if (!empty($_POST['password'])) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET
            nombre_usuario='$nombre_usuario',
            nombre_completa='$nombre_completa',
            correo='$correo',
            pasword_hash='$password_hash',
            id_rol='$id_rol',
            activo='$activo'
            WHERE id_usuario='$id'
        ";
    } else {
        $sql = "UPDATE usuario SET
            nombre_usuario='$nombre_usuario',
            nombre_completa='$nombre_completa',
            correo='$correo',
            id_rol='$id_rol',
            activo='$activo'
            WHERE id_usuario='$id'
        ";
    }

    if ($conexion->query($sql)) {
        header("Location: usuario.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

/* CARGAR USUARIO */
$consulta = $conexion->query("SELECT * FROM usuario WHERE id_usuario='$id'");
$usuario = $consulta->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Usuario</title>
<link rel="stylesheet" href="pacientes.css">
</head>

<body>

<h2>Editar Usuario</h2>

<form method="POST">

<label>Nombre de Usuario:</label>
<input type="text" name="nombre_usuario" value="<?= $usuario['nombre_usuario'] ?>" required>

<label>Nombre Completo:</label>
<input type="text" name="nombre_completa" value="<?= $usuario['nombre_completa'] ?>" required>

<label>Correo:</label>
<input type="email" name="correo" value="<?= $usuario['correo'] ?>" required>

<label>Nueva Contraseña (opcional):</label>
<input type="password" name="password">

<label>Rol:</label>
<select name="id_rol" required>
    <option value="1" <?= $usuario['id_rol']==1?'selected':'' ?>>Administrador</option>
    <option value="2" <?= $usuario['id_rol']==2?'selected':'' ?>>Doctor</option>
    <option value="3" <?= $usuario['id_rol']==3?'selected':'' ?>>Recepción</option>
</select>

<label>
<input type="checkbox" name="activo" <?= $usuario['activo']==1?'checked':'' ?>>
 Activo
</label>

<button type="submit">Guardar cambios</button>


</form>

</body>
</html>
