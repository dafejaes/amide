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
        if ($this->op == 'sersave') {
            $this->idcli = isset($rqst['idcli']) ? $rqst['idcli'] : 0;
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->apellido = isset($rqst['apellido']) ? $rqst['apellido'] : '';
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->identificacion = isset($rqst['identificacion']) ? $rqst['identificacion'] : '';
            $this->cargo = isset($rqst['cargo']) ? $rqst['cargo'] : '';
            $this->telefono = isset($rqst['telefono']) ? $rqst['telefono'] : '';
            $this->celular = isset($rqst['celular']) ? $rqst['celular'] : '';
            $this->pais = isset($rqst['pais']) ? $rqst['pais'] : '';
            $this->departamento = isset($rqst['departamento']) ? $rqst['departamento'] : '';
            $this->ciudad = isset($rqst['ciudad']) ? $rqst['ciudad'] : '';
            $this->direccion = isset($rqst['direccion']) ? $rqst['direccion'] : '';
            $this->habilitado = isset($rqst['habilitado']) ? intval($rqst['habilitado']) : 0;
            $this->sersave();
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
                'id' => $obj->rcp_id,
                'consecutivo' => $obj->rcp_consecutivo,
                'nombreequipo' => $obj->eqt_nombre,
                'nombreser' =>$obj->ser_nombre,
                'estado' => $obj->rcp_estado,
                'ubicacion' => $obj->ubi_ubicacion,
                'torre' => $obj->ubi_torre,
                'piso' => $obj->ubi_piso,
                'extension' => $obj->ubi_extension,
                'fecharecepcion' =>$obj->rcp_fecharecepcion,
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

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }

}