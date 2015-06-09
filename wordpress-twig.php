<?php
/**
 * Plugin Name: wordpress-twig
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Plugin d'intégration du moteur de template twig avec WordPress.
 * Version:  1.0.0
 * Author: bellafkih 
 * License:  GPL2
 */
if (! class_exists ( "\Composer\Autoload\ClassLoader" )) {
	require_once 'vendor/autoload.php';
}
$flag = 'default';
require_once 'functions.php';
if (! class_exists ( 'Wordpress_Twig' )) {
	class Wordpress_Twig {
		
		/**
		 * Load PHP Files
		 */
		function includes() {
			/* load class to instance of envirenement */
			require_once 'classes/TWP_Manager.class.php';
			
			/* load independant functions used by plugin */
			
			require_once 'classes/TWP_Entree.class.php';
			require_once 'classes/TWP_Liste_Entree.class.php';
		}
		
		/**
		 * Load the translation of the plugin.
		 */
		function i18n() {
			load_plugin_textdomain ( 'wordpress-twig', false, basename ( dirname ( __FILE__ ) ) . '/languages' );
		}
		
		/**
		 * define constants of plugin
		 */
		public function constants() {
			define ( 'PLUGIN_TWP', dirname ( __FILE__ ) );
			define ( "VIEWS_PATH", get_stylesheet_directory () . "/views" );
			define ( "CACHE_PATH", __DIR__ . '/cache' );
			define ( 'THEME_PATH', get_template_directory () );
			define ( 'PLUGIN_TEMPLATES', PLUGIN_TWP . '/vues' );
		}
		
		/**
		 * the constructor
		 */
		public function Wordpress_Twig() {
			$this->constants ();
			$this->includes ();
			/* FILTRES */
			/**
			 * redefine all Wordpress Templates
			 * add_filter ( "home_template", function (){});
			 */
			/* Home */
			add_filter ( "home_template", function () {
				global $flag;
				$flag = 'home';
				$templates = array ();
				$templates [] = 'home.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* index */
			add_filter ( "index_template", function () {
				global $flag;
				$flag = 'index';
				return "index.twig";
			} );
			
			/* single */
			add_filter ( "single_template", function () {
				
				global $post, $flag;
				$flag = 'single';
				$templates = array (
						"single-{$post->post_type}.twig",
						'single.twig',
						'index.twig' 
				);
				return twig_locate_template ( $templates );
			} );
			
			/* page */
			add_filter ( "page_template", function () {
				global $post, $flag;
				$flag = 'page';
				$id = get_the_ID ();
				$templates = array ();
				$meta_values = get_post_meta ( $id, 'wp_template_twig', true );
				if ($meta_values != '' && $meta_values != 'default') {
					$templates [] = $meta_values;
				}
				$slug = $post->post_name;
				$templates [] = 'page-' . $slug . '.twig';
				$templates [] = "page-" . $id . ".twig";
				$templates [] = 'page.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* 404 */
			add_filter ( "404_template", function () {
				global $flag;
				$flag = '404';
				$templates = array ();
				$templates [] = '404.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* archive */
			add_filter ( "archive_template", function () {
				global $flag, $post;
				$templates = array ();
				$flag = 'archive';
				$templates [] = "archive-{$post->post_type}.twig";
				$templates [] = "archive.twig";
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* search */
			add_filter ( "search_template", function () {
				global $flag;
				$flag = 'search';
				$templates [] = 'search.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* author */
			add_filter ( "author_template", function () {
				global $flag, $post;
				$flag = 'author';
				$author = get_the_author ();
				$templates = array ();
				$templates [] = 'author-' . get_the_author () . '.twig';
				$templates [] = 'author-' . get_the_author_meta ( 'ID' ) . '.twig';
				$templates [] = 'author.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* category */
			add_filter ( "category_template", function () {
				global $flag;
				$flag = 'category';
				$category = get_queried_object ();
				$templates = array ();
				if (! empty ( $category->slug )) {
					$templates [] = "category-{$category->slug}.twig";
					$templates [] = "category-{$category->term_id}.twig";
				}
				$templates [] = 'category.twig';
				$templates [] = 'archive.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* tag */
			add_filter ( "tag_template", function () {
				global $flag;
				$flag = 'tag';
				$tag = get_queried_object ();
				$templates = array ();
				if (! empty ( $tag->slug )) {
					$templates [] = "tag-{$tag->slug}.twig";
					$templates [] = "tag-{$tag->term_id}.twig";
				}
				$templates [] = 'tag.twig';
				$templates [] = 'archive.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* taxonomy */
			add_filter ( "taxonomy_template", function () {
				global $flag;
				$flag = 'taxonomy';
				$term = get_queried_object ();
				$templates = array ();
				if (! empty ( $term->slug )) {
					$taxonomy = $term->taxonomy;
					$templates [] = "taxonomy-$taxonomy-{$term->slug}.twig";
					$templates [] = "taxonomy-$taxonomy.twig";
				}
				$templates [] = 'taxonomy.twig';
				$templates [] = 'archive.twig';
				$templates [] = 'index.twig';
				return twig_locate_template ( $templates );
			} );
			
			/* date */
			add_filter ( "date_template", function () {
				global $flag;
				$flag = 'date';
				$templates = array (
						'date.twig',
						'archive.twig',
						'index.twig' 
				);
				return twig_locate_template ( $templates );
			} );
			
			/* front_page */
			add_filter ( "frontpage_template", function () {
				$templates = array (
						'front-page.twig',
						'home.twig',
						'index.twig' 
				);
				return twig_locate_template ( $templates );
			} );
			
			/* attachment */
			add_filter ( "attachment_template", function () {
				global $flag, $posts;
				$flag = 'attachment';
				if (! empty ( $posts ) && isset ( $posts [0]->post_mime_type )) {
					$type = explode ( '/', $posts [0]->post_mime_type );
					if (! empty ( $type )) {
						if ($template = twig_locate_template ( array (
								$type [0] . ".twig" 
						) )) {
							return $template;
						} elseif (! empty ( $type [1] )) {
							if ($template = twig_locate_template ( array (
									$type [1] . ".twig" 
							) ))
								return $template;
							elseif ($template = twig_locate_template ( array (
									"$type[0]_$type[1]" . ".twig" 
							) ))
								return $template;
						}
					}
				}
				$templates = array (
						'attachment.twig',
						'single.twig',
						'index.twig' 
				);
				return twig_locate_template ( $templates );
			} );
			
			/* comments_popup */
			add_filter ( 'comments_popup_template', function () {
				// return "comments-popup.twig";
			} );
			
			/* comments */
			add_filter ( "comments_template", function () {
				global $flag;
				$flag = 'comments';
				$templates = array ();
				$templates [] = 'comments.twig';
				$templates [] = "index.twig";
				return twig_locate_template ( $templates );
			} );
			
			/* REGISTER */
			/* deactivation off plugin */
			register_deactivation_hook ( __FILE__, array (
					$this,
					'deactivate' 
			) );
			
			/* activation off plugin */
			register_activation_hook ( __FILE__, array (
					$this,
					'activate' 
			) );
			
			/* Uninstall */
			register_uninstall_hook ( __FILE__, array('Wordpress_Twig',
					'uninstall' 
			 ) );
			
			/* ACTIONS */
			// add_action ( 'wp_router_generate_routes', 'sf_add_routes', 20 );
			
			/* saving choosed template at editing page */
			add_action ( 'save_post', 'save_metaboxes' );
			
			/* add panel dashboard to configure the plugin */
			add_action ( 'admin_menu', 'theme_options_panel' );
			
			/* load the translation at initialisation of wordpress tools */
			add_action ( 'init', array (
					$this,
					'i18n' 
			) );
			
			add_action ( 'init', 'load_scripts' );
			add_action ( 'wp_ajax_empty_cache', 'empty_cache' );
			add_action ( 'wp_ajax_add_dir', 'add_dir' );
			add_action ( 'wp_ajax_wt_debug', 'wt_debug' );
			add_action ( 'wp_ajax_remove_dir', 'remove_dir' );
			add_action ( 'wp_ajax_routing', 'routing' );
			add_action ( 'wp_ajax_auto_reload', 'auto_reload' );
			add_action ( 'wp_ajax_is_cache', 'is_cache' );	
			add_action ( 'wp_ajax_list_dirs', 'list_dirs' );
			
			/* add meta box in edit page "Templates Disponibles" */
			add_action ( 'add_meta_boxes', 'load_templates' );
			
			/* Internationalize the text strings used. */
			add_action ( 'plugins_loaded', array (
					&$this,
					'i18n' 
			) );
			add_action ( 'switch_theme', 'my_on_switch_theme' );
			
			/**
			 * hook : template_include ; This filter hook is executed immediately before WordPress includes the predetermined template file.
			 * This can be used to override WordPress's default template behavior.
			 *
			 * @param string $info
			 *        	the name of template returned by add_filter ()
			 * @return html
			 */
			add_action ( "template_include", function ($info) {
			
				try {
					$is_routing = get_option ( 'wt_routing' );
					//var_dump($is_routing);
					if ($is_routing) {
						//echo "in is_routing";
						$home = parse_url ( get_home_url () );
						$resultat = '';
						if (isset ( $home ['path'] )) {
							$curent_url = $_SERVER ['REQUEST_URI'];
							$resultat = substr ( $curent_url, strlen ( $home ['path'] ) + 1 );
						} else {
							$resultat = $_SERVER ['REQUEST_URI'];
						}
						if (TWP_Liste_Entree::exist_route ( $resultat )) {
							//echo "route existe";
							return;
						} else {
							//echo "echo not existe";
							//echo $info;
							$entree = TWP_Liste_Entree::getByTemplate ( $info );
							if (is_object ( $entree )) {
								if ($entree->getType () == 'php') {
									return get_template_directory () . '/' . substr ( $info, 0, strlen ( $info ) - 4 ) . 'php';
								}
								if ($entree->getType () == 'twig') {
									global $twig, $flag;
									if (class_exists ( 'TWP_Manager' )) {
										$twig = TWP_Manager::getEnvirenement ();
										$template = $twig->loadTemplate ( $info );
										$template->display ( array_merge ( array (
												'loop' => new TWP_Loop () 
										), $entree->getDataTemplate () ) );
									}
								}
							} else {
								//echo $info;
								global $twig, $flag;
								if (class_exists ( 'TWP_Manager' )) {
									$twig = TWP_Manager::getEnvirenement ();
									$template = $twig->loadTemplate ( $info );
									$template->display ( array_merge ( array (
											'loop' => new TWP_Loop () 
									) ) );
								}
							}
						}
					} else {
						
						$entree = TWP_Liste_Entree::getByTemplate ( $info );
						if (is_object ( $entree )) {
							if ($entree->getType () == 'php') {
								return get_template_directory () . '/' . substr ( $info, 0, strlen ( $info ) - 4 ) . 'php';
							}
							if ($entree->getType () == 'twig') {
								global $twig, $flag;
								if (class_exists ( 'TWP_Manager' )) {
									$twig = TWP_Manager::getEnvirenement ();
									$template = $twig->loadTemplate ( $info );
									$template->display ( array_merge ( array (
											'loop' => new TWP_Loop () 
									), $entree->getDataTemplate () ) );
								}
							}
						} else {
							global $twig, $flag;
							if (class_exists ( 'TWP_Manager' )) {
								$twig = TWP_Manager::getEnvirenement ();
								$template = $twig->loadTemplate ( $info );
								$template->display ( array_merge ( array (
										'loop' => new TWP_Loop () 
								) ) );
							}
						}
					}
				} catch ( Twig_Error_Syntax $e ) {
					show_errors ( $e );
				} catch ( Twig_Error_Loader $e ) {
					show_errors ( $e );
				}
			} );
		}
		
		/**
		 * called function at ctivating of pluging
		 * creating views folder in theme directory at activation of plugin
		 */
		public function activate() {
			create_files ();
			$default_templates = get_stylesheet_directory () . "/views" . ';' . PLUGIN_TWP . '/vues';
			add_option ( 'wt_paths', $default_templates, '', 'yes' );
			add_option ( 'wt_debug', true, '', 'yes' );
			add_option ( 'wt_routing', false, '', 'yes' );
			add_option ( 'wt_auto_reload', true, '', 'yes' );
			add_option ( 'wt_is_cache', true, '', 'yes' );
				
				
		}
		public static function uninstall() {
		}
		/**
		 * called function at deactivating of pluging
		 */
		public function deactivate() {
// 			delete_option ( 'wt_paths' );
// 			delete_option ( 'wt_debug' );
// 			delete_option ( 'wt_routing' );
// 			delete_option ( 'wt_auto_reload' );
// 			delete_option ( 'wt_is_cache' );
				
		}
	}
}
 
function routing_activated() {
	$home = parse_url ( get_home_url () );
	$resultat = '';
	if (isset ( $home ['path'] )) {
		$curent_url = $_SERVER ['REQUEST_URI'];
		$resultat = substr ( $curent_url, strlen ( $home ['path'] ) + 1 );
	} else {
		$resultat = $_SERVER ['REQUEST_URI'];
	}
	if (TWP_Liste_Entree::exist_route ( $resultat )) {
		return;
	}
}

$wpt= new Wordpress_Twig ();
