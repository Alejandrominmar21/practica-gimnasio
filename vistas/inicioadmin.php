<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Gimnasio</title>

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
  <link href="Recursos/css/cover.css" rel="stylesheet">
</head>

<body class="text-center" style="background-image:url('Recursos/img/inicio.jpg');">
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
        <p class="text-right"><?php if(isset($_COOKIE["correo"]) && isset($_COOKIE["inicio"])){ echo$_COOKIE["correo"]. " " . $_COOKIE["inicio"]. " ";}
                      else if(isset($_POST["correo"])){ echo$_POST["correo"];} ?> 
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav>
  </header>

      <main role="main" class="inner cover">
        <h1 class="cover-heading">Bienvenido</h1>
        <p class="lead">Esta es la página de inicio del gimnasio de la práctica de DWES</p>
        <p class="lead">
          <a href="#" class="btn btn-lg btn-secondary">PDF</a>
        </p>
      </main>

      </footer>
      </div>
</body>

</html>