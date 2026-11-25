<?php
include ('conexion.php');

if(isset($_POST['registro'])){
    $cui = $_POST['cui'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre_apellido = $_POST['nombre_apellido'];
    $puesto = $_POST['puesto'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    //Condición, validar si el usuario existe
    $validar_usuario = $conn->prepare("SELECT * FROM Colaborador WHERE usuario = :usuario");
    $validar_usuario->bindParam("usuario", $usuario, PDO::PARAM_STR);
    $validar_usuario->execute();
    $validar_usuario_resultado = $validar_usuario->fetch(PDO::FETCH_ASSOC);
    
    if($validar_usuario_resultado){
        echo "<br> Este usuario ya existe, por favor ingrese otro";
    }else{

    //Registro, inserción de nuevos datos
    $query = $conn->prepare("INSERT INTO colaborador(cui, nombre_apellido, puesto, fecha_nacimiento, correo, telefono, usuario, contrasena)
    VALUES (:cui, :nombre_apellido, :puesto, :fecha_nacimiento, :correo, :telefono, :usuario, :contrasena)");

    $query->bindParam("cui", $cui, PDO::PARAM_INT);
    $query->bindParam("usuario", $usuario, PDO::PARAM_STR);
    $query->bindParam("contrasena", $contrasena, PDO::PARAM_STR);
    $query->bindParam("nombre_apellido", $nombre_apellido, PDO::PARAM_STR);
    $query->bindParam("puesto", $puesto, PDO::PARAM_INT);
    $query->bindParam("fecha_nacimiento", $fecha_nacimiento, PDO::PARAM_STR);
    $query->bindParam("correo", $correo, PDO::PARAM_STR);
    $query->bindParam("telefono", $telefono, PDO::PARAM_INT);

    $ejecutar = $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if($ejecutar){
        echo '<br> Registro Realizado Correctamente';
    }else{
        echo '<br> El registro no pudo ser completado';
    }
  }
}
?>


<link rel="stylesheet" href="style.css">
<form method="post" action="" name="signin-form">
    <div class = "form-element">
        <label>Código Único de Identificación</label>
        <input type="text" name="cui" required />
    </div>
    <div class="form-element">
        <label>Usuario</label>
        <input type="text" name="usuario" required />
    </div>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="contrasena" required />
    </div>
    <div class="form-element">
        <label>Nombre y Apellido</label>
        <input type="text" name="nombre_apellido" required />
    </div>
    <div class="form-element">
        <label>Puesto</label>
        <input type="number" name="puesto" required />
    </div>
    <div class="form-element">
        <label>Fecha de Nacimiento</label> <br>
        <input type="date" name="fecha_nacimiento" required />
    </div>
    <div class="form-element">
        <label>Teléfono</label>
        <input type="number" name="telefono" required />
    </div>
    <div class="form-element">
        <label>Correo</label>
        <input type="text" name="correo" required />
    </div>
    <button type="submit" name="registro" value="registro">
        Registrar
    </button>
</form>

