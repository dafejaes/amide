<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Camilo Garzon Calle
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
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->url = isset($rqst['url']) ? $rqst['url'] : '';
            $this->fechainicio = isset($rqst['fechainicio']) ? $rqst['fechainicio'] : '';
            $this->fechafin = isset($rqst['fechafin']) ? $rqst['fechafin'] : '';
            $this->nit = isset($rqst['nit']) ? $rqst['nit'] : '';
            $this->telefono = isset($rqst['telefono']) ? $rqst['telefono'] : '';
            $this->pais = isset($rqst['pais']) ? $rqst['pais'] : '';
            $this->departamento = isset($rqst['departamento']) ? $rqst['departamento'] : '';
            $this->ciudad = isset($rqst['ciudad']) ? $rqst['ciudad'] : '';
            $this->direccion = isset($rqst['direccion']) ? $rqst['direccion'] : '';
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
            $q = "INSERT INTO dmt_cliente (cli_dtcreate, cli_nombre, cli_estado, cli_email, cli_url, cli_fecha_inicio, cli_fecha_fin, cli_nit, cli_telefono, cli_pais, cli_departamento, cli_ciudad, cli_direccion) VALUES (" . $this->UTILITY->date_now_server() . ", '$this->nombre', '$this->estado', '$this->email', '$this->url', '$this->fechainicio', '$this->fechafin', '$this->nit', '$this->telefono', '$this->pais', '$this->departamento', '$this->ciudad', '$this->direccion')";
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $id = mysql_insert_id();
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    public function cliget() {
        $q = "SELECT * FROM am_sucursales, am_clientes where am_clientes_cli_id = cli_id ORDER BY suc_nombre AND suc_borrado = 0";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_sucursales, am_clientes WHERE suc_id = " . $this->id . "AND am_clientes_cli_id = clid_id"    ;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->suc_id,
                'cli_id' => $obj->am_clientes_cli_id,
                'sucnombre' => ($obj->suc_nombre),
                'ciudad' => ($obj->suc_ciudad),
                'direccion' => ($obj->suc_direccion),
                'telefono' => ($obj->suc_telefono),
                'clinombre' => ($obj->cli_nombre),
                'clinit' => ($obj->cli_nit),
                'nit' => ($obj->cli_nit),
                'dtcreate' => ($obj->suc_actualizado));
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