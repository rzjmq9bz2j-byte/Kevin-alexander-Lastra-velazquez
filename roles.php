<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!empty($_POST['nombre']) && !empty($_POST['descripcion'])) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO roles (nombre, descripcion)
            VALUES ('$nombre', '$descripcion')";

    if ($conexion->query($sql)) {
        header("Location: roles.php");
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>







<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link rel="stylesheet" href="pacientes.css">
</head>

<body>

<header>
     <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>roles</h1>
</header>


<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>


<h2>Formulario de Rol</h2><BR>

<form action="roles.php" method="POST">

    <label>Nombre del rol:</label>
    <input type="text" name="nombre" required>

    <label>Descripción:</label>
    <input type="text" name="descripcion" required>

    <button type="submit">Guardar</button>

</form><BR>
























<h2>Lista de Roles</h2>

<table border="1">
<thead>
<tr>
    <th>id_rol</th>
    <th>nombre</th>
    <th>descripcion</th>
    <th>acciones</th>
</tr>
</thead>

<tbody>
<?php
$consulta = $conexion->query("SELECT * FROM roles");

while ($fila = $consulta->fetch_assoc()) { ?>
<tr>
    <td><?= $fila['id_rol'] ?></td>
    <td><?= $fila['nombre'] ?></td>
    <td><?= $fila['descripcion'] ?></td>

    <td>
        <button><a href="roleditar.php?id=<?= $fila['id_rol'] ?>">Editar</a></button>
        <button onclick="confirmar(<?= $fila['id_rol'] ?>)">Eliminar</button>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<!-- MODAL -->
<div id="modal" style="display:none; position:fixed; top:0; left:0;
     width:100%; height:100%; background:rgba(0,0,0,.6);">
  <div style="background:white; padding:20px; width:300px;
       margin:15% auto; border-radius:10px; text-align:center;">
    <h3>Eliminar Rol</h3>
    <p>¿Seguro que deseas eliminar?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" 
       style="padding:8px 12px; background:red; color:white; text-decoration:none; border-radius:5px;">Eliminar</a>
  </div>
</div>

<script>
function confirmar(id){
    document.getElementById("btnEliminar").href = "roleliminar.php?id=" + id;
    document.getElementById("modal").style.display = "block";
}

function cerrarModal(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
