<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login Gimnasio</title>

    

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
    <link href="Recursos/css/login.css" rel="stylesheet">
  </head>
  
  <body class="text-center" style="background-color: orangered">
  <div class="form-signin">
    <form  action="index.php?accion=inciarsesion" method="post">
  <!--<img class="mb-4" src="" alt="" width="72" height="72">-->
    <h1 class="h3 mb-3 font-weight-normal">Introduce tus datos</h1>
    <label for="email" class="sr-only">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email" required autofocus
      value="<?php if(isset($_COOKIE['email'])) {echo$_COOKIE['email']; }?>">
    <label for="contraseña" class="sr-only">Contraseña</label>
    <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required
      value="<?php if(isset($_COOKIE['contraseña'])) {echo$_COOKIE['contraseña']; }?>">
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" name="recordar" checked="on"> Recordar contraseña <br>
        <input type="checkbox" name="sesion" checked="on"> Mantener la sesión
      </label>
  </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Inciar sesión</button>  
  </form>
  <hr>
  <form  action="index.php?accion=registrarse" method="post">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Registrarse</button> 
  </form>
  <hr>
  <form  action="index.php?accion=iralinstalador" method="post">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Crear Base de datos</button> 
  </form>
  <p class="mt-5 mb-3">Práctica DWEC - Alejandro Minchón Márquez</p>
</div>


</body>
</html>
