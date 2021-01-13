<!DOCTYPE html>
<html>
  <head>
    <?php require_once 'includes/head.php'; ?>
  </head>
  <body class="cuerpo">
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
        <p class="text-right"><?php echo$_COOKIE["correo"]. " " . $_COOKIE["inicio"]. " " ?> 
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav>
    <header>
    <div class="container centrar">      
        <p  class="text-center"><h2>Actualizar actividad</h2> </p>
      </div>
      <?php // Mostramos los mensajes procedentes del controlador que se hayn generado
            foreach ($parametros["mensajes"] as $mensaje) : ?> 
             <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
      <?php endforeach; ?>
      <form action="index.php?accion=actact" method="post" enctype="multipart/form-data" class="text-center">
        <!-- Rellenamos los campos con los valores recibidos desde el controlador -->
        <label for="nombre">Nombre
          <input type="nombre" class="form-control" name="nombre" value="<?= $parametros["datos"]["nombre"] ?>" required></label>
        <br/> 
        <label for="descripcion">Descripcion
          <input type="text" class="form-control" name="descripcion" value="<?= $parametros["datos"]["descripcion"] ?>" required></label>
        <br/> 
        <label for="aforo">Aforo
          <input type="text" class="form-control" name="aforo" value="<?= $parametros["datos"]["aforo"] ?>" required></label>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <br/>
        <input type="submit" value="Actualizar" name="submit" class="btn btn-success">
      </form>
    </div>
  </body>
</html>