<html>
  <head>
    <?php require_once 'includes/head.php';
      if(isset($_COOKIE['activado'])){//mandará a index.php a los usuarios no activados
        if($_COOKIE['activado']==false){header("Location: index.php");}
      }else{
        header("Location: index.php");
      }
    ?>
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
            <a class="nav-link" href="index.php?accion=irinicio">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?accion=Horario">Horario</a>
          </li>
        </ul>
        <p class="text-right"><?php echo$_COOKIE['correo']. " " . $_COOKIE['inicio']. " " ?> 
          <form  action="index.php?accion=cerrarsesion" method="post">
            <button class="btn-outline-dark" type="submit">Cerrar sesion</button> 
          </form></p>      
      </div>
    </nav>
    <header>
    <div class="container centrar">   <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
        <tr>
          <th>Hora</th>
          <th>Lunes</th>
          <th>Martes</th>
          <th>Miercoles</th>          
          <th>Jueves</th>
          <th>Viernes</th>
          <th>Sábado</th>
        </tr> 
       <?php 
          foreach ($horas as $hora) {
            echo" <tr> <th>". $hora ."</th>";
            foreach ($dias as $dia) {
              $resultado = $this->modelo->horariotramos($hora,$dia);
              if($resultado == "nada"){
                echo"<th> </th>";
              }else{
                $resultadoact = $this->modelo->buscaractividad($resultado["actividad_id"]);
                echo"<th>".$resultadoact["nombre"].                
                "</th>";
                
              }
            }
          }
          
       ?>

      </table>
    </div>
  </body>
</html>