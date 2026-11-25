<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Sucursal
    WHERE
    registro_mercantil = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}

//Update para modificar la sucursal
if(isset($_POST['registro_modificar']) && isset($_POST['nombre_modificar'])){
  $registro_modificar = $_POST['registro_modificar'];
  $nombre_modificar = $_POST['nombre_modificar'];
  $direccion_modificar = $_POST['direccion_modificar'];
  $correo_modificar = $_POST['correo_modificar'];
  $telefono_modificar = $_POST['telefono_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Sucursal
  SET
  nombre = :nombre,
  direccion = :direccion,
  correo = :correo,
  telefono = :telefono
  WHERE
  registro_mercantil = :registro_mercantil;");
  $query_modificar->bindParam("registro_mercantil", $registro_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("nombre", $nombre_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("direccion", $direccion_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("correo", $correo_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("telefono", $telefono_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Sucursal Modificada Correctamente</span>';

}


//Insert para agregar nueva Sucursal
if(isset($_POST['registro_mercantil'])){
  $registro_mercantil = $_POST['registro_mercantil'];
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];

  $query = $conn->prepare("INSERT INTO Sucursal (registro_mercantil, nombre, direccion, correo, telefono)
  VALUES (:registro_mercantil, :nombre, :direccion, :correo, :telefono);");
  $query->bindParam("registro_mercantil", $registro_mercantil, PDO::PARAM_STR);
  $query->bindParam("nombre", $nombre, PDO::PARAM_STR);
  $query->bindParam("direccion", $direccion, PDO::PARAM_STR);
  $query->bindParam("correo", $correo, PDO::PARAM_STR);
  $query->bindParam("telefono", $telefono, PDO::PARAM_STR);
  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

  echo '<br><span style="color:white;">Sucursal Agregada Correctamente</span>';

}

//Select para la tabla de Sucursales
$query = $conn->prepare("SELECT
*
FROM
Sucursal
ORDER BY nombre ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

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
    
    <title>Sucursal</title>
    
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
  

    <div>
      <div class="container_titulo">
        <div class="titulo"><h1>Sucursal</h1></div>
      </div>
    <div>

    <!-- Botón Agregar Nuevo -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nueva Sucursal
      </button>


    <!-- Modal Agregar-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Sucursal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Registro Mercantil</label>
                <input type="number" name="registro_mercantil" class="form-control" id="exampleInputEmail1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="exampleInputPassword1">
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
    <!-- Fin Modal Agregar -->


    <!-- Inicio de la Tabla Puesto -->
    <table class="table table-striped table-light">
        <thead>
          <tr>
            <th>Registro Mercantil</th>
            <th>Nombre</th>
            <th>Dirección</th>
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
              <?php echo $link['registro_mercantil'] ?>
            </th>
            <td>
              <?php echo $link['nombre'] ?>
            </td>
            <td>
              <?php echo $link['direccion'] ?>
            </td>
            <td>
              <?php echo $link['correo'] ?>
            </td>
            <td>
              <?php echo $link['telefono'] ?>
            </td>
            <td class="columna_acciones">
              
              <!-- Botón Modal Eliminar-->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['registro_mercantil'] ?>">
                Eliminar
              </button>

              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['registro_mercantil'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar la sucursal: <?php echo $link['nombre']?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <form action="" method="POST">
                        <input type="hidden" name="id_eliminar" value="<?php echo $link['registro_mercantil']?>">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del Modal Eliminar-->


              <!-- Botón Modificar -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['registro_mercantil']?>">
                  Modificar
              </button>
                

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['registro_mercantil']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Sucursal</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Registro Mercantil</label>
                          <input readonly type="number" name="registro_modificar" value="<?php echo $link['registro_mercantil']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Nombre</label>
                          <input required type="text" name="nombre_modificar" value="<?php echo $link['nombre']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Dirección</label>
                          <input required type="text" name="direccion_modificar" value="<?php echo $link['direccion']?>" class="form-control" id="exampleInputPassword1">
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
