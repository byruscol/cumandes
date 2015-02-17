<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'cumandes');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'clinicol');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'u7V&QC@>+CPbKrV|2~t**tb +KULz+}mq4f)lGhg03j:g/v7:$}rcaxEb0b%e_yP');
define('SECURE_AUTH_KEY', 'r~O:X|+jd5n*EtW)E%i5iuoy1TMtWH3|}MONY[zF8]K>^f7f-z:hC`*a8#owkG_%');
define('LOGGED_IN_KEY', 'h-JL%Bvnwpj7y^G0#*;@WWe+}{4o/)^tN:Ry@2r.-awd>P(-HQ=R}#?n!qdc^2g-');
define('NONCE_KEY', 'nt|u*A?G/J]GI@+(k=2psW<i7SZ.&J01OrGN0kWp+bjBz3d;}tFSJ s32Q.P oZy');
define('AUTH_SALT', 'BnBM%c+lwNxrfBB2!=iG5%7i^{4y:Xyv-MQ#+#]zalJ|v-Her0pJ<;kb|lkP=iIy');
define('SECURE_AUTH_SALT', ';,7Xdt5sYb<-HChnZDJ|JI`//oE>$&9%Ybp>8wk!V@}JJnE>SMsD_9u8AyS,Y-~Y');
define('LOGGED_IN_SALT', '-lyr[|FYfHd/lr|WD86s&wK`O$Ur;:8}pGM}|xr?t&wZK@t^(ON4Kh>p)=Skkwz$');
define('NONCE_SALT', '6M|e $*|RYS|S!&xqK,#rh+)g|2(FqiAs2IY+Qc=WXC+;xLCypR[b|;IMEH_&(or');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


