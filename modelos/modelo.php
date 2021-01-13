<?php

/**
 *   Clase 'modelo' que implementa el modelo de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la base de datos
 * en una capa especializada
 */
class modelo {

  //Atributo que contendrá la referencia a la base de datos 
  private $conexion;
  // Parámetros de conexión a la base de datos 
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "gymdatos";

  /**
   * Constructor de la clase que ejecutará directamente el método 'conectar()'
   */
  public function __construct() {
    $this->conectar();
  }

  /**
   * Método que realiza la conexión a la base de datos de usuarios mediante PDO.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function conectar() {
    try {
      
      $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return TRUE;
    } catch (PDOException $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * Función que nos permite conocer si estamos conectados o no a la base de datos.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function estaConectado() {
    if ($this->conexion) :
      return TRUE;
    else :
      return FALSE;
    endif;
  }


  public function login(){
    
    $emailCliente = $_POST['email'];
    $claveCliente = $_POST['contraseña'];

    
    $consulta = "SELECT * FROM usuarios WHERE email='" . $emailCliente . "' AND password='" . $claveCliente . "'";
    $resultsquery = $this->conexion->query($consulta);
    
    return $resultsquery->rowCount();
    
  }
  public function esadmin(){
    
    $emailCliente = $_POST['email'];
    $claveCliente = $_POST['contraseña'];

    
    $consulta = "SELECT * FROM usuarios WHERE email='" . $emailCliente . "' AND password='" . $claveCliente . "'";
    $resultsquery = $this->conexion->query($consulta);
    $usuario = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
    
    if($usuario[0]["rol_id"] == 0 ){
      return false;
    }else{
      return true;
    }    
    
  }

  /**
   * Función que realiza el listado de todos los usuarios registrados
   * Devuelve un array asociativo con tres campos:
   * -'correcto': indica si el listado se realizó correctamente o no.
   * -'datos': almacena todos los datos obtenidos de la consulta.
   * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
   * @return type
   */
  public function listado() {
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];
    //Realizamos la consulta...
    try {  //Definimos la instrucción SQL  
      $sql = "SELECT * FROM usuarios";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->query($sql);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($resultsquery) :
        $return["correcto"] = TRUE;
        $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
      endif; // o no :(
    } catch (PDOException $ex) {
      $return["error"] = $ex->getMessage();
    }

