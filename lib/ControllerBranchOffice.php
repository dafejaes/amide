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
        $q = "SELECT * FROM am_sucursales, am_clientes where am_clientes_cli_id = cli_id ORDER BY suc_nombre AND suc_borrado = 0";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_sucursales, am_clientes WHERE suc_id = " . $this->id . "AND am_clientes_cli_id = cli_id"    ;
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

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }
}