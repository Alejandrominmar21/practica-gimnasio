<!doctype html>
<html lang="en">

<head>
  <title>Registro</title>

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

<body style="background-color:#FEFB2E;">
  <div style="width: 20%;"  class="form-signin">
    <div class="py-5 text-center">
      <h1>Registro</h1>
      <p class="lead">Registrate para poder acceder a la página web</p>
    </div>
    <form action="index.php?accion=adduser" method="post">
      <label for="email" class="sr-only">Email</label><input type="email" name="email" class="form-control" placeholder="Email" required autofocus>     
      <label for="nombre" class="sr-only">nombre</label><input type="nombre" name="nombre" class="form-control" placeholder="Nombre" required autofocus>
      <label for="apellidos" class="sr-only">apellidos</label><input type="user" name="apellidos" class="form-control" placeholder="Apellidos" required autofocus>
      <label for="direccion" class="sr-only">direccion</label><input type="direccion" name="direccion" class="form-control" placeholder="Direccion" required autofocus>
      <label for="nif" class="sr-only">nif</label><input type="nif" name="nif" class="form-control" placeholder="NIF" required autofocus>
      <label for="telefono" class="sr-only">Télefono</label><input type="telefono" name="telefono" class="form-control" placeholder="telefono" required autofocus>
      <label for="contraseña" class="sr-only">Contraseña</label><input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
      <button class="btn btn-lg btn-outline-dark btn-block" type="submit">Registrarse</button>
    </form>
    <hr>
    <footer class="container">
      <p class="mt-5 mb-3">Práctica DWEC - Alejandro Minchón Márquez</p>
    </footer>
  </div>



  <script src="form-validation.js"></script>
</body>

</html>