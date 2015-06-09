 <?php 
 function test(){
 global  $wpdb;
 $wpdb->insert( 
	'pfe_paths', 
	array( 
		'path' => 'value1', 
	), 
	array( 
		'%s' 
	) 
);
 echo 'test';
 
}?>