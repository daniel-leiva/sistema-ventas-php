<?php
include('conexion.php');

//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Puesto
    WHERE
    codigo = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}

//Update para modificar los puestos
if(isset($_POST['nombre_modificar']) && isset($_POST['departamento_modificar'])){
  $codigo_modificar = $_POST['codigo_modificar'];
  $nombre_modificar = $_POST['nombre_modificar'];
  $departamento_modificar = $_POST['departamento_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Puesto
  SET
  nombre = :nombre, departamento = :departamento
  WHERE
  codigo = :codigo;");
  $query_modificar->bindParam("codigo", $codigo_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("nombre", $nombre_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("departamento", $departamento_modificar, PDO::PARAM_INT);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Puesto Modificado Correctamente</span>';

}

//Insert para agregar nuevo puesto
if (isset($_POST['nombre']) && isset($_POST['departamento'])){
  $nombre = $_POST['nombre'];
  $departamento = $_POST['departamento'];

  $inst = $conn->prepare("INSERT INTO Puesto (nombre, departamento)
  VALUES (:nombre, :departamento);");
  $inst->bindParam("nombre", $nombre, PDO::PARAM_STR);
  $inst->bindParam("departamento", $departamento, PDO::PARAM_INT);
  $inst->execute();

  echo '<br><span style="color:white;">Puesto Agregado Correctamente</span>';

}

//Select para la tabla de puestos
$query = $conn->prepare("SELECT
P.codigo as 'codigo', P.nombre as 'puesto', D.nombre as 'departamento'
FROM
Puesto P, Departamento D
WHERE
P.departamento = D.codigo
ORDER BY codigo ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);

//Select para el seleccionador de Departamentos
$query_departamento = $conn->prepare("SELECT
codigo, nombre
FROM
Departamento;");
$query_departamento->execute();
$departamentos = $query_departamento->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style2.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&family=Noto+Serif:wght@700&display=swap"
        rel="stylesheet">

    <title>Puesto</title>
</head>

<body>

    <!-- Inicio del Navbar Tabs Menú-->
    <ul class="nav nav-tabs" style="font-weight: bold;">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">INICIO</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="" role="button"
                aria-expanded="false">Empresa</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sucursal.php">Sucursal</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="departamentos.php">Departamento</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="puesto.php">Puesto</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="colaborador.php">Colaborador</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">Almacén</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="productos.php">Productos</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="lote.php">Lote</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
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
            <div class="titulo">
                <h1>Puestos</h1>
            </div>
        </div>
        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar Nuevo Puesto
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Puesto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label> Departamentos </label>
                            <select name="departamento" class="form-select" aria-label="Default select example">

                                <?php foreach ($departamentos as $row => $link){
                  ?>
                                <option value="<?php echo $link['codigo']?>"> <?php echo $link['nombre']?> </option>
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
                <th>Código</th>
                <th>Puesto</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($resultado as $row => $link){
          ?>
            <tr>
                <th>
                    <?php echo $link['codigo'] ?>
                </th>
                <td>
                    <?php echo $link['puesto'] ?>
                </td>
                <td>
                    <?php echo $link['departamento'] ?>
                </td>
                <td class="columna_acciones">
                    <!-- Botón Modal Eliminar-->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#modalEliminar<?php echo $link['codigo'] ?>">
                        Eliminar
                    </button>

                    <!-- Modal Eliminar -->
                    <div class="modal fade" id="modalEliminar<?php echo $link['codigo'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Está seguro que desea eliminar el puesto: <?php echo $link['puesto']?>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_eliminar" value="<?php echo $link['codigo']?>">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin del Modal Eliminar-->


                    <!-- Botón Modificar -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalModificar<?php echo $link['codigo']?>">
                        Modificar
                    </button>
                    </div>
                    </div>

                    <!-- Modal Modificar-->
                    <div class="modal fade" id="modalModificar<?php echo $link['codigo']?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Puesto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="" method="POST">
                                        <div>
                                            <label for="exampleInputPassword1" class="form-label">Código</label>
                                            <input readonly type="text" name="codigo_modificar"
                                                value="<?php echo $link['codigo']?>" class="form-control"
                                                id="exampleInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Nombre</label>
                                            <input required type="text" name="nombre_modificar"
                                                value="<?php echo $link['puesto']?>" class="form-control"
                                                id="exampleInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label> Departamentos </label>
                                            <select name="departamento_modificar" class="form-select"
                                                aria-label="Default select example">
                                                <?php foreach ($departamentos as $row => $link){
                            ?>
                                                <option required value="<?php echo $link['codigo']?>">
                                                    <?php echo $link['nombre']?> </option>
                                                <?php
                            }
                            ?>
                                            </select>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>