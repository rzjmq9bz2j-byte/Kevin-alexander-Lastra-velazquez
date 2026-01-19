<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -------------------------------------------
// GUARDAR REGISTRO
// -------------------------------------------
if (!empty($_POST['nombre']) && !empty($_POST['especialidad']) && !empty($_POST['telefono']) && !empty($_POST['correo'])) {

    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "INSERT INTO medicos (nombre, especialidad, telefono, correo)
            VALUES ('$nombre', '$especialidad', '$telefono', '$correo')";

    if ($conexion->query($sql)) {
        header("Location: medicos.php");
        exit;
    } else {
        echo "Error al registrar: " . $conexion->error;
    }
}
?>


























<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Médicos</title>
<link rel="stylesheet" href="pacientes.css">
</head>
<body>

<header>
   <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
  <h1>MEDICOS </h1>
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registro de Médico</h2><BR>

<form action="medicos.php" method="POST" class="form-card">
  
  <label>Nombre:</label>
  <input type="text" name="nombre" required>

  <label>Especialidad:</label>
  <input type="text" name="especialidad" required>

  <label>Teléfono:</label>
  <input type="number" name="telefono" required>

  <label>Correo:</label>
  <input type="email" name="correo" required>

  <button type="submit">Guardar</button>
</form><BR>





















<h2>Lista de Médicos</h2>


<table border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Especialidad</th>
      <th>Teléfono</th>
      <th>Correo</th>
      <th>Acciones</th>
    </tr>
  </thead>
  
  <tbody>
  <?php 
    $consulta = $conexion->query("SELECT * FROM medicos");
    while($fila = $consulta->fetch_assoc()) { ?>
      <tr>
        <td><?= $fila['id_medico'] ?></td>
        <td><?= $fila['nombre'] ?></td>
        <td><?= $fila['especialidad'] ?></td>
        <td><?= $fila['telefono'] ?></td>
        <td><?= $fila['correo'] ?></td>
       
       

<td>
    
        <button>  <a href="medico_editar.php?id=<?= $fila['id_medico'] ?>" class="btn-editar">
  Editar
</a> </button>

    <button onclick="confirmarEliminar(<?= $fila['id_medico'] ?>)">Eliminar</button>
</td>
       
       
       
       
        

        </td>
      </tr>
  <?php } ?>
  </tbody>
</table>
<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar este medico?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "medico_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>



</body>
</html>