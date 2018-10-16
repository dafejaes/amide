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
        if ($this->op == 'ubisave') {
            $this->idare = isset($rqst['idare']) ? intval($rqst['idare']) : 0;
            $this->idsuc = isset($rqst['idsuc']) ? intval($rqst['idsuc']) : 0;
            $this->torre = isset($rqst['torre']) ? $rqst['torre'] : '';
            $this->piso = isset($rqst['piso']) ? $rqst['piso'] : '';
            $this->ubicacion = isset($rqst['ubicacion']) ? $rqst['ubicacion'] : '';
            $this->extension = isset($rqst['extension']) ? $rqst['extension'] : '';
            $this->ubisave();
        } else if ($this->op == 'ubiget') {
            $this->locatget();
        } else if ($this->op == 'clidelete') {
            $this->clidelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function ubisave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT ubi_id FROM am_ubicaciones WHERE ubi_id = " . $this->id;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->cli_id;
                $table = "am_ubicaciones";
                $arrfieldscomma = array(
                    'am_sucursales_suc_id' => $this->idsuc,
                    'ubi_torre' => $this->torre,
                    'ubi_piso' => $this->piso,
                    'ubi_ubicacion' => $this->ubicacion,
                    'ubi_extension' => $this->extension);
                $arrfieldsnocomma = array('ubi_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "cli_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            }
            $q = "UPDATE am_ubicaciones_has_am_areas SET am_areas_are_id =". $this->idare . "WHERE am_ubicaciones_ubi_id =" . $this->id;
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        } else {
            $q = "INSERT INTO am_ubicaciones (am_sucursales_suc_id, ubi_torre, ubi_piso, ubi_ubicacion, ubi_extension, ubi_actualizado, ubi_borrado) VALUES (" . $this->idsuc . ", '". $this->torre . "','" .  $this->piso . "','" . $this->ubicacion . "','" . $this->extension . "'," . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $q = "INSERT INTO am_ubicaciones_has_am_areas (am_ubicaciones_ubi_id, am_areas_are_id)VALUES (" . $id . "," . $this->idare . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    public function locatget() {
        $q = "SELECT ubi_id, suc_id, suc_nombre, ubi_ubicacion, are_nombre, ubi_piso, ubi_torre, ubi_extension, ubi_actualizado FROM am_ubicaciones, am_areas, am_sucursales, am_ubicaciones_has_am_areas WHERE ubi_borrado = 0 AND am_ubicaciones.am_sucursales_suc_id = suc_id AND am_ubicaciones_ubi_id = ubi_id AND am_areas_are_id =are_id ORDER BY ubi_ubicacion ASC";
        if ($this->id > 0) {
            $q = "SELECT ubi_id, suc_id, ubi_ubicacion, are_nombre, ubi_piso, ubi_torre, ubi_extension, ubi_actualizado FROM am_ubicaciones, am_areas, am_sucursales, am_ubicaciones_has_am_areas WHERE ubi_borrado = 0 AND am_ubicaciones.am_sucursales_suc_id = suc_id AND am_ubicaciones_ubi_id = ubi_id AND am_areas_are_id =are_id AND ubi_id=" . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'id' => $obj->ubi_id,
                'idsuc' => $obj->suc_id,
                'ubicacion'=>$obj->ubi_ubicacion,
                'sucnombre'=>$obj->suc_nombre,
                'areanombre'=>$obj->are_nombre,
                'piso'=>$obj->ubi_piso,
                'torre' => $obj->ubi_piso,
                'extension' => $obj->ubi_extension,
                'dtcreate' => $obj->ubi_actualizado);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function clidelete() {
        if ($this->id > 0) {
            $q = "UPDATE am_clientes SET cli_borrado = 1 WHERE cli_id = $this->id";
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $q = "UPDATE am_sucursales SET suc_borrado = 1 WHERE am_clientes_cli_id = $this->id";
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

    public function setId($_id) {
        $this->id = $_id;
    }

}

?>