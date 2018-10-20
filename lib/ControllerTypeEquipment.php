<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 */

class ControllerTypeEquipment {

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
        if ($this->op == 'tipoeqsave') {
            $this->clase = isset($rqst['clase']) ? $rqst['clase'] : '';
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->alias = isset($rqst['alias']) ? $rqst['alias'] : '';
            $this->marca = isset($rqst['marca']) ? $rqst['marca'] : '';
            $this->modelo = isset($rqst['modelo']) ? $rqst['modelo'] : '';
            $this->clasificacion = isset($rqst['clasificacion']) ? $rqst['clasificacion'] : '';
            $this->tipo = isset($rqst['tipo']) ? $rqst['tipo'] : '';
            $this->id2 = isset($rqst['id2']) ? $rqst['id2'] : '';
            $this->tipoeqsave();
        } else if ($this->op == 'tipoeqget') {
            $this->tequiget();
        } else if ($this->op == 'tipoeqdelete') {
            $this->tipoeqdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else if ($this->op == 'partecget'){
            $this->partecget();
        }else if ($this->op == 'magcaliget'){
            $this->magcaliget();
        }else if ($this->op == 'partecsave'){
            $this->idpartec=isset($rqst['idpartec']) ? intval($rqst['idpartec']) : 0;
            $this->namepartec=isset($rqst['nombrepartec']) ? $rqst['nombrepartec'] : '';
            $this->valor=isset($rqst['valor']) ? $rqst['valor'] : '';
            $this->unidad=isset($rqst['unidad']) ? $rqst['unidad'] : '';
            $this->partecsave();
        } else if ($this->op == 'magcalisave'){
            $this->idmagcali=isset($rqst['idmagcali']) ? intval($rqst['idmagcali']) : 0;
            $this->namemagcali=isset($rqst['nombremagcali']) ? $rqst['nombremagcali'] : '';
            $this->inferior=isset($rqst['inferior']) ? $rqst['inferior'] : '';
            $this->superior=isset($rqst['superior']) ? $rqst['superior'] : '';
            $this->emax=isset($rqst['emax']) ? $rqst['emax'] : '';
            $this->unidadmagcali=isset($rqst['unidadmagcali']) ? $rqst['unidadmagcali'] : '';
            $this->magcalisave();
        } else if ($this->op == 'partecdelete'){
            $this->idpartec = isset($rqst['idpartec']) ? intval($rqst['idpartec']) : 0;
            $this->partecdelete();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function tipoeqsave() {
        $simulador=0;
        $patron=0;
        $biomedico=0;
        if($this->clase == 'Simulador'){
            $patron=1;
            $simulador=1;
        }else if($this->clase=='Patron'){
            $patron=1;
        }else if($this->clase=='Biomedico'){
            $biomedico=1;
        }
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT eqt_id FROM am_equipos_tipo WHERE eqt_id = " . $this->id;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $id = $obj->eqt_id;
                $table = "am_equipos_tipo";
                $arrfieldscomma = array(
                    'eqt_clase' => $this->clase,
                    'eqt_nombre' => $this->nombre,
                    'eqt_alias' => $this->alias,
                    'eqt_marca' => $this->marca,
                    'eqt_modelo' => $this->modelo,
                    'eqt_claisificacion' =>$this->clasificacion,
                    'eqt_tipo' =>$this->tipo,
                    'eqt_id2' => $this->id2,
                    'eqt_es_biomedico' => $biomedico,
                    'eqt_patron' => $patron,
                    'eqt_uso_metrol' => 1,
                    'eqt_simulador' => $simulador);
                $arrfieldsnocomma = array('eqt_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "eqt_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $q = "INSERT INTO am_equipos_tipo (eqt_clase,eqt_nombre,eqt_alias,eqt_marca,eqt_modelo,eqt_clasificacion,eqt_tipo,eqt_id2,eqt_es_biomedico,eqt_patron,eqt_uso_metrol,eqt_simulador, eqt_actualizado, eqt_borrado) VALUES ('" . $this->clase . "', '". $this->nombre . "','" .  $this->alias . "','" . $this->marca . "','" . $this->modelo . "','" . $this->clasificacion . "','" . $this->tipo . "','" . $this->id2 . "', ". $biomedico . ", " . $patron . ", " . 1 . "," . $simulador . ", " . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }
    private function partecsave() {
        if ($this->idpartec > 0) {
            //actualiza la informacion
            $q = "SELECT partec_id FROM am_partec WHERE partec_id = " . $this->idpartec;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $idpartec = $obj->partec_id;
                $table = "am_partec";
                $arrfieldscomma = array(
                    'partec_nombre' => $this->namepartec,
                    'partec_valor' => $this->valor,
                    'partec_unidad' => $this->unidad);
                $arrfieldsnocomma = array('partec_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "partec_id = '$idpartec'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $idpartec));
            }
        } else {
            $q = "INSERT INTO am_partec (am_equipos_tipo_eqt_id,partec_nombre,partec_valor,partec_unidad,partec_actualizado,partec_borrado) VALUES (". $this->id . ",'" . $this->namepartec . "', '". $this->valor . "','" .  $this->unidad . "', " . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $id = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    public function partecget() {
        $q = "SELECT * FROM am_partec WHERE partec_borrado = 0 ORDER BY eqt_nombre ASC ";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_partec WHERE partec_borrado = 0 AND am_equipos_tipo_eqt_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'idpartec' => $obj->partec_id,
                'namepartec' => $obj->partec_nombre,
                'valor' =>$obj->partec_valor,
                'unidad' => $obj->partec_unidad,
                'datecreate' => $obj->partec_actualizado);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    public function magcaliget() {
        $q = "SELECT * FROM am_magcali WHERE mc_borrado = 0 ORDER BY mc_nombre ASC ";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_magcali WHERE mc_borrado = 0 AND am_equipos_tipo_eqt_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'idmagcali' => $obj->mc_id,
                'namemagcali' => $obj->mc_nombre,
                'inferior' =>$obj->mc_inferior,
                'superior' => $obj->mc_superior,
                'emax' => $obj->mc_emax,
                'unidadmagcali' =>$obj->mc_unidad,
                'datecreate' => $obj->mc_actualizado);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function tequiget() {
        $q = "SELECT * FROM am_equipos_tipo WHERE eqt_borrado = 0 ORDER BY eqt_nombre ";
        if ($this->id > 0) {
            $q = "SELECT * FROM am_equipos_tipo WHERE eqt_borrado = 0 AND eqt_id = " . $this->id;
        }
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);

        $arr = array();
        while ($obj = mysqli_fetch_object($con)){
            $arr[] = array(
                'id' => $obj->eqt_id,
                'id2' => $obj->eqt_id2,
                'clase' =>$obj->eqt_clase,
                'nombre' => $obj->eqt_nombre,
                'marca' => $obj->eqt_marca,
                'modelo' => $obj->eqt_modelo,
                'clasificacion' => $obj->eqt_clasificacion,
                'alias' => $obj->eqt_alias,
                'biomedico' => $obj->eqt_es_biomedico,
                'patron' => $obj->eqt_patron,
                'usometrol' => $obj->eqt_uso_metrol,
                'simulador' => $obj->eqt_simulador,
                'datecreate' => $obj->eqt_actualizado,
                'tipo'=>$obj->eqt_tipo);
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }
    private function magcalisave() {
        if ($this->idmagcali > 0) {
            //actualiza la informacion
            $q = "SELECT mc_id FROM am_magcali WHERE mc_id = " . $this->idmagcali;
            $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            while ($obj = mysqli_fetch_object($con)) {
                $idmagcali = $obj->mc_id;
                $table = "am_magcali";
                $arrfieldscomma = array(
                    'mc_nombre' => $this->namemagcali,
                    'mc_inferior' => $this->inferior,
                    'mc_superior' => $this->superior,
                    'mc_emax' => $this->emax,
                    'mc_unidad' => $this->unidadmagcali);
                $arrfieldsnocomma = array('mc_actualizado' => $this->UTILITY->date_now_server());
                $q = $this->UTILITY->make_query_update($table, "mc_id = '$idmagcali'", $arrfieldscomma, $arrfieldsnocomma);
                mysqli_query($this->conexion, $q) or die(mysqli_error($this->conexion) . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $idmagcali));
            }
        } else {
            $q = "INSERT INTO am_magcali (am_equipos_tipo_eqt_id, mc_nombre, mc_inferior, mc_superior, mc_emax, mc_unidad, mc_actualizado, mc_borrado) VALUES (" . $this->id . ",'" . $this->namemagcali . "', ". $this->inferior . "," .  $this->superior . "," . $this->emax . ",'". $this->unidadmagcali . "', " . $this->UTILITY->date_now_server() . ", " . 0 . ")";
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $idmagcali = mysqli_insert_id($this->conexion);
            $arrjson = array('output' => array('valid' => true, 'id' => $idmagcali));
        }
        $this->response = ($arrjson);
    }

    private function tipoeqdelete() {
        if ($this->id > 0) {
            $q = "UPDATE am_equipos_tipo SET eqt_borrado = 1 WHERE eqt_id = $this->id";
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }
    private function partecdelete() {
        if ($this->idpartec > 0) {
            $q = "UPDATE am_partec SET partec_borrado = 1 WHERE partec_id = $this->idpartec";
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->idpartec));
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