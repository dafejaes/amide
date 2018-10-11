-- MySQL Script generated by MySQL Workbench
-- Thu Oct 11 15:22:35 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema amide_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `amide_db` ;

-- -----------------------------------------------------
-- Schema amide_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `amide_db` DEFAULT CHARACTER SET utf8 ;
USE `amide_db` ;

-- -----------------------------------------------------
-- Table `amide_db`.`am_clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_clientes` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_clientes` (
  `cli_id` INT NOT NULL,
  `cli_nombre` VARCHAR(255) NULL,
  `cli_nit` VARCHAR(45) NULL,
  `cli_tipo` VARCHAR(45) NULL,
  `cli_estado` VARCHAR(45) NULL,
  `cli_actualizado` DATETIME NULL,
  `cli_borrado` TINYINT NULL,
  PRIMARY KEY (`cli_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_sucursales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_sucursales` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_sucursales` (
  `suc_id` INT NOT NULL,
  `am_clientes_cli_id` INT NOT NULL,
  `suc_nombre` VARCHAR(255) NULL,
  `suc_ciudad` VARCHAR(45) NULL,
  `suc_direccion` VARCHAR(255) NULL,
  `suc_telefono` VARCHAR(45) NULL,
  `suc_actualizado` DATETIME NULL,
  `suc_borrado` TINYINT NULL,
  PRIMARY KEY (`suc_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_usuarios` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_usuarios` (
  `usr_id` INT NOT NULL,
  `am_sucursales_suc_id` INT NOT NULL,
  `usr_nombre` VARCHAR(255) NULL,
  `usr_correo` VARCHAR(100) NULL,
  `usr_contraseña` VARCHAR(45) NULL,
  `usr_telefono` VARCHAR(45) NULL,
  `usr_cargo` VARCHAR(100) NULL,
  `usr_estado` TINYINT NULL,
  `usr_actualizado` VARCHAR(45) NULL,
  `usr_borrado` TINYINT NULL,
  PRIMARY KEY (`usr_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_perfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_perfiles` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_perfiles` (
  `prf_id` INT NOT NULL,
  `prf_nombre` VARCHAR(100) NULL,
  `prf_descripcion` VARCHAR(255) NULL,
  `prf_actualizado` DATETIME NULL,
  `prf_borrado` TINYINT NULL,
  PRIMARY KEY (`prf_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_usuarios_has_am_perfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_usuarios_has_am_perfiles` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_usuarios_has_am_perfiles` (
  `am_usuarios_usr_id` INT NOT NULL,
  `am_perfiles_prf_id` INT NOT NULL,
  PRIMARY KEY (`am_usuarios_usr_id`, `am_perfiles_prf_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_ubicaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_ubicaciones` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_ubicaciones` (
  `ubi_id` INT NOT NULL,
  `am_sucursales_suc_id` INT NOT NULL,
  `ubi_torre` VARCHAR(45) NULL,
  `ubi_piso` VARCHAR(45) NULL,
  `ubi_ubicacion` VARCHAR(45) NULL,
  `ubi_extension` VARCHAR(45) NULL,
  `ubi_actualizado` DATETIME NULL,
  `ubi_borrado` TINYINT NULL,
  PRIMARY KEY (`ubi_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_areas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_areas` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_areas` (
  `are_id` INT NOT NULL,
  `am_sucursales_suc_id` INT NOT NULL,
  `are_nombre` VARCHAR(100) NULL,
  `are_actualizado` DATETIME NULL,
  `are_borrado` TINYINT NULL,
  PRIMARY KEY (`are_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_departamento` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_departamento` (
  `dep_id` INT NOT NULL,
  `am_areas_are_id` INT NOT NULL,
  `dep_nombre` VARCHAR(100) NULL,
  `dep_actualizado` DATETIME NULL,
  `dep_borrado` TINYINT NULL,
  PRIMARY KEY (`dep_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_servicio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_servicio` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_servicio` (
  `ser_id` INT NOT NULL,
  `am_departamento_dep_id` INT NOT NULL,
  `ser_nombre` VARCHAR(45) NULL,
  `ser_actualizado` DATETIME NULL,
  `ser_borrado` TINYINT NULL,
  PRIMARY KEY (`ser_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_ubicaciones_has_am_areas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_ubicaciones_has_am_areas` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_ubicaciones_has_am_areas` (
  `am_ubicaciones_ubi_id` INT NOT NULL,
  `am_areas_are_id` INT NOT NULL,
  PRIMARY KEY (`am_ubicaciones_ubi_id`, `am_areas_are_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_equipos_tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_equipos_tipo` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_equipos_tipo` (
  `eqt_id` INT NOT NULL AUTO_INCREMENT,
  `eqt_nombre` VARCHAR(300) NOT NULL,
  `eqt_marca` VARCHAR(60) NOT NULL,
  `eqt_modelo` VARCHAR(60) NULL,
  `eqt_clasificacion` VARCHAR(100) NULL,
  `eqt_alias` VARCHAR(300) NULL,
  `eqt_es_biomedico` TINYINT NULL,
  `eqt_patron` TINYINT NULL,
  `eqt_uso_metrol` TINYINT NULL,
  `eqt_simulador` TINYINT NULL,
  `eqt_actualizado` DATETIME NULL,
  `eqt_borrado` TINYINT NULL,
  PRIMARY KEY (`eqt_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_equipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_equipos` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_equipos` (
  `eq_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `am_servicio_ser_id` INT NOT NULL,
  `am_ubicaciones_ubi_id` INT NOT NULL,
  `eq_serie` VARCHAR(100) NULL,
  `eq_placa` VARCHAR(100) NULL,
  `eq_codigo` INT NULL,
  `eq_borrado` TINYINT NULL,
  `eq_actualizado` DATETIME NULL,
  PRIMARY KEY (`eq_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_partec`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_partec` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_partec` (
  `partec_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `partec_nombre` VARCHAR(50) BINARY NULL,
  `partec_valor` VARCHAR(50) NULL,
  `partec_unidad` VARCHAR(50) NULL,
  `partec_actualizado` DATETIME NULL,
  `partec_borrado` TINYINT NULL,
  PRIMARY KEY (`partec_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_instructivo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_instructivo` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_instructivo` (
  `ins_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `ins_secuencia` VARCHAR(100) NULL,
  `ins_paso` VARCHAR(60) NULL,
  `ins_tipo_paso` VARCHAR(60) NULL,
  `ins_actualizado` DATETIME NULL,
  `ins_borrado` TINYINT NULL,
  PRIMARY KEY (`ins_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_vmetro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_vmetro` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_vmetro` (
  `vmetro_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `vmetro_nombre` VARCHAR(1024) NULL,
  `vmetro_costo` VARCHAR(60) NULL,
  `vmetro_anno` YEAR(4) NULL,
  `vmetro_actualizado` DATETIME NULL,
  `vmetro_borrado` TINYINT NULL,
  PRIMARY KEY (`vmetro_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_magcali`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_magcali` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_magcali` (
  `mc_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `mc_nombre` VARCHAR(100) NULL,
  `mc_inferior` INT NULL,
  `mc_superior` INT NULL,
  `mc_emax` INT NULL,
  `mc_unidad` VARCHAR(1024) NULL,
  `mc_borrado` TINYINT NULL,
  `mc_actualizado` DATETIME NULL,
  PRIMARY KEY (`mc_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_recepcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_recepcion` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_recepcion` (
  `recp_id` INT NOT NULL,
  `am_equipos_eq_id` INT NOT NULL,
  `am_ubicaciones_ubi_id` INT NOT NULL,
  `am_servicio_ser_id` INT NOT NULL,
  `rcp_consecutivo` INT NULL,
  `rcp_estado` VARCHAR(30) NULL,
  `rcp_fechaingreso` DATETIME NULL,
  `rcp_servicio` VARCHAR(100) NULL,
  `rcp_golpes` TINYINT NULL,
  `rcp_manchas` TINYINT NULL,
  `rcp_prueba_encendido` TINYINT NULL,
  `rcp_escala_medicion` INT NULL,
  `rcp_obs_recepcion` VARCHAR(2000) NULL,
  `rcp_obs_entrega` VARCHAR(2000) NULL,
  `rcp_recepcionista_id` INT NULL,
  `rcp_borrado` TINYINT NULL,
  PRIMARY KEY (`recp_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_recepcion_has_am_equipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_recepcion_has_am_equipos` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_recepcion_has_am_equipos` (
  `req_id` INT NOT NULL,
  `am_recepcion_recp_id` INT NOT NULL,
  `am_equipos_eq_id` INT NOT NULL,
  `req_certificado` VARCHAR(100) NULL,
  `req_fechaentrega` DATETIME NULL,
  `req_entregado` TINYINT NULL,
  `req_borrado` TINYINT NULL,
  PRIMARY KEY (`req_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_metodo_calibracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_metodo_calibracion` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_metodo_calibracion` (
  `mc_id` INT NOT NULL,
  `mc_nombre` VARCHAR(200) NULL,
  `mc_descripcion` VARCHAR(2000) NULL,
  `mc_borrado` TINYINT NULL,
  `mc_actualizado` DATETIME NULL,
  PRIMARY KEY (`mc_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_orden`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_orden` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_orden` (
  `or_id` INT NOT NULL,
  `am_metodo_calibracion_mc_id` INT NOT NULL,
  `am_equipos_eq_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  `am_recepcion_has_am_equipos_req_id` INT NOT NULL,
  `or_fecha_hora_apertura` DATETIME NULL,
  `or_fecha_hora_entrega` DATETIME NULL,
  `or_fecha_hora_inicio` DATETIME NULL,
  `or_fecha_hora_finaliza` DATETIME NULL,
  `or_servicio` VARCHAR(60) NULL,
  `or_tipo` VARCHAR(60) NULL,
  `or_estado` VARCHAR(60) NULL,
  `or_tiempo_empleado` TIME NULL,
  `or_borrado` INT NULL,
  PRIMARY KEY (`or_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`user` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`user` (
  `username` VARCHAR(16) NOT NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(32) NOT NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP);


-- -----------------------------------------------------
-- Table `amide_db`.`am_calibracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_calibracion` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_calibracion` (
  `cal_id` INT NOT NULL,
  `am_orden_or_id` INT NOT NULL,
  `cal_calibrador_id` INT NULL,
  `cal_revisor_id` INT NULL,
  `cal_codigo` VARCHAR(200) NULL,
  `cal_fecha_hora_calibracion` DATETIME NULL,
  `cal_estado` VARCHAR(60) NULL,
  `cal_borrado` TINYINT NULL,
  PRIMARY KEY (`cal_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_patrones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_patrones` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_patrones` (
  `am_orden_or_id` INT NOT NULL,
  `am_equipos_eq_id` INT NOT NULL,
  PRIMARY KEY (`am_orden_or_id`, `am_equipos_eq_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amide_db`.`am_metodo_calibracion_has_am_equipos_tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amide_db`.`am_metodo_calibracion_has_am_equipos_tipo` ;

CREATE TABLE IF NOT EXISTS `amide_db`.`am_metodo_calibracion_has_am_equipos_tipo` (
  `am_metodo_calibracion_mc_id` INT NOT NULL,
  `am_equipos_tipo_eqt_id` INT NOT NULL,
  PRIMARY KEY (`am_metodo_calibracion_mc_id`, `am_equipos_tipo_eqt_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
