<!doctype html>
<html lang="en">

<head>
  <title>Nuevo tramo</title>

  <!-- Bootstrap core CSS -->
  <link href="Recursos/css/bootstrap.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="form-validation.css" rel="stylesheet">
  <link href="Recursos/css/login.css" rel="stylesheet">
</head>

<body style="background-color: lightsteelblue;">

    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Gimnasio</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/practica/index.php?accion=irinicio">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/practica/index.php?accion=Horario">Horario</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/practica/index.php?accion=listado">Usuarios</a>
          </li>
        </ul>
        <p class="text-right">
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav> -->
 
  <div style="width: 20%;"  class="form-signin justify-content-center" >
    <div class="py-5 text-center">
      <h1>Añadir tramo</h1>
    </div>
    <form action="index.php?accion=addtramo" method="post">
      <label for="dia" class="sr-only">Día</label><input type="user" name="dia" class="form-control" placeholder="dia" required autofocus>     
      <label for="horainicio" class="sr-only">Hora Inicio</label><input type="nombre" name="horainicio" class="form-control" placeholder="horainicio" required autofocus>
      <label for="horafin" class="sr-only">Hora fin</label><input type="user" name="horafin" class="form-control" placeholder="horafin" required autofocus>
      <label for="actividad_id" class="sr-only">Id de la atividad</label><input type="actividad_id" name="actividad_id" class="form-control" placeholder="actividad_id" required autofocus>
      <label for="fecha_alta" class="sr-only">fecha alta</label><input type="fecha_alta" name="fecha_alta" class="form-control" placeholder="fecha_alta" required autofocus>
      <label for="fecha_baja" class="sr-only">fecha baja</label><input type="fecha_baja" name="fecha_baja" class="form-control" placeholder="fecha_baja" required autofocus>
      <button class="btn btn-lg btn-outline-dark btn-block" type="submit">Añadir tramo</button>
    </form>
    <hr>
    <footer class="container">
      <p class="mt-5 mb-3">Práctica DWEC - Alejandro Minchón Márquez</p>
    </footer>
  </div>



  <script src="form-validation.js"></script>
</body>

</html>