    return $return;
  }

  /**
   * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
   * @param $id es un valor numérico. Es el campo clave de la tabla
   * @return boolean
   */
  public function deluser($id) {
    // La función devuelve un array con dos valores:'correcto', que indica si la
    // operación se realizó correctamente, y 'mensaje', campo a través del cual le
    // mandamos a la vista el mensaje indicativo del resultado de la operación
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];
    //Si hemos recibido el id y es un número realizamos el borrado...
    if ($id && is_numeric($id)) {
      try {
        //Inicializamos la transacción
        $this->conexion->beginTransaction();
        //Definimos la instrucción SQL parametrizada 
        $sql = "DELETE FROM usuarios WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);
        //Supervisamos si la eliminación se realizó correctamente... 
        if ($query) {
          $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
          $return["correcto"] = TRUE;
        }// o no :(
      } catch (PDOException $ex) {
        $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
        $return["error"] = $ex->getMessage();
      }
    } else {
      $return["correcto"] = FALSE;
    }

    return $return;
  }

  /**
   * 
   * @param type $datos
   * @return type
   */
  public function adduser($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "INSERT INTO usuarios(id,nif,nombre,apellidos,email,password,telefono,direccion,estado,imagen,rol_id)
                         VALUES (:id,:nif,:nombre,:apellidos,:email,:password,:telefono,:direccion,:estado,:imagen,:rol_id)";
      // Preparamos la consulta...
      $query = $this->conexion->prepare($sql);
      // y la ejecutamos indicando los valores que tendría cada parámetro
      $query->execute([
          'email' => $datos["email"],
          'nombre' => $datos["nombre"],
          'apellidos' => $datos["apellidos"],
          'password' => $datos["contraseña"],
          'direccion' => $datos["direccion"],
          'estado' => true,
          'imagen' => "ninguna",
          'nif' => $datos["nif"],         
          'id' => random_int(0,99999999),
          'rol_id' => 0,
          'telefono' => $datos["telefono"]
          
      ]); //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit(); // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }

  public function actuser($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "UPDATE usuarios SET nif=:nif, nombre=:nombre, apellidos=:apellidos, email=:email, password=:password, telefono=:telefono, direccion=:direccion, imagen=:imagen,
              rol_id=:rol_id WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute([
          'id'=> $datos["id"],
          'nif' => $datos["nif"],
          'nombre' => $datos["nombre"],
          'apellidos' => $datos["apellidos"],
          'email' => $datos["email"],
          'telefono' => $datos["telefono"],
          'direccion' => $datos["direccion"],
          'password' => $datos["password"],
          'imagen'=> null,
          'rol_id' => $datos["rol_id"]          
          
      ]);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }// o no :(
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }

  public function listausuario($id) {
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];

    if ($id && is_numeric($id)) {
      try {
        $sql = "SELECT * FROM usuarios WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);        
        //Supervisamos que la consulta se realizó correctamente... 
        if ($query) {
          $return["correcto"] = TRUE;
          $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
        }// o no :(
      } catch (PDOException $ex) {
        $return["error"] = $ex->getMessage();
        //die();
      }
    }

    return $return;
  }

  public function horariotramos($hora,$dia) {
      try {
        $sql = "SELECT * FROM tramos WHERE (horainicio=:hora OR horafin=:hora) AND dia=:dia";
        $query = $this->conexion->prepare($sql);
        $query->execute(['hora' => $hora,
                         'dia' => $dia]);        
        //Supervisamos que la consulta se realizó correctamente... 
        if (($query->rowCount())!=0) {
          return $query->fetch(PDO::FETCH_ASSOC);
        }// o no :(
      } catch (PDOException $ex) {
        $return["error"] = $ex->getMessage();
        //die();
      }
    return "nada";
  }
  public function deltramo($id) {
    // La función devuelve un array con dos valores:'correcto', que indica si la
    // operación se realizó correctamente, y 'mensaje', campo a través del cual le
    // mandamos a la vista el mensaje indicativo del resultado de la operación
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];
    //Si hemos recibido el id y es un número realizamos el borrado...
    if ($id && is_numeric($id)) {
      try {
        //Inicializamos la transacción
        $this->conexion->beginTransaction();
        //Definimos la instrucción SQL parametrizada 
        $sql = "DELETE FROM tramos WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);
        //Supervisamos si la eliminación se realizó correctamente... 
        if ($query) {
          $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
          $return["correcto"] = TRUE;
        }// o no :(
      } catch (PDOException $ex) {
        $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
        $return["error"] = $ex->getMessage();
      }
    } else {
      $return["correcto"] = FALSE;
    }

    return $return;
  }

  public function acttramo($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "UPDATE tramos SET dia=:dia, horainicio=:horainicio, horafin=:horafin, actividad_id=:actividad_id, fecha_alta=:fecha_alta, fecha_baja=:fecha_baja WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute([
          'id'=> $datos["id"],
          'dia' => $datos["dia"],
          'horainicio' => $datos["horainicio"],
          'horafin' => $datos["horafin"],
          'actividad_id' => $datos["actividad_id"],
          'fecha_alta' => $datos["fecha_alta"],
          'fecha_baja' => $datos["fecha_baja"]       
          
      ]);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }// o no :(
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }

  public function addtramo($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "INSERT INTO tramos(id,dia,horainicio,	horafin, actividad_id,fecha_alta,fecha_baja)
                         VALUES (:id, :dia, :horainicio, :horafin, :actividad_id, :fecha_alta, :fecha_baja);";
      // Preparamos la consulta...
      $query = $this->conexion->prepare($sql);
      // y la ejecutamos indicando los valores que tendría cada parámetro
      $query->execute([
          'dia' => $datos["dia"],
          'horainicio' => $datos["horainicio"],
          'horafin' => $datos["horafin"],
          'actividad_id' => $datos["actividad_id"],
          'fecha_alta' => $datos["fecha_alta"],
          'fecha_baja' => $datos["fecha_baja"],       
          'id' => random_int(0,99999999),
          
      ]); //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit(); // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }
  public function listatramo($id) {
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];

    if ($id && is_numeric($id)) {
      try {
        $sql = "SELECT * FROM tramos WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);        
        //Supervisamos que la consulta se realizó correctamente... 
        if ($query) {
          $return["correcto"] = TRUE;
          $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
          //print_r( $return["datos"]);
        }// o no :(
      } catch (PDOException $ex) {
        $return["error"] = $ex->getMessage();
        //die();
      }
    }

    return $return;
  }
  public function buscaractividad($id) {
    try {
      $sql = "SELECT * FROM actividades WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute(['id' => $id]);        
      //Supervisamos que la consulta se realizó correctamente... 
      if (($query->rowCount())!=0) {
        return $query->fetch(PDO::FETCH_ASSOC);
      }// o no :(
    } catch (PDOException $ex) {
      $return["error"] = $ex->getMessage();
      //die();
    }
}

