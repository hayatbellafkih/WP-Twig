Documentation of wordpress-twig

1.	DESCRIPTION : 
----------------------------------------------------------------------------------------
  WP-Twig  est un plugin qui permet de créer des thèmes WordPress à base  des templates
  Twig. 
  
  OBJECTIFS :
   * respecter la hièrarchie du wordpress, de ce fait, au lieu 
   de créer page.php, on crée page.twig . 
   *  réécrire les fonctions wordpress pour qu'elles soient accessible dans les templates Twig.
   * implémente un système de routage pour créer des routes personnalisable 
     avec l'intégration du plugin WP Router
   * servir du fcichier functions.php comme controleur pour passer les données au templates Twig
   
  Pré-requis  l’installation :
     •	Le répertoire du thème doit avoir les droits d’écriture 
  Pré-requis de l'utilisation du routage:
     -> activer le module apache rewrite_module
     -> activer le type nom de l'article pour le permaliens   
2.	Installation 
L’installation du plugin se fait de deux façons :
  Installation automatique :
   •	Via Dashboard->plugins ->Ajouter le plugin
   •	Activer le plugin
  Installation manuelle : 
  •	Télécharger le plugin au format zip et l’ajouter dans le répertoire des plugins
  •	Activer le plugin 
Après l’installation :
Une fois le plugin est activé :
  •	Un répertoire « views » est crée dans le thème active.
  •	La template index.twig est crée dans « views »

  
