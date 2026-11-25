<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Producto
    WHERE
    codigo_barra = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}


//Update para modificar la sucursal
if(isset($_POST['codigo_modificar']) && isset($_POST['nombre_modificar'])){
  $codigo_modificar = $_POST['codigo_modificar'];
  $nombre_modificar = $_POST['nombre_modificar'];
  $marca_modificar = $_POST['marca_modificar'];
  $proveedor_modificar = $_POST['proveedor_modificar'];
  $precioC_modificar = $_POST['precioC_modificar'];
  $precioV_modificar = $_POST['precioV_modificar'];
  $lote_modificar = $_POST['lote_modificar'];
  $inventario_modificar = $_POST['inventario_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Producto
  SET
  nombre = :nombre,
  marca = :marca,
  proveedor = :proveedor,
  precio_compra = :precio_compra,
  precio_venta = :precio_venta,
  lote = :lote,
  inventario = :inventario
  WHERE
  codigo_barra = :codigo_barra;");
  $query_modificar->bindParam("codigo_barra", $codigo_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("nombre", $nombre_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("marca", $marca_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("proveedor", $proveedor_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("precio_compra", $precioC_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("precio_venta", $precioV_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("lote", $lote_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("inventario", $inventario_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Producto Modificado Correctamente</span>';

}


//Insert para agregar nuevo Producto
if(isset($_POST['codigo_barra'])){
  $codigo_barra = $_POST['codigo_barra'];
  $nombre = $_POST['nombre'];
  $marca = $_POST['marca'];
  $proveedor = $_POST['proveedor'];
  $precio_compra = $_POST['precio_compra'];
  $precio_venta = $_POST['precio_venta'];
  $lote = $_POST['lote'];
  $inventario = $_POST['inventario'];

  $query = $conn->prepare("INSERT INTO Producto (codigo_barra, nombre, marca, proveedor, precio_compra, precio_venta, lote, inventario)
  VALUES (:codigo_barra, :nombre, :marca, :proveedor, :precio_compra, :precio_venta, :lote, :inventario)");
  $query->bindParam("codigo_barra", $codigo_barra, PDO::PARAM_INT);
  $query->bindParam("nombre", $nombre, PDO::PARAM_STR);
  $query->bindParam("marca", $marca, PDO::PARAM_STR);
  $query->bindParam("proveedor", $proveedor, PDO::PARAM_INT);
  $query->bindParam("precio_compra", $precio_compra, PDO::PARAM_INT);
  $query->bindParam("precio_venta", $precio_venta, PDO::PARAM_INT);
  $query->bindParam("lote", $lote, PDO::PARAM_INT);
  $query->bindParam("inventario", $inventario, PDO::PARAM_INT);

  $query->execute();
  //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  echo "<br> Producto Agregado Exitosamente";
}

//Select para la tabla de Productos
$query = $conn->prepare("SELECT
P.codigo_barra, P.nombre, P.marca, P2.nombre as 'proveedor', P.precio_compra, P.precio_venta, P.lote, L.fecha_vencimiento, P.inventario
FROM
Producto P, Proveedor P2, Lote L
WHERE
P.proveedor = P2.nit AND P.lote = L.id
ORDER BY nombre ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para seleccionador de Proveedores
$query_proveedor = $conn->prepare("SELECT
nit, nombre
FROM
Proveedor;");
$query_proveedor->execute();
$proveedores = $query_proveedor->fetchAll(PDO::FETCH_ASSOC);

//Select para seleccionar Lote
$query_lote = $conn->prepare("SELECT
id, fecha_vencimiento
FROM
Lote;");
$query_lote->execute();
$lotes = $query_lote->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Productos</title>
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
        <div class="titulo"><h1>Productos</h1></div>
      </div>
      <div>
          <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar Nuevo Producto
      </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Código de barras</label>
                <input type="number" name="codigo_barra" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Marca</label>
                <input type="text" name="marca" class="form-control" id="exampleInputPassword1">
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
                <label for="exampleInputPassword1" class="form-label">Precio de Compra</label>
                <input type="number" step="0.01" name="precio_compra" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Precio de Ventas</label>
                <input type="number" step="0.01" name="precio_venta" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Lote</label>
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
                <label for="exampleInputPassword1" class="form-label">Inventario</label>
                <input type="number" name="inventario" class="form-control" id="exampleInputPassword1">
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
            <th>Código de barras</th>
            <th>Nombre</th>
            <th>Marca</th>
            <th>Proveedor</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Lote</th>
            <th>Fecha de Vencimiento</th>
            <th>Inventario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($resultado as $row => $link){
          ?>
          <tr>
            <th>
              <?php echo $link['codigo_barra'] ?>
            </th>
            <td>
              <?php echo $link['nombre'] ?>
            </td>
            <td>
              <?php echo $link['marca'] ?>
            </td>
            <td>
              <?php echo $link['proveedor'] ?>
            </td>
            <td>
              <?php echo $link['precio_compra'] ?>
            </td>
            <td>
              <?php echo $link['precio_venta'] ?>
            </td>
            <td>
              <?php echo $link['lote'] ?>
            </td>
            <td>
              <?php echo $link['fecha_vencimiento'] ?>
            </td>
            <td>
              <?php echo $link['inventario'] ?>
            </td>
            <td class="columna_acciones">

              <!-- Botón Modal Eliminar-->
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['codigo_barra'] ?>">
                Eliminar
              </button>

              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['codigo_barra'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar el producto: <?php echo $link['nombre']?>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <form action="" method="POST">
                        <input type="hidden" name="id_eliminar" value="<?php echo $link['codigo_barra']?>">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin del Modal Eliminar-->


              <!-- Botón Modificar -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['codigo_barra']?>">
                  Modificar
              </button>
                </div>
              </div>

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['codigo_barra']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Producto</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Código de Barras</label>
                          <input readonly type="number" name="codigo_modificar" value="<?php echo $link['codigo_barra']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Nombre</label>
                          <input required type="text" name="nombre_modificar" value="<?php echo $link['nombre']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Marca</label>
                          <input required type="text" name="marca_modificar" value="<?php echo $link['marca']?>" class="form-control" id="exampleInputPassword1">
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
                          <label for="exampleInputPassword1" class="form-label">Precio de Compra</label>
                          <input required type="number" step="0.01" name="precioC_modificar" value="<?php echo $link['precio_compra']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Precio de Venta</label>
                          <input required type="number" step="0.01" name="precioV_modificar" value="<?php echo $link['precio_venta']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Lote</label>
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
                          <label for="exampleInputPassword1" class="form-label">Inventario</label>
                          <input required type="number" name="inventario_modificar" value="<?php echo $link['inventario']?>" class="form-control" id="exampleInputPassword1">
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
