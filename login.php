<?php
session_start();
include "conexion.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario  = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $fila = $res->fetch_assoc();
if (password_verify($password, $fila['password_hash'])) {

    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['usuario']    = $fila['nombre_usuario'];
    $_SESSION['id_rol']     = $fila['id_rol'];

    if ($fila['id_rol'] == 1) {
        header("Location: admin01.html");
    } elseif ($fila['id_rol'] == 2) {
        header("Location: doctor01.html");
    } elseif ($fila['id_rol'] == 3) {
        header("Location: recepcion01.html");
    }
    exit();

        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - Centro de Salud</title>
    <link rel="stylesheet" href="inicio.css">
</head>
<body>

<div class="card">
    <div class="logo-box">
        <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
    </div>

    <h1>Bienvenid@</h1>
    <h2>Por favor ingresa tus datos</h2><br>

    <form method="POST">
        <label class="label">Nombre de usuario</label>
        <input type="text" name="usuario" class="input" placeholder="Nombre de usuario" required>

        <label class="label">Contraseña</label>
        <input type="password" name="password" class="input" placeholder="Contraseña" required>

        <button type="submit" class="animated-button">
            <span class="text">Entrar</span>
            <span class="circle"></span>
        </button>

        <?php if ($error != ""): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
