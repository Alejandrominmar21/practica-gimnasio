<?php

/**
 * Incluimos el modelo para poder acceder a su clase y a los métodos que implementa
 */
require_once 'modelos/modelo.php';

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización
 */
class controlador
{

  // El atributo $modelo es de la 'clase modelo' y será a través del que podremos 
  // acceder a los datos y las operaciones de la base de datos desde el controlador
  private $modelo;
  //$mensajes se utiliza para almacenar los mensajes generados en las tareas, 
  //que serán posteriormente transmitidos a la vista para su visualización
  private $mensajes;
  private $datos;
  /**
   * Constructor que crea automáticamente un objeto modelo en el controlador e
   * inicializa los mensajes a vacío
   */
  public function __construct()
  {
    $this->modelo = new modelo();
    $this->mensajes = [];
    $this->datos = [];
  }

  /**
   * Método que envía al usuario a la página de inicio del sitio y le asigna 
   * el título de manera dinámica
   */
  public function index()
  {
    $parametros = [
      "tituloventana" => "Login"
    ];
    //Mostramos la página de inicio
    
    include_once 'vistas/login.php';
  }
  
  
  public function inciarsesion(){
      if (isset($_POST['email']) && isset($_POST['contraseña'])) {
        $resultadologin = $this->modelo->login();
        session_start();
        $_SESSION['logueado']=$_POST['email'];
        $_SESSION['usuario']= $_POST['email'];
        if(isset($_POST["recordar"]) && ($_POST["recordar"]=="on")){
          setcookie('email',$_POST['email'],time() + (15 * 24 * 60 * 60));
          setcookie('contraseña',$_POST['contraseña'],time() + (15 * 24 * 60 * 60));
        }else{ //Si no está seleccionado el checkbox..
            // Eliminamos las cookies
            if(isset($_COOKIE['email'])){
              setcookie('email',""); 
            }
            if(isset($_COOKIE['contraseña'])){
              setcookie('contraseña',""); 
            }          
        }
        if(isset($_POST["sesion"])&&($_POST["sesion"]=="on")){ // Si está seleccionado el checkbox...
          // Creamos una cookie para la sesión
          setcookie("sesion",$_POST['email'],time() + (15* 24 * 60 * 60));
        } else { //Si no está seleccionado el checkbox..
          // Eliminamosla cookie
          if(isset($_COOKIE["sesion"])){
          setcookie("sesion",""); }
        }

        
        if ($resultadologin != 0) {
          setcookie("correo",$_POST['email'],0);//estas cookies las usaré para mantener los datos entre las diferentes páginas
          $inicio = date('h:i:s a', time());
          setcookie("inicio", $inicio,0);
          $admin = $this->modelo->esadmin();
          if($admin==true){
            setcookie("admin", true,0);
            include_once 'vistas/inicioadmin.php';
          }else{
            setcookie("admin", false,0);
            include_once 'vistas/inicio.php';
          }
         
        } else {        
          $this->index();   //Redirigimos a la página de inicio 
        }
      } else {
        $mensaje =  "Nombre de usuario o contraseña invalida!";
      }
    
  } //Fin de iniciar sesion

