<?php
include('conexion.php');


//Delete para acción de Eliminar
if (isset($_POST['id_eliminar'])){
  try{
    $id_eliminar = $_POST['id_eliminar'];
    $query_eliminar = $conn->prepare("DELETE FROM
    Tarea
    WHERE
    id = :id_eliminar");
    $query_eliminar->bindParam("id_eliminar", $id_eliminar, PDO::PARAM_INT);
    $query_eliminar->execute();
    echo '<br><span style="color:white;">Registro Eliminado Correctamente</span>';
  }catch (Exception $e) {
    echo '<br><span style="color:white;">Este dato está en uso, no puede ser eliminado</span>';
  }
}

//Update para modificar la Tarea
if(isset($_POST['id_modificar']) && isset($_POST['nombre_modificar'])){
  $id_modificar = $_POST['id_modificar'];
  $nombre_modificar = $_POST['nombre_modificar'];
  $colaborador_modificar = $_POST['colaborador_modificar'];
  $descripcion_modificar = $_POST['descripcion_modificar'];
  $fecha_modificar = $_POST['fecha_modificar'];

  $query_modificar = $conn->prepare("UPDATE
  Tarea
  SET
  nombre_tarea = :nombre_tarea,
  colaborador = :colaborador,
  descripcion = :descripcion,
  fecha_limite = :fecha_limite
  WHERE
  id = :id;");
  $query_modificar->bindParam("id", $id_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("nombre_tarea", $nombre_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("colaborador", $colaborador_modificar, PDO::PARAM_INT);
  $query_modificar->bindParam("descripcion", $descripcion_modificar, PDO::PARAM_STR);
  $query_modificar->bindParam("fecha_limite", $fecha_modificar, PDO::PARAM_STR);
  $query_modificar->execute();

  echo '<br><span style="color:white;">Tarea Modificada Correctamente</span>';

}



//Update para modificar el Estado Actual de la Tarea
if(isset($_POST['estado_modificarE'])){
  $id_modificarE = $_POST['id_modificarE'];
  $estado_modificarE = $_POST['estado_modificarE'];

  $query_modificar2 = $conn->prepare("UPDATE
  Tarea
  SET
  estado_tarea = :estado_modificarE
  WHERE
  id = :id_modificarE;");
  $query_modificar2->bindParam("id_modificarE", $id_modificarE, PDO::PARAM_INT);
  $query_modificar2->bindParam("estado_modificarE", $estado_modificarE, PDO::PARAM_INT);
  $query_modificar2->execute();


  echo '<br><span style="color:white;">Tarea Modificada Correctamente</span>';

}


//Insert para agregar nueva Tarea
if(isset($_POST['nombre_tarea']) && isset($_POST['colaborador'])){
    $nombre_tarea = $_POST['nombre_tarea'];
    $colaborador = $_POST['colaborador'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
    $estado_tarea = $_POST['estado_tarea'];

  
    $query = $conn->prepare("INSERT INTO Tarea (nombre_tarea, colaborador, descripcion, fecha_limite, estado_tarea)
    VALUES (:nombre_tarea, :colaborador, :descripcion, :fecha_limite, :estado_tarea);");
    $query->bindParam("nombre_tarea", $nombre_tarea, PDO::PARAM_STR);
    $query->bindParam("colaborador", $colaborador, PDO::PARAM_INT);
    $query->bindParam("descripcion", $descripcion, PDO::PARAM_STR);
    $query->bindParam("fecha_limite", $fecha_limite, PDO::PARAM_STR);
    $query->bindParam("estado_tarea", $estado_tarea, PDO::PARAM_INT);
    $query->execute();
    //$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
  
    echo '<br><span style="color:white;">Tarea Agregada Correctamente</span>';
  
}

//Select para la tabla de Tareas
$query = $conn->prepare("SELECT
T.id, T.nombre_tarea, C.nombre_apellido as colaborador, T.descripcion, T.fecha_limite, E.estado as estado_tarea
FROM
Tarea T, EstadoTarea E, Colaborador C
WHERE
T.estado_tarea = E.id AND T.colaborador = C.cui
ORDER BY id ASC;");
$query->execute();
$resultado = $query->fetchALL(PDO::FETCH_ASSOC);


//Select para selector de Colaboradores
$query_colaborador = $conn->prepare("SELECT
cui, nombre_apellido
FROM
Colaborador;");
$query_colaborador->execute();
$colaboradores = $query_colaborador->fetchAll(PDO::FETCH_ASSOC);

//Select para selector de Estado
$query_estado = $conn->prepare("SELECT
*
FROM
EstadoTarea;");
$query_estado->execute();
$estados_tarea = $query_estado->fetchAll(PDO::FETCH_ASSOC);


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
    
    <title>Tareas</title>
    
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
        <div class="titulo"><h1>Lista de Tareas</h1></div>
      </div>
    <div>


        <!-- Botón Agregar Nuevo -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        Agregar Nueva Tarea
      </button>
      </div>
    </div>

    <!-- Modal Agregar-->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Tarea</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form action="" method="POST">
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nombre</label>
                <input type="text" name="nombre_tarea" class="form-control" id="exampleInputPassword1">
              </div>
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
                <label for="exampleInputPassword1" class="form-label">Descripción</label>
                <textarea class="form-control" id="floatingTextarea" name="descripcion"></textarea>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Fecha Limite</label>
                <input required type="datetime-local" name="fecha_limite" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3">
                <input type="hidden" name="estado_tarea" value="1" class="form-control" id="exampleInputPassword1">
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
            <th>ID</th>
            <th>Nombre</th>
            <th>Colaborador</th>
            <th>Descripción</th>
            <th>Fecha Limite</th>
            <th>Estado</th>
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
              <?php echo $link['nombre_tarea'] ?>
            </td>
            <td>
              <?php echo $link['colaborador'] ?>
            </td>
            <td>
              <?php echo $link['descripcion'] ?>
            </td>
            <td>
              <?php echo $link['fecha_limite'] ?>
            </td>

            <?php
              if( $link['estado_tarea'] == 'Pendiente' ){
                  echo '<td style="color:red; font-weight:bold;">'.$link['estado_tarea'].'</td>';
              }elseif($link['estado_tarea'] == 'En ejecución' ){
                  echo '<td style="color:blue;font-weight:bold;">'.$link['estado_tarea'].'</td>';
              }elseif($link['estado_tarea'] == 'Completada'){
                  echo '<td style="color:green;font-weight:bold;">'.$link['estado_tarea'].'</td>';
              }
            ?>

            <td class="columna_acciones">



            
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                Acciones
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" style="text-align:center;">
                <li>
                <?php if( $link['estado_tarea'] == 'Pendiente'){ ?>
                  <!-- Botón Modal Eliminar-->
                  <button type="button" class="dropdown-item" style="background-color:#dc3545; color:white;height:40px;" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $link['id'] ?>">
                    Eliminar
                  </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <!-- Botón Modificar -->
                  <button type="button" class="dropdown-item" style="background-color: #0d6efd; color:white;height:40px;" data-bs-toggle="modal" data-bs-target="#modalModificar<?php echo $link['id']?>">
                      Modificar
                  </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <!-- Botón Iniciar -->
                  <button type="button" class="dropdown-item" style="background-color:#ffc107; color:black;height:40px;" data-bs-toggle="modal" data-bs-target="#modalEstadoIn<?php echo $link['id']?>">
                    Iniciar Tarea
                </button>
                </li>
                <?php } ?>

                <?php if( $link['estado_tarea'] == 'En ejecución'){ ?>
                  <li>
                  <button type="button" class="dropdown-item" style="background-color:198754; color:white; height:40px;" data-bs-toggle="modal" data-bs-target="#modalEstadoCom<?php echo $link['id']?>">
                    Marcar como Completada
                </button>
                </li>
                <?php } ?>
              </ul>
            </div>


              <!-- Modal Eliminar -->
              <div class="modal fade" id="modalEliminar<?php echo $link['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ¿Está seguro que desea eliminar la tarea: <?php echo $link['nombre_tarea']?>?
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

              <!-- Modal Modificar-->
              <div class="modal fade" id="modalModificar<?php echo $link['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modificar Tarea</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      
                      <form action="" method="POST">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">ID</label>
                          <input readonly type="number" name="id_modificar" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Nombre</label>
                          <input required type="text" name="nombre_modificar" value="<?php echo $link['nombre_tarea']?>" class="form-control" id="exampleInputPassword1">
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
                          <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                          <textarea class="form-control" name="descripcion_modificar" value="<?php echo $link['descripcion']?>" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Fecha Limite</label>
                          <input required type="datetime-local" name="fecha_modificar" value="<?php echo $link['fecha_limite']?>" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Estado</label>
                          <input readonly type="text" value="<?php echo $link['estado_tarea']?>" class="form-control" id="exampleInputEmail1">
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

              <!-- Modal Estado Iniciar -->
              <div class="modal fade" id="modalEstadoIn<?php echo $link['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Iniciar Tarea</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    ¿Desea iniciar la tarea #<?php echo $link['id']?>: <?php echo $link['nombre_tarea']?>?
                    <br><br>
                      <form action="" method="POST">
                      <div>
                        <input type="hidden" name="id_modificarE" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                      </div>
                      <button type="submit" name='estado_modificarE' value="2" class="btn btn-lg btn-warning">Iniciar Tarea</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin Modal Estado Iniciar-->

              <!-- Modal Estado Marcar Completada -->
              <div class="modal fade" id="modalEstadoCom<?php echo $link['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Marcar Tarea como Completada</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    ¿Desea marcar como completada la tarea #<?php echo $link['id']?>: <?php echo $link['nombre_tarea']?>?
                    <br><br>
                      <form action="" method="POST">
                      <div>
                        <input type="hidden" name="id_modificarE" value="<?php echo $link['id']?>" class="form-control" id="exampleInputEmail1">
                      </div>
                      <button type="submit" name='estado_modificarE' value="3" class="btn btn-lg btn-success">Marcar como Completada</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin Modal Estado Marcar Completada-->

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
