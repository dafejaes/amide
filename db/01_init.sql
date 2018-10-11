-- SE CARGAN Clientes
INSERT INTO `dmt_cliente` (`cli_id`, `cli_dtcreate`, `cli_nombre`, `cli_estado`, `cli_email`, `cli_url`, `cli_telefono`, `cli_fecha_inicio`, `cli_fecha_fin`, `cli_nit`, `cli_pais`, `cli_departamento`, `cli_ciudad`, `cli_direccion`) VALUES ('1', '2013-05-16 00:00:00', 'Universidad de Antioquia', 'activo', 'universidad@udea.edu.co', 'www.udea.edu.co', '4116508', '2013-05-01 00:00:00', '2020-06-12 00:00:00', '900097657-1', 'Colombia', 'Antioquia', 'Medellin', 'Zona Norte');
-- SE CARGAN USUARIOS
INSERT INTO `dmt_usuario` (`usr_id`, `dmt_cliente_cli_id`, `usr_dtcreate`, `usr_habilitado`, `usr_email`, `usr_pass`, `usr_nombre`, `usr_apellido`, `usr_identificacion`, `usr_cargo`, `usr_telefono`, `usr_celular`, `usr_pais`, `usr_departamento`, `usr_ciudad`, `usr_direccion`, `usr_imagen`) VALUES
(1, 1, NOW(), 1, 'prueba@correo.com', '95B490918894B85EB280AF6B54DB9DBF811ED3D7', 'prueba', 'apellido_prueba', '123456789', 'Administrador', '654987321', '321654987', 'elpais', 'departamento-estado', 'laciudad', 'ladireccion', 'prueba.jpg');

-- SE CARGAN PERFILES
INSERT INTO `dmt_perfiles` (`prf_id`, `prf_nombre`, `prf_descripcion`) VALUES
(1, 'Clientes - Ver', NULL),
(2, 'Clientes - Crear', NULL),
(3, 'Clientes - Editar', NULL),
(4, 'Clientes - Eliminar', NULL),
(5, 'Usuarios - Ver', NULL),
(6, 'Usuarios - Crear', NULL),
(7, 'Usuarios - Editar', NULL),
(8, 'Usuarios - Eliminar', NULL),
(9, 'Usuarios - Permisos', NULL);

-- SE INICIALIZAN PERFILES
INSERT INTO dmt_usuario_has_dmt_perfiles (dmt_usuario_usr_id, dmt_perfiles_prf_id, dtcreate) VALUES 
('1', '1', NOW()),
('1', '2', NOW()),
('1', '3', NOW()),
('1', '4', NOW()),
('1', '5', NOW()),
('1', '6', NOW()),
('1', '7', NOW()),
('1', '8', NOW()),
('1', '9', NOW());