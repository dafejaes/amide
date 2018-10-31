<?php
include 'ConectionDb.php';
include 'Util.php';

class ControllerEquipDirect {
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
        if ($this->op == 'ordensave') {
            $this->metodo = 1;
            $this->idrecep=isset($rqst['idrecep3']) ? intval($rqst['idrecep3']) : 0;
            $this->servicio= 'Calibracion';
            $this->tipo = 'Interna';
            $this->estado = 'Pendiente';
            $this->idresponsable = isset($rqst['idresponsable']) ? intval($rqst['idresponsable']) : 0;
            $this->iddirector= isset($rqst['iddirector']) ? intval($rqst['iddirector']) : 0;
            $this->patrones = isset($rqst['patrones']) ? $rqst['patrones'] : '';
            $this->ordensave();
        } else if ($this->op == 'metroget') {
            $this->metroget();
        } else if ($this->op == 'obsget') {
            $this->idrecep2=isset($rqst['idrecep2']) ? intval($rqst['idrecep2']) : 0;
            $this->obsget();
        } else if ($this->op == 'recepget') {
            $this->idrecep2=isset($rqst['idrecep2']) ? intval($rqst['idrecep2']) : 0;
            $this->recepget();
        } else if ($this->op == 'patronesget') {
            $this->patronesget();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**  Función para obtener las ubicaciones */

    public function directget() {
        $q = "SELECT * FROM am_recepcion, am_equipos, am_equipos_tipo, am_ubicaciones, am_servicio WHERE rcp_borrado=0 AND rcp_estado = 'Pendiente' AND am_equipos_eq_id = eq_id AND am_equipos_tipo_eqt_id=eqt_id AND am_servicio_ser_id = ser_id AND am_ubicaciones_ubi_id = ubi_id";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_recepcion, am_equipos, am_equipos_tipo, am_ubicaciones, am_servicio  WHERE recp_id = " . $this->id . " AND rcp_borrado=0 AND rcp_estado = 'Terminado' AND am_equipos_eq_id = eq_id AND am_equipos_tipo_eqt_id=eqt_id AND am_servicio_ser_id = ser_id AND am_ubicaciones_ubi_id = ubi_id";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->recp_id,
                'nombre' => $obj->eqt_nombre,
                'extension' => $obj->ubi_extension,
                'ubicacion' => $obj->ubi_ubicacion,
                'torre' => $obj->ubi_torre,
                'piso' => $obj->ubi_piso,
                'servicio' => $obj->ser_nombre,
                'fechaingreso' => $obj->rcp_fechaingreso,
                'estado' => $obj->rcp_estado,
                'consecutivo' => $obj->rcp_consecutivo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    public function patronesget() {
        $q = "SELECT * FROM am_equipos_tipo, am_equipos WHERE am_equipos_tipo_eqt_id = eqt_id AND eq_borrado = 0 AND eqt_patron = 1";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_equipos_tipo, am_equipos WHERE eq_id = " . $this->id . " AND am_equipos_tipo_eqt_id = eqt_id AND eq_borrado = 0 AND eqt_patron = 1";
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
                'codigo' => $obj->eq_codigo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function metroget() {
        $q = "SELECT * FROM am_usuarios WHERE usr_borrado=0 AND usr_cargo = 'Metrologo' ORDER BY usr_cargo";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_usuarios WHERE usr_id = " . $this->id . " AND usr_borrado = 0 AND usr_cargo = 'Metrologo'";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->usr_id,
                'nombre' =>$obj->usr_nombre);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    public function obsget() {
        $q = "SELECT * FROM am_recepcion WHERE recp_id = $this->idrecep2";
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'obsentre' => $obj->rcp_obs_entrega,
                'obsrecep' => $obj->rcp_obs_recepcion);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function ordensave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT cli_id FROM am_clientes WHERE cli_id = " . $this->id;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->cli_id;
                $table = "am_clientes";
                $arrfieldscomma = array(
                    'cli_nombre' => $this->nombre,
                    'cli_estado' => $estado2,
                    'cli_nit' => $this->nit,
                    'cli_tipo' => $this->tipo,
                    'cli_url' => $this->url);
                $arrfieldsnocomma = array('cli_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "cli_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $contador=count($this->patrones);
            if($contador == 0){
                $arrjson=array('output' => array('valid' => false, 'response' => array('content' => 'No seleccionó patrones')));
            }else{
                $q = "INSERT INTO am_orden (am_metodo_calibracion_mc_id, am_recepcion_recp_id, or_fecha_hora_apertura, or_fecha_hora_entrega, or_fecha_hora_inicio, or_fecha_hora_finaliza, or_servicio, or_tipo, or_estado, or_director_id, or_tiempo_empleado, or_borrado, or_responsable) VALUES (" . $this->metodo . "," . $this->idrecep . "," . $this->UTILITY->date_now_server() . ",'" . "','" . "','" . "','" . $this->servicio . "','" . $this->tipo . "','". $this->estado . "',". $this->iddirector . ",'" . "'," . 0 . "," . $this->idresponsable . ")";
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $id = mysqli_insert_id($this->conexion);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
                for ($i = 0; $i < $contador; $i++) {
                    $q2 = "INSERT INTO am_patrones (am_orden_or_id, am_equipos_eq_id) VALUES (". $id . "," . $this->patrones[$i]['id'] . ")";
                    mysqli_query($this->conexion, $q2) or die(mysqli_error() . "***ERROR: " . $q2);
                }
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