<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Lote
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
if(isset($_POST['id_modificar']) && isset($_POST['fechaV_modificar'])){
  $id_modificar = $_POST['id_modificar'];
  $fechaP_modificar = $_POST['fechaP_modificar'];
  $fechaV_modificar = $_POST['fechaV_modificar'];
  $compra_modificar = $_POST['compra_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Lote
  SET
  fecha_produccion = :fecha_produccion,
  fecha_vencimiento = :fecha_vencimiento,
  compra = :compra
  WHERE
  id = :id;");
  $query_modificar->bindParam("id", $id_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("fecha_produccion", $fechaP_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("fecha_vencimiento", $fechaV_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("compra", $compra_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Lote Modificado Correctamente</span>';

}


//Insert para Agregar Nuevo Lote
if(isset($_POST['compra'])){
  $fecha_produccion = $_POST['fecha_produccion'];
  $fecha_vencimiento = $_POST['fecha_vencimiento'];
  $compra = $_POST['compra'];

  $query = $conn->prepare("INSERT INTO Lote (fecha_produccion, fecha_vencimiento, compra)
  VALUES (:fecha_produccion, :fecha_vencimiento, :compra);");
  $query->bindParam("fecha_produccion", $fecha_produccion, PDO::PARAM_STR);
  $query->bindParam("fecha_vencimiento", $fecha_vencimiento, PDO::PARAM_STR);
  $query->bindParam("compra", $compra, PDO::PARAM_INT);

  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  echo "<br> Lote Agregado Exitosamente";
}

//Select para la tabla de Lotes
$query = $conn->prepare("SELECT
L.id, L.fecha_produccion, L.fecha_vencimiento, L.compra, C.fecha as 'fecha_compra'
FROM
Lote L, Compra C
WHERE
L.compra = C.id
ORDER BY id ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para seleccionador de Compra
$query_compra = $conn->prepare("SELECT
id, fecha
FROM
Compra;");
$query_compra->execute();
$compras = $query_compra->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Lote</title>
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
        <div class="titulo"><h1>Lotes</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nuevo Lote
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Lote</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Fecha de Producción</label>
                <input type="date" name="fecha_produccion" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label> Compra </label>
                <select name="compra" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($compras as $row => $link){
                  ?>
                  <option value="<?php echo $link['id']?>">#<?php echo $link['id']?> (Fecha: <?php echo $link['fecha']?>) </option>
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
            <th>Fecha de Producción</th>
            <th>Fecha de Vencimiento</th>
            <th>Compra</th>
            <th>Fecha de Compra</th>
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
              <?php echo $link['fecha_produccion'] ?>
            </td>
            <td>
              <?php echo $link['fecha_vencimiento'] ?>
            </td>
            <td>
              <?php echo $link['compra'] ?>
            </td>
            <td>
              <?php echo $link['fecha_compra'] ?>
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
                      ¿Está seguro que desea eliminar el Lote: #<?php echo $link['id']?> con fecha de vencimiento: <?php echo $link['fecha_vencimiento']?>?
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
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Lote</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">ID</label>
                          <input readonly type="number" name="id_modificar" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Fecha de Producción</label>
                          <input required type="date" name="fechaP_modificar" value="<?php echo $link['fecha_produccion']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Fecha de Vencimiento</label>
                          <input required type="date" name="fechaV_modificar" value="<?php echo $link['fecha_vencimiento']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label> Compra </label>
                          <select name="compra_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($compras as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['id']?>">#<?php echo $link2['id']?> (Fecha: <?php echo $link2['fecha']?>) </option>
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
