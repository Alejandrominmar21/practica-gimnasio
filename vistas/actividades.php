<html>
  <head>
    <?php require_once 'includes/head.php' ?>
  </head>
  <body class="cuerpo" style="background-color:lightsteelblue">
  <header>
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
        <p class="text-right"><?php echo$_COOKIE["correo"]. " " . $_COOKIE["inicio"]. " "  ?> 
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav>
  </header>
  <form action="index.php?accion=iraddact" method="post"> <button class="btn-outline-dark" type="submit">Añadir actividad</button> </form> 
    <div class="container centrar">   <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
        <tr>
          <th>id</th>
          <th>nombre</th>
          <th>descripcion</th>
          <th>aforo</th>          
        </tr> 
        <?php foreach ($parametros["datos"] as $d) : ?>
          <!--Mostramos cada registro en una fila de la tabla-->
         
          <tr>  
          <td><?= $d["id"] ?></td>
            <td><?= $d["nombre"] ?></td>
            <td><?= $d["descripcion"] ?></td>
            <td><?= $d["aforo"] ?></td>            
            <td><a href="index.php?accion=actact&id=<?= $d['id'] ?>">Editar </a><a href="index.php?accion=delact&id=<?= $d['id'] ?>">Eliminar</a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </body>
</html>