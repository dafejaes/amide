<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 */

class ControllerCustomer {

    private $conexion, $CDB, $op, $id, $euid, $sdid;
    private $UTILITY;
    private $response;

    function __construct() {
        $this->CDB = new ConectionDb();
        $this->UTILITY = new Util();
        $this->conexion = $this->CDB->openConect();
        $rqst = $_REQUEST;
        $this->op = isset($rqst['op']) ? $rqst['op'] : '';
        $this->id = isset($rqst['id']) ? intval($rqst['id']) : 0;
        $this->ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $this->lu = isset($rqst['lu']) ? $rqst['lu'] : '';
        $this->ti = isset($rqst['ti']) ? $rqst['ti'] : '';
        if (!$this->UTILITY->validate_key($this->ke, $this->ti, $this->lu)) {
            $this->op = 'noautorizado';
        }
        if ($this->op == 'clisave') {
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->estado = isset($rqst['estado']) ? $rqst['estado'] : '';
            $this->tipo = isset($rqst['tipo']) ? $rqst['tipo'] : '';
            $this->url = isset($rqst['url']) ? $rqst['url'] : '';
            $this->nit = isset($rqst['nit']) ? $rqst['nit'] : '';
            $this->clisave();
        } else if ($this->op == 'cliget') {
            $this->cliget();
        } else if ($this->op == 'clidelete') {
            $this->clidelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function clisave() {
        $id = 0;
        if($this->estado = 'Activo'){
           $estado2=1;
        }
        else{
            $estado2=0;
        }
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT cli_id FROM dmt_cliente WHERE cli_id = " . $this->id;
            $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            while ($obj = mysql_fetch_object($con)) {
                $id = $obj->cli_id;
                $table = "dmt_cliente";
                $arrfieldscomma = array(
                    'cli_nombre' => $this->nombre,
                    'cli_estado' => $this->estado,
                    'cli_email' => $this->email,
                    'cli_url' => $this->url,
                    'cli_fecha_inicio' => $this->fechainicio,
                    'cli_fecha_fin' => $this->fechafin,
                    'cli_nit' => $this->nit,
                    'cli_telefono' => $this->telefono,
                    'cli_pais' => $this->pais,
                    'cli_departamento' => $this->departamento,
                    'cli_ciudad' => $this->ciudad,
                    'cli_direccion' => $this->direccion);
                $arrfieldsnocomma = array('cli_dtcreate' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "cli_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $q = "INSERT INTO am_clientes (cli_nombre, cli_nit, cli_tiipo, cli_url, cli_estado, cli_actualizado, cli_borrado) VALUES (" . $this->nombre . ", ". $this->nit . "," .  $this->tipo . "," . $this->url . "," . $estado2 . "," . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id();
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    public function cliget() {
        $q = "SELECT * FROM am_clientes ORDER BY cli_nombre AND cli_borrado = 0";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_clientes WHERE cli_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->cli_id,
                'nombre' => ($obj->cli_nombre),
                'nit' => ($obj->cli_nit),
                'tipo' => ($obj->cli_tipo),
                'url' => ($obj->cli_url),
                'estado' => ($obj->cli_estado),
                'clinit' => ($obj->cli_nit),
                'dtcreate' => ($obj->cli_actualizado));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function clidelete() {
        if ($this->id > 0) {
            $q = "DELETE FROM dmt_cliente WHERE cli_id = " . $this->id;
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }

    public function getResponseJSON() {
        $this->CDB->closeConect();
        return json_encode($this->response);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

}

?>