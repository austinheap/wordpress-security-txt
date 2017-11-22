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
class WordPress_Security_Txt_Public
{

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
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        self::$cache_cleared = get_transient('WORDPRESS_SECURITY_TXT_CACHE_CLEARED');

        if ($this->version != WORDPRESS_SECURITY_TXT_VERSION) {
            throw new Exception('Internal version mismatch in plugin wordpress-security-txt; it needs to be reinstalled.');
        }
    }

    /**
     * Hijacks requests for enabled routes
     *
     * @return   void
     */
    public function route()
    {
        if (! isset($_SERVER) || ! isset($_SERVER['REQUEST_URI']) || ! isset($_SERVER['HTTP_HOST'])) {
            return;
        }

        $this->options = WordPress_Security_Txt_Admin::get_options($this->plugin_name);

        if (! is_array($this->options) || ! isset($this->options['enable']) || ! $this->options['enable']) {
            return;
        }

        $request = ($this->is_secure() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $site    = get_site_url();

        if (strpos($request, $site) !== 0) {
            return;
        }

        $this->apply_routes(substr($request, strlen($site)));
    }

    /**
     * Applies plugin routes to a given URI.
     *
     * @param string $uri
     */
    private function apply_routes($uri)
    {
        $routes = [
            '/security.txt'             => ['method' => 'redirect', 'document' => 'security.txt'],
            '/.well-known/security.txt' => ['method' => 'show', 'document' => 'security.txt'],
        ];

        if (isset($this->options['encryption']) && isset($this->options['encryption'])) {
            $routes = array_merge($routes, [
                '/gpg.txt'             => ['method' => 'redirect', 'document' => 'gpg.txt'],
                '/.well-known/gpg.txt' => ['method' => 'show', 'document' => 'gpg.txt'],
            ]);
        }

        if (isset($routes[$uri])) {
            if ($routes[$uri]['method'] == 'redirect') {
                $this->redirect($routes[$uri]['document']);
            } elseif ($routes[$uri]['method'] == 'show') {
                $this->show($routes[$uri]['document']);
            }
        }
    }

    /**
     * Determines if current request is made via HTTPS.
     *
     * @since 1.0.0
     * @return bool
     */
    private function is_secure()
    {
        return (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
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
    private function redirect($document)
    {
        header('Location: ' . get_site_url() . '/.well-known/' . $document);

        exit;
    }

    /**
     * Gets the cache file for the plugin.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function cache_file()
    {
        return get_temp_dir() . DIRECTORY_SEPARATOR . 'wordpress-security-txt-cache.txt';
    }

    /**
     * Removes the cache file for the plugin.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function cache_clear()
    {
        $cache_file = self::cache_file();

        if (is_file($cache_file)) {
            $result = unlink($cache_file);
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
    public static function cache_cleared($reset = false)
    {
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
    private function show($document)
    {
        if ($document == 'security.txt') {
            $output = $this->render_security_txt();
        } elseif ($document == 'gpg.txt') {
            $output = $this->render_gpg_txt();
        }

        if (empty($output)) {
            return;
        }

        header('Content-Length: ' . sizeof($output));
        header('Content-Type: text/plain');

        print $output;

        exit;
    }

    /**
     * Renders gpg.txt for display
     *
     * @return string
     */
    private function render_gpg_txt()
    {
        return $this->options['encryption'];
    }

    /**
     * Renders security.txt for display
     *
     * @return string
     */
    private function render_security_txt()
    {
        $output = $this->get_security_txt_cache();

        if (empty($output)) {
            WordPress_Security_Txt::import_lib();

            $writer = (new \AustinHeap\Security\Txt\Writer)->setDebug(isset($this->options['credits']) ? $this->options['credits'] : false)
                                                           ->addContact($this->options['contact']);

            if (! empty($this->options['encryption'])) {
                $writer->setEncryption(get_site_url() . '/.well-known/gpg.txt');
            }

            if (! empty($this->options['disclosure']) && $this->options['disclosure'] != 'default') {
                $writer->setDisclosure($this->options['disclosure']);
            }

            if (! empty($this->options['acknowledgement'])) {
                $writer->setAcknowledgement($this->options['acknowledgement']);
            }

            $output = $writer->execute()->getText();
        }

        $this->write_security_txt_cache($output);

        return $output;
    }

    /**
     * Write to the security.txt cache.
     *
     * @param string $data
     * @return void
     */
    private function write_security_txt_cache($data)
    {
        if (isset($this->options['cache']) && $this->options['cache']) {
            file_put_contents(self::cache_file(), $data);
            WordPress_Security_Txt::event('cache');
        }
    }

    /**
     * Get the security.txt cache.
     *
     * @return mixed
     */
    private function get_security_txt_cache()
    {
        $data = null;

        if (isset($this->options['cache']) && $this->options['cache']) {
            $cache_file = self::cache_file();

            if (is_file($cache_file) && filemtime($cache_file) < time() - 86400) {
                self::cache_clear();
            }

            if (is_readable($cache_file)) {
                $data = file_get_contents($cache_file);
            }
        }

        return $data;
    }
}
