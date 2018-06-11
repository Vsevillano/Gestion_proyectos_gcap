<?php 
// Datos para la conexion a la BBDD
define("LOCALHOST", 'localhost');
define("DBNAME", '2daw1718_sevevi');
define("CADCONEXION", "mysql:host=".LOCALHOST.";dbname=".DBNAME);
define("USER", '2daw1718_sevevi');
define("PSW", 'usuario');


// Datos para la conexion a gmail
define("GMAIL_USER", 'gestionproyectosgcap@gmail.com');
define("GMAIL_PASS", 'Gcap2018proyectos');


// Inactividad de la sesion, por defecto, 3600s (1h).
define("INACTIVO", '3600');

// Datos para el envio de mensajes de alta
define("MAIL_FROM", 'me@example.com');
define("MAIL_ASUNTO", 'Alta en Gestion de proyectos del IES Gran Capitan.');
define("MAIL_MESSAGE", 'Como alumno del I.E.S Gran Capitán, has sido dado de alta en "Gestion de proyectos". Ahora puedes crear tu perfil de <strong>administrador del sistema</strong>.
Por favor, acceda al siguiente enlace <strong>(en máximo 48h)</strong> para completar el registro:');
define("MAIL_URL_TOKEN", 'http://cpd.iesgrancapitan.org:9101/~sevevi/DWES/repaso/gestion_proyectos/');
define("MAIL_URL_TOKEN_INT", 'http://192.168.12.129/~sevevi/DWES/repaso/gestion_proyectos/');

// Datos para el envio de mensajes de los nuevos proyectos
define("MAIL_FROM_PROYECTO", 'me@example.com');
define("MAIL_ASUNTO_PROYECTO", 'Registro en Gestion de proyectos del IES Gran Capitan.');
define("MAIL_MESSAGE_PROYECTO", 'Como alumno del I.E.S Gran Capitán, ahora puedes <strong>registrar tu proyecto</strong>.
Por favor, acceda al siguiente enlace <strong>(en máximo 48h)</strong> para ello:');
define("MAIL_URL_TOKEN_PROYECTO", 'http://cpd.iesgrancapitan.org:9101/~sevevi/DWES/repaso/gestion_proyectos/');

// Datos para el envio de mensajes de comentarios
define("MAIL_COMENTARIO_FROM", 'me@example.com');
define("MAIL_COMENTARIO_ASUNTO", 'Comentario en Gestion de proyectos del IES Gran Capitan');
define("MAIL_COMENTARIO_MESSAGE", 'Como invitado de la aplicación "Gestion de proyectos" del I.E.S Gran Capitán, has solicitado <strong>comentar el siguiente proyecto</strong>.
Por favor, acceda al siguiente enlace <strong>(en máximo 48h)</strong> para ello:');
define("MAIL_COMENTARIO_URL_TOKEN", 'http://cpd.iesgrancapitan.org:9101/~sevevi/DWES/repaso/gestion_proyectos/');

// Datos para el envio de mensajes de VALORACIONES
define("MAIL_VALORACION_FROM", 'me@example.com');
define("MAIL_VALORACION_ASUNTO", 'Valoracion en Gestion de proyectos del IES Gran Capitan');
define("MAIL_VALORACION_MESSAGE", 'Como invitado de la aplicacion "Gestion de proyectos" del I.E.S Gran Capitán, has solicitado <strong>valorar el siguiente proyecto</strong>.
Por favor, acceda al siguiente enlace <strong>(en máximo 48h)</strong> para ello:');
define("MAIL_VALORACION_URL_TOKEN", 'http://cpd.iesgrancapitan.org:9101/~sevevi/DWES/repaso/gestion_proyectos/');

// Datos para el envio de mensajes de RECUPERACION
define("MAIL_RECUPERACION_FROM", 'me@example.com');
define("MAIL_RECUPERACION_ASUNTO", 'Recuperar contraseña Gestion de proyectos del IES Gran Capitan');
define("MAIL_RECUPERACION_MESSAGE", 'Como administrador de la aplicacion "Gestion de proyectos" del I.E.S Gran Capitán, has solicitado <strong>cambiar la contraseña</strong> de tu cuenta.
Por favor, acceda al siguiente enlace <strong>(en máximo 48h)</strong> para ello:');
define("MAIL_RECUPERACION_URL", 'http://cpd.iesgrancapitan.org:9101/~sevevi/DWES/repaso/gestion_proyectos/');

// Tiempo para alargar el envio del token --> 2 = 2 dias mas
define("TIEMPO_EXTRA", '2');

?>