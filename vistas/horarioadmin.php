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
  </header>
  <form action="index.php?accion=iraddtramo" method="post"> <button class="btn-outline-dark" type="submit">Añadir tramo</button> </form> 
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
        <!--mira listado.php para seguir-->
        
       <?php 
          foreach ($horas as $hora) {
            echo" <tr> <th>". $hora ."</th>";
            foreach ($dias as $dia) {
              $resultado = $this->modelo->horariotramos($hora,$dia);
              if($resultado == "nada"){
                echo"<th> </th>";
              }else{
                $resultadoact = $this->modelo->buscaractividad($resultado["actividad_id"]);
                $id = $resultado["id"];
                echo"<th>".$resultadoact["nombre"].
                    "<a href='index.php?accion=acttramo&id=". $id ."'><img width='15' height='15' src='Recursos/img/boligrafo.png'> </a><a href='index.php?accion=deltramo&id=". $id ."'><img width='15' height='15' src='Recursos/img/eliminar.png'></a></th>";               
              }
            }
          }
       ?>

      </table>
    </div>
  </body>
</html>