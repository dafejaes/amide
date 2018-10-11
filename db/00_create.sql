CREATE TABLE `dmt_usuario` (
  `usr_id` int(11) NOT NULL auto_increment,
  `dmt_cliente_cli_id` int(11) default NULL,
  `usr_dtcreate` datetime NOT NULL,
  `usr_nombre` varchar(100) default NULL,
  `usr_apellido` varchar(100) default NULL,
  `usr_cargo` varchar(45) default NULL,
  `usr_identificacion` varchar(45) default NULL,
  `usr_email` varchar(100) default NULL,
  `usr_pass` varchar(60) default NULL,
  `usr_telefono` varchar(45) default NULL,
  `usr_celular` varchar(45) default NULL,
  `usr_habilitado` varchar(10) default NULL,
  `usr_contacto` varchar(10) default NULL,
  `usr_pais` varchar(100) default NULL,
  `usr_departamento` varchar(100) default NULL,
  `usr_ciudad` varchar(100) default NULL,
  `usr_direccion` varchar(100) default NULL,
  `usr_imagen` varchar(100) default NULL,
  PRIMARY KEY  (`usr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE `dmt_cliente` (
  `cli_id` int(11) NOT NULL auto_increment,
  `cli_dtcreate` datetime NOT NULL,
  `cli_nombre` varchar(100) default NULL,
  `cli_nit` varchar(45) default NULL,
  `cli_email` varchar(100) default NULL,
  `cli_telefono` varchar(45) default NULL,
  `cli_pais` varchar(45) default NULL,
  `cli_departamento` varchar(45) default NULL,
  `cli_ciudad` varchar(45) default NULL,
  `cli_direccion` varchar(100) default NULL,
  `cli_estado` varchar(100) default NULL,
  `cli_url` varchar(100) default NULL,
  `cli_fecha_inicio` datetime NOT NULL,
  `cli_fecha_fin` datetime NOT NULL,
  PRIMARY KEY  (`cli_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `dmt_perfiles` (
  `prf_id` int(11) NOT NULL auto_increment,
  `prf_nombre` varchar(45) NOT NULL,
  `prf_descripcion` varchar(45) default NULL,
  PRIMARY KEY  (`prf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `dmt_usuario_has_dmt_perfiles` (
  `dmt_usuario_usr_id` int(11) NOT NULL,
  `dmt_perfiles_prf_id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL,
  PRIMARY KEY  (`dmt_usuario_usr_id`,`dmt_perfiles_prf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dmt_cer_ent` (
  `cer_ent_usr_id` int(11) NOT NULL,
  `cer_ent_cli_id` int(11) NOT NULL,
  `cer_ent_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`cer_ent_usr_id`,`cer_ent_cli_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dmt_cer_met` (
  `cer_met_usr_id` int(11) NOT NULL,
  `cer_met_cli_id` int(11) NOT NULL,
  `cer_met_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`cer_met_usr_id`,`cer_met_cli_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;