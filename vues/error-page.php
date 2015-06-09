<?php function displays($e){
?>
<style type="text/css">
#title {
	background-color: #686F8C;
	text-align: center;
}

#content {
	background-color: #3A8EBA;
	border-corner-shape: scoop;
	border-radius: 80%/30px;
	text-align: center;
}

</style>

		<div id='content'><?php  echo $e->getmessage() ;?></div>

<?php 
	
}
?>
