<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Devolucion
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
if(isset($_POST['id_modificar']) && isset($_POST['producto_modificar'])){
  $id_modificar = $_POST['id_modificar'];
  $producto_modificar = $_POST['producto_modificar'];
  $lote_modificar = $_POST['lote_modificar'];
  $tipo_modificar = $_POST['tipo_modificar'];
  $factura_modificar = $_POST['factura_modificar'];
  $cantidad_modificar = $_POST['cantidad_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Devolucion
  SET
  producto = :producto,
  lote = :lote,
  tipo = :tipo,
  factura = :factura,
  cantidad = :cantidad
  WHERE
  id = :id;");
  $query_modificar->bindParam("id", $id_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("producto", $producto_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("lote", $lote_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("tipo", $tipo_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("factura", $factura_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("cantidad", $cantidad_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Devolución Modificada Correctamente</span>';

}


//Insert para agregar nueva Devolución
if (isset($_POST['factura'])){
  $producto = $_POST['producto'];
  $lote = $_POST['lote'];
  $tipo = $_POST['tipo'];
  $factura = $_POST['factura'];
  $cantidad = $_POST['cantidad'];

  $query = $conn->prepare("INSERT INTO Devolucion (producto, lote, tipo, factura, cantidad)
  VALUES (:producto, :lote, :tipo, :factura, :cantidad);");
  $query->bindParam("producto", $producto, PDO::PARAM_INT);
  $query->bindParam("lote", $lote, PDO::PARAM_INT);
  $query->bindParam("tipo", $tipo, PDO::PARAM_STR);
  $query->bindParam("factura", $factura, PDO::PARAM_INT);
  $query->bindParam("cantidad", $cantidad, PDO::PARAM_INT);

  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  echo "<br> Devolución Agregada Exitosamente";

}

//Select para la tabla de Devoluciones
$query = $conn->prepare("SELECT
D.id, P.nombre as producto, D.lote, L.fecha_vencimiento, D.tipo, D.factura, V.fecha as fecha_venta, D.cantidad
FROM
Devolucion D, Venta V, Producto P, Lote L
WHERE
D.factura = V.id_venta AND D.producto = P.codigo_barra AND P.lote = L.id
ORDER BY id ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para selector de Productos
$query_producto = $conn->prepare("SELECT
codigo_barra, nombre
FROM
Producto;");
$query_producto->execute();
$productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

//Select para selector de Lote
$query_lote = $conn->prepare("SELECT
id, fecha_vencimiento
FROM
Lote;");
$query_lote->execute();
$lotes = $query_lote->fetchAll(PDO::FETCH_ASSOC);

//Select para selector de Factura(Venta)
$query_factura = $conn->prepare("SELECT
id_venta, fecha
FROM
Venta;");
$query_factura->execute();
$facturas = $query_factura->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Devoluciones</title>
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
        <div class="titulo"><h1>Devoluciones</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nueva Devolución
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Devolución</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">

              <div class="mb-3">
                <label>Producto</label>
                <select name="producto" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($productos as $row => $link){
                  ?>
                    <option value="<?php echo $link['codigo_barra']?>"> <?php echo $link['nombre']?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label>Lote</label>
                <select name="lote" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($lotes as $row => $link){
                  ?>
                    <option value="<?php echo $link['id']?>"> #<?php echo $link['id']?> (Vence: <?php echo $link['fecha_vencimiento']?>) </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Tipo de Devolución</label>
                <input type="text" name="tipo" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
              <label>Factura</label>
                <select name="factura" class="form-select" aria-label="Default select example">
                  
                  <?php foreach ($facturas as $row => $link){
                  ?>
                    <option value="<?php echo $link['id_venta']?>"> #<?php echo $link['id_venta']?> (Fecha: <?php echo $link['fecha']?>) </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" id="exampleInputPassword1">
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
            <th>Producto</th>
            <th>Lote</th>
            <th>Fecha de Vencimiento</th>
            <th>Tipo de Devolución</th>
            <th>Factura</th>
            <th>Fecha de la Venta</th>
            <th>Cantidad</th>
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
              <?php echo $link['producto'] ?>
            </td>
            <td>
              <?php echo $link['lote'] ?>
            </td>
            <td>
            <?php echo $link['fecha_vencimiento'] ?>
            </td>
            <td>
              <?php echo $link['tipo'] ?>
            </td>
            <td>
              <?php echo $link['factura'] ?>
            </td>
            <td>
              <?php echo $link['fecha_venta'] ?>
            </td>
            <td>
              <?php echo $link['cantidad'] ?>
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
                      ¿Está seguro que desea eliminar la devolución: #<?php echo $link['id']?> con fecha de venta: <?php echo $link['fecha_venta']?>?
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
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Devolución</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">ID</label>
                          <input readonly type="number" name="id_modificar" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Producto</label>
                          <select name="producto_modificar" class="form-select" aria-label="Default select example">
                          
                            <?php foreach ($productos as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['codigo_barra']?>"> <?php echo $link2['nombre']?> </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label>Lote</label>
                          <select name="lote_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($lotes as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['id']?>"> #<?php echo $link2['id']?> (Vence: <?php echo $link2['fecha_vencimiento']?>) </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Tipo</label>
                          <input required type="text" name="tipo_modificar" value="<?php echo $link['tipo']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label>Factura</label>
                          <select name="factura_modificar" class="form-select" aria-label="Default select example">
                            
                            <?php foreach ($facturas as $row => $link2){
                            ?>
                              <option value="<?php echo $link2['id_venta']?>"> #<?php echo $link2['id_venta']?> (Fecha: <?php echo $link2['fecha']?>) </option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Cantidad</label>
                          <input required type="text" name="cantidad_modificar" value="<?php echo $link['cantidad']?>" class="form-control" id="exampleInputPassword1">
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
