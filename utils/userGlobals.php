<?php
	global $post,$wp_rewrite,$is_iphone,$is_iphone,$is_chrome, $is_safari, $is_safari,$is_NS4,$is_opera, $is_macIE, $is_winIE, $is_gecko, $is_gecko, $is_lynx,$is_IE, $is_apache
	, $query_string,$is_IIS,$is_iis7, $wp_version, $wp_db_version, $tinymce_version,$manifest_version,$manifest_version,$wp_meta_boxes,$pagenow,$wp_roles, $post_type,$allowedtags,$allowedposttags,$menu, $required_php_version,$required_mysql_version,$super_admins,$wp_admin_bar,$wp_query,$wp,$wpdb,$wp_locale;
	$twig->addGlobal('$test', "hello test");
	$twig->addGlobal('GET', $_GET);
	$twig->addGlobal('POST',$_POST );
	$twig->addGlobal('FILES',$_FILES );
	$twig->addGlobal('COOKIE',$_COOKIE );
// 	$twig->addGlobal('SESSION',$_SESSION );
	$twig->addGlobal('ENV',$_ENV );
	$twig->addGlobal('SERVER',$_SERVER );
 	$twig->addGlobal('twig',TWP_Manager::getEnvirenement () );
 	/*****/
	$twig->addGlobal('wp_rewrite',$wp_rewrite );
	$twig->addGlobal('is_iphone',$is_iphone );
	$twig->addGlobal('is_chrome',$is_chrome );
	$twig->addGlobal('is_safari', $is_safari);
	$twig->addGlobal('is_NS4',$is_NS4 );
	$twig->addGlobal('is_opera',$is_opera );
	$twig->addGlobal('is_macIE', $is_macIE);
	$twig->addGlobal('is_winIE', $is_winIE);
	$twig->addGlobal('is_gecko', $is_gecko);
	$twig->addGlobal('is_lynx ', $is_lynx );
	$twig->addGlobal('is_IE',$is_IE );
	/*****/
	$twig->addGlobal('is_apache', $is_apache);
	$twig->addGlobal('is_IIS', $is_IIS);
	$twig->addGlobal('is_iis7',$is_iis7 );
	/****/
	$twig->addGlobal('wp_version', $wp_version);
	$twig->addGlobal('wp_db_version', $wp_db_version );
	$twig->addGlobal('tinymce_version', $tinymce_version);
	$twig->addGlobal('manifest_version',$manifest_version );
	$twig->addGlobal('required_php_version ', $required_php_version );
	$twig->addGlobal('required_mysql_version',$required_mysql_version );
	/*****/
	
	$twig->addGlobal('super_admins',$super_admins );
	$twig->addGlobal('wp_query',$wp_query );
	$twig->addGlobal('wp_rewrite',$wp_rewrite );
	$twig->addGlobal('wp',$wp );
	$twig->addGlobal('wpdb',$wpdb );
	$twig->addGlobal('wp_locale',$wp_locale );
	$twig->addGlobal('wp_admin_bar',$wp_admin_bar );
	$twig->addGlobal('wp_roles',$wp_roles );
	$twig->addGlobal('wp_meta_boxes', $wp_meta_boxes);
	$twig->addGlobal('pagenow',$pagenow );
		$twig->addGlobal('post_type',$post_type );
		$twig->addGlobal('allowedposttags',$allowedposttags );
		$twig->addGlobal('allowedtags', $allowedtags);
		$twig->addGlobal('menu',$menu );
 		$twig->addGlobal('query_string',$query_string );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
// 		$twig->addGlobal('', );
