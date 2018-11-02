<?php
include 'ConectionDb.php';
include 'Util.php';

class ControllerClosedOrder {
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
        if ($this->op == 'recepsave') {
            $this->ideq = isset($rqst['ideq']) ? intval($rqst['ideq']) : 0;
            $this->consecutivo=isset($rqst['consecutivo']) ? intval($rqst['consecutivo']) : 0;
            $this->estado = isset($rqst['estado']) ? $rqst['estado'] : '';
            $this->golpes= isset($rqst['golpes']) ? $rqst['golpes'] : '';
            $this->manchas = isset($rqst['manchas']) ? $rqst['manchas'] : '';
            $this->prueba = isset($rqst['prueba']) ? $rqst['prueba'] : '';
            $this->obsrecep= isset($rqst['obsrecep']) ? $rqst['obsrecep'] : '';
            $this->obsentre=  isset($rqst['obsentre']) ? $rqst['obsentre'] : '';
            $this->idrecep= isset($rqst['idrecep']) ? intval($rqst['idrecep']) : 0;
            $this->recepsave();
        } else if ($this->op == 'patronesordenget') {
            $this->patronesordenget();
        } else if ($this->op == 'obsget') {
            $this->idrecep2=isset($rqst['idrecep2']) ? intval($rqst['idrecep2']) : 0;
            $this->obsget();
        } else if ($this->op == 'recepget') {
            $this->recepget();
        } else if ($this->op == 'estadoordenedit') {
            $this->estadoordenedit();
        }else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**  Función para obtener las ubicaciones */

    public function ordencerraget() {
        $q = "SELECT * FROM am_orden, am_recepcion, am_equipos, am_ubicaciones, am_usuarios WHERE or_borrado = 0 AND am_recepcion_recp_id = recp_id AND am_equipos_eq_id = eq_id AND am_ubicaciones_ubi_id = ubi_id AND (or_estado = 'Medido' OR or_estado = 'Rechazado' OR or_estado = 'Corregido') AND or_responsable = usr_id ORDER BY rcp_consecutivo ";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_clientes WHERE cli_borrado = 0 AND cli_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'id' => $obj->or_id,
                'consecutivo' => ($obj->rcp_consecutivo),
                'responsable' => ($obj->usr_nombre),
                'fechageneracion' => ($obj->or_fecha_hora_apertura),
                'inicia' => ($obj->or_fecha_hora_inicio),
                'termina' => ($obj->or_fecha_hora_finaliza),
                'estado' => ($obj->or_estado));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    public function patronesordenget() {
        if ($this->id > 0) {
            $q = "SELECT * FROM am_patrones, am_equipos, am_equipos_tipo WHERE am_orden_or_id = ". $this->id . " AND am_equipos_eq_id = eq_id AND am_equipos_tipo_eqt_id = eqt_id";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'id' => $obj->eq_id,
                'equipo'=>$obj->eqt_nombre,
                'marca' =>$obj->eqt_marca,
                'modelo' => $obj->eqt_modelo,
                'placa' => $obj->eq_placa,
                'serie' => $obj->eq_serie,
                'codigo'=>$obj->eq_codigo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
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