3.	UTILISATION : 
-------------------------------------------------------------------------------------------------------
	* Ajouter variable
      Functions.php
         TWP_Manager::addGlobal('langage','PHP');

      Page.twig
         Mon langage préféré est : {{ langage }}

	* Ajouter fonction
     Functions.php
         - Sans parametre
           $function = new Twig_SimpleFunction ( "salutation", function () {
		     echo "Bonjour tout le monde";
	       } );
	        $function = new Twig_SimpleFunction ( "salutation", function () {
		       return 'Bonjour tout le monde';
	        } );
       - Avec parametres
	        $function = new Twig_SimpleFunction ( "salutation", function ($nom) {
		     echo "Bonjour  " . $nom;
	        } );
	    TWP_Manager::addFunction ( $function );
    Single.twig 
             {{ salutation() }}

    * Ajouter filtre :
      Functions.php      
       // fonction anonyme
	     $filter = new Twig_SimpleFilter ( 'rot13', function ($string) {
		      return str_rot13 ( $string );
	    } );
	
	   // simple fonction PHP
	     $filter = new Twig_SimpleFilter ( 'rot13', 'str_rot13' );

	   // fonction d'une class
	     $filter = new Twig_SimpleFilter ( 'rot13', array (
			'SomeClass',
			'rot13Filter' 
	  ) );
	
	  TWP_Manager::getEnvirenement ()->addFilter ( $filter );
     Page.twig
       {{ 'Twig'|rot13 }}
       Résultat d’affichage:  Gjvt

    * Ajouter extension
      // ExtensionDevise.php
       <?php
              class DeviseExtension extends Twig_Extension
              {
	                public function getFilters()
	                {
		                  return array(
				                       new Twig_SimpleFilter('device', array($this, 'deviceFilter')),
		                               );
	                }

	                public function deviceFilter($number, $device=' DH')
	                {
		                 return $number.$device;
	                }

	               public function getName()
	               {
		                 return 'app_extension';
	                }
              }

       ?>	

     Functions.php
          include_once PLUGIN_TWP . '/classes/ExtensionDevise.php';
	      TWP_Manager::addExtension ( 'DeviseExtension' );
     Page.twig
          <h1>{{ 5222|device }}</h1>
     Resultat :
           5222 DH

    *	Les fonctionnalité prédéfinits
	     **  Variables :
		   voir fin de fichier la liste des variables déjà prédéfinis
	     **  Fonctions :
		  voir fin de fichier la liste des fonctions déjà prédéfinies 
	     **  Boucles :
		  le plugin implémente trois boucles du wordpress 
		     • the loop : 
			   la boucle par défaut du WordPress
			   cette boucle est accessible dans tous les fichiers Twig appartenant au hiérarchie du wordpress ( aussi les templates des Pages Wordpress) 
			   afin d'inclure dans les nouvelles fichiers Twig non wordpress la boucle wordpress, il faut les passer en argument comme suit: 'loop' => new TWP_Loop ()
			   exemple:			   
                nom-template.twig
			      {% for post in loop %}
                   //appel des methodes: the_content(), the_title(), ... 
                  {% endfor %}
				  
             • Query_posts():
			   exemple:
			    nom-template.twig
				{{ query_posts({'cat':'adulte'}) }}
                {% for post in loop %}
                    <!--post content-->
                        {{ the_content() }}
                    <!--post content end-->
                {% endfor %}

			 • WP_Query():
               exemple:
			   Functions.php
                       	$new_entree = new TWP_Entree ( 'twig', 'page.twig', array (
			                                          'new_query' => new TWP_Loop_Query( array('post_type' => 'page' ,
					                                                                           'posts_per_page' =>6
			                                                                                   )
																				        )
	                                                                                ) 
													 );
	                    TWP_Liste_Entree::addEntree ( $new_entree );

			   nom-template.twig
			  <div id='test_new_query'>
	              {% if new_query is not empty %} {% for post in new_query %}
	                <h1>{{ the_title() }}</h1>
	                     {% endfor %} {% else %}
	                <h3>no data to dispaly</h3>
	              {% endif %}
              </div>
          </div>


 
		 
    *   Choix de type de templating :
             Une fois le plugin est activé, les templates qui seront utilisées sont celles du Twig, existant en dossier « views », or
		   il est possible à un moment donnée, d'utiliser les templates PHP. Voila un exemple où on veut utiliser 404.php et non 404.twig :

         Functions.php
            ListeEntree::addEntree ( new  Data ( 'php', '404.twig', array()));
            //la requête  404 vas utiliser 404.php
            ListeEntree::addEntree ( new  Data ( 'twig', '404.twig', array()));
            //la requette 404 vas utiliser 404.twig
			
    *   Passage des données :
           Le but principal de ce plugin est de réaliser tout les traitements nécessaires dans le fichier « functions.php »
		   voire dans l’un des fichiers d’un plugin activé , et puis passer les données aux templates pour les afficher.
           L’utilisation du Twig pour afficher les pages nécessite :
             •	Le nom de la template
             •	Les données à passer au template : ils doivent être au format de tableau associative (cle => valeur) dont « cle » 
			     est utilisé dans les templates twig, lors d’affichage , la balise {{ cle }} est remplacé par « valeur ».
             • Il faut noter l’utilisation de  array_merge afin de construire un seul tableau de données à partir de plusieurs tableau .
    *   Gestion des  routes :
         La gestion des routes se fait par le hook « wp_router_generate_routes » :
                add_action ( 'wp_router_generate_routes', 'routes_function’);
         à  savoir que chaque action d’ajout, de modification ou de suppression d’une route se fait dans la fonction « routes_function ».
		 
        ** Ajouter une route :
            Afin d’ajouter une nouvelle route personnalisable,le plugin WP Router a été utilisé  avec plus de personnalisations.
                      http://monsite.org/go/05/23
            Un exemple d’une route personnalisable :
            add_action ( 'wp_router_generate_routes', 'added_routes');
	            function added_routes(WP_Router $router) {
		         $route_args = array (   
				'path' => '^go/(.*?)/(.*?)',
				'page_callback' => 'go_callback',
				'query_vars' => array (
						'mois' => 1,
						'jour' => 2 
				),
                                                'template' => 'page.php'
				'page_arguments' => array (
						'mois',
						'jour' 
				),
				'access_callback' => true,
				'title' => 'Go title',
				'twig_template' => 'go.twig',
				
				'twig_data' => array (
						'data_one',
						'data_two' 
				),
				'is_twig' => true 
		        );
		        TWP_Liste_Entree::addRoute ( $router, $route_args, 'go' );
	        }

        Les précédentes instructions peuvent être ajouté dans functions.php voire dans un plugin activé.
        Explication des différentes propriétés:
        -	Path : C’est la route qu’on vient de créer, elle est sous format d’expression régulière.
        -	Access_callback :Définit les droit  et  permissions de la route 
             True : toute personne peut consulter le contenu de la page associé à la route.
             False : deux cas de figures
                 Si l’utilisateur est authentifié, il sera rediriger vers 403
                 Si l’utilisateur est non authentifié, il sera rediriger vers page d’authentification
        -	Is_twig : Ce paramètre définit le mode d’affichage du contenu de la page
                 True :   on veut utiliser une des templates Twig pour le rendu de la route, en effet c’est la template « twig_template »
                 False :  dans ce cas, on veux pas utiliser les templates Twig, mais on peut utiliser du PHP. La propriété « page_callback » permet de définir  la méthode à appeler pour afficher le contenu de la page
        -	Template : cette propriété sert à un modèle des nouvelles routes crées, 
                     Suivant la propriété « is_twig »,  le « the_content ()»  est remplacé par le contenu de la template Twig ou bien le contenu de la propriété « page_callback ».
        -	Title : spécifier le titre de la route
        -	Twig_data : tableau regroupe le(s) nom(s) de(s) fonction(s) , qui doivent retourner un tableau associative, ce tableau contient les données à passer au template « twig_template »
        -	Query_vars : cette propriété permet d’associer un nom aux motifs de l’expression régulière. Ces variables seront utiliser dans Page_arguments 
        -	Page_arguments : définit l’ordre des paramètres de la méthode de « page_callback »  

		** Editer route :
             La mise à jour d’une route se fait simplement par mise à jour de l’une des propriétés de la route :
		     $route_args_edit = array (
				'template' => 'page.php' ,
				'twig_template' => '404.twig'
		         );
		     TWP_Liste_Entree::editRoute ($router,$route_args_edit,'go');
         ** Supprimer route :
                      TWP_Liste_Entree::removeRoute ($router,'go');
    * Configuration du plugin :
        • La configuration de l’instance Twig :
            La configuration porte sur :
              	Gestion de la cache : 
                  Si activé : les fichiers scripts sont conservé dans le dossier cache du  répertoire du plugin
                  Si désactiver : aucun fichier ne sera conservé 
                  Possibilité de vider le cache, cela supprime tous les fichiers du répertoire « cache » 
              	Auto reload :
                  Ce paramètre sert pour mettre à jour scripts PHP des templates.
                    Si activé : recompilation automatique du template après chaque changement dans la template .
                    Si désactivé : les changements ne seront plus pris en charge lors de la prochaine utilisation de la template
              	Ajout de nouveaux répertoires :
                   En effet , les templates Twig sont recherché dans répertoires bien précises
                   Par défaut, les répertoires « views » du thème active et le répertoire « vues » du répertoire du plugin sont reconnu par le plugin.
				   De ce fait il est possible d’ajouter de nouveaux répertoires de templates , celles qui vont contenir les templates (fichier .twig).
              	Le débogage :
                    L’activation du débogage permet d’afficher les messages d’erreur, en contre partie la désactivation de ce dernier empêche
					l’affichage des erreurs rencontré dans le template 

        •	Gestion du routage :
               Possibilité d’activer ou désactiver le routage
                    Si activé : les routes crée sont prise en considération
                    Si désactiver : les routes crée ne sont pas prise en considération

Notes importantes :
	Le plugin WP-Twig intègre le plugin wp-router pour l’implémentation de système de routage.


 
VARIABLES GLOBALES:
-------------------
libele      valeur
GET                                $_GET
POST                               $_POST
FILES                              $_FILES 
COOKIE                             $_COOKIE
ENV                                $_ENV
SERVER                             $_SERVER
twig                               TWP_Manager::getEnvirenement ()
wp_rewrite                         $wp_rewrite
is_iphone                          $is_iphone
is_chrome                          $is_chrome
is_safari                          $is_safari
is_NS4                             $is_NS4
is_opera                           $is_opera
is_macIE                           $is_macIE
is_winIE                           $is_winIE
is_gecko                           $is_gecko
is_lynx                            $is_lynx
is_IE                              $is_IE
is_apache                          $is_apache
is_IIS                             $is_IIS
is_iis7                            $is_iis7
wp_version                         $wp_version
wp_db_version                      $wp_db_version
tinymce_version                    $tinymce_version
manifest_version                   $manifest_version
required_php_version               $required_php_version
required_mysql_version             $required_mysql_version
super_admins                       $super_admins 
wp_query                           $wp_query
wp_rewrite                         $wp_rewrite
wp                                 $wp
wpdb                               $wpdb
wp_locale                          $wp_locale
wp_admin_bar                       $wp_admin_bar
wp_roles                           $wp_roles
wp_meta_boxes                      $wp_meta_boxes
pagenow                            $pagenow
post_type                          $post_type
allowedposttags                    $allowedposttags
allowedtags                        $allowedtags
menu                               $menu
query_string                       $query_string


FONCTIONS GLOBALES
------------------

liste des methode redefinit:
get_template_directory_uri
the_content
the_title
the_ID
the_tags
the_category 
the_excerpt
the_shortlink
get_posts
have_posts
get_header
get_footer
wp_head
wp_footer
get_template_part
__
_e
get_sidebar
get_search_form
get_the_author_meta
get_post_format
body_class
wp_title
the_title_attribute
the_guid
get_header_image
get_post_class
the_meta
the_shortlink
wp_list_comments
have_comments
get_comments_number
comment_form
comments_open
is_page
is_single
post_password_required
get_comment_pages_count
bloginfo
get_post_format_string
wp_nav_menu
esc_url
get_bloginfo
language_attributes
term_description
single_tag_title
is_tax
get_the_date
the_date
WP_Query
get_the_title
types_render_field
call
get_the_title
the_ID
comments_template
is_404
is_admin
is_admin_bar_showing
is_archive
is_attachment
is_author
is_category
is_comments_popup
is_date
is_day
is_month
is_year
is_feed
is_front_page
is_home
in_category
get_the_category
print_r
microtime 
is_page
is_page_template
get_header_textcolor
has_nav_menu
home_url
has_post_thumbnail
the_post_thumbnail
the_permalink
get_the_permalink
get_the_time
function_exists
dynamic_sidebar
comments_number
trackback_url
get_option
paginate_comments_links
is_user_logged_in
wp_get_current_commenter
get_day_link
get_the_author_link
comments_popup_link
is_search
current_user_can
get_the_tag_list
isset
is_numeric
get_wp_query
post_class
wp_link_pages
esc_attr
wp_kses
do_shortcode
wp_localize_script
sanitize_title
onetone_options_array
onetone_get_background
trim
echo
get_permalink
wp_login_url
apply_filters
query_posts
wp_list_categories
wp_get_archives
rewind_posts
the_permalink
get_children
wp_get_attachment_image
get_author_posts_url
next_comments_link
post_type_supports
get_post_type
get_the_category_list
edit_post_link
number_format_i18n
is_paged
get_search_query
wp_nonce_field
var_dump
get_page_template
get_boundary_post
user_trailingslashit
permalink_anchor
get_post_permalink
post_permalink
get_page_link
_get_page_link
get_attachment_link
get_year_link
get_month_link
the_feed_link
get_feed_link
get_post_comments_feed_link
post_comments_feed_link
get_author_feed_link
get_category_feed_link
get_term_feed_link
get_tag_feed_link
get_edit_tag_link
edit_tag_link
get_edit_term_link
edit_term_link
get_search_link
get_search_feed_link
get_search_comments_feed_link
get_post_type_archive_link
get_post_type_archive_feed_link
get_edit_post_link
get_delete_post_link
get_edit_comment_link
edit_comment_link
get_edit_bookmark_link
edit_bookmark_link
get_edit_user_link
get_previous_post
get_adjacent_post
get_next_post
get_adjacent_post_rel_link
adjacent_posts_rel_link
adjacent_posts_rel_link_wp_head
next_post_rel_link
get_boundary_post
prev_post_rel_link
get_previous_post_link
previous_post_link
get_next_post_link
next_post_link
get_adjacent_post_link
adjacent_post_link
get_pagenum_link
get_next_posts_page_link
next_posts
get_next_posts_link
next_posts_link
get_previous_posts_page_link
previous_posts
get_previous_posts_link
previous_posts_link
get_posts_nav_link
get_comment_author
comment_author
get_comment_author_email
comment_author_email
comment_author_email_link
get_comment_author_email_link
get_comment_author_link
comment_author_link
get_comment_author_IP
comment_author_IP
get_comment_author_url
comment_author_url
get_comment_author_url_link
comment_author_url_link
comment_class
get_comment_class
get_comment_date
comment_date
get_comment_excerpt
comment_excerpt
get_comment_ID
comment_ID
get_comment_link
get_comments_link
comments_link
get_comments_number
comments_number
get_comments_number_text
get_comment_text
comment_text
get_comment_time
comment_time
get_comment_type
comment_type
get_trackback_url
trackback_url
trackback_rdf
pings_open
wp_comment_form_unfiltered_html_nonce
comments_popup_script
get_comment_reply_link
comment_reply_link
get_post_reply_link
post_reply_link
get_cancel_comment_reply_link
cancel_comment_reply_link
get_comment_id_fields
comment_id_fields
comment_form_title
get_the_author
the_author
get_the_modified_author
the_modified_author
the_author_meta
get_the_author_link
the_author_link
get_the_author_posts
the_author_posts
the_author_posts_link
get_author_posts_url
wp_list_authors
is_multi_author
__clear_multi_author_cache
get_category_link
get_category_parents
_usort_terms_by_name
_usort_terms_by_ID
get_the_category_by_ID
category_description
wp_dropdown_categories
wp_tag_cloud
default_topic_count_scale
wp_generate_tag_cloud
_wp_object_name_sort_cb
_wp_object_count_sort_cb
walk_category_tree
walk_category_dropdown_tree
get_tag_link
get_the_tags
the_tags
tag_description
term_description
get_the_terms
get_the_term_list
the_terms
has_category
has_tag
has_term
_walk_bookmarks
wp_list_bookmarks
get_the_ID
get_the_guid
get_the_content
_convert_urlencoded_to_entities
get_the_excerpt
has_excerpt
get_body_class
post_password_required
_wp_link_page
post_custom
get_post_custom
wp_dropdown_pages
wp_list_pages
wp_page_menu
walk_page_tree
walk_page_dropdown_tree
the_attachment_link
prepend_attachment
get_the_password_form
get_page_template_slug
wp_post_revision_title
wp_post_revision_title_expanded
wp_list_post_revisions
_wp_menu_item_classes_by_context
walk_nav_menu_tree
_nav_menu_item_id_use_once
get_post_thumbnail_id
the_post_thumbnail
update_post_thumbnail_cache
get_the_post_thumbnail
get_author_template
get_category_template
get_index_template
get_404_template
get_archive_template
get_post_type_archive_template
get_tag_template
get_taxonomy_template
get_date_template
get_home_template
get_front_page_template
get_page_template
get_attached_file
get_current_user_id
get_currentuserinfo
posts_nav_link
esc_attr_e
header_image
is_active_sidebar
the_search_query
count_many_users_posts
get_user_option
update_user_option
delete_user_option
get_blogs_of_user
is_user_member_of_blog
add_user_meta
delete_user_meta
get_user_meta
update_user_meta
count_users
wp_dropdown_users
sanitize_user_field
update_user_caches
clean_user_cache
username_exists
email_exists
validate_username
wp_insert_user
wp_get_password_hint
check_password_reset_key
reset_password
register_new_user
wp_get_session_token
wp_get_all_sessions
wp_destroy_current_session
wp_destroy_other_sessions
wp_destroy_all_sessions
wp_get_attachment_url
wp_reset_query
wp_reset_postdata
the_posts_navigation
get_the_posts_navigation
get_categories
get_category
get_category_by_path
get_category_by_slug
get_cat_ID
get_cat_name
cat_is_ancestor_of
sanitize_category
get_tags
get_tag
clean_category_cache
get_theme_mod
admin_url
the_post_navigation
previous_comments_link
_nx
the_archive_description
the_archive_title 


      