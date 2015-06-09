<?php

function check_option($option){
$op=get_option($option);
return (bool)$op;
}
function auto_reload() {
	//var_dump($_POST ["auto_reload"]);
	update_option ( 'wt_auto_reload',$_POST ["auto_reload"] );
	exit ();
}

/**
 *delete all the files and sub-directories of a directory ($dir)
 *
 * @param string $dir the directory to empty
 * @param bool $delete mark a directory to be removed
 * @return void
 */
function clear_dir($dir, $delete = false) {
	$dossier = $dir;
	$dir = opendir ( $dossier );
	while ( $file = readdir ( $dir ) ) {
		if (! in_array ( $file, array (
				".",
				".." 
		) )) {
			if (is_dir ( "$dossier/$file" )) {
				clear_dir ( "$dossier/$file", true );
			} else {
				unlink ( "$dossier/$file" );
			}
		}
	}
	closedir ( $dir );
	if ($delete == true) {
		rmdir ( "$dossier/$file" );
	}
}

/**
 * tester si la chaine en parametre respecte l'expression regulire $reg
 */
function find_between($dir, $post) {
	$liste_template = array ();
	foreach ( $dir as $file ) {
		$handle = fopen ( get_template_directory () . '/views/' . $file, "r" );
		if ($handle) {
			while ( ($line = fgets ( $handle )) !== false ) {
				$meta_element_class = get_post_meta ( $post->ID, 'wp_template_twig', true ); // /true ensures you get just one value instead of an array
				$tab [0] = preg_match ( "/^{#[ ]*Template Name:(.*?)#}/i", $line, $matches );
				if ((isset ( $matches [1] ))) {
					$tab [1] = $matches [1];
					$tab [2] = $file;
					$liste_template [] = $tab;
				}
			}
			fclose ( $handle );
		}
	}
	return $liste_template;
} 
/**
 * add new metabox to edit page of Page template, it is called with the hook "add_meta_boxes"
 *
 * @return void
 */
function load_templates() {
	add_meta_box ( 'so_meta_box', 'Templates disponibles', 'render_meta_tmps', 'page', 'side', 'high' );
}

/**
 * generate and display the HTML content to be displayed in the meta box (Choose Template) in Page edit
 *
 * @param unknown $post
 *        	the post that the meta box is attached, in our case is the Page post type
 * @return void
 */
function render_meta_tmps($post) {

	$flg = false;
	$meta_element_class = get_post_meta ( $post->ID, 'wp_template_twig', true ); // /true ensures you get just one value instead of an array

	$render_title = '<label>' . __ ( 'Choose the template:', 'wordpress-twig' ) . '</label>
               <select name="custom_element_grid_class" id="custom_element_grid_class">
	                <option>default</option>';
	$dir = get_template_directory () . '/views';
	$noms = scandir ( $dir );
	$t = find_between ( $noms, $post );
	$render = '';
	foreach ( $t as $template ) {
		$render .= '<option value="' . $template [2] . '" ' . selected ( $meta_element_class, $template [2] ) . ' >' . $template [1] . '</option>';
	}
	$render_title_fin = "</select>";
	echo $render_title . $render . $render_title_fin;
}

/**
 * Save the updated value of the meta box in the created|updated Page
 *
 * @param int $post_ID
 *        	the id of the created|updated Page
 */
function save_metaboxes($post_ID) {
	global $post;
	if (isset ( $_POST ["custom_element_grid_class"] )) {
		$meta_element_class = $_POST ['custom_element_grid_class'];
		update_post_meta ( $post->ID, 'wp_template_twig', $meta_element_class );
	}
}
/**
 * retrieve the prior template from an array of templates
 *
 * @param array $templates
 *        	array contains the names of templates
 * @return string $f the more prior template to be rendered
 */
function twig_locate_template($templates) {
	foreach ( $templates as $f ) {
		$tmp = file_exists ( get_template_directory () . '/views/' . $f );
		if ($tmp) {
			return $f;
			break;
		}
	}
}

/**
 * add a menu in the back office to manage the plugin wordpress-plugin
 */
function theme_options_panel() {
	add_menu_page ( 'wordpress-twig settings', 'W-T setting', 'manage_options', 'theme-options', 'wps_plugin_func_settings' );
}

/**
 * the HTML to be rendered in the menu of the plugin
 */
function wps_plugin_func_settings() {
	include PLUGIN_TWP . '/vues/config.html.php';
}

/**
 * function to load JS files
 */
