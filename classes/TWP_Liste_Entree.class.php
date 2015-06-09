<?php
require_once 'TWP_Entree.class.php';
class TWP_Liste_Entree {
	private static $listeEntree = array ();
	private static $liste_routes = array ();
	public static function addEntree($entree) {
		if (is_object ( $entree )) {
			if (is_null ( self::getByTemplate ( $entree->getTemplate () ) )) {
				$data = new TWP_Entree ( $entree->getType (), $entree->getTemplate (), $entree->getDataTemplate () );
				self::$listeEntree [] = $data;
			} else {
				echo "<br>the template  {$entree->getTemplate ()} is already has an entree <br>";
			}
		} else {
			// echo 'la methode addEntree necessite un argument de type objet de la classe Data';
		}
	}
	public static function removeRoute(WP_Router $router, $id) {
		try {
			$router->remove_route ( $id );
			unset ( self::$liste_routes [$id] );
		} catch ( TWP_Exception $e ) {
		}
	}
	public static function editRoute(WP_Router $router, $args = array(), $id) {
		try {
			$router->edit_route ( $id, $args );
		} catch ( TWP_Exception $e ) {
		}
	}
	public static function addRoute(WP_Router $router, $args, $id) {
		try {
			$is_routing = get_option ( 'wt_routing' );
			if ($is_routing) {
				$router->add_route ( $id, $args );
				self::$liste_routes [$id] = $args ['path'];
			}
		} catch ( TWP_Exception $e ) {
		}
	}
	public static function getRoute(WP_Router $router, $id) {
		try {
		return 	$router->get_route ( $id);
		} catch ( TWP_Exception $e ) {
		}
	}
	public static function exist_route($route) {
		$route_search = substr ( $route, 1 );
		$resultat = false;
		foreach ( self::$liste_routes as $route ) {
			$resultat = preg_match ( "#$route#", $route_search );
			if ($resultat)
				break;
		}
		return $resultat;
	}
	public static function liste_routes() {
		return self::$liste_routes;
	}
	public static function liste_entree() {
		return self::$listeEntree;
	}
	public function getDataFromEntry() {
	}
	public static function getByTemplate($template) {
		$entree = null;
		foreach ( self::$listeEntree as $entree ) {
			if ($entree->getTemplate () == $template) {
				return $entree;
				break;
			}
		}
	}
}
?>