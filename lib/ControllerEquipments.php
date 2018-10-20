<?php
include 'ConectionDb.php';
include 'Util.php';
/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 */
class ControllerEquipments {

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
        if ($this->op == 'eqsave') {
            $this->idtipoeq = isset($rqst['idtipoeq']) ? intval($rqst['idtipoeq']) : 0;
            $this->idser = isset($rqst['idser']) ? intval($rqst['idser']) : 0;
            $this->idubi = isset($rqst['idubi']) ? intval($rqst['idubi']) : 0;
            $this->serie = isset($rqst['serie']) ? $rqst['serie'] : '';
            $this->invima = isset($rqst['invima']) ? $rqst['invima'] : '';
            $this->placa = isset($rqst['placa']) ? $rqst['placa'] : '';
            $this->codigo = isset($rqst['codigo']) ? intval($rqst['codigo']) : 0;
            $this->eqsave();
        } else if ($this->op == 'serget') {
            $this->serget();
        } else if ($this->op == 'sersave') {
            $this->chk = isset($rqst['chk']) ? $rqst['chk'] : '';
            $this->usrprfsave();
        } else if ($this->op == 'serdelete') {
            $this->serdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**  Función para obtener las ubicaciones */

    public function eqget() {
        $q = "SELECT * FROM am_equipos, am_equipos_tipo, am_ubicaciones WHERE eq_borrado =  0 AND  am_equipos_tipo_eqt_id = eqt_id AND am_ubicaciones_ubi_id = ubi_id ORDER BY eqt_nombre ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_equipos, am_equipos_tipo, am_ubicaciones  WHERE eq_id = " . $this->id . " AND am_equipos_tipo_eqt_id = eqt_id AND eq_borrado = 0 AND  am_ubicaciones_ubi_id = ubi_id ORDER BY eqt_nombre ASC";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->eq_id,
                'nombre' => $obj->eqt_nombre,
                'marca' => $obj->eqt_marca,
                'modelo' => $obj->eqt_modelo,
                'serie' => $obj->eq_serie,
                'placa' => $obj->eq_placa,
                'codigo' => $obj->eq_codigo,
                'ubicacion' => $obj->ubi_ubicacion);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function eqsave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT eq_id FROM am_equipos WHERE eq_id = " . $this->id . " AND eq_borrado = 0";
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->eq_id;
                $table = "am_equipos";
                $arrfieldscomma = array(
                    'am_equipos_tipo_eqt_id' => $this->idtipoeq,
                    'am_servicio_ser_id' => $this->idser,
                    'am_ubicaciones_ubi_id' => $this->idubi,
                    'eq_serie' => $this->serie,
                    'eq_invima' => $this->invima,
                    'eq_placa' => $this->placa,
                    'eq_codigo' => $this->codigo);
                $arrfieldsnocomma = array('eq_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "eq_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            }
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $q = "INSERT INTO am_equipos (am_equipos_tipo_eqt_id, am_servicio_ser_id, am_ubicaciones_ubi_id, eq_serie, eq_invima, eq_placa, eq_codigo, eq_borrado, eq_actualizado) VALUES (" . $this->idtipoeq . "," . $this->idser . "," . $this->idubi . ",'" . $this->serie . "','" . $this->invima . "','" . $this->placa . "','" . $this->codigo . "'," . 0 . "," . $this->UTILITY->date_now_server() . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
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

?>