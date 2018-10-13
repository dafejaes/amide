<?php
include 'ConectionDb.php';
include 'Util.php';
/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 */
class ControllerLocation {

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
        if ($this->op == 'locatsave') {
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
            $this->usrsave();
        } else if ($this->op == 'locatget') {
            $this->locatget();
        } else if ($this->op == 'locatsave') {
            $this->chk = isset($rqst['chk']) ? $rqst['chk'] : '';
            $this->usrprfsave();
        } else if ($this->op == 'locatdelete') {
            $this->usrdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**  Función para obtener las ubicaciones */

    public function locatget() {
        $q = "SELECT * FROM am_ubicaciones, am_ubicaciones_has_am_areas, am_areas WHERE am_ubicaciones_ubi_id = ubi_id AND am_areas_are_id = are_id AND ubi_borrado = 0 ORDER BY ubi_id";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_ubicaciones, am_ubicaciones_has_am_areas, am_areas WHERE am_ubicaciones_ubi_id = ubi_id AND am_areas_are_id= are_id AND ubi_borrado = 0 AND  ubi_id = ". $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->ser_id,
                'sucnombre' => $obj->suc_nombre,
                'torre'=>$obj->ubi_torre,
                'piso'=>$obj->ubi_piso,
                'ubicacion'=>$obj->ubi_ubicacion,
                'extension'=>$obj->ubi_extension,
                'dtcreate'=>$obj->ubi_actualizado
            );
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