<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!empty($_POST['nombre']) && !empty($_POST['tipo']) && !empty($_POST['descripcion'])) {

    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO metidos_anticonceptivos (nombre, tipo, descripcion)
            VALUES ('$nombre', '$tipo', '$descripcion')";

    if ($conexion->query($sql)) {
        header("Location: metodos.php");
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
<title>Métodos Anticonceptivos</title>
<link rel="stylesheet" href="pacientes.css">

</head>
<body>

<header>
   <div class="logo-box">
    <img src="Logo Medicina Salud Minimalista Corporativo Azul.PNG" alt="logo">
</div>
    <h1>METODOS ANTICONCEPTIVOS </h1>
</header>

<nav>
  <ul>
    <li><a href="admin01.html">Inicio</a></li>
  </ul>
</nav>

<h2>Registrar Método</h2><BR>

<form action="metodos.php" method="POST">

<label>Nombre:</label>
<input type="text" name="nombre" required>

<label>tipo</label>
    <select name="tipo" required>
        <option value="">Seleccionar...</option>
        <option value="hormonales">hormonales</option>
        <option value="barreras">barreras</option>
        <option value="naturales">naturales</option>
        <option value="quirurgicos">quirurgicos</option>
        <option value="Otros">Otros</option>
    </select>


<label>Descripción:</label>
<input type="text" name="descripcion" required>


<button type="submit">Guardar</button>


</form><BR>






























<h2>Lista de Métodos</h2>

<table border="1">
<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Tipo</th>
<th>Descripción</th>
  <th>Acciones</th>
</tr>
</thead>

<tbody>

<?php
$consulta = $conexion->query("SELECT * FROM metidos_anticonceptivos");

if (!$consulta) {
    die("Error en consulta: " . $conexion->error);
}

while ($fila = $consulta->fetch_assoc()) { ?>
<tr>
<td><?= $fila['id_metodo'] ?></td>
<td><?= $fila['nombre'] ?></td>
<td><?= $fila['tipo'] ?></td>
<td><?= $fila['descripcion'] ?></td>
 <td>

    
        <button> <a href="metodo_editar.php?id=<?= $fila['id_metodo'] ?>" class="btn-editar">
  Editar
</a> </button>
    
    <button onclick="confirmarEliminar(<?= $fila['id_metodo'] ?>)">Eliminar</button>
</td>
       



    

</tr>
<?php } ?>

</tbody>
</table>

<div id="modalEliminar" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6)">
  <div style="background:white;padding:20px;width:320px;margin:15% auto;border-radius:10px;text-align:center;">
    <p>¿Eliminar este metodo?</p>
    <button onclick="cerrarModal()">Cancelar</button>
    <a id="btnEliminar" href="#" class="btn">Eliminar</a>
  </div>
</div>

<script>
function confirmarEliminar(id){
    document.getElementById("btnEliminar").href = "metodo_eliminar.php?id=" + id;
    document.getElementById("modalEliminar").style.display = "block";
}
function cerrarModal(){
    document.getElementById("modalEliminar").style.display = "none";
}
</script>
</body>
</html>
