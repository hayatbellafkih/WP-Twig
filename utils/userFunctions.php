<?php
if (class_exists ( 'TWP_Manager' )) {
	$twig->addFunction ( new Twig_SimpleFunction ( "get_template_directory_uri", function () {
		return get_template_directory_uri ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_content", function ($more_link_text = null, $strip_teaser = false) {
		the_content ( $more_link_text, $strip_teaser );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_title", function ($before = '', $after = '', $echo = true ) {
		the_title ($before , $after, $echo );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_ID", function () {
		the_ID ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_tags", function ($before = null, $sep = ', ', $after = '') {
		echo the_tags ( $before, $sep, $after );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_category", function ($separator = '', $parents='', $post_id = false) {
		the_category ($separator , $parents, $post_id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_excerpt", function () {
		the_excerpt ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "the_shortlink", function ( $text = '', $title = '', $before = '', $after = '') {
		the_shortlink ( $text , $title , $before , $after);
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "get_posts", function ($args) {
		return get_posts ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( "have_posts", function () {
		return have_posts ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( "get_header", function ($name = null) {
		global $twig;
		
		do_action ( 'get_header', $name );
		
		$templates = array ();
		$name = ( string ) $name;
		if ('' !== $name)
			$templates [] = "header-{$name}.twig";
		
		$templates [] = 'header.twig';
		foreach ( $templates as $f ) {
			$tmp = file_exists ( get_template_directory () . '/views/' . $f );
			if ($tmp) {
				$template = $twig->loadTemplate ( $f );
				// TODO
				$template->display ( array () );
				break;
			}
		}
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_footer', function ($name = null) {
		do_action ( 'get_footer', $name );
		global $twig;
		$templates = array ();
		$name = ( string ) $name;
		if ('' !== $name)
			$templates [] = "footer-{$name}.twig";
		
		$templates [] = 'footer.twig';
		foreach ( $templates as $f ) {
			$tmp = file_exists ( get_template_directory () . '/views/' . $f );
			if ($tmp) {
				$template = $twig->loadTemplate ( $f );
				$template->display ( array () );
				break;
			}
		}
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_head', function () {
		do_action ( 'wp_head' );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_footer', function () {
		do_action ( 'wp_footer' );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_template_part', function ($slug, $name = null) {
		global $twig;
		do_action ( "get_template_part_{$slug}", $slug, $name );
		$templates = array ();
		$name = ( string ) $name;
		if ('' !== $name)
			$templates [] = "{$slug}-{$name}.twig";
		
		$templates [] = "{$slug}.twig";
		$template = $twig->loadTemplate ( twig_locate_template ( $templates ) );
		$entree = TWP_Liste_Entree::getByTemplate (  twig_locate_template ( $templates ) );
		if (class_exists ( 'TWP_Manager' )) {
			$twig = TWP_Manager::getEnvirenement ();
			if (!is_object ( $entree )) {
				
				$template->display ( array (
						'loop' => new TWP_Loop () 
				) );
			}
		 else {
			
			$template->display ( array_merge ( array (
					'loop' => new TWP_Loop () 
			), $entree->getDataTemplate () ) );
		}}
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( '__', function ($str, $domain) {
		return __ ( $str, $domain );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_e', function ($str, $domain) {
		return _e ( $str, $domain );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_sidebar', function ($name = null) {
		global $twig;
		$templates = array ();
		$name = ( string ) $name;
		if ('' !== $name)
			$templates [] = "sidebar-{$name}.twig";
		$templates [] = 'sidebar.twig';
		$template = $twig->loadTemplate ( twig_locate_template ( $templates ) );
		$template->display ( array () );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_search_form', function ($echo = true) {
		get_search_form ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_author_meta', function ($field = '', $user_id = false) {
		return get_the_author_meta ( $field, $user_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_format', function ($post = null) {
		return get_post_format ( $post = null );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'body_class', function ($class = '') {
		body_class ( $class );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_title', function ($sep = '&raquo;', $display = true, $seplocation = '') {
		wp_title ( $sep, $display, $seplocation );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_title_attribute', function ($args = '') {
		the_title_attribute ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_guid', function ($id = 0) {
		the_guid ( $id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_header_image', function () {
		return get_header_image ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_class', function ($class = '', $post_id = null) {
		get_post_class ( $class, $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_meta', function () {
		the_meta ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_shortlink', function ($text = '', $title = '', $before = '', $after = '') {
		the_shortlink ( $text, $title, $before, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_comments', function ($args = array(), $comments = null) {
		wp_list_comments ( $args, $comments );
	} ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( 'comments_template', function ($file = '/views/comments.twig', $separate_comments = false) {
	// echo comments_template ( $file, $separate_comments );
	// } ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'have_comments', function () {
		return have_comments ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comments_number', function () {
		return get_comments_number ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_form', function ($args = array(), $post_id = null) {
		comment_form ( $args, $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_open', function ($post_id = null) {
		return comments_open ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_page', function () {
		return is_page ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_single', function () {
		return is_single ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_password_required', function ($post = null) {
		post_password_required ( $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_pages_count', function ($comments = null, $per_page = null, $threaded = null) {
		get_comment_pages_count ( $comments, $per_page, $threaded );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'bloginfo', function ($info) {
		bloginfo ( $info );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_format_string', function () {
		get_post_format_string ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_nav_menu', function ($args = array()) {
		wp_nav_menu ( $args );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'esc_url', function ($url, $protocols = null, $_context = 'display') {
		return esc_url ( $url, $protocols, $_context );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_bloginfo', function ($show = '', $filter = 'raw') {
		get_bloginfo ( $show = '', $filter = 'raw' );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'language_attributes', function ($doctype = 'html') {
		language_attributes ( $doctype );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'term_description', function ($term = 0, $taxonomy = 'post_tag') {
		echo term_description ( $term, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'single_tag_title', function ($prefix = '', $display = false) {
		return single_tag_title ( $prefix, $display );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_tax', function ($taxonomy = '', $term = '') {
		echo is_tax ( $taxonomy, $term );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_date', function ($d = '', $post = null) {
		return get_the_date ( $d, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_date', function ($d = '', $before = '', $after = '', $echo = true) {
		return the_date ( $d, $before, $after, $echo );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'WP_Query', function ($args = array()) {
		return new WP_Query ( $args );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_title', function ($post = 0) {
		get_the_title ( $post );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'types_render_field', function ($str = "", $args = array( )) {
		return types_render_field ( $str, $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'call', function ($function_name = '', $function_args = array()) {
		try {
			if ($function_name != '') {
				if (empty ( $function_args )) {
					if (function_exists ( $function_name ) && is_callable ( $function_name )) {
						call_user_func ( $function_name );
					} else {
						echo "la fonction est non callable";
					}
				} else {
					if (function_exists ( $function_name )) {
						if (count ( $function_args ) == 1) {
							call_user_func ( $function_name, $function_args );
						} else {
							call_user_func_array ( $function_name, $function_args );
						}
					}
				}
			}
		} catch ( Exception $e ) {
			echo 'Exception reçue : ', $e->getMessage (), "\n";
		}
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_title', function ($id = 0) {
		return get_the_title ( $id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_ID', function () {
		the_ID ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_template', function ($file = 'comments.twig', $separate_comments = false) {
		global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_ID, $user_identity, $overridden_cpage;
		global $twig;
		if (! (is_single () || is_page () || $withcomments) || empty ( $post ))
			return;
		
		if (empty ( $file ))
			$file = 'comments.twig';
		
		$req = get_option ( 'require_name_email' );
		
		/*
		 * Comment author information fetched from the comment cookies.
		 * Uuses wp_get_current_commenter().
		 */
		$commenter = wp_get_current_commenter ();
		
		/*
		 * The name of the current comment author escaped for use in attributes.
		 * Escaped by sanitize_comment_cookies().
		 */
		$comment_author = $commenter ['comment_author'];
		
		/*
		 * The email address of the current comment author escaped for use in attributes.
		 * Escaped by sanitize_comment_cookies().
		 */
		$comment_author_email = $commenter ['comment_author_email'];
		
		/*
		 * The url of the current comment author escaped for use in attributes.
		 */
		$comment_author_url = esc_url ( $commenter ['comment_author_url'] );
		
		$comment_args = array (
				'order' => 'ASC',
				'orderby' => 'comment_date_gmt',
				'status' => 'approve',
				'post_id' => $post->ID 
		);
		
		if ($user_ID) {
			$comment_args ['include_unapproved'] = array (
					$user_ID 
			);
		} else if (! empty ( $comment_author_email )) {
			$comment_args ['include_unapproved'] = array (
					$comment_author_email 
			);
		}
		
		$comments = get_comments ( $comment_args );
		
		/**
		 * Filter the comments array.
		 *
		 * @since 2.1.0
		 *       
		 * @param array $comments
		 *        	Array of comments supplied to the comments template.
		 * @param int $post_ID
		 *        	Post ID.
		 */
		$wp_query->comments = apply_filters ( 'comments_array', $comments, $post->ID );
		$comments = &$wp_query->comments;
		$wp_query->comment_count = count ( $wp_query->comments );
		update_comment_cache ( $wp_query->comments );
		
		if ($separate_comments) {
			$wp_query->comments_by_type = separate_comments ( $comments );
			$comments_by_type = &$wp_query->comments_by_type;
		}
		
		$overridden_cpage = false;
		if ('' == get_query_var ( 'cpage' ) && get_option ( 'page_comments' )) {
			set_query_var ( 'cpage', 'newest' == get_option ( 'default_comments_page' ) ? get_comment_pages_count () : 1 );
			$overridden_cpage = true;
		}
		
		if (! defined ( 'COMMENTS_TEMPLATE' ))
			define ( 'COMMENTS_TEMPLATE', true );
		
		$theme_template = STYLESHEETPATH . $file;
		/**
		 * Filter the path to the theme template file used for the comments template.
		 *
		 * @since 1.5.1
		 *       
		 * @param string $theme_template
		 *        	The path to the theme template file.
		 */
		$include = apply_filters ( 'comments_template', $theme_template );
		$template = $twig->loadTemplate ( $file );
		$template->display ( array () );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_404', function () {
		return is_404 ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_admin', function () {
		return is_admin ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_admin_bar_showing', function () {
		return is_admin_bar_showing ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_archive', function () {
		return is_archive ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_attachment', function () {
		return is_attachment ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_author', function ($author = '') {
		return is_author ( $author );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_category', function ($category = '') {
		return is_category ( $category );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_comments_popup', function () {
		return is_comments_popup ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_date', function () {
		return is_date ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_day', function () {
		return is_day ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_month', function () {
		return is_month ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_year', function () {
		return is_year ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_feed', function ($feeds = '') {
		return is_feed ( $feeds );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_front_page', function () {
		return is_front_page ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_home', function () {
		return is_home ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'in_category', function ($category, $post = null) {
		return in_category ( $category, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_category', function ($id = false) {
		return get_the_category ( $id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'print_r', function ($var) {
		print_r ( $var );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'microtime', function ($bool = true) {
		return microtime ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_page', function () {
		return is_page ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( "is_page_template", function () {
		is_page_template ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_header_textcolor', function () {
		return get_header_textcolor ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_nav_menu', function ($location) {
		return has_nav_menu ( $location );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'home_url', function ($path = '', $scheme = null) {
		home_url ( $path, $scheme );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_post_thumbnail', function ($post_id = null) {
		return has_post_thumbnail ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_post_thumbnail', function ($size = 'post-thumbnail', $attr = '') {
		the_post_thumbnail ( $size, $attr );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_permalink', function () {
		the_permalink ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_permalink', function ($id = 0, $leavename = false) {
		get_the_permalink ( $id, $leavename );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_time', function ($d = '', $post = null) {
		return get_the_time ( $d, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'function_exists', function ($function) {
		return function_exists ( $function );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'dynamic_sidebar', function ($index = 1) {
		dynamic_sidebar ( $index );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_number', function ($zero = false, $one = false, $more = false, $deprecated = '') {
		comments_number ( $zero, $one, $more, $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'trackback_url', function () {
		trackback_url ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_option', function ($option, $default = false) {
		return get_option ( $option, $default = false );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'paginate_comments_links', function ($args = array()) {
		return paginate_comments_links ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_user_logged_in', function () {
		return is_user_logged_in ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_current_commenter', function () {
		return wp_get_current_commenter ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_day_link', function ($year, $month, $day) {
		get_day_link ( $year, $month, $day );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_author_link', function () {
		return get_the_author_link ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_popup_link', function ($zero = false, $one = false, $more = false, $css_class = '', $none = false) {
		comments_popup_link ( $zero, $one, $more, $css_class, $none );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_search', function () {
		return is_search ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'current_user_can', function ($capability) {
		return current_user_can ( $capability );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_tag_list', function ($before = '', $sep = '', $after = '', $id = 0) {
		echo get_the_tag_list ( $before, $sep, $after, $id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'isset', function ($vars) {
		return isset ( $ars );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_numeric', function ($vars) {
		return is_numeric ( $vars );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_wp_query', function () {
		global $wp_query;
		return $wp_query;
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_class', function ($class = '', $post_id = null) {
		post_class ( $class, $post_id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_link_pages', function ($args = '') {
		wp_link_pages ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'esc_attr', function ($str = '') {
		return esc_attr ( $str );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_kses', function ($string, $allowed_html, $allowed_protocols = array()) {
		return wp_kses ( $string, $allowed_html, $allowed_protocols );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'do_shortcode', function ($string) {
		echo do_shortcode ( $string );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_localize_script', function ($handle, $object_name, $l10n) {
		return wp_localize_script ( $handle, $object_name, $l10n );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'sanitize_title', function ($title, $fallback_title = '', $context = 'save') {
		return sanitize_title ( $title, $fallback_title, $context );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'onetone_options_array', function ($title = '') {
		if (function_exists ( 'onetone_options_array' ))
			return onetone_options_array ( $title );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'onetone_get_background', function ($title = '') {
		return onetone_get_background ( $title );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'trim', function ($title = '') {
		return trim ( $title );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'echo', function ($title = '') {
		echo $title;
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_permalink', function ($id = 0, $leavename = false) {
		return get_permalink ( $id, $leavename );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_login_url', function ($redirect = '', $force_reauth = false) {
		wp_login_url ( $redirect, $force_reauth );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'apply_filters', function ($tag, $value) {
		return apply_filters ( $tag, $value );
	} ) );
	// $twig->addGlobal ( 'error', new Errors () );
	$twig->addFunction ( new Twig_SimpleFunction ( 'query_posts', function ($query = 'posts_per_page=-1') {
		$GLOBALS ['wp_query'] = new WP_Query ();
		$GLOBALS ['wp_query']->query ( $query );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_categories', function ($args = '') {
		return wp_list_categories ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_archives', function ($args = '') {
		wp_get_archives ( $args = '' );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'rewind_posts', function () {
		rewind_posts ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_permalink', function () {
		the_permalink ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_children', function ($args = '', $output = OBJECT) {
		return get_children ( $args, $output );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_attachment_image', function ($attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
		return wp_get_attachment_image ( $attachment_id, $size, $icon, $attr );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_author_posts_url', function ($author_id, $author_nicename = '') {
		get_author_posts_url ( $author_id, $author_nicename );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'next_comments_link', function ($label = '', $max_page = 0) {
		next_comments_link ( $label, $max_page );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_type_supports', function ($post_type, $feature) {
		return post_type_supports ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_type', function ($post = null) {
		return get_post_type ( $post );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_category_list', function ($separator = '', $parents = '', $post_id = false) {
		return get_the_category_list ( $separator, $parents, $post_id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'edit_post_link', function ($id = 0, $context = 'display') {
		echo edit_post_link ( $text = null, $before = '', $after = '', $id = 0 );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'number_format_i18n', function ($number, $decimals = 0) {
		return number_format_i18n ( $number, $decimals = 0 );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_paged', function () {
		return is_paged ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_search_query', function ($escaped = true) {
		return get_search_query ( $escaped );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_nonce_field', function ($action = -1, $name = "_wpnonce", $referer = true, $echo = true) {
		echo wp_nonce_field ( $action, $name, $referer, $echo );
	} ) );
	
	// $twig->addFunction ( new Twig_SimpleFunction ( 'get_post_meta', function ($post_id, $key = '', $single = false ) {
	// return get_post_meta($post_id, $key , $single);
	// } ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'var_dump', function ($a) {
		var_dump ( $a );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_page_template', function () {
		return get_page_template ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'a', function () {
		global $template;
		$filename = basename ( $template );
		echo '<strong>' . $filename . '</strong>';
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'b', function () {
		global $twig;
		echo 'one' . TWP_Manager::getDebug () . '<br>';
		TWP_Manager::setDebug ( 0 );
		echo 'two' . TWP_Manager::getDebug ();
	} ) );
	
	/**
	 * tester 100% **
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_boundary_post', function () {
		return get_boundary_post ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'user_trailingslashit', function ($string, $type_of_url = '') {
		return user_trailingslashit ( $string, $type_of_url );
	} ) );
	
	// $twig->addFunction ( new Twig_SimpleFunction ( 'get_extended', function () {
	// return get_extended();
	// } ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'permalink_anchor', function ($mode = 'id') {
		echo permalink_anchor ( $mode );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_permalink', function ($id = 0, $leavename = false, $sample = false) {
		return get_post_permalink ( $id, $leavename, $sample );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_permalink', function ($post_id = 0, $deprecated = '') {
		return post_permalink ( $post_id, $deprecated );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_page_link', function ($post = false, $leavename = false, $sample = false) {
		return get_page_link ( $post = false, $leavename = false, $sample = false );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_get_page_link', function ($post = false, $leavename = false, $sample = false) {
		return _get_page_link ( $post, $leavename, $sample );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_attachment_link', function ($post = null, $leavename = false) {
		return get_attachment_link ( $post, $leavename );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_year_link', function ($year) {
		return get_year_link ( $year );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_month_link', function ($year, $month) {
		return get_month_link ( $year, $month );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_feed_link', function ($anchor, $feed = '') {
		the_feed_link ( $anchor, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_feed_link', function ($feed = '') {
		return get_feed_link ( $feed = '' );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_comments_feed_link', function ($post_id = 0, $feed = '') {
		return get_post_comments_feed_link ( $post_id, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_comments_feed_link', function ($link_text = '', $post_id = '', $feed = '') {
		post_comments_feed_link ( $link_text, $post_id, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_author_feed_link', function ($author_id, $feed = '') {
		return get_author_feed_link ( $author_id, $feed );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_feed_link', function ($cat_id, $feed = '') {
		return get_category_feed_link ( $cat_id, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_term_feed_link', function ($term_id, $taxonomy = 'category', $feed = '') {
		return get_term_feed_link ( $term_id, $taxonomy, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_tag_feed_link', function ($tag_id, $feed = '') {
		return get_tag_feed_link ( $tag_id, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_tag_link', function ($tag_id, $taxonomy = 'post_tag') {
		return get_edit_tag_link ( $tag_id, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'edit_tag_link', function ($link = '', $before = '', $after = '', $tag = null) {
		// à tester
		edit_tag_link ( $link, $before, $after, $tag );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_term_link', function ($term_id, $taxonomy, $object_type = '') {
		// à verif
		return get_edit_term_link ( $term_id, $taxonomy, $object_type );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'edit_term_link', function ($link = '', $before = '', $after = '', $term = null, $echo = true) {
		// à verif
		
		echo edit_term_link ( $link, $before, $after, $term, $echo );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_search_link', function ($query = '') {
		return get_search_link ( $query );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_search_feed_link', function ($search_query = '', $feed = '') {
		return get_search_feed_link ( $search_query, $feed );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_search_comments_feed_link', function ($search_query = '', $feed = '') {
		return get_search_comments_feed_link ( $search_query, $feed );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_type_archive_link', function ($post_type) {
		return get_post_type_archive_link ( $post_type );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_type_archive_feed_link', function ($post_type, $feed = '') {
		return get_post_type_archive_feed_link ( $post_type, $feed );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_post_link', function ($id = 0, $context = 'display') {
		return get_edit_post_link ( $id, $context );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_delete_post_link', function ($id = 0, $deprecated = '', $force_delete = false) {
		return html_entity_decode ( get_delete_post_link ( $id, $deprecated, $force_delete ) );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_comment_link', function ($comment_id = 0) {
		return html_entity_decode ( get_edit_comment_link ( $comment_id ) );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'edit_comment_link', function ($text = null, $before = '', $after = '') {
		edit_comment_link ( $text, $before, $after );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_bookmark_link', function ($link = 0) {
		return html_entity_decode ( get_edit_bookmark_link ( $link ) );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'edit_bookmark_link', function () {
		edit_bookmark_link ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_edit_user_link', function ($user_id = null) {
		return get_edit_user_link ( $user_id );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_previous_post', function ($in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		return get_previous_post ( $in_same_term, $excluded_terms, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_adjacent_post', function ($in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category') {
		return get_adjacent_post ( $in_same_term, $excluded_terms, $previous, $taxonomy );
	} ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ();
	// } ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_next_post', function ($in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		return get_next_post ( $in_same_term = false, $excluded_terms, $taxonomy = 'category' );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_adjacent_post_rel_link', function ($title = '%title', $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category') {
		return get_adjacent_post_rel_link ( $title, $in_same_term, $excluded_terms, $previous, $taxonomy );
	} ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( 'adjacent_posts_rel_link(', function () {
	// ();
	// } ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'adjacent_posts_rel_link', function ($title = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		echo get_adjacent_post_rel_link ( $title, $in_same_term, $excluded_terms, true, $taxonomy );
		echo get_adjacent_post_rel_link ( $title, $in_same_term, $excluded_terms, false, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'adjacent_posts_rel_link_wp_head', function () {
		adjacent_posts_rel_link_wp_head ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'next_post_rel_link', function ($title = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		next_post_rel_link ( $title, $in_same_term, $excluded_terms, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'prev_post_rel_link', function ($title = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		echo get_adjacent_post_rel_link ( $title, $in_same_term, $excluded_terms, true, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_boundary_post', function ($in_same_term = false, $excluded_terms = '', $start = true, $taxonomy = 'category') {
		return get_boundary_post ( $in_same_term, $excluded_terms, $start, $taxonomy );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_previous_post_link', function ($format = '&laquo; %link', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		return html_entity_decode ( get_adjacent_post_link ( $format, $link, $in_same_term, $excluded_terms, true, $taxonomy ) );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'previous_post_link', function ($format = '&laquo; %link', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		echo get_previous_post_link ( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_next_post_link', function ($format = '%link &raquo;', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		return html_entity_decode ( get_adjacent_post_link ( $format, $link, $in_same_term, $excluded_terms, false, $taxonomy ) );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'next_post_link', function ($format = '%link &raquo;', $link = '%title', $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
		echo get_next_post_link ( $format, $link, $in_same_term, $excluded_terms, $taxonomy );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_adjacent_post_link', function ($format, $link, $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category') {
		return get_adjacent_post_link ( $format, $link, $in_same_term, $excluded_terms, $previous, $taxonomy );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'adjacent_post_link', function ($format, $link, $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category') {
		echo get_adjacent_post_link ( $format, $link, $in_same_term, $excluded_terms, $previous, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_pagenum_link', function ($pagenum = 1, $escape = true) {
		return get_pagenum_link ( $pagenum, $escape );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_next_posts_page_link', function ($max_page = 0) {
		return get_next_posts_page_link ( $max_page );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'next_posts', function ($max_page = 0, $echo = true) {
		next_posts ( $max_page, $echo );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_next_posts_link', function ($label = null, $max_page = 0) {
		/* à tester */
		return get_next_posts_link ( $label, $max_page );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'next_posts_link', function ($label = null, $max_page = 0) {
		/* à verife */
		echo get_next_posts_link ( $label, $max_page );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_previous_posts_page_link', function () {
		return get_previous_posts_page_link ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'previous_posts', function ($echo = true) {
		return previous_posts ( $echo );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_previous_posts_link', function () {
		return get_previous_posts_link ();
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'previous_posts_link', function ($label = null) {
		previous_posts_link ( $label );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_posts_nav_link', function ($args = array()) {
		return get_posts_nav_link ( $args );
	} ) );
	/**
	 * comment-template.php
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author', function ($comment_ID = 0) {
		return get_comment_author ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author', function ($comment_ID = 0) {
		return comment_author ( $comment_ID );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_email', function ($comment_ID = 0) {
		return get_comment_author_email ( $comment_ID );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_email', function ($comment_ID = 0) {
		comment_author_email ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_email_link', function ($linktext = '', $before = '', $after = '') {
		comment_author_email_link ( $linktext, $before, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_email_link', function ($linktext = '', $before = '', $after = '') {
		return get_comment_author_email_link ( $linktext, $before, $after );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_link', function ($comment_ID = 0) {
		return get_comment_author_link ( $comment_ID );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_link', function ($comment_ID = 0) {
		comment_author_link ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_IP', function ($comment_ID = 0) {
		return get_comment_author_IP ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_IP', function ($comment_ID = 0) {
		echo get_comment_author_IP ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_url', function ($comment_ID = 0) {
		return get_comment_author_url ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_url', function ($comment_ID = 0) {
		comment_author_url ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_author_url_link', function ($linktext = '', $before = '', $after = '') {
		return get_comment_author_url_link ( $linktext, $before, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_author_url_link', function ($linktext = '', $before = '', $after = '') {
		echo get_comment_author_url_link ( $linktext, $before, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_class', function ($class = '', $comment_id = null, $post_id = null, $echo = true) {
		return comment_class ( $class, $comment_id, $post_id, $echo );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_class', function ($class = '', $comment_id = null, $post_id = null) {
		return get_comment_class ( $class, $comment_id, $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_date', function ($d = '', $comment_ID = 0) {
		return get_comment_date ( $d, $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_date', function ($d = '', $comment_ID = 0) {
		comment_date ( $d, $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_excerpt', function ($comment_ID = 0) {
		return get_comment_excerpt ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_excerpt', function ($comment_ID = 0) {
		comment_excerpt ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_ID', function () {
		return get_comment_ID ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_ID', function () {
		comment_ID ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_link', function () {
		return get_comment_link ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comments_link', function ($post_id = 0) {
		return get_comments_link ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_link', function ($deprecated = '', $deprecated_2 = '') {
		comments_link ( $deprecated, $deprecated_2 );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comments_number', function ($post_id = 0) {
		return get_comments_number ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_number', function ($zero = false, $one = false, $more = false, $deprecated = '') {
		comments_number ( $zero, $one, $more, $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comments_number_text', function ($zero = false, $one = false, $more = false) {
		return get_comments_number_text ( $zero, $one, $more );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_text', function ($comment_ID = 0, $args = array()) {
		return get_comment_text ( $comment_ID, $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_text', function ($comment_ID = 0, $args = array()) {
		comment_text ( $comment_ID, $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_time', function ($d = '', $gmt = false, $translate = true) {
		return get_comment_time ( $d = '', $gmt = false, $translate = true );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_time', function ($d = '') {
		comment_time ( $d );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_type', function ($comment_ID = 0) {
		return get_comment_type ( $comment_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_type', function ($commenttxt = false, $trackbacktxt = false, $pingbacktxt = false) {
		comment_type ( $commenttxt, $trackbacktxt, $pingbacktxt );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_trackback_url', function () {
		return get_trackback_url ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'trackback_url', function () {
		trackback_url ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'trackback_rdf', function ($deprecated = '') {
		trackback_rdf ( $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'pings_open', function ($post_id = null) {
		return pings_open ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_comment_form_unfiltered_html_nonce', function () {
		wp_comment_form_unfiltered_html_nonce ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comments_popup_script', function ($width = 400, $height = 400, $file = '') {
		comments_popup_script ( $width, $height, $file );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_reply_link', function ($args = array(), $comment = null, $post = null) {
		/**
		 * tester *
		 */
		return get_comment_reply_link ( $args, $comment, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_reply_link', function ($args = array(), $comment = null, $post = null) {
		/**
		 * à tester*
		 */
		comment_reply_link ( $args, $comment, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_reply_link', function ($args = array(), $post = null) {
		return get_post_reply_link ( $args, $post );
	} ) );
	/**
	 * *****************ajout *****************
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_reply_link', function ($args = array(), $post = null) {
		post_reply_link ( $args, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_cancel_comment_reply_link', function ($text = '') {
		return get_cancel_comment_reply_link ( $text );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'cancel_comment_reply_link', function ($text = '') {
		cancel_comment_reply_link ( $text );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_comment_id_fields', function ($id = 0) {
		return get_comment_id_fields ( $id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_id_fields', function ($id = 0) {
		comment_id_fields ( $id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'comment_form_title', function ($noreplytext = false, $replytext = false, $linktoparent = true) {
		comment_form_title ( $noreplytext, $replytext, $linktoparent );
	} ) );
	
	/**
	 * *********** author template ************
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_author', function ($deprecated = '') {
		return get_the_author ( $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_author', function ($deprecated = '', $deprecated_echo = true) {
		the_author ( $deprecated, $deprecated_echo );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_modified_author', function () {
		return get_the_modified_author ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_modified_author', function () {
		the_modified_author ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_author_meta', function () {
		the_author_meta ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_author_link', function () {
		return get_the_author_link ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_author_link', function () {
		the_author_link ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_author_posts', function () {
		return get_the_author_posts ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_author_posts', function () {
		the_author_posts ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_author_posts_link', function ($deprecated = '') {
		the_author_posts_link ( $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_author_posts_url', function ($author_id, $author_nicename = '') {
		return get_author_posts_url ( $author_id, $author_nicename );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_authors', function ($args = '') {
		wp_list_authors ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_multi_author', function () {
		return is_multi_author ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '__clear_multi_author_cache', function () {
		__clear_multi_author_cache ();
	} ) );
	
	/**
	 * ************fin de comments-template *******
	 */
	/**
	 * ************debut category-template ********
	 */
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_link', function ($category) {
		return get_category_link ( $category );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_parents', function ($id, $link = false, $separator = '/', $nicename = false, $visited = array()) {
		return get_category_parents ( $id, $link, $separator, $nicename, $visited );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_usort_terms_by_name', function ($a, $b) {
		return _usort_terms_by_name ( $a, $b );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_usort_terms_by_ID', function () {
		return _usort_terms_by_ID ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_category_by_ID', function ($cat_ID) {
		return get_the_category_by_ID ( $cat_ID );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'category_description', function ($category = 0) {
		return category_description ( $category );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_dropdown_categories', function ($args = '') {
		return wp_dropdown_categories ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_tag_cloud', function ($args = '') {
		return wp_tag_cloud ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'default_topic_count_scale', function ($count) {
		return default_topic_count_scale ( $count );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_generate_tag_cloud', function ($tags, $args = '') {
		return wp_generate_tag_cloud ( $tags, $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_wp_object_name_sort_cb', function ($a, $b) {
		return _wp_object_name_sort_cb ( $a, $b );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_wp_object_count_sort_cb', function ($a, $b) {
		return _wp_object_count_sort_cb ( $a, $b );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_wp_object_count_sort_cb', function ($a, $b) {
		return _wp_object_count_sort_cb ( $a, $b );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'walk_category_tree', function () {
		/**
		 * a tester *
		 */
		return walk_category_tree ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'walk_category_dropdown_tree', function () {
		/**
		 * à tester *
		 */
		return walk_category_dropdown_tree ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_tag_link', function ($tag) {
		return get_tag_link ( $tag );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_tags', function ($id = 0) {
		return get_the_tags ( $id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_tags', function ($before = null, $sep = ', ', $after = '') {
		the_tags ( $before, $sep, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'tag_description', function ($tag = 0) {
		return tag_description ( $tag );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'term_description', function ($term = 0, $taxonomy = 'post_tag') {
		return term_description ( $term, $taxonomy );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_terms', function ($post, $taxonomy) {
		return get_the_terms ( $post, $taxonomy );
	} ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_term_list', function ($id, $taxonomy, $before = '', $sep = '', $after = '') {
		return get_the_term_list ( $id, $taxonomy, $before, $sep, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_terms', function ($id, $taxonomy, $before = '', $sep = ', ', $after = '') {
		the_terms ( $id, $taxonomy, $before, $sep, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_category', function ($category = '', $post = null) {
		return has_category ( $category, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_tag', function ($tag = '', $post = null) {
		return has_tag ( $tag, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_term', function ($term = '', $taxonomy = '', $post = null) {
		return has_term ( $term, $taxonomy, $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_walk_bookmarks', function ($bookmarks, $args = '') {
		return _walk_bookmarks ( $bookmarks, $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_bookmarks', function ($args = '') {
		return wp_list_bookmarks ( $args );
	} ) );
	/**
	 * *** fin bookmark **
	 */
	/**
	 * *** debut post-template *****
	 */
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_ID', function () {
		return get_the_ID ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_guid', function () {
		return get_the_guid ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_content', function ($more_link_text = null, $strip_teaser = false) {
		return get_the_content ( $more_link_text, $strip_teaser );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_convert_urlencoded_to_entities', function ($match) {
		return _convert_urlencoded_to_entities ( $match );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_excerpt', function () {
		return get_the_excerpt ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'has_excerpt', function ($id = 0) {
		return has_excerpt ( $id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_body_class', function ($class = '') {
		return get_body_class ( $class );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_password_required', function ($post = null) {
		return post_password_required ( $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_wp_link_page', function ($i) {
		return _wp_link_page ( $i );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'post_custom', function ($key = '') {
		return post_custom ( $key );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_custom', function ($post_id = 0) {
		return get_post_custom ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_dropdown_pages', function ($args = '') {
		wp_dropdown_pages ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_pages', function ($args = '') {
		wp_list_pages ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_page_menu', function ($args = array()) {
		wp_page_menu ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'walk_page_tree', function ($pages, $depth, $current_page, $r) {
		/* à tester */
		walk_page_tree ( $pages, $depth, $current_page, $r );
	} ) );
	/* à tester */
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'walk_page_dropdown_tree', function () {
		walk_page_dropdown_tree ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_attachment_link', function ($id = 0, $fullsize = false, $deprecated = false, $permalink = false) {
		the_attachment_link ( $id, $fullsize, $deprecated, $permalink );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'prepend_attachment', function ($content) {
		return prepend_attachment ( $content );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_password_form', function ($post = 0) {
		return get_the_password_form ( $post );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_page_template_slug', function ($post_id = null) {
		$post = get_post ( $post_id );
		if (! $post || 'page' != $post->post_type)
			return false;
		$template = get_post_meta ( $post->ID, 'wp_template_twig', true );
		if (! $template || 'default' == $template)
			return '';
		return $template;
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_post_revision_title', function ($revision, $link = true) {
		return wp_post_revision_title ( $revision, $link );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_post_revision_title_expanded', function ($revision, $link = true) {
		return wp_post_revision_title_expanded ( $revision, $link = true );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_list_post_revisions', function ($post_id = 0, $type = 'all') {
		wp_list_post_revisions ( $post_id, $type );
	} ) );
	/**
	 * ********fin template post-template *****
	 */
	/**
	 * *******debut template ***
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( '_wp_menu_item_classes_by_context', function (&$menu_items) {
		// _wp_menu_item_classes_by_context( &$menu_items );
	} ) );
	/* non detaille à tester */
	$twig->addFunction ( new Twig_SimpleFunction ( 'walk_nav_menu_tree', function ($items, $depth, $r) {
		walk_nav_menu_tree ( $items, $depth, $r );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_nav_menu_item_id_use_once', function ($id, $item) {
		return _nav_menu_item_id_use_once ( $id, $item );
	} ) );
	/**
	 * ** debut du template post-thunbnail-template ******
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_thumbnail_id', function ($post_id = null) {
		return get_post_thumbnail_id ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_post_thumbnail', function ($size = 'post-thumbnail', $attr = '') {
		the_post_thumbnail ( $size, $attr );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'update_post_thumbnail_cache', function ($wp_query = null) {
		update_post_thumbnail_cache ( $wp_query );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_post_thumbnail', function ($post_id = null, $size = 'post-thumbnail', $attr = '') {
		return get_the_post_thumbnail ( $post_id, $size, $attr );
	} ) );
	
	/**
	 * *** fin template **
	 */
	/**
	 * *** debut template template.php **
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_author_template', function () {
		return get_author_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_template', function () {
		return get_category_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_index_template', function () {
		return get_index_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_404_template', function () {
		return get_404_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_archive_template', function () {
		return get_archive_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_post_type_archive_template', function () {
		return get_post_type_archive_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_tag_template', function () {
		return get_tag_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_taxonomy_template', function () {
		return get_taxonomy_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_date_template', function () {
		return get_date_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_home_template', function () {
		return get_home_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_front_page_template', function () {
		return get_front_page_template ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_page_template', function () {
		return get_page_template ();
	} ) );
	/**
	 * *** debut post.php ***
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_attached_file', function ($attachment_id, $unfiltered = false) {
		return get_attached_file ( $attachment_id, $unfiltered = false );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_current_user_id', function () {
		return get_current_user_id ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_currentuserinfo', function () {
		global $current_user;
		return get_currentuserinfo ();
		
		// echo 'Username: ' . $current_user->user_login . "\n";
		// echo 'User email: ' . $current_user->user_email . "\n";
		// echo 'User first name: ' . $current_user->user_firstname . "\n";
		// echo 'User last name: ' . $current_user->user_lastname . "\n";
		// echo 'User display name: ' . $current_user->display_name . "\n";
		// echo 'User ID: ' . $current_user->ID . "\n";
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'posts_nav_link', function ($sep = '', $prelabel = '', $nxtlabel = '') {
		posts_nav_link ( $sep, $prelabel, $nxtlabel );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'esc_attr_e', function ($text, $domain = 'default') {
		esc_attr_e ( $text, $domain );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'header_image', function () {
		header_image ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_active_sidebar', function ($index) {
		return is_active_sidebar ( $index );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_search_query', function () {
		the_search_query ();
	} ) );
	/**
	 * ***************** user.php*************
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'count_many_users_posts', function ($users, $post_type = 'post', $public_only = false) {
		return count_many_users_posts ( $users, $post_type, $public_only );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_user_option', function ($option, $user = 0, $deprecated = '') {
		return get_user_option ( $option, $user, $deprecated );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'update_user_option', function ($user_id, $option_name, $newvalue, $global = false) {
		return update_user_option ( $user_id, $option_name, $newvalue, $global = false );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'delete_user_option', function ($user_id, $option_name, $global = false) {
		return delete_user_option ( $user_id, $option_name, $global );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_blogs_of_user', function ($user_id, $all = false) {
		return get_blogs_of_user ( $user_id, $all );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'is_user_member_of_blog', function ($user_id = 0, $blog_id = 0) {
		return is_user_member_of_blog ( $user_id, $blog_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'add_user_meta', function ($user_id, $meta_key, $meta_value, $unique = false) {
		return add_user_meta ( $user_id, $meta_key, $meta_value, $unique );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'delete_user_meta', function ($user_id, $meta_key, $meta_value = '') {
		return delete_user_meta ( $user_id, $meta_key, $meta_value );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_user_meta', function ($user_id, $key = '', $single = false) {
		return get_user_meta ( $user_id, $key, $single );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'update_user_meta', function ($user_id, $meta_key, $meta_value, $prev_value = '') {
		return update_user_meta ( $user_id, $meta_key, $meta_value, $prev_value );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'count_users', function ($strategy = 'time') {
		return count_users ( $strategy );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_dropdown_users', function ($args = '') {
		wp_dropdown_users ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'sanitize_user_field', function ($field, $value, $user_id, $context) {
		sanitize_user_field ( $field, $value, $user_id, $context );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'update_user_caches', function () {
		update_user_caches ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'clean_user_cache', function () {
		clean_user_cache ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'username_exists', function ($username) {
		return username_exists ( $username );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'email_exists', function ($email) {
		return email_exists ( $email );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'validate_username', function ($username) {
		return validate_username ( $username );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_insert_user', function ($userdata) {
		return wp_insert_user ( $userdata );
	} ) );
	
	/**
	 * ** .
	 *
	 * .... ***
	 */
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_password_hint', function () {
		return wp_get_password_hint ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'check_password_reset_key', function ($key, $login) {
		return check_password_reset_key ( $key, $login );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'reset_password', function ($user, $new_pass) {
		return reset_password ( $user, $new_pass );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'register_new_user', function ($user_login, $user_email) {
		return register_new_user ( $user_login, $user_email );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_session_token', function () {
		return wp_get_session_token ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_all_sessions', function () {
		return wp_get_all_sessions ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_destroy_current_session', function () {
		wp_destroy_current_session ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_destroy_other_sessions', function () {
		wp_destroy_other_sessions ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_destroy_all_sessions', function () {
		wp_destroy_all_sessions ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_get_attachment_url', function ($post_id = 0) {
		return wp_get_attachment_url ( $post_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_reset_query', function () {
		wp_reset_query ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'wp_reset_postdata', function () {
		wp_reset_postdata ();
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_posts_navigation', function ($args = array()) {
		the_posts_navigation ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_the_posts_navigation', function ($args = array()) {
		return get_the_posts_navigation ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_categories', function ($args = '') {
		return get_categories ( $args = '' );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category', function ($category, $output = OBJECT, $filter = 'raw') {
		return get_category ( $category, $output, $filter );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_by_path', function ($category_path, $full_match = true, $output = OBJECT) {
		return get_category_by_path ( $category_path, $full_match, $output );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_category_by_slug', function ($slug) {
		return get_category_by_slug ( $slug );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_cat_ID', function ($cat_name) {
		return get_cat_ID ( $cat_name );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_cat_name', function ($cat_id) {
		return get_cat_name ( $cat_id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'cat_is_ancestor_of', function ($cat1, $cat2) {
		return cat_is_ancestor_of ( $cat1, $cat2 );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'sanitize_category', function ($category, $context = 'display') {
		return sanitize_category ( $category, $context );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '', function ($field, $value, $cat_id, $context) {
		return sanitize_category_field ( $field, $value, $cat_id, $context );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_tags', function ($args = '') {
		return get_tags ( $args );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_tag', function ($tag, $output = OBJECT, $filter = 'raw') {
		return get_tag ( $tag, $output, $filter );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'clean_category_cache', function ($id) {
		clean_category_cache ( $id );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'get_theme_mod', function ($name, $default = false) {
		return get_theme_mod ( $name, $default );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'admin_url', function ($path='', $scheme='admin') {
	return admin_url($path, $scheme );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_post_navigation', function ( $args = array()) {
	the_post_navigation( $args);
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'previous_comments_link', function ($label = '') {
	previous_comments_link( $label );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( '_nx', function ($single, $plural, $number, $context, $domain = 'default') {
	return _nx($single, $plural, $number, $context, $domain );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_archive_description', function ($before = '', $after = '' ) {
	the_archive_description( $before, $after );
	} ) );
	$twig->addFunction ( new Twig_SimpleFunction ( 'the_archive_title', function ($before = '', $after = '' ) {
	the_archive_title($before, $after );
	} ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( '', function () {
	// ( );
	// } ) );
	// $twig->addFunction ( new Twig_SimpleFunction ( 'get_adjacent_post', function ($in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category') {
	// return get_adjacent_post ( $in_same_term, $excluded_terms, $previous, $taxonomy );
	// } ) );
	
	$twig->addFunction ( new Twig_SimpleFunction ( 'trace', function () {
		echo '<h1><b>debut de backtrace</b></h1>';
		var_dump ( debug_backtrace () );
		echo '<h1><b>fin de backtrace</b></h1>';
	} ) );
}

// ?>