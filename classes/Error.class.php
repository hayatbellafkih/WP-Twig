<?php
class Errors {
	private $type;
	private $message;
	private $fichier;
	private $ligne;
	private $date;
	public function Errors() {
		// error_reporting(0);
		set_error_handler ( array (
				$this,
				'gestionDesErreurs' 
		) );
		set_exception_handler ( array (
				$this,
				'gestionDesExceptions' 
		) );
		register_shutdown_function ( array (
				$this,
				'gestionDesErreursFatales' 
		) );
	}
	public function gestionDesErreurs($type, $message, $fichier, $ligne) {
		switch ($type) {
			case E_ERROR :
			case E_PARSE :
			case E_CORE_ERROR :
			case E_CORE_WARNING :
			case E_COMPILE_ERROR :
			case E_COMPILE_WARNING :
			case E_USER_ERROR :
				$type_erreur = "Erreur fatale";
				break;
			case E_WARNING :
			case E_USER_WARNING :
				$type_erreur = "Avertissement";
				break;
			
			case E_NOTICE :
			case E_USER_NOTICE :
				$type_erreur = "Remarque";
				break;
			
			case E_STRICT :
				$type_erreur = "Syntaxe Obsolète";
				break;
			
			default :
				$type_erreur = "Erreur inconnue";
		}
		$erreur = date ( "d.m.Y H:i:s" ) . ' - ' . $type_erreur . '    ' . $message . '   ligne ' . $ligne . ' (' . $fichier . ')   ';
		$this->date = date ( "d.m.Y H:i:s" );
		$this->ligne = $ligne;
		$this->fichier = $fichier;
		$this->type_erreur = $type_erreur;
		$this->message = $message;
		
		// Enregistrement de l'erreur dans un fichier txt
		
		$log = fopen ( PLUGIN_TWP . '/log/errors.log', 'a' );
		fwrite ( $log, $erreur . "\n" );
		fclose ( $log );
		

	}
	public function getMessage() {
		return $this->message;
	}
	public function  getLigne(){
		return $this->ligne;
	}
	public function getFichier(){
		return $this->fichier;
	}
	public function getdate(){
		return $this->date;
	}
	public function getType_erreur(){
		return $this->type_erreur;
	}
	public function gestionDesExceptions($exception) {
		$this->gestionDesErreurs ( E_USER_ERROR, $exception->getMessage (), $exception->getFile (), $exception->getLine () );
		global $twig;
		$template = $twig->loadTemplate ( "error.twig" );
		$template->display ( array (
				'errors' => $this 
		) );
	}
	public function gestionDesErreursFatales() {
		if (is_array ( $e = error_get_last () )) {
			$type = isset ( $e ['type'] ) ? $e ['type'] : 0;
			$message = isset ( $e ['message'] ) ? $e ['message'] : '';
			$fichier = isset ( $e ['file'] ) ? $e ['file'] : '';
			$ligne = isset ( $e ['line'] ) ? $e ['line'] : '';
			
			if ($type > 0)
				$this->gestionDesErreurs ( $type, $message, $fichier, $ligne );
		}
	}
}