<?php

include 'ConectionDb.php';
include 'Util.php';
/**
 * Created by PhpStorm.
 * User: danie
 */

class ControllerHealthcareArea {
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
        if ($this->op == 'asissave') {
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->idsuc = isset($rqst['idsuc']) ? $rqst['idsuc'] : 0;
            $this->asissave();
        } else if ($this->op == 'asisget') {
            $this->idsuc = isset($rqst['idsuc']) ? $rqst['idsuc'] : 0;
            $this->asisget();
        } else if ($this->op == 'sucdelete') {
            $this->sucdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
    }

    private function asisget(){
        if($this->idsuc > 0) {
            $q = "SELECT * FROM am_areas WHERE are_borrado = 0 AND am_sucursales_suc_id = '" . $this->idsuc . "'ORDER BY are_nombre";
        }else{
            $q = "SELECT * FROM am_areas WHERE are_borrado = 0 ORDER BY are_nombre ";
            if ($this->id > 0) {
                $q = "SELECT * FROM am_areas WHERE are_borrado = 0 AND are_id = " . $this->id;
            }
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){

            $arr[] = array(
                'id' => $obj->are_id,
                'nombre' => ($obj->are_nombre),
                'dtcreate' => ($obj->are_actualizado));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    private function asissave() {
        if($this->idsuc > 0){
            $q="INSERT INTO am_areas (am_sucursales_suc_id, are_nombre, are_actualizado, are_borrado) VALUES ('" . $this->idsuc . "','" . $this->nombre . "'," . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }else {
            if ($this->id > 0) {
                //actualiza la informacion
                $q = "SELECT cli_id FROM am_clientes WHERE cli_id = " . $this->id;
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                while ($obj = mysqli_fetch_object($con)) {
                    $id = $obj->cli_id;
                    $table = "am_clientes";
                    $arrfieldscomma = array(
                        'cli_nombre' => $this->nombre,
                        'cli_nit' => $this->nit,
                        'cli_tipo' => $this->tipo,
                        'cli_url' => $this->url);
                    $arrfieldsnocomma = array('cli_actualizado' => $this->UTILITY->date_now_server());
                    $q = $this->UTILITY->make_query_update($table, "cli_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                    mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                }
            }else{
                    $q = "INSERT INTO am_areas (cli_nombre, cli_nit, cli_tipo, cli_url, cli_estado, cli_actualizado, cli_borrado) VALUES ('" . $this->nombre . "', '" . $this->nit . "','" . $this->tipo . "','" . $this->url . "','" . $estado2 . "'," . $this->UTILITY->date_now_server() . ", " . 0 . ")";
                    mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                    $id = mysqli_insert_id($this->conexion);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
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