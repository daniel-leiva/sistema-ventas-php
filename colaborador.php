<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Colaborador
    WHERE
    cui = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}

//Update para modificar el colaborador
if(isset($_POST['cui_modificar']) && isset($_POST['puesto_modificar']) && isset($_POST['nombre_modificar'])){
  $cui_modificar = $_POST['cui_modificar'];
  $nombre_modificar = $_POST['nombre_modificar'];
  $puesto_modificar = $_POST['puesto_modificar'];
  $fecha_modificar = $_POST['fecha_modificar'];
  $correo_modificar = $_POST['correo_modificar'];
  $telefono_modificar = $_POST['telefono_modificar'];
  $usuario_modificar = $_POST['usuario_modificar'];
  $contrasena_modificar = $_POST['contrasena_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Colaborador
  SET
  nombre_apellido = :nombre,
  puesto = :puesto,
  fecha_nacimiento = :fecha,
  correo = :correo,
  telefono = :telefono,
  usuario = :usuario,
  contrasena = :contrasena
  WHERE
  cui = :cui;");
  $query_modificar->bindParam("cui", $cui_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("nombre", $nombre_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("puesto", $puesto_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("fecha", $fecha_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("correo", $correo_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("telefono", $telefono_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("usuario", $usuario_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("contrasena", $contrasena_modificar, PDO::PARAM_STR);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Colaborador Modificado Correctamente</span>';


}


//Insert para agregar nuevo colaborador
if (isset($_POST['cui']) && isset($_POST['puesto'])){
  $cui = $_POST['cui'];
  $nombre_apellido = $_POST['nombre_apellido'];
  $puesto = $_POST['puesto'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];

  $inst = $conn->prepare("INSERT INTO Colaborador(cui, nombre_apellido, puesto, fecha_nacimiento, correo, telefono, usuario, contrasena)
  VALUES (:cui, :nombre_apellido, :puesto, :fecha_nacimiento, :correo, :telefono, :usuario, :contrasena);");
  $inst->bindParam("cui", $cui, PDO::PARAM_INT);
  $inst->bindParam("nombre_apellido", $nombre_apellido, PDO::PARAM_STR);
  $inst->bindParam("puesto", $puesto, PDO::PARAM_INT);
  $inst->bindParam("fecha_nacimiento", $fecha_nacimiento, PDO::PARAM_STR);
  $inst->bindParam("correo", $correo, PDO::PARAM_STR);
  $inst->bindParam("telefono", $telefono, PDO::PARAM_STR);
  $inst->bindParam("usuario", $usuario, PDO::PARAM_STR);
  $inst->bindParam("contrasena", $contrasena, PDO::PARAM_STR);
  $inst->execute();

  echo '<br><span style="color:white;">Colaborador Agregado Correctamente</span>';

}

//Select para la tabla de Colaboradores
$query = $conn->prepare("SELECT
C.cui, C.nombre_apellido, p.nombre as 'puesto', C.fecha_nacimiento, C.correo, C.telefono, C.usuario, C.contrasena
FROM
Colaborador C, Puesto P
WHERE
C.puesto = P.codigo
ORDER BY nombre_apellido ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para el seleccionador de Puestos
$query_puesto = $conn->prepare("SELECT 
codigo, nombre
FROM
Puesto;");
$query_puesto->execute();
$puestos = $query_puesto->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style2.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&family=Noto+Serif:wght@700&display=swap" rel="stylesheet">

    <title>Colaborador</title>
  </head>
  <body>

  <!-- Inicio del Navbar Tabs Menú-->
  <ul class="nav nav-tabs" style="font-weight: bold;">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">INICIO</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="" role="button" aria-expanded="false">Empresa</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="sucursal.php">Sucursal</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="departamentos.php">Departamento</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="puesto.php">Puesto</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="colaborador.php">Colaborador</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Almacén</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="productos.php">Productos</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="lote.php">Lote</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="devoluciones.php">Devoluciones</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="clientes.php">Clientes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="proveedores.php">Proveedores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="compras.php">Compras</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="ventas.php">Ventas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="tareas.php">Tareas</a>
      </li>
      <li class="nav-item" style="margin-left: auto;">
            <a href="logout.php" class="nav-link"> Cerrar Sesión </a>
      </li>
    </ul>
    <!-- Fin del Navbar Tabs Menú-->


    <!-- Botón Agregar Nuevo -->
    <div>
      <div class="container_titulo">
        <div class="titulo"><h1>Colaboradores</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nuevo Colaborador
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Colaborador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
            <div class="modal-header">
              <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Usuario</label>
                  <input type="text" name="usuario" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                  <input type="password" name="contrasena" class="form-control" id="exampleInputPassword1">
                </div>
              </div>
              <div class="mb-3">
                <br>
                <label for="exampleInputPassword1" class="form-label">CUI</label>
                <input type="number" name="cui" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nombre y Apellido</label>
                <input type="text" name="nombre_apellido" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label>Puestos</label>
                <select name="puesto" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($puestos as $row => $link){
                  ?>
                    <option value="<?php echo $link['codigo']?>"> <?php echo $link['nombre']?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Télefono</label>
                <input type="number" name="telefono" class="form-control" id="exampleInputPassword1">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Fin Modal -->


    <!-- Inicio de la Tabla Puesto -->
    <table class="table table-striped table-light">
        <thead>
          <tr>
            <th>CUI</th>
            <th>Nombre y Apellido</th>
            <th>Puesto</th>
            <th>Fecha de Nacimiento</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($resultado as $row => $link){
          ?>
          <tr>
            <th>
              <?php echo $link['cui'] ?>
            </th>
            <td>
              <?php echo $link['nombre_apellido'] ?>
            </td>
            <td>
              <?php echo $link['puesto'] ?>
            </td>
            <td>
              <?php echo $link['fecha_nacimiento'] ?>
            </td>
            <td>
              <?php echo $link['correo'] ?>
            </td>
            <td>
              <?php echo $link['telefono'] ?>
            </td>
            <td class="columna_acciones">
              <!-- Botón Modal Eliminar-->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['cui'] ?>">
                Eliminar
              </button>

              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['cui'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar a este colaborador: <?php echo $link['nombre_apellido']?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <form action="" method="POST">
                        <input type="hidden" name="id_eliminar" value="<?php echo $link['cui']?>">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del Modal Eliminar-->

                <!-- Botón Modificar -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['cui']?>">
                  Modificar
                </button>
                </div>
              </div>

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['cui']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Sucursal</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <form action="" method="POST">
                        <div class="modal-header">
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Usuario</label>
                            <input required type="text" name="usuario_modificar" value="<?php echo $link['usuario']?>" class="form-control" id="exampleInputPassword1">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                            <input required type="password" name="contrasena_modificar" value="<?php echo $link['contrasena']?>" class="form-control" id="exampleInputPassword1">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">CUI</label>
                          <input readonly type="number" name="cui_modificar" value="<?php echo $link['cui']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Nombre y Apellido</label>
                          <input required type="text" name="nombre_modificar" value="<?php echo $link['nombre_apellido']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label>Puestos</label>
                          <select name="puesto_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($puestos as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['codigo']?>"> <?php echo $link2['nombre']?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Fecha de Nacimiento</label>
                          <input required type="date" name="fecha_modificar" value="<?php echo $link['fecha_nacimiento']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Correo</label>
                          <input required type="email" name="correo_modificar" value="<?php echo $link['correo']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Teléfono</label>
                          <input required type="text" name="telefono_modificar" value="<?php echo $link['telefono']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Fin Modal Modificar -->


            </td>
          </tr>
          <?php } ?>
        </tbody>
    </table>
    <!-- Fin de la Tabla Puesto -->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
