<style type="text/css">
.wpt-td{

}
h1 {
	
}
td{
width:400px;
}
#title {
	text-align: left;
}
.wpt-label{
font-family: "Times New Roman", Times, serif;
font-size: 20px;
}
</style>
<div id='title'>
	<h1> <?php _e('Setting of WP-Twig','wordpress-twig')?></h1>
	<p><?php _e('this is the page that let developer configure the plugin' ,'wordpress-twig')?></p>
</div>

<table>
<tr>
		<td id='wpt-td'><label class='wpt-label'><?php _e ( 'Activate the cache', 'wordpress-twig' ) ;?></label></td>
		<td><input type="checkbox"  <?php if(get_option('wt_is_cache') == '1') {echo "checked" ;}?> id="wt_is_cache"></td>
	</tr>
	<tr>
		<td id='wpt-td'><label class='wpt-label'><?php _e ( 'Empty the cache', 'wordpress-twig' ) ;?></label></td>
		<td><button id="empty"><?php echo __('Validate','wordpress-twig')?></button></td>
	</tr>
	<tr>
		<td id='wpt-td'><label class='wpt-label' ><?php  _e('Debug', 'wordpress-twig')?></label></td>
		<td><select id="debug">
				<option value="1"
					<?php if(get_option('wt_debug') == '1'){echo("selected");}?>><?php  _e('Activate', 'wordpress-twig')?></option>
				<option value="0"
					<?php if(get_option('wt_debug') == '0'){echo("selected");}?>><?php  _e('Deactivate', 'wordpress-twig')?></option>
		</select></td>
	</tr>
		<tr>
		<td id='wpt-td'><label class='wpt-label' ><?php _e('Auto Reload','wordpress-twig') ?></label></td>
		<td><select id='auto_reload'>
				<option value="1"
					<?php if(get_option('wt_auto_reload') == '1'){echo("selected");}?>><?php _e('Activate', 'wordpress-twig')?></option>
				<option value="0"
					<?php if(get_option('wt_auto_reload') == '0' || get_option('wt_auto_reload') == ''){echo("selected");}?>><?php  _e('Deactivate', 'wordpress-twig')?></option>
		</select></td>
	</tr>
	<tr>
		<td id='wpt-td'><label class='wpt-label' for="icone"><?php _e('Add new directories of templates','wordpress-twig')?></label><br /></td>
		<td><input type="text" name="directory" id="pathTxt" name="pathTxt" />
			<input type="button" value="<?php  _e('Add', 'wordpress-twig')?>" id="dirs">
						
			</td>
	</tr>
	<tr><td><a id='list_dirs' href='' ><?php _e('list of templates directories','wordpress-twig')?></a></td><td></td></tr>
	<tr><td id="registred_dirs" ></td><td></td></tr>
	
	<tr>
		<td id='wpt-td'><label class='wpt-label' for="icone"><?php _e('Activate the routing','wordpress-twig')?></label><br /></td>
		<td><select id="routing">
				<option value="1"
					<?php if(get_option('wt_routing') == '1'){echo("selected");}?>><?php _e('Activate', 'wordpress-twig')?></option>
				<option value="0"
					<?php if(get_option('wt_routing') == '0' || get_option('wt_routing') == ''){echo("selected");}?>><?php  _e('Deactivate', 'wordpress-twig')?></option>
		</select></td>
	</tr>
</table>
<div>
<?php
// $liste_templates = explode ( ";", get_option ( 'wt_paths' ) );
// if (count ( $liste_templates ) > 0) {
// 	for($i = 0; $i < count ( $liste_templates ); $i ++) {
// 		?>
<!-- 		<div> -->
			<!--  <a id="<?php //echo "dir_$i"?>"  
				href="<?php //echo $liste_templates[$i] ?>"><?php //echo $liste_templates[$i] ?></a>-->
			<!--  <a class='lien' id="<?php // echo $i?>" href="">delete</a> -->
<!-- 		</div> -->
		<?php
// 	}
// }
?>
<div id="paths"></div>
</div>