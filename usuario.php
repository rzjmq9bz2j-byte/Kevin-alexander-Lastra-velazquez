<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!empty($_POST['nombre_usuario']) && 
    !empty($_POST['nombre_completa']) && 
    !empty($_POST['correo']) && 
    !empty($_POST['password']) &&
    !empty($_POST['id_rol'])) {

    $nombre_usuario = $_POST['nombre_usuario'];
    $nombre_completa = $_POST['nombre_completa'];
    $correo = $_POST['correo'];
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_rol = $_POST['id_rol'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    // INSERT CORRECTO con nombres EXACTOS
    $sql = "INSERT INTO usuario (nombre_usuario, nombre_completa, correo, pasword_hash, id_rol, activo)
            VALUES ('$nombre_usuario', '$nombre_completa', '$correo', '$password_hash', '$id_rol', '$activo')";

    if ($conexion->query($sql)) {
        header("Location: usuario.php");
        exit;
    } else {
        echo "Error al guardar: " . $conexion->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<header>
   <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>USUARIO</h1>
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registrar Usuario</h2><BR>

<form action="usuario.php" method="POST">

<label>Nombre de Usuario:</label>
<input type="text" name="nombre_usuario" required>

<label>Nombre Completo:</label>
<input type="text" name="nombre_completa" required>

<label>Correo:</label>
<input type="email" name="correo" required>

<label>Contraseña:</label>
<input type="password" name="password" required>

<label>Rol:</label>
<select name="id_rol" required>
    <option value="">Seleccionar...</option>
    <option value="1">Administrador</option>
    <option value="2">Doctor</option>
    <option value="3">Recepción</option>
</select>

<label>Activo:</label>
<input type="checkbox" name="activo" checked>

<button type="submit">Guardar</button>


</form><BR>

<h2>Lista de Usuarios</h2>

<table border="1">
<thead>
<tr>
<th>ID</th>
<th>Usuario</th>
<th>Nombre Completo</th>
<th>Correo</th>
<th>Rol</th>
<th>Activo</th>
  <th>Acciones</th>
</tr>
</thead>

<tbody>

<?php
$consulta = $conexion->query("SELECT * FROM usuario");

if (!$consulta) {
    die("Error en consulta: " . $conexion->error);
}

while ($fila = $consulta->fetch_assoc()) { ?>
<tr>
<td><?= $fila['id_usuario'] ?></td>
<td><?= $fila['nombre_usuario'] ?></td>
<td><?= $fila['nombre_completa'] ?></td>
<td><?= $fila['correo'] ?></td>
<td><?= $fila['id_rol'] ?></td>
<td><?= $fila['activo'] == 1 ? 'Sí' : 'No' ?></td>
<td>
       <button>
  <a href="usuarioeditar.php?id=<?= $fila['id_usuario'] ?>">Editar</a>
</button>

<button onclick="confirmar(<?= $fila['id_usuario'] ?>)">Eliminar</button>

        </td>
</tr>
<?php } ?>

</tbody>
</table>
<div id="modal" style="display:none; position:fixed; top:0; left:0;
width:100%; height:100%; background:rgba(0,0,0,.6);">

<div style="background:white; padding:20px; width:300px;
margin:15% auto; border-radius:10px; text-align:center;">

<h3>Eliminar Usuario</h3>
<p>¿Seguro que deseas eliminar?</p>

<button onclick="cerrarModal()">Cancelar</button>

<a id="btnEliminar" href="#"
style="padding:8px 12px; background:red; color:white;
text-decoration:none; border-radius:5px;">Eliminar</a>

</div>
</div>

<script>
function confirmar(id){
    document.getElementById("btnEliminar").href = "usuarioeliminar.php?id=" + id;
    document.getElementById("modal").style.display = "block";
}

function cerrarModal(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
