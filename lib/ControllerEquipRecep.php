<?php
include 'ConectionDb.php';
include 'Util.php';

class ControllerEquipRecep {
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
        } else if ($this->op == 'conseget') {
            $this->conseget();
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

    public function eqrecepget() {
        $q = "SELECT * FROM am_equipos, am_ubicaciones, am_servicio, am_recepcion, am_equipos_tipo WHERE rcp_borrado = 0 AND am_equipos_eq_id = eq_id AND am_equipos.am_ubicaciones_ubi_id = ubi_id AND am_equipos.am_servicio_ser_id = ser_id AND am_equipos_tipo_eqt_id = eqt_id ORDER BY rcp_consecutivo ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_equipos, am_ubicaciones, am_servicio, am_recepcion  WHERE rcp = " . $this->id . " AND rcp_borrado = 0 AND am_equipos_eq_id = eq_id AND am_ubicaciones_ubi_id = ubi_id AND am_servicio_ser_id = ser_id AND am_equipos_tipo_eqt_id = eqt_id ORDER BY rcp_consecutivo";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->recp_id,
                'consecutivo' => $obj->rcp_consecutivo,
                'nombreequipo' => $obj->eqt_nombre,
                'nombreser' =>$obj->ser_nombre,
                'estado' => $obj->rcp_estado,
                'ubicacion' => $obj->ubi_ubicacion,
                'torre' => $obj->ubi_torre,
                'piso' => $obj->ubi_piso,
                'extension' => $obj->ubi_extension,
                'fecharecepcion' =>$obj->rcp_fechaingreso,
                'obsrecep' =>$obj->rcp_obs_recepcion,
                'obsentre' => $obj->rcp_obs_entrega);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function recepget() {
        $q = "SELECT * FROM am_clientes, am_sucursales, am_equipos_tipo, am_equipos, am_recepcion, am_ubicaciones WHERE recp_id = " . $this->id . " AND am_equipos_eq_id = eq_id AND am_equipos_tipo_eqt_id = eqt_id AND am_equipos.am_ubicaciones_ubi_id = ubi_id AND am_sucursales_suc_id = suc_id AND am_clientes_cli_id = cli_id";
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'idrecep' => $obj->recp_id,
                'consecutivo' => $obj->rcp_consecutivo,
                'sucnombre' => $obj->suc_nombre,
                'nit' => $obj->cli_nit,
                'direccion' =>$obj->suc_direccion,
                'fechaingreso' =>$obj->rcp_fechaingreso,
                'equipo'=>$obj->eqt_nombre,
                'marca' =>$obj->eqt_marca,
                'modelo' => $obj->eqt_modelo,
                'placa' => $obj->eq_placa,
                'serie' =>$obj->eq_serie,
                'golpes' =>$obj->rcp_golpes,
                'manchas' =>$obj->rcp_manchas,
                'prueba' =>$obj->rcp_prueba_encendido,
                'obsentre' =>$obj->rcp_obs_entrega,
                'obsrecep' =>$obj->rcp_obs_recepcion,
                'fechainicio'=>$this->UTILITY->date_now_server());
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function conseget() {
        $q = "SELECT rcp_consecutivo FROM am_recepcion ORDER BY rcp_consecutivo DESC LIMIT 1";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_equipos, am_ubicaciones, am_servicio, am_recepcion  WHERE rcp = " . $this->id . " AND rcp_borrado = 0 AND am_equipos_eq_id = eq_id AND am_ubicaciones_ubi_id = ubi_id AND am_servicio_ser_id = ser_id AND am_equipos_tipo_eqt_id = eqt_id ORDER BY rcp_consecutivo";
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'consecutivo' => $obj->rcp_consecutivo);
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

    private function recepsave() {
        if($this->golpes == 'Si'){
            $golpes=1;
        }else{
            $golpes=0;
        }
        if($this->manchas == 'Si'){
            $manchas=1;
        }else{
            $manchas=0;
        }
        if($this->prueba == 'Si'){
            $prueba=1;
        }else{
            $prueba=0;
        }
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT cli_id FROM am_clientes WHERE cli_id = " . $this->id;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->cli_id;
                $table = "am_clientes";
                $arrfieldscomma = array(
                    'cli_nombre' => $this->nombre,
                    'cli_estado' => 1,
                    'cli_nit' => $this->nit,
                    'cli_tipo' => $this->tipo,
                    'cli_url' => $this->url);
                $arrfieldsnocomma = array('cli_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "cli_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $q = "INSERT INTO am_recepcion (am_equipos_eq_id, rcp_consecutivo, rcp_estado, rcp_fechaingreso, rcp_golpes, rcp_manchas, rcp_prueba_encendido, rcp_obs_recepcion, rcp_obs_entrega, rcp_recepcionista_id, rcp_borrado) VALUES (". $this->ideq . "," . $this->consecutivo . ",'" . $this->estado . "'," . $this->UTILITY->date_now_server() . "," . $golpes . "," . $manchas . "," . $prueba . ",'" . $this->obsrecep . "','" . $this->obsentre . "'," . $this->idrecep . "," . 0 .")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }
    public function estadoordenedit(){
        if ($this->id > 0) {
            $q = "UPDATE am_recepcion SET rcp_estado = 'Orden generada' WHERE recp_id = $this->id";
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