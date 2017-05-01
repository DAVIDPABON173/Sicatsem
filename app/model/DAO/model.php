<?php



/**
* Clase utilitaria para la comunicación con la base de datos.
* Esta clase será extendida por todos los modelos.
*/
class Model extends mysqli
{


  /**
  * Datos de conexion
  */
  private $db_host ;
  private $db_user ;
  private $db_pass ;
  private $db_name ;
  private $connection;


  /**
  * Realiza la conexión con la base de datos (tomando los datos del archivo config.php)
  */
  public function __construct(){
//    require_once 'app/config/datosDeConexion.php';
      $this->db_host = 'localhost';
      $this->db_user = 'root';
      $this->db_pass = '';
      $this->db_name = 'sicatsem';
      $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die(('Error ' . mysqli_error($connection)));
      $this->connection->query("SET NAMES 'utf8'");

    }

  /**
  * Realiza una consulta a la base de datos.
  * @return - En caso de error retorna el mensaje de error. Consultas del tipo SELECT, SHOW, DESCRIBE o EXPLAIN que
  * no retornen error, devuelven un conjunto de datos. Consultas INSERT, UPDATE O DELETE retornan un boolean.
  */
  public function query($sql){
    if(!$this->connection->connect_errno) {
        return $this->connection->query($sql);
    } else {
        return $this->connection->connect_error();
    }
  }

  /**
  * @param $query - Consulta realizada
  * @return Retorna el número de filas del resultado de instrucciones SELECT.
  */
  public function rowsQuery($query){
     return $query->num_rows;
  }

  /**
  * @return - En caso de error retorna el mensaje de error.Devuelve el numero de filas afectadas por la última consulta INSERT,
  * UPDATE, REPLACE or DELETE.
  */
  public function rowsOpe(){
    if(!$this->connection->connect_errno) {
        return $this->connection->affected_rows;
    } else {
        return $this->connection->connect_error();
    }
  }

  /**
  * @param $query - Consulta realizada
  * @return Libera la memoria asociada a la 'query'
  */
  public function liberar($query){
    // $query->free();
  }

  /**
  * @param $query - Consulta realizada
  * @return Retorna un array que corresponde a la fila obtenida o NULL si
  * es que no hay más filas en el resultset representado por el parámetro $query.
  */
  public function recorrer($query){
    return  mysqli_fetch_array($query, MYSQLI_NUM);
  }

  /**
  * @return Cierra una conexión abierta previamente a base de datos.
  */
  public function close(){
    $this->connection->close();
  }



}


?>
