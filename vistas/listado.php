<html>
  <head>
    <?php require_once 'includes/head.php';  
          if(isset($_COOKIE['admin'])){
            if($_COOKIE['admin']==false){header("Location: index.php");}
          }else{header("Location: index.php");}  ?>
  </head>
  <body class="cuerpo" style="background-color:lightsteelblue">
  <header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Gimnasio</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php?accion=irinicio">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?accion=Horario">Horario</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?accion=listado">Usuarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?accion=mostraract">Actividades</a>
          </li>
        </ul>
        <p class="text-right"><?php echo$_COOKIE["correo"]. " " . $_COOKIE["inicio"]. " " /*echo$parametros["email"]. " " . date('h:i:s a', time()). " "*/ ?> 
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav>
    <header>
    <div class="container centrar" >   <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
        <tr>
          <th>id</th>
          <th>nif</th>
          <th>nombre</th>
          <th>apellidos</th>
          <th>email</th>
          <th>telefono</th>
          <th>direccion</th>
          <th>estado</th>
          <th>Operaciones</th>
        </tr>
        <!--Los datos a listar están almacenados en $parametros["datos"], que lo recibimos del controlador-->
        <?php foreach ($parametros["datos"] as $d) : ?>
          <!--Mostramos cada registro en una fila de la tabla-->
          <tr>  
          <td><?= $d["id"] ?></td>
            <td><?= $d["nif"] ?></td>
            <td><?= $d["nombre"] ?></td>
            <td><?= $d["apellidos"] ?></td>
            <td><?= $d["email"] ?></td>
            <td><?= $d["telefono"] ?></td>
            <td><?= $d["direccion"] ?></td>
            <td><?= $d["rol_id"] ?></td>              
            <td><a href="index.php?accion=actuser&id=<?= $d['id'] ?>">Editar </a><a href="index.php?accion=deluser&id=<?= $d['id'] ?>">Eliminar</a>
              <?php if($d["rol_id"]==1){echo"<a href='index.php?accion=activaruser&id=". $d['id'] ."'> Activar </a></td>";} ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </body>
</html>