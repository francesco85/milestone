<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //

if(file_exists(dirname(__FILE__).'/local.php')){
   //local db
    define('DB_NAME', 'milestone');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
}else{
    //live db
    define('DB_NAME', 'cytyt');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
}



/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'TT3tKHb33}y5i-W26#WD*8h5)(YpScp `br&eFjLY]qA_y>hQG1F=aHr70*I1b}>');
define('SECURE_AUTH_KEY',  '5)P=6+(zrf>x4xMRi*}Qio8QGY.i:s|IK/l<s:<PQ {$y^py qyk_|;bQ.L%@?SH');
define('LOGGED_IN_KEY',    'N0M5 ]@j8BXMi[ywKy#yPG[PQ[PVdBiRr]s_YNSy`RAqmkR+rcvPib;WgVA2meD)');
define('NONCE_KEY',        'p&E<5]7v].9|LxWa2A8^MBY?>_V=4i+Co(p[:cgSI`^d-F-*E)1SH`x#:Vj]ew_f');
define('AUTH_SALT',        'WafCUjYjkT9GjsM7mpp[X%`$L@Cjj7KJvTD33fS9{SbFrI)(th6MPO&zzvYSF%9,');
define('SECURE_AUTH_SALT', '}ev^(EYPkaR~ [j6m4c6e+1D<0$4|fa&K:58Zai$9t36}$,70yoqe9]jF:w8#|:7');
define('LOGGED_IN_SALT',   'I/T4<NqlI)S`tl7v[8VnPP~QoMfZn*[RDa=;7wWxbSO+qJS,O&1PSB#x@Tu<dOYo');
define('NONCE_SALT',       'jw#K~6uae`,RyYd5}HV}%7-{&uf7)zm=cU Prje8Wdh`vOoIXIe5_8o*rKnVxHgu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpml_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
