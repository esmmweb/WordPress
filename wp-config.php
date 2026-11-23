<?php
/**
 * WordPress configuration for ESM Web Solutions (multisite network).
 *
 * Runs on Pantheon (platform settings come from wp-config-pantheon.php) and
 * locally in Lando (settings come from the gitignored wp-config-local.php).
 * Do not commit credentials to this file.
 *
 * See https://pantheon.io/docs
 */

@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );

/**
 * Pantheon platform settings. Everything you need should already be set.
 */
if ( file_exists( dirname( __FILE__ ) . '/wp-config-pantheon.php' ) && isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
	require_once dirname( __FILE__ ) . '/wp-config-pantheon.php';

/**
 * Local configuration (Lando). Copy wp-config-local-sample.php if you need a
 * fresh one. IMPORTANT: the local config must not include wp-settings.php.
 */
} elseif ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) && ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
	require_once dirname( __FILE__ ) . '/wp-config-local.php';

/**
 * Not on Pantheon and no wp-config-local.php: placeholders only.
 */
} else {
	define( 'DB_NAME', 'database_name' );
	define( 'DB_USER', 'database_username' );
	define( 'DB_PASSWORD', 'database_password' );
	define( 'DB_HOST', 'database_host' );
	define( 'DB_CHARSET', 'utf8' );
	define( 'DB_COLLATE', '' );
	define( 'AUTH_KEY', 'put your unique phrase here' );
	define( 'SECURE_AUTH_KEY', 'put your unique phrase here' );
	define( 'LOGGED_IN_KEY', 'put your unique phrase here' );
	define( 'NONCE_KEY', 'put your unique phrase here' );
	define( 'AUTH_SALT', 'put your unique phrase here' );
	define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
	define( 'LOGGED_IN_SALT', 'put your unique phrase here' );
	define( 'NONCE_SALT', 'put your unique phrase here' );
}

/** Standard wp-config.php stuff from here on down. **/

/** WordPress database table prefix. */
$table_prefix = 'wp_';

/**
 * Debugging. Off by default; wp-config-local.php turns it on locally.
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/**
 * Multisite.
 *
 * Subdomain network on Live (and locally in Lando); subdirectory network on
 * every other Pantheon environment (dev, test, multidevs), e.g.
 * emeliosm.esmwebsolutions.com on Live becomes test-esmm.pantheonsite.io/emeliosm/
 * on Test. pantheon.yml sets search_replace: convert so Pantheon performs that
 * conversion when content is cloned from Live.
 * https://docs.pantheon.io/guides/multisite/search-replace
 *
 * On Pantheon the network domain follows the environment hostname
 * (PANTHEON_HOSTNAME is defined in wp-config-pantheon.php). Locally,
 * wp-config-local.php defines DOMAIN_CURRENT_SITE first.
 */
define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
if ( ! empty( $_ENV['PANTHEON_ENVIRONMENT'] ) && 'live' !== $_ENV['PANTHEON_ENVIRONMENT'] ) {
	define( 'SUBDOMAIN_INSTALL', false );
} else {
	define( 'SUBDOMAIN_INSTALL', true );
}
if ( ! defined( 'DOMAIN_CURRENT_SITE' ) ) {
	define( 'DOMAIN_CURRENT_SITE', defined( 'PANTHEON_HOSTNAME' ) ? PANTHEON_HOSTNAME : 'esmwebsolutions.com' );
}
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

/* That's all, stop editing! Happy Pressing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
