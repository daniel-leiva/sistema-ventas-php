<?php
include ('conexion.php');

session_start();
if(isset($_POST['login'])){

    $username = $_POST['username'];
    $contrasena = $_POST['contrasena'];

    $query = $conn->prepare("SELECT * FROM Colaborador
    WHERE usuario = :username and contrasena = :contrasena;");

    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->bindParam("contrasena", $contrasena, PDO::PARAM_STR);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if(!$resultado){
        echo '<br> Datos Incorrectos';
    }else{
            //Se ejecuta cuando el usuario y contraseña son Correctos
            echo '<br>Sesión Iniciada';
            $_SESSION['cui_colaborador'] = $resultado['cui'];
            header('Location: index.php');
            exit;
        }
        //Aquí termina
}

?>

<link rel="stylesheet" href="style.css">
<form method="post" action="" name="signin-form">
    <div class = "form-element">
        <label>Usuario</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="contrasena" required />
    </div>
    <button type="submit" name="login" value="login">
        Iniciar Sesión
    </button>
    <a href="registro.php" class="button"> Registrarse </a>
</form>

