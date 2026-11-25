<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Venta
    WHERE
    id_venta = :id_eliminar");
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
  $fecha_modificar = $_POST['fecha_modificar'];
  $total_modificar = $_POST['total_modificar'];
  $sucursal_modificar = $_POST['sucursal_modificar'];
  $cliente_modificar = $_POST['cliente_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Venta
  SET
  colaborador = :colaborador,
  fecha = :fecha,
  total = :total,
  sucursal = :sucursal,
  cliente = :cliente
  WHERE
  id_venta = :id_venta;");
  $query_modificar->bindParam("id_venta", $id_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("colaborador", $colaborador_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("fecha", $fecha_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("total", $total_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("sucursal", $sucursal_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("cliente", $cliente_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Venta Modificada Correctamente</span>';

}


//Insert para ingresar nueva Venta
if (isset($_POST['colaborador'])){
  $colaborador = $_POST['colaborador'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];
  $sucursal = $_POST['sucursal'];
  $cliente = $_POST['cliente'];

  $query = $conn->prepare("INSERT INTO Venta (colaborador, fecha, total, sucursal, cliente)
  VALUES (:colaborador, :fecha, :total, :sucursal, :cliente);");
  $query->bindParam("colaborador", $colaborador, PDO::PARAM_INT);
  $query->bindParam("fecha", $fecha, PDO::PARAM_STR);
  $query->bindParam("total", $total, PDO::PARAM_INT);
  $query->bindParam("sucursal", $sucursal, PDO::PARAM_INT);
  $query->bindParam("cliente", $cliente, PDO::PARAM_INT);

  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  echo "<br> Venta Agregada Exitosamente";

}

//Select para la tabla de Ventas
$query = $conn->prepare("SELECT
V.id_venta, C.nombre_apellido as 'colaborador', V.fecha, V.total, S.nombre as 'sucursal', C2.nombre as 'nom_cliente', C2.apellido as 'ap_cliente'
FROM 
Venta V, Colaborador C, Sucursal S, Cliente C2
WHERE
V.colaborador = C.cui AND V.sucursal = S.registro_mercantil AND V.cliente = C2.nit
ORDER BY id_venta ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para selector de Colaboradores
$query_colaborador = $conn->prepare("SELECT
cui, nombre_apellido
FROM
Colaborador;");
$query_colaborador->execute();
$colaboradores = $query_colaborador->fetchAll(PDO::FETCH_ASSOC);

//Select para el selector de Sucursal
$query_sucursal = $conn->prepare("SELECT
registro_mercantil, nombre
FROM
Sucursal;");
$query_sucursal->execute();
$sucursales = $query_sucursal->fetchAll(PDO::FETCH_ASSOC);

//Select para el selector de Cliente
$query_cliente = $conn->prepare("SELECT
nit, nombre, apellido
FROM
Cliente;");
$query_cliente->execute();
$clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Ventas</title>
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
        <div class="titulo"><h1>Ventas</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nueva Venta
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Venta</h5>
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
                <label for="exampleInputPassword1" class="form-label">Fecha</label>
                <input type="datetime-local" name="fecha" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Total</label>
                <input type="number" step="0.01" name="total" class="form-control" id="exampleInputPassword1">
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
                <label>Cliente</label>
                <select name="cliente" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($clientes as $row => $link){
                  ?>
                    <option value="<?php echo $link['nit']?>"> <?php echo $link['nombre']?> <?php echo $link['apellido']?> </option>
                  <?php
                  }
                  ?>
                </select>
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
            <th>Fecha</th>
            <th>Total</th>
            <th>Sucursal</th>
            <th>Cliente</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($resultado as $row => $link){
          ?>
          <tr>
            <th>
              <?php echo $link['id_venta'] ?>
            </th>
            <td>
              <?php echo $link['colaborador'] ?>
            </td>
            <td>
              <?php echo $link['fecha'] ?>
            </td>
            <td>
              <?php echo $link['total'] ?>
            </td>
            <td>
              <?php echo $link['sucursal'] ?>
            </td>
            <td>
              <?php echo $link['nom_cliente'] ?> <?php echo $link['ap_cliente']?> 
            </td>
            <td class="columna_acciones">

              <!-- Botón Modal Eliminar-->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['id_venta'] ?>">
                Eliminar
              </button>

              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['id_venta'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar la venta: #<?php echo $link['id_venta']?> con fecha: <?php echo $link['fecha']?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <form action="" method="POST">
                        <input type="hidden" name="id_eliminar" value="<?php echo $link['id_venta']?>">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del Modal Eliminar-->


              <!-- Botón Modificar -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['id_venta']?>">
                  Modificar
              </button>
                </div>
              </div>

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['id_venta']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Venta</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">ID</label>
                          <input readonly type="number" name="id_modificar" value="<?php echo $link['id_venta']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label> Colaborador </label>
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
                          <label for="exampleInputPassword1" class="form-label">Fecha</label>
                          <input required type="datetime-local" name="fecha_modificar" value="<?php echo $link['fecha']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Total</label>
                          <input required type="number" step="0.01" name="total_modificar" value="<?php echo $link['total']?>" class="form-control" id="exampleInputPassword1">
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
                          <label>Cliente</label>
                          <select name="cliente_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($clientes as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['nit']?>"> <?php echo $link2['nombre']?> <?php echo $link2['apellido']?> </option>
                            <?php
                            }
                            ?>
                          </select>
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