  public function irinicio(){
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo'])){
      if(isset($_COOKIE['admin']) && $_COOKIE['admin']==true){
        include_once 'vistas/inicioadmin.php';
      }else{
        include_once 'vistas/inicio.php';
      }
    }    
    else{header("Location: index.php");}
  }
  public function registrarse(){
      include_once 'vistas/registro.php';
  }
  public function iralinstalador(){
    include_once 'instalar/principal.php';
}

  public function iraddtramo(){
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo'])){
      if(isset($_COOKIE['admin']) && $_COOKIE['admin']==true){
        include_once 'vistas/addtramo.php';
      }else{
        include_once 'vistas/inicio.php';
      }
    }    
    else{header("Location: index.php");}
  }

  public function iraddact(){
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo'])){
      if(isset($_COOKIE['admin']) && $_COOKIE['admin']==true){
        include_once 'vistas/addact.php';
      }else{
        include_once 'vistas/inicio.php';
      }
    }    
    else{header("Location: index.php");}
  }


  public function horario(){
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo'])){
      if(isset($_COOKIE['admin']) && $_COOKIE['admin']==true){
        $dias = ["lunes","martes","miercoles","jueves","viernes","sabado"];
        $horas = ["07:00", "07:30", "08:00", "08:30", "09:00", "09:30",  "10:00", "10:30",  "11:00", "11:30",  "12:00", "12:30",  "13:00", "13:30",  "14:00", "14:30",
        "15:00", "15:30",  "16:00", "17:30",  "18:00", "18:30",  "19:00", "19:30",  "20:00", "20:30",  "21:00", "21:30", "22:00", "22:30"];
        include_once 'vistas/horarioadmin.php';
      }else{
        $dias = ["lunes","martes","miercoles","jueves","viernes","sabado"];
        $horas = ["07:00", "07:30", "08:00", "08:30", "09:00", "09:30",  "10:00", "10:30",  "11:00", "11:30",  "12:00", "12:30",  "13:00", "13:30",  "14:00", "14:30",
        "15:00", "15:30",  "16:00", "17:30",  "18:00", "18:30",  "19:00", "19:30",  "20:00", "20:30",  "21:00", "21:30", "22:00", "22:30"];
        include_once 'vistas/Horario.php';
      }
    }    
    else{header("Location: index.php");}
    
  }
  public function deltramo()
  {
    // verificamos que hemos recibido los parámetros desde la vista de listado 
    if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
      $id = $_GET["id"];
      //Realizamos la operación de suprimir el usuario con el id=$id
      $resultModelo = $this->modelo->deltramo($id);
      //Analizamos el valor devuelto por el modelo para definir el mensaje a 
      //mostrar en la vista listado
      if ($resultModelo["correcto"]) :
        $this->mensajes[] = [
          "tipo" => "success",
          "mensaje" => "Se eliminó correctamente el tramo $id"
        ];
      else :
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "La eliminación del tramo no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
        ];
      endif;
    } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
      $this->mensajes[] = [
        "tipo" => "danger",
        "mensaje" => "No se pudo acceder al id del tramo a eliminar!! :("
      ];
    }
    //Relizamos el listado de los usuarios
    $this->horario();
  }

  public function acttramo()
  {
    // Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
    // Inicializamos valores de los campos de texto
    $valdia = "";
    $valhorainicio= "";
    $valhorafin = "";
    $valactividad_id= "";
    $valfecha_alta= "";
    $valfecha_baja = "";

    // Si se ha pulsado el botón actualizar...
    if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
      $id = $_POST['id']; //Lo recibimos por el campo oculto
      $nuevodia = $_POST['dia'];
      $nuevahorainicio = $_POST['horainicio'];
      $nuevahorafin = $_POST['horafin'];
      $nuevaactividad_id = $_POST['actividad_id'];
      $nuevafecha_alta = $_POST['fecha_alta'];
      $nuevofecha_baja = $_POST['fecha_baja'];

      

            
      if (count($errores) == 0) {
        //Ejecutamos la instrucción de actualización a la que le pasamos los valores
        $resultModelo = $this->modelo->acttramo([
          'id' => $id,
          'dia' => $nuevodia,
          'horainicio' => $nuevahorainicio,
          'horafin' => $nuevahorafin,
          'actividad_id' => $nuevaactividad_id,
          'fecha_alta' => $nuevafecha_alta,
          'fecha_baja' => $nuevofecha_baja
        ]);
        //Analizamos cómo finalizó la operación de registro y generamos un mensaje
        //indicativo del estado correspondiente
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "El tramo se actualizó correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El tramo no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "Datos de registro de tramo erróneos!! :("
        ];
      }

      // Obtenemos los valores para mostrarlos en los campos del formulario
      $valdia = $nuevodia;
      $valhorainicio= $nuevahorainicio;
      $valhorafin = $nuevahorafin;
      $valactividad_id= $nuevaactividad_id;
      $valfecha_alta= $nuevafecha_alta;
      $valfecha_baja =  $nuevofecha_baja;
      
    } else { //Estamos rellenando los campos con los valores recibidos del listado
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->listatramo($id);
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Los datos del tramo se obtuvieron correctamente!! :)"
          ];
          $valdia = $resultModelo["datos"]["dia"];
          $valhorainicio = $resultModelo["datos"]["horainicio"];
          $valhorafin = $resultModelo["datos"]["horafin"];
          $valactividad_id = $resultModelo["datos"]["actividad_id"];
          $valfecha_alta = $resultModelo["datos"]["fecha_alta"];
          $valfecha_baja = $resultModelo["datos"]["fecha_baja"];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudieron obtener los datos de tramo!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
    }
    //Preparamos un array con todos los valores que tendremos que rellenar en
    //la vista adduser: título de la página y campos del formulario
    $parametros = [
      "tituloventana" => "Base de Datos con PHP y PDO",
      "datos" => [
        'id' => $id,
          'dia' => $valdia,
          'horainicio' => $valhorainicio,
          'horafin' => $valhorafin,
          'actividad_id' => $valactividad_id,
          'fecha_alta' => $valfecha_alta,
          'fecha_baja' => $valfecha_baja
      ],
      "mensajes" => $this->mensajes
    ];
    //Mostramos la vista actuser
    include_once 'vistas/acttramo.php';
  }

  public function addtramo()
  {
    if (isset($_POST["dia"]) &&isset($_POST["horainicio"]) &&isset($_POST["horafin"]) &&isset($_POST["actividad_id"]) &&isset($_POST["fecha_alta"]) &&isset($_POST["fecha_baja"])) {      
      $dia = $_POST['dia'];
      $horainicio = $_POST['horainicio'];
      $horafin = $_POST['horafin'];
      $actividad_id = $_POST['actividad_id'];
      $fecha_alta = $_POST['fecha_alta'];
      $fecha_alta = $_POST['fecha_baja'];
      
        $resultModelo = $this->modelo->addtramo([
          'dia' => $dia,
          'horainicio' => $horainicio,
          'horafin' => $horafin,
          'actividad_id' => $actividad_id,
          'fecha_alta' => $fecha_alta,
          'fecha_baja' => $fecha_alta
        ]);
        if ($resultModelo["correcto"]) :
          $this->horario();
        else :
         echo$resultModelo["error"];
          
        endif;      
    }
    $this->horario();
  }

  public function cerrarsesion(){
    session_start(); // Activamos el uso de sesiones
    session_unset(); // Libera todas las variables de sesión
    session_destroy(); // Destruimos la sesión
    header("Location: index.php"); //Redirigimos a la página de Login
  }

  /**
   * Método que obtiene de la base de datos el listado de usuarios y envía dicha
   * infomación a la vista correspondiente para su visualización
   */
  public function listado()
  {
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo']) && isset($_COOKIE['admin'])){
      if($_COOKIE['admin']==true){
        //include_once 'vistas/inicio.php';      
        // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
        $parametros = [
          "tituloventana" => "Base de Datos con PHP y PDO",
          "datos" => NULL,
          "mensajes" => []
        ];
        // Realizamos la consulta y almacenamos los resultados en la variable $resultModelo
        $resultModelo = $this->modelo->listado();
        // Si la consulta se realizó correctamente transferimos los datos obtenidos
        // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
        // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
        if ($resultModelo["correcto"]) :
          $parametros["datos"] = $resultModelo["datos"];
          //Definimos el mensaje para el alert de la vista de que todo fue correctamente
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "El listado se realizó correctamente"
          ];
        else :
          //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
        //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo 
        //'mensaje', que recoge cómo finalizó la operación:
        $parametros["mensajes"] = $this->mensajes;
        // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
        include_once 'vistas/listado.php';
      }else{
        header("Location: index.php");
      }
    }    
    else{header("Location: index.php");}
  }

  /**
   * Método de la clase controlador que realiza la eliminación de un usuario a 
   * través del campo id
   */
  public function deluser()
  {
    // verificamos que hemos recibido los parámetros desde la vista de listado 
    if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
      $id = $_GET["id"];
      //Realizamos la operación de suprimir el usuario con el id=$id
      $resultModelo = $this->modelo->deluser($id);
      //Analizamos el valor devuelto por el modelo para definir el mensaje a 
      //mostrar en la vista listado
      if ($resultModelo["correcto"]) :
        $this->mensajes[] = [
          "tipo" => "success",
          "mensaje" => "Se eliminó correctamente el usuario $id"
        ];
      else :
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "La eliminación del usuario no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
        ];
      endif;
    } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
      $this->mensajes[] = [
        "tipo" => "danger",
        "mensaje" => "No se pudo acceder al id del usuario a eliminar!! :("
      ];
    }
    //Relizamos el listado de los usuarios
    $this->listado();
  }

  public function adduser()
  {
    if (isset($_POST["email"]) &&isset($_POST["nombre"]) &&isset($_POST["apellidos"]) &&isset($_POST["direccion"]) &&isset($_POST["nif"]) &&isset($_POST["telefono"]) &&
    isset($_POST["contraseña"])) {      
      $email = $_POST["email"];  
      $nombre = $_POST["nombre"];
      $apellidos = $_POST["apellidos"];   
      $direccion = $_POST["direccion"];   
      $nif = $_POST["nif"];   
      $telefono = $_POST["telefono" ];   
      $contraseña = $_POST["contraseña"]; 
      
        $resultModelo = $this->modelo->adduser([
          'email' => $email,
          'nombre' => $nombre,
          'apellidos' => $apellidos,
          'direccion' => $direccion,
          'nif' => $nif,
          'telefono' => $telefono,
          'contraseña' => $contraseña          
        ]);
        if ($resultModelo["correcto"]) :
          include_once 'vistas/login.php';
        else :
         echo$resultModelo["error"];
          
        endif;      
    }{
      echo"error";
    }

    
  }

  /**
   * Método de la clase controlador que permite actualizar los datos del usuario
   * cuyo id coincide con el que se pasa como parámetro desde la vista de listado
   * a través de GET
   */
  public function actuser()
  {
    // Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
    // Inicializamos valores de los campos de texto
    $valnif = "";
    $valemail = "";
    $valnombre = "";
    $valapellidos = "";
    $valtelefono = "";
    $valdireccion = "";
    $valrol_id = "";

    // Si se ha pulsado el botón actualizar...
    if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
      $id = $_POST['id']; //Lo recibimos por el campo oculto
      $pass = $_POST['password'];
      $nuevonif = $_POST['nif'];
      $nuevoemail = $_POST['email'];
      $nuevonombre = $_POST['nombre'];
      $nuevoapellidos = $_POST['apellidos'];
      $nuevotelefono = $_POST['telefono'];
      $nuevodireccion = $_POST['direccion'];
      $nuevorol_id = $_POST['rol_id'];

      

            
      if (count($errores) == 0) {
        //Ejecutamos la instrucción de actualización a la que le pasamos los valores
        $resultModelo = $this->modelo->actuser([
          'id' => $id,
          'nif' => $nuevonif,
          'email' => $nuevoemail,
          'nombre' => $nuevonombre,
          'apellidos' => $nuevoapellidos,
          'telefono' => $nuevotelefono,
          'direccion' => $nuevodireccion,
          'password' => $pass,
          'rol_id' => $nuevorol_id
        ]);
        //Analizamos cómo finalizó la operación de registro y generamos un mensaje
        //indicativo del estado correspondiente
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "El usuario se actualizó correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El usuario no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "Datos de registro de usuario erróneos!! :("
        ];
      }

      // Obtenemos los valores para mostrarlos en los campos del formulario
      $valnif = $nuevonif;
      $valemail = $nuevoemail;
      $valnombre = $nuevonombre;
      $valapellidos = $nuevoapellidos;
      $valtelefono = $nuevotelefono;
      $valdireccion = $nuevodireccion;
      $valrol_id = $nuevorol_id;

      
    } else { //Estamos rellenando los campos con los valores recibidos del listado
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->listausuario($id);
        // print_r($resultModelo);
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Los datos del usuario se obtuvieron correctamente!! :)"
          ];
          $valnif = $resultModelo["datos"]["nif"];
          $valemail = $resultModelo["datos"]["email"];
          $valnombre = $resultModelo["datos"]["nombre"];
          $valapellidos = $resultModelo["datos"]["apellidos"];
          $valtelefono = $resultModelo["datos"]["telefono"];
          $valdireccion = $resultModelo["datos"]["direccion"];
          $valrol_id = $resultModelo["datos"]["rol_id"];
          $pass = $resultModelo["datos"]["password"];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
    }
    //Preparamos un array con todos los valores que tendremos que rellenar en
    //la vista adduser: título de la página y campos del formulario
    $parametros = [
      "tituloventana" => "Base de Datos con PHP y PDO",
      "datos" => [
        "nif" => $valnif,
        "email"  => $valemail,
        "nombre" => $valnombre,        
        "apellidos" => $valapellidos,
        "telefono" => $valtelefono,
        "direccion" => $valdireccion,
        "password" => $pass,
        "rol_id" => $valrol_id
      ],
      "mensajes" => $this->mensajes
    ];
    //Mostramos la vista actuser
    include_once 'vistas/actuser.php';
  }
  public function mostraract()
  {
    if(isset($_COOKIE['email']) && isset($_COOKIE['correo']) && isset($_COOKIE['admin'])){
      if($_COOKIE['admin']==true){
        //include_once 'vistas/inicio.php';      
        // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
        $parametros = [
          "tituloventana" => "Base de Datos con PHP y PDO",
          "datos" => NULL,
          "mensajes" => []
        ];
        // Realizamos la consulta y almacenamos los resultados en la variable $resultModelo
        $resultModelo = $this->modelo->mostraract();
        // Si la consulta se realizó correctamente transferimos los datos obtenidos
        // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
        // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
        if ($resultModelo["correcto"]) :
          $parametros["datos"] = $resultModelo["datos"];
          //Definimos el mensaje para el alert de la vista de que todo fue correctamente
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "El listado se realizó correctamente"
          ];
        else :
          //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
        //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo 
        //'mensaje', que recoge cómo finalizó la operación:
        $parametros["mensajes"] = $this->mensajes;
        // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
        include_once 'vistas/actividades.php';
      }else{
        header("Location: index.php");
      }
    }    
    else{header("Location: index.php");}
  }
  public function delact()
  {
    // verificamos que hemos recibido los parámetros desde la vista de listado 
    if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
      $id = $_GET["id"];
      //Realizamos la operación de suprimir el usuario con el id=$id
      $resultModelo = $this->modelo->delact($id);
      //Analizamos el valor devuelto por el modelo para definir el mensaje a 
      //mostrar en la vista listado
      if ($resultModelo["correcto"]) :
        $this->mensajes[] = [
          "tipo" => "success",
          "mensaje" => "Se eliminó correctamente la actividad $id"
        ];
      else :
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "La eliminación de La actividad no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
        ];
      endif;
    } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
      $this->mensajes[] = [
        "tipo" => "danger",
        "mensaje" => "No se pudo acceder al id de la actividad a eliminar!! :("
      ];
    }
    //Relizamos el listado de los usuarios
    $this->mostraract();
  }

  public function actact()
  {
    // Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
    // Inicializamos valores de los campos de texto
    $valnombre = "";
    $valdescripcion = "";
    $valaforo = "";

    // Si se ha pulsado el botón actualizar...
    if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
      $id = $_POST['id']; //Lo recibimos por el campo oculto
      $nuevonombre = $_POST['nombre'];
      $nuevodescripcion = $_POST['descripcion'];
      $nuevoaforo= $_POST['aforo'];
      

            
      if (count($errores) == 0) {
        //Ejecutamos la instrucción de actualización a la que le pasamos los valores
        $resultModelo = $this->modelo->actact([
          'id' => $id,
          'nombre' => $nuevonombre,
          'descripcion' => $nuevodescripcion,
          'aforo' => $nuevoaforo,
        ]);
        //Analizamos cómo finalizó la operación de registro y generamos un mensaje
        //indicativo del estado correspondiente
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "La actividad se actualizó correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "La actividad no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "Datos de registro de La actividad erróneos!! :("
        ];
      }

      // Obtenemos los valores para mostrarlos en los campos del formulario
      $valnombre = $nuevonombre;
      $valdescripcion = $nuevodescripcion;
      $valaforo = $nuevoaforo;
  

      
    } else { //Estamos rellenando los campos con los valores recibidos del listado
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->listaact($id);
        // print_r($resultModelo);
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Los datos de la actividad se obtuvieron correctamente!! :)"
          ];
          $valnombre = $resultModelo["datos"]["nombre"];
          $valdescripcion = $resultModelo["datos"]["descripcion"];
          $valaforo = $resultModelo["datos"]["aforo"];
        else :
          $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "No se pudieron obtener los datos de la actividad!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
    }
    //Preparamos un array con todos los valores que tendremos que rellenar en
    //la vista adduser: título de la página y campos del formulario
    $parametros = [
      "tituloventana" => "Base de Datos con PHP y PDO",
      "datos" => [
        "nombre" => $valnombre,        
        "descripcion" => $valdescripcion,
        "aforo" => $valaforo
      ],
      "mensajes" => $this->mensajes
    ];
    include_once 'vistas/actact.php';
  }

  public function addact()
  {
    if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["aforo"]) ) {      
      $nombre = $_POST["nombre"];  
      $descripcion = $_POST["descripcion"];
      $aforo = $_POST["aforo"];   
      
        $resultModelo = $this->modelo->addact([
          'nombre' => $nombre,
          'descripcion' => $descripcion,
          'aforo' => $aforo
        ]);
        if ($resultModelo["correcto"]) :
          $this->mostraract();
        else :
         echo$resultModelo["error"];
          
        endif;      
    }
    $this->mostraract();
    
  }
}
