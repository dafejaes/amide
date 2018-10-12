-- Se agregan los clientes

INSERT INTO `am_clientes` (`cli_id`, `cli_nombre`, `cli_tipo`, `cli_url`, `cli_nit`, `cli_estado`, `cli_actualizado`, `cli_borrado`) VALUES
(1, 'Hospital Universidad de Antioquia', 'Interno', 'www.udea.edu.co', '890980040-8', 1, NOW(), 0);

-- Se crean las sucursales

INSERT INTO `am_sucursales` (`suc_id`, `am_clientes_cli_id`, `suc_nombre`, `suc_ciudad`, `suc_direccion`, `suc_telefono`, `suc_actualizado`, `suc_borrado`) VALUES
(1, 1, 'Hospital Ciudad Universitaria', 'Medellin', 'calle 67 No. 53 - 108', '219 8332', NOW(), 0);

--  Se agregan los usuarios

INSERT INTO `am_usuarios` (`usr_id`, `am_sucursales_suc_id`, `usr_nombre`, `usr_correo`, `usr_contrasena`, `usr_telefono`, `usr_cargo`, `usr_estado`, `usr_actualizado`, `usr_borrado`) VALUES
(1, 1, 'Prueba', 'prueba@correo.com', '95B490918894B85EB280AF6B54DB9DBF811ED3D7', '12345', 'Administrador', 1, NOW(), 0);

-- Se crean los perfiles

INSERT INTO `am_perfiles` (`prf_id`, `prf_nombre`, `prf_descripcion`, `prf_actualizado`, `prf_borrado`) VALUES
(1, 'Clientes - ver', 'El usuario puede ver los clientes', NOW(), 0),
(2, 'Clientes - editar', 'El usuario puede editar los clientes', NOW(), 0),
(3, 'Clientes - crear', 'El usuario puede crear clientes', NOW(), 0),
(4, 'Clientes - borrar', 'El usuario puede borrar clientes', NOW(), 0),
(5, 'Ubicaciones - ver', 'El usuario puede ver las oficinas', NOW(), 0),
(6, 'Ubicaciones - editar', 'El usuario puede editar las oficinas', NOW(), 0),
(7, 'Ubicaciones - crear', 'El usuario puede crear oficinas', NOW(), 0),
(8, 'Ubicaciones - borrar', 'El usuario puede borrar las oficinas', NOW(), 0),
(9, 'Equipos - ver', 'El usuario puede ver los equipos', NOW(), 0),
(10, 'Equipos - editar', 'El usuario puede editar los equipos', NOW(), 0),
(11, 'Equipos - crear', 'El usuario puede crear equipos', NOW(), 0),
(12, 'Equipos - borrar', 'El usuario puede borrar equipos', NOW(), 0);

INSERT INTO `am_usuarios_has_am_perfiles` (`am_usuarios_usr_id`, `am_perfiles_prf_id`) VALUES
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12);