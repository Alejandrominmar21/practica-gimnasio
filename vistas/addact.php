<!doctype html>
<html lang="en">

<head>
<?php 
          if(isset($_COOKIE['admin'])){
            if($_COOKIE['admin']==false){header("Location: index.php");}
          }else{header("Location: index.php");}  ?>
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
      <h1>Añadir actividad</h1>
    </div>
    <div class="container centrar">   <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
    <form action="index.php?accion=addact" method="post">
      <label for="nombre" class="sr-only">Nombre</label><input type="user" name="nombre" class="form-control" placeholder="nombre" required autofocus>     
      <label for="descripcion" class="sr-only">Descripcion</label><input type="user" name="descripcion" class="form-control" placeholder="descripcion" required autofocus>
      <label for="aforo" class="sr-only">Aforo</label><input type="user" name="aforo" class="form-control" placeholder="aforos" required autofocus>
      <button class="btn btn-lg btn-outline-dark btn-block" type="submit">Añadir actividad</button>
    </form>
    <hr>
    <footer class="container">
      <p class="mt-5 mb-3">Práctica DWEC - Alejandro Minchón Márquez</p>
    </footer>
  </div>



  <script src="form-validation.js"></script>
</body>

</html>