<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 */
class ControllerUser {

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
        if ($this->op != 'usrlogin') {
            if (!$this->UTILITY->validate_key($this->ke, $this->ti, $this->lu)) {
                $this->op = 'noautorizado';
            }
        } else {
            if (!$this->UTILITY->validate_key($this->ke, $this->ti)) {
                $this->op = 'noautorizado';
            }
        }
        if ($this->op == 'usrsave') {
            $this->idsuc = isset($rqst['idsuc']) ? $rqst['idsuc'] : 0;
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->identificacion = isset($rqst['identificacion']) ? $rqst['identificacion'] : '';
            $this->cargo = isset($rqst['cargo']) ? $rqst['cargo'] : '';
            $this->telefono = isset($rqst['telefono']) ? $rqst['telefono'] : '';
            $this->estado = isset($rqst['estado']) ? $rqst['estado'] : '';
            $this->usrsave();
        } else if ($this->op == 'usrlogin') {
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->usrlogin();
        } else if ($this->op == 'usrget') {
            $this->usrget();
        } else if ($this->op == 'usrprfget') {
            $this->usrprfget();
        } else if ($this->op == 'usrprfsave') {
            $this->chk = isset($rqst['chk']) ? $rqst['chk'] : '';
            $this->usrprfsave();
        } else if ($this->op == 'usrdelete') {
            $this->usrdelete();
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
    private function usrsave() {
        $id = 0;
        $resultado = 0;
        $pass = '';
        if($this->estado == 'Activo'){
            $estado2=1;
        }else if($this->estado == 'Inactivo'){
            $estado2=0;
        }
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();
        } else {
            if ($this->id > 0) {
                //se verifica que el email está disponible
                $q = "SELECT usr_id FROM am_usuarios WHERE usr_correo = '" . $this->email . "' AND usr_id != $this->id ";
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    //actualiza la informacion
                    $q = "SELECT usr_id FROM am_usuarios WHERE usr_id = " . $this->id;
                    $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                    while ($obj = mysqli_fetch_object($con)) {
                        $id = $obj->usr_id;
                        if (strlen($this->pass) > 2) {
                            $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                        }
                        $table = "am_usuarios";
                        $arrfieldscomma = array(
                            'usr_nombre' => $this->nombre,
                            'usr_correo' => $this->email,
                            'usr_contrasena' => $pass,
                            'usr_cargo' => $this->cargo,
                            'usr_identificacion' => $this->identificacion,
                            'usr_telefono' => $this->telefono,
                            'usr_estado' => $estado2);
                        $arrfieldsnocomma = array('am_sucursales_suc_id' => $this->idsuc,'usr_actualizado' => $this->UTILITY->date_now_server());
                        $q = $this->UTILITY->make_query_update($table, "usr_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                        mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                        $arrjson = array('output' => array('valid' => true, 'id' => $id));
                    }
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            } else {
                //se verifica que el email está disponible
                $q = "SELECT usr_id FROM am_usuarios WHERE usr_correo = '" . $this->email . "'";
                $con = mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    if (strlen($this->pass) > 2) {
                        $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                    }
                    $this->pass = $pass;
                    $q = "INSERT INTO am_usuarios (am_sucursales_suc_id, usr_nombre, usr_correo, usr_contrasena,usr_telefono, usr_cargo, usr_estado, usr_identificacion, usr_actualizado, usr_borrado ) VALUES (" . $this->idsuc . ",'" . $this->nombre . "','" . $this->email . "','" . $this->pass . "','" . $this->telefono . "','". $this->cargo . "'," . $estado2 . ",'" . $this->identificacion . "'," . $this->UTILITY->date_now_server() . ",". 0 . ")";
                    mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
                    $id = mysqli_insert_id($this->conexion);
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            }
        }
        $this->response = ($arrjson);
    }

    public function usrget() {
        if ($this->id > 0) {
            $q = "SELECT * FROM am_usuarios WHERE usr_id = " . $this->id . " AND usr_borrado = 0";
            $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            $arr = array();
            while ($obj = mysqli_fetch_object($con)) {
                $arr[] = array(
                    'id' => $obj->usr_id,
                    'idsuc'=> $obj->am_sucursales_suc_id,
                    'nombre'=> $obj->usr_nombre,
                    'correo' => $obj->usr_correo,
                    'telefono' => $obj->usr_telefono,
                    'cargo' => $obj->usr_cargo,
                    'identificacion'=> $obj->usr_identificacion,
                    'pass'=>$obj->usr_contrasena,
                    'dtcreate' => $obj->usr_actualizado);

            }
        }else{
            $q = "SELECT * FROM am_usuarios, am_sucursales WHERE am_sucursales_suc_id = suc_id AND usr_borrado = 0 ORDER BY usr_nombre ASC";
            $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $resultado = mysqli_num_rows($con);
            $arr = array();
            while ($obj = mysqli_fetch_object($con)) {
                $arr[] = array(
                    'id' => $obj->usr_id,
                    'idsuc'=> $obj->am_sucursales_suc_id,
                    'nombre'=> $obj->usr_nombre,
                    'correo' => $obj->usr_correo,
                    'telefono' => $obj->usr_telefono,
                    'cargo' => $obj->usr_cargo,
                    'sucnombre'=> $obj->suc_nombre,
                    'dtcreate' => $obj->usr_actualizado);

            }
        }
        //if ($this->sdid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_sede_sde_id = " . $this->sdid;
        //}
        //if ($this->euid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_empresa_emp_id = " . $this->euid;
        //}

        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function usrdelete() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "DELETE FROM dmt_usuario WHERE usr_id = " . $this->id;
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    /**
     * Metodo para loguearse
     */
    private function usrlogin() {
        //$resultado = 0;
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();
        } else {
            if ($this->pass == "") {
                $arrjson = $this->UTILITY->error_missing_data();
            } else {
                $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                $q = "SELECT * FROM am_usuarios WHERE usr_correo = '$this->email' AND usr_contrasena = '$pass' AND usr_estado = 1 AND usr_borrado = 0";
                $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                while ($obj = mysqli_fetch_object($con)) {
                    $q2 = "SELECT suc_id, suc_nombre FROM am_sucursales WHERE suc_id = " . $obj->am_sucursales_suc_id;
                    $con2 = mysqli_query($this->conexion,$q2) or die(mysqli_error() . "***ERROR: " . $q2);
                    $sucursal = '0';
                    $sucursalnombre = 'ninguno';
                    while ($obj2 = mysqli_fetch_object($con2)) {
                        $sucursal = $obj2->suc_id;
                        $sucursalnombre = $obj2->suc_nombre;
                    }

                    //se consultan los perfiles asignados
                    $q3 = "SELECT am_perfiles_prf_id FROM am_usuarios_has_am_perfiles WHERE am_usuarios_usr_id = $obj->usr_id ORDER BY am_perfiles_prf_id ASC";
                    $con3 = mysqli_query($this->conexion,$q3) or die(mysqli_error() . "***ERROR: " . $q3);
                    $arrassigned = array();
                    while ($obj3 = mysqli_fetch_object($con3)) {
                        $arrassigned[] = ($obj3->am_perfiles_prf_id);
                    }

                    //se consulta el cliente
                    $arrjson = array('output' => array(
                            'valid' => true,
                            'id' => $obj->usr_id,
                            'idsuc' => ($sucursal),
                            'sucursalnombre' => ($sucursalnombre),
                            'nombre' => ($obj->usr_nombre),
                            'cargo' => ($obj->usr_cargo),
                            'email' => ($obj->usr_correo),
                            'telefono' => ($obj->usr_telefono),
                            'habilitado' => ($obj->usr_estado),
                            'dtcreate' => ($obj->usr_actualizado),
                            'permisos' => $arrassigned));
                }
                if ($resultado == 0) {
                    $arrjson = $this->UTILITY->error_wrong_data_login();
                }
            }
        }
        $this->response = ($arrjson);
    }

    private function usrprfget() {
        //se consultan los perfiles asignados
        $q = "SELECT * FROM dmt_usuario_has_dmt_perfiles WHERE dmt_usuario_usr_id = $this->id ORDER BY dmt_perfiles_prf_id ASC";
        $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
        $arrassigned = array();
        $arravailable = array();
        while ($obj = mysql_fetch_object($con)) {
            $arrassigned[] = array('id' => $obj->dmt_perfiles_prf_id);
        }
        //se consultan los perfiles disponibles
        $q = "SELECT * FROM dmt_perfiles ORDER BY prf_nombre ASC";
        $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
        while ($obj = mysql_fetch_object($con)) {
            $arravailable[] = array(
                'id' => $obj->prf_id,
                'nombre' => $obj->prf_nombre,
                'descripcion' => $obj->prf_descripcion);
        }

        $arrjson = array('output' => array('valid' => true, 'available' => $arravailable, 'assigned' => $arrassigned));
        $this->response = ($arrjson);
    }

    private function usrprfsave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "DELETE FROM dmt_usuario_has_dmt_perfiles WHERE dmt_usuario_usr_id = " . $this->id;
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $arrchk = explode('-', $this->chk);
            for ($i = 0; $i < count($arrchk); $i++) {
                $prf_id = intval($arrchk[$i]);
                if ($prf_id > 0) {
                    $q = "INSERT INTO dmt_usuario_has_dmt_perfiles (dmt_usuario_usr_id, dmt_perfiles_prf_id, dtcreate) VALUES ($this->id, $prf_id, " . $this->UTILITY->date_now_server() . ")";
                    mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                }
            }
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

    public function extraLogin($email, $pass) {
        $this->email = $email;
        $this->pass = $pass;
        $this->usrlogin();
    }

}

?>