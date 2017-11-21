<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for the public-facing stylesheet and JavaScript.
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/public
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The plugin options.
	 *
	 * @since         1.0.0
	 * @access        private
	 * @var        array $options The plugin options.
	 */
	private $options;

	/**
	 * The plugin cache cleared flag.
	 *
	 * @since         1.0.0
	 * @access        private
	 * @var        bool $cache_cleared The plugin cache cleared flag.
	 */
	private static $cache_cleared;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		self::$cache_cleared = get_transient('WORDPRESS_SECURITY_TXT_CACHE_CLEARED');
	}

	/**
	 * Hijacks requests for enabled routes
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function route() {
		if ( isset( $_SERVER ) && isset( $_SERVER['REQUEST_URI'] ) && isset( $_SERVER['HTTP_HOST'] ) ) {
			$this->options = WordPress_Security_Txt_Admin::get_options( $this->plugin_name );

			if ( is_array( $this->options ) && isset( $this->options['enable'] ) && $this->options['enable'] ) {
				$request = ( $this->is_secure() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$site    = get_site_url();

				if ( strpos( $request, $site ) !== 0 ) {
					return;
				}

				$uri = substr( $request, strlen( $site ) );

				$routes = [
					'/security.txt'             => [ 'method' => 'redirect', 'document' => 'security.txt' ],
					'/.well-known/security.txt' => [ 'method' => 'show', 'document' => 'security.txt' ],
				];

				if ( isset( $this->options['encryption'] ) && isset( $this->options['encryption'] ) ) {
					$routes = array_merge( $routes, [
						'/gpg.txt'             => [ 'method' => 'redirect', 'document' => 'gpg.txt' ],
						'/.well-known/gpg.txt' => [ 'method' => 'show', 'document' => 'gpg.txt' ],
					] );
				}

				if ( isset( $routes[ $uri ] ) ) {
					$this->{$routes[ $uri ]['method']}( $routes[ $uri ]['document'] );
				}
			}
		}
	}

	/**
	 * Determines if current request is made via HTTPS.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	private function is_secure() {
		return ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) || $_SERVER['SERVER_PORT'] == 443;
	}

	/**
	 * Redirects a request to the correct location.
	 *
	 * @since 1.0.0
	 *
	 * @param string $document
	 *
	 * @return void
	 */
	private function redirect( $document ) {
		$uri = get_site_url() . '/.well-known/' . $document;
		header( 'Location: ' . $uri );

		exit;
	}

	/**
	 * Gets the cache file for the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function cache_file() {
		return get_temp_dir() . DIRECTORY_SEPARATOR . 'wordpress-security-txt-cache.txt';
	}

	/**
	 * Removes the cache file for the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function cache_clear() {
		$cache_file = self::cache_file();

		if ( is_file( $cache_file ) ) {
			$result = unlink( $cache_file );
			set_transient('WORDPRESS_SECURITY_TXT_CACHE_CLEARED', $result, 5);
			self::$cache_cleared = get_transient('WORDPRESS_SECURITY_TXT_CACHE_CLEARED');
		}

		return false;
	}

	/**
	 * Indicates if the cache was cleared during the current request.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function cache_cleared( $reset = false ) {
		$result = is_null(self::$cache_cleared) ? false : self::$cache_cleared;

		if ($reset) {
			delete_transient('WORDPRESS_SECURITY_TXT_CACHE_CLEARED');
		}

		return $result;
	}

	/**
	 * Displays a document, assuming it can be rendered correctly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $document
	 *
	 * @return void
	 */
	private function show( $document ) {
		switch ( $document ) {
			case 'security.txt':
				$output = null;

				if ( isset( $this->options['cache'] ) && $this->options['cache'] ) {
					$cache_file = self::cache_file();

					if ( is_file( $cache_file ) && is_readable( $cache_file ) ) {
						if ( filemtime( $cache_file ) < time() - 86400 ) {
							self::cache_clear();
						} else {
							$output = file_get_contents( $cache_file );
						}
					}
				}

				if ( empty( $output ) ) {
					WordPress_Security_Txt::import_lib();

					$writer = ( new \AustinHeap\Security\Txt\Writer )->setDebug( isset( $this->options['credits'] ) ? $this->options['credits'] : false )
					                                                 ->addContact( $this->options['contact'] );

					if ( isset( $this->options['encryption'] ) && ! empty( $this->options['encryption'] ) ) {
						$writer->setEncryption( get_site_url() . '/.well-known/gpg.txt' );
					}

					if ( isset( $this->options['disclosure'] ) && ! empty( $this->options['disclosure'] ) && $this->options['disclosure'] != 'default' ) {
						$writer->setDisclosure( $this->options['disclosure'] );
					}

					if ( isset( $this->options['acknowledgement'] ) && ! empty( $this->options['acknowledgement'] ) ) {
						$writer->setAcknowledgement( $this->options['acknowledgement'] );
					}

					$output = $writer->generate()->getText();
				}

				if ( isset( $cache_file ) && ! is_file( $cache_file ) ) {
					file_put_contents( $cache_file, $output );
					WordPress_Security_Txt::event( 'cache' );
				}

				break;

			case 'gpg.txt':
				$output = $this->options['encryption'];

				break;

			default:
				return;
		}

		if ( empty( $output ) ) {
			return;
		}

		header( 'Content-Length: ' . sizeof( $output ) );
		header( 'Content-Type: text/plain' );

		print $output;

		exit;
	}

}