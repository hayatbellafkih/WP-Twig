<?php

/**
 *
 * @author user
 * @return
 *
 * @package
 *
 */
class TWP_Manager {
	public static $cache;
	private static $auto_reload;
	private static $charset;
	private static $base_template_class;
	private static $strict_variables;
	private static $autoescape;
	private static $optimizations;
	private static $twig_instance;
	
	/**
	 * Empêche la copie externe de l'instance.
	 */
	private function __clone() {
	}
	private function __construct($cache = CACHE_PATH, $auto_reload = true, $btc = 'Twig_Template', $op = -1, $charset = 'UTF-8') {
		self::$cache = $cache;
		self::$auto_reload = $auto_reload;
		self::$charset = $charset;
		self::$base_template_class = $btc;
		self::$optimizations = $op;
	}
	public static function details() {
		echo '<b>cache          </b>:' . self::$cache . '<br>';
		echo '<b>auto_reload    </b>:' . self::$auto_reload . '<br>';
		$tmp = explode ( ";", get_option ( 'wt_paths' ) );
		//var_dump ( self::getDebug () );
		echo '<br>';
		echo '<b>debug        </b>:' . self::getDebug . '<br>';
		echo '<b>base_templates </b>:' . self::$base_template_class . '<br><br>';
	}

	public static function getCache() {
		if(get_option('wt_is_cache')){
			return self::$cache;
		}
		else{
			return false;
		}
	}
	
	/**
	 * create new instance of twig envirenement with
	 *
	 * @return Twig_Environment $twig
	 */
	public static function getEnvirenement() {	
		//var_dump(check_option ( 'wt_is_cache' ));
		try {
			new TWP_Manager ();
			static $twig;
			$tmp = explode ( ";", get_option ( 'wt_paths' ) );
			if ($twig === null) {
				Twig_Autoloader::register ();
				if (! empty ( $tmp )) {
					$loader = new Twig_Loader_Filesystem ( $tmp );
					$twig = new Twig_Environment ( $loader, array (
							'cache' => self::getCache(),
							'debug' => check_option ( 'wt_debug' ),
							'auto_reload' => check_option ( 'wt_auto_reload' ),
							'optimizations' => self::$optimizations,
							'charset' => self::$charset 
					) );
					
					require PLUGIN_TWP . '/utils/userFunctions.php';
					require PLUGIN_TWP . '/utils/userGlobals.php';
				}
				if (defined ( get_option ( 'wt_debug' ) ) && true === get_option ( 'wt_debug' )) {
					$twig->addExtension ( new Twig_Extension_Debug () );
				}
			}
			return $twig;
		} catch ( Twig_Error_Loader $e ) {
			show_errors ( $e );
		} catch ( Exception $e ) {
			show_errors ( $e );
		}
	}
	public static function displayTemplate($template_name, $data = array()) {
		try {
			$twig = self::getEnvirenement ();
			$template = $twig->loadTemplate ( $template_name );
			$template->display ( $data );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
		}
	}
	public static function addGlobal($name, $value) {
		try {
			self::getEnvirenement ()->addGlobal ( $name, $value );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
		}
	}
	/**
	 * add new function to be called in twig templates
	 * @param Twig_Function_Function $function
	 */
	public static function addFunction($function){
		self::getEnvirenement ()->addFunction ( $function );
	}
	
	public static function addExtension($extension_class){
		if(class_exists($extension_class)){
			self::getEnvirenement ()->addExtension ( new $extension_class() );		
		}
	}

}
