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

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }

}

?>