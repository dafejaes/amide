<?php

include 'ConectionDb.php';
include 'Util.php';
/**
 * Created by PhpStorm.
 * User: danie
 */

class ControllerBranchOffice
{
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
        if ($this->op == 'sucsave') {
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->idcli = isset($rqst['idcli']) ? $rqst['idcli'] : '';
            $this->ciudad = isset($rqst['ciudad']) ? $rqst['ciudad'] : '';
            $this->direccion = isset($rqst['direccion']) ? $rqst['direccion'] : '';
            $this->telefono = isset($rqst['telefono']) ? $rqst['telefono'] : '';
            $this->sucsave();
        } else if ($this->op == 'sucget') {
            $this->sucget();
        } else if ($this->op == 'sucdelete') {
            $this->sucdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
    }

    /**  Función para obtener las sucursales */

    public function sucget() {
        $q = "SELECT * FROM am_sucursales, am_clientes where am_clientes_cli_id = cli_id  AND suc_borrado = 0 ORDER BY suc_nombre";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_sucursales, am_clientes WHERE am_clientes_cli_id = cli_id AND suc_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->suc_id,
                'cli_id' => $obj->am_clientes_cli_id,
                'nombre' => ($obj->suc_nombre),
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

    private function sucsave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT suc_id FROM am_sucursales WHERE suc_id = " . $this->id;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->suc_id;
                $table = "am_sucursales";
                $arrfieldscomma = array(
                    'suc_nombre' => $this->nombre,
                    'suc_ciudad' => $this->ciudad,
                    'suc_direccion' => $this->direccion,
                    'suc_telefono' => $this->telefono);
                $arrfieldsnocomma = array('suc_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "suc_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $q = "INSERT INTO am_sucursales (am_clientes_cli_id, suc_nombre, suc_ciudad, suc_direccion, suc_telefono, suc_actualizado, suc_borrado) VALUES ('" . $this->idcli . "', '" . $this->nombre . "', '". $this->ciudad . "','" .  $this->direccion . "','" . $this->telefono . "'," . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    private function sucdelete() {
        if ($this->id > 0) {
            $q = "UPDATE am_sucursales SET suc_borrado = 1 WHERE suc_id = $this->id";
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
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
}