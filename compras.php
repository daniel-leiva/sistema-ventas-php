<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Compra
    WHERE
    id = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}


//Update para modificar la sucursal
if(isset($_POST['id_modificar']) && isset($_POST['colaborador_modificar'])){
  $id_modificar = $_POST['id_modificar'];
  $colaborador_modificar = $_POST['colaborador_modificar'];
  $proveedor_modificar = $_POST['proveedor_modificar'];
  $sucursal_modificar = $_POST['sucursal_modificar'];
  $fecha_modificar = $_POST['fecha_modificar'];
  $total_modificar = $_POST['total_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Compra
  SET
  colaborador = :colaborador,
  proveedor = :proveedor,
  sucursal = :sucursal,
  fecha = :fecha,
  total = :total
  WHERE
  id = :id;");
  $query_modificar->bindParam("id", $id_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("colaborador", $colaborador_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("proveedor", $proveedor_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("sucursal", $sucursal_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("fecha", $fecha_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("total", $total_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Compra Modificada Correctamente</span>';

}


//Insert para agregar nueva Compra
if (isset($_POST['colaborador'])){
  $colaborador = $_POST['colaborador'];
  $proveedor = $_POST['proveedor'];
  $sucursal = $_POST['sucursal'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];

  $query = $conn->prepare("INSERT INTO Compra (colaborador, proveedor, sucursal, fecha, total)
  VALUES (:colaborador, :proveedor, :sucursal, :fecha, :total);");
  $query->bindParam("colaborador", $colaborador, PDO::PARAM_INT);
  $query->bindParam("proveedor", $proveedor, PDO::PARAM_INT);
  $query->bindParam("sucursal", $sucursal, PDO::PARAM_INT);
  $query->bindParam("fecha", $fecha, PDO::PARAM_STR);
  $query->bindParam("total", $total, PDO::PARAM_INT);

  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  echo "<br> Compra Agregada Exitosamente";

}

//Select para la tabla de Compras
$query = $conn->prepare("SELECT
C.id, C2.nombre_apellido as 'colaborador', P.nombre as 'proveedor', S.nombre as 'sucursal', C.fecha, C.total
FROM
Compra C, Colaborador C2, Proveedor P, Sucursal S
WHERE
C.colaborador = C2.cui AND C.proveedor = P.nit AND C.sucursal = S.registro_mercantil
ORDER BY id ASC");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para el selector de Colaboradores
$query_colaborador = $conn->prepare("SELECT
cui, nombre_apellido
FROM
Colaborador;");
$query_colaborador->execute();
$colaboradores = $query_colaborador->fetchAll(PDO::FETCH_ASSOC);

//Selecto para el selector de Proveedores
$query_proveedor = $conn->prepare("SELECT
nit, nombre
FROM
Proveedor;");
$query_proveedor->execute();
$proveedores = $query_proveedor->fetchAll(PDO::FETCH_ASSOC);

//Select para selector de Sucursales
$query_sucursal = $conn->prepare("SELECT
registro_mercantil, nombre
FROM
Sucursal;");
$query_sucursal->execute();
$sucursales = $query_sucursal->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Compras</title>
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
        <div class="titulo"><h1>Compras</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nueva Compra
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Compra</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
              <div class="mb-3">
                <label>Colaborador</label>
                <select name="colaborador" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($colaboradores as $row => $link){
                  ?>
                    <option value="<?php echo $link['cui']?>"> <?php echo $link['nombre_apellido']?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label>Proveedor</label>
                <select name="proveedor" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($proveedores as $row => $link){
                  ?>
                    <option value="<?php echo $link['nit']?>"> <?php echo $link['nombre']?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
              <label>Sucursal</label>
                <select name="sucursal" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($sucursales as $row => $link){
                  ?>
                    <option value="<?php echo $link['registro_mercantil']?>"> <?php echo $link['nombre']?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Fecha</label>
                <input type="datetime-local" name="fecha" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Total</label>
                <input type="number" step="0.01" name="total" class="form-control" id="exampleInputPassword1">
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
            <th>ID</th>
            <th>Colaborador</th>
            <th>Proveedor</th>
            <th>Sucursal</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($resultado as $row => $link){
          ?>
          <tr>
            <th>
              <?php echo $link['id'] ?>
            </th>
            <td>
              <?php echo $link['colaborador'] ?>
            </td>
            <td>
              <?php echo $link['proveedor'] ?>
            </td>
            <td>
              <?php echo $link['sucursal'] ?>
            </td>
            <td>
              <?php echo $link['fecha'] ?>
            </td>
            <td>
              <?php echo $link['total'] ?>
            </td>
            <td class="columna_acciones">

              <!-- Botón Modal Eliminar-->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['id'] ?>">
                Eliminar
              </button>

              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar la compra: #<?php echo $link['id']?> con fecha: <?php echo $link['fecha']?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <form action="" method="POST">
                        <input type="hidden" name="id_eliminar" value="<?php echo $link['id']?>">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del Modal Eliminar-->


              <!-- Botón Modificar -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['id']?>">
                  Modificar
              </button>
                </div>
              </div>

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Compra</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">ID</label>
                          <input readonly type="number" name="id_modificar" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label>Colaborador</label>
                          <select name="colaborador_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($colaboradores as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['cui']?>"> <?php echo $link2['nombre_apellido']?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label>Proveedor</label>
                          <select name="proveedor_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($proveedores as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['nit']?>"> <?php echo $link2['nombre']?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label>Sucursal</label>
                          <select name="sucursal_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($sucursales as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['registro_mercantil']?>"> <?php echo $link2['nombre']?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Fecha</label>
                          <input required type="date" name="fecha_modificar" value="<?php echo $link['fecha']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Total</label>
                          <input required type="number" step="0.01" name="total_modificar" value="<?php echo $link['total']?>" class="form-control" id="exampleInputPassword1">
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
