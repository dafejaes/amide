<?php

/**
 * Clase para conectar a la base de datos

 *
 */
class ConectionDb {

    private $host, $user, $pass, $db, $connection, $server_date;

    /**
     * Constructor que establece los datos de conexion a la base de datos
     */
    public function __construct() {
	$this->host = "localhost";
	$this->pass = "";
	$this->user = "root";
	$this->db = "amide_db";
	//Este es el timestamp que se debe ingresar, de acuerdo a la hora deseada
	$this->server_date = 'DATE_ADD(NOW(),INTERVAL 1 HOUR)';
	$this->connection = NULL;
    }

    /**
     * Establece la connexion con la base de datos
     */
    public function openConect() {
	$this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
	if (!$this->connection) {
	    throw new Exception("No fue posible conectarse al servidor MySQL");
	}
	if (!mysqli_select_db($this->connection,$this->db)) {
	    throw new Exception("No se puede seleccionar la base de datos $this->db");
	}
	return $this->connection;
    }

    /**
     * Cierra la conexion con la base de datos
     */
    public function closeConect() {
	mysqli_close($this->connection);
    }

    public function getServerDate() {
	return $this->server_date;
    }

}

?>