function load_scripts() {
	wp_enqueue_script ( 'inputtitle_submit', plugins_url ( '/js/w-t_setting_dashboard.js', __FILE__ ), array (
			'jquery' 
	) );
	wp_localize_script ( 'inputtitle_submit', 'PT_Ajax', array (
			'ajaxurl' => admin_url ( 'admin-ajax.php' ),
			'nextNonce' => wp_create_nonce ( 'myajax-next-nonce' ) 
	) );
	wp_register_script ( 'config-script', plugins_url ( '/js/w-t_setting_dashboard.js', __FILE__ ), array (
			'jquery' 
	) );
	wp_enqueue_script ( 'config-script' );
}
/**
 * the called function at choosing to Empty the cache in the menu setting (back office)
 * it remove all fils of the cache directory of the plugin
 */
function empty_cache() {
	clear_dir ( PLUGIN_TWP . '/cache' );
}

/**
 * add the input directory to options table
 * all the directories are separated by comma
 */
function add_dir() {
	$old_paths = get_option ( 'wt_paths' );
	if (is_dir ( $_POST ["path"] )) {
		$old_paths .= ';' . $_POST ["path"];
		update_option ( 'wt_paths', $old_paths );
	}
	exit ();
}
/**
 * update wt_routing option
 * wt_routing option : if the routing is activated or not
 */
function routing() {
	update_option ( 'wt_routing', $_POST ['routing'] );
	exit ();
}
/**
 * update the debug mode off Twig instance
 */
function wt_debug() {
	update_option ( 'wt_debug', $_POST ["debug"] );
	exit ();
}


function list_dirs(){
	echo  get_option('wt_paths');
	exit ();
}

/**
 * remove selected (by click) dir from the option (wp_paths)
 */
function remove_dir() {
	$str_liste_dir = get_option ( 'wt_paths' );
	$array_liste_dir = explode ( ';', $str_liste_dir );
	echo $array_liste_dir [$_POST ['removed_dir_index']] == get_template_directory () . '/views';
	if ($array_liste_dir [$_POST ['removed_dir_index']] == get_template_directory () . '/views' || $array_liste_dir [$_POST ['removed_dir_index']] == PLUGIN_TWP . '/vues') {
	} else {
		unset ( $array_liste_dir [$_POST ['removed_dir_index']] );
		update_option ( 'wt_paths', implode ( ';', $array_liste_dir ) );
	}
}

/**
 * update the option (wp_paths) after changing the theme in condition that the plugin WPT is activated
 *
 * @param unknown $new_theme
 *        	the new theme to switch
 */
function my_on_switch_theme($new_theme) {
	delete_option ( 'wt_paths' );
	$default_templates = get_stylesheet_directory () . "/views" . ';' . PLUGIN_TWP . '/vues';
	add_option ( 'wt_paths', $default_templates, '', 'yes' );
	if (is_plugin_active ( 'wordpress-twig/wordpress-twig.php' )) {
		create_files ();
	}
}

function is_cache(){
  update_option('wt_is_cache',$_POST['is_cache']);
}
function create_files() {
	if (is_writable ( get_template_directory () )) {
		$files = scandir ( __DIR__ . '/demos/new-theme' ) or die ( 'le dossier demo est introuvable' );
		if (! file_exists ( get_template_directory () . '/views' )) {
			$old = umask ( 0 );
			mkdir ( get_template_directory () . '/views', 0777, true );
			umask ( $old );
		}
		foreach ( $files as $file ) {
			if ($file != '.' && $file != '..') {
				if (! file_exists ( get_template_directory () . '/views/' . $file )) {
					copy ( __DIR__ . '/demos/new-theme/' . $file, get_template_directory () . '/views/' . $file ) or die ( 'Probleme at copy of demo files' );
					chmod ( get_template_directory () . '/views/' . $file, fileperms ( __DIR__ . '/demos/new-theme/' . $file ) );
				}
			}
		}
	}
}
function show_errors($e) {
	?>
<style type="text/css">
#title {
	background-color: #686F8C;
	text-align: center;
}

span{
font-weight: bold;
}
#center {
	background-color: #3A8EBA;
	/* 	border-corner-shape: scoop; */
	/* 	border-radius: 80%/30px; */
	/* 	text-align: center; */
}
</style>
<div id='center'>
	<h3>Informations sur l'erreur</h3>
	<table>
		<tr>
			<td><span>Message</span></td>
			<td><?php  echo $e->getmessage() ;?></td></tr>
		<tr>
			<td><span>Line</span></td>
			<td><?php  echo $e->getline() ;?></td>
		</tr>
		<tr>
			<td><span>Fichier</span></td>
			<td><?php  echo $e->getfile() ;?></td>
		</tr>
	</table>
</div>
<?php
}
?>