public function mostraract() {
  $return = [
      "correcto" => FALSE,
      "datos" => NULL,
      "error" => NULL
  ];
  //Realizamos la consulta...
  try {  //Definimos la instrucción SQL  
    $sql = "SELECT * FROM actividades";
    // Hacemos directamente la consulta al no tener parámetros
    $resultsquery = $this->conexion->query($sql);
    //Supervisamos si la inserción se realizó correctamente... 
    if ($resultsquery) :
      $return["correcto"] = TRUE;
      $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
    endif; // o no :(
  } catch (PDOException $ex) {
    $return["error"] = $ex->getMessage();
  }

  return $return;
}
public function delact($id) {
  // La función devuelve un array con dos valores:'correcto', que indica si la
  // operación se realizó correctamente, y 'mensaje', campo a través del cual le
  // mandamos a la vista el mensaje indicativo del resultado de la operación
  $return = [
      "correcto" => FALSE,
      "error" => NULL
  ];
  //Si hemos recibido el id y es un número realizamos el borrado...
  if ($id && is_numeric($id)) {
    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "DELETE FROM actividades WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute(['id' => $id]);
      //Supervisamos si la eliminación se realizó correctamente... 
      if ($query) {
        $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }// o no :(
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
    }
  } else {
    $return["correcto"] = FALSE;
  }

  return $return;
}
public function listaact($id) {
  $return = [
      "correcto" => FALSE,
      "datos" => NULL,
      "error" => NULL
  ];

  if ($id && is_numeric($id)) {
    try {
      $sql = "SELECT * FROM actividades WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute(['id' => $id]);        
      //Supervisamos que la consulta se realizó correctamente... 
      if ($query) {
        $return["correcto"] = TRUE;
        $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
      }// o no :(
    } catch (PDOException $ex) {
      $return["error"] = $ex->getMessage();
      //die();
    }
  }

  return $return;
}
public function actact($datos) {
  $return = [
      "correcto" => FALSE,
      "error" => NULL
  ];

  try {
    //Inicializamos la transacción
    $this->conexion->beginTransaction();
    //Definimos la instrucción SQL parametrizada 
    $sql = "UPDATE actividades SET nombre=:nombre, descripcion=:descripcion, aforo=:aforo WHERE id=:id";
    $query = $this->conexion->prepare($sql);
    $query->execute([
        'id'=> $datos["id"],
        'nombre' => $datos["nombre"],
        'descripcion' => $datos["descripcion"],
        'aforo' => $datos["aforo"] 
        
    ]);
    //Supervisamos si la inserción se realizó correctamente... 
    if ($query) {
      $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
      $return["correcto"] = TRUE;
    }// o no :(
  } catch (PDOException $ex) {
    $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
    $return["error"] = $ex->getMessage();
    //die();
  }

  return $return;
}
public function addact($datos) {
  $return = [
      "correcto" => FALSE,
      "error" => NULL
  ];

  try {
    //Inicializamos la transacción
    $this->conexion->beginTransaction();
    //Definimos la instrucción SQL parametrizada 
    $sql = "INSERT INTO actividades(id,nombre,descripcion ,aforo)
                       VALUES (:id,:nombre,:descripcion	,:aforo)";
    // Preparamos la consulta...
    $query = $this->conexion->prepare($sql);
    // y la ejecutamos indicando los valores que tendría cada parámetro
    $query->execute([
        'nombre' => $datos["nombre"],
        'descripcion' => $datos["descripcion"],
        'aforo' => $datos["aforo"],       
        'id' => random_int(0,99999999),
    ]); //Supervisamos si la inserción se realizó correctamente... 
    if ($query) {
      $this->conexion->commit(); // commit() confirma los cambios realizados durante la transacción
      $return["correcto"] = TRUE;
    }
  } catch (PDOException $ex) {
    $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
    $return["error"] = $ex->getMessage();
    //die();
  }

  return $return;
}
}
