<?php
/*
Plugin Name: FileMaker API Wrapper
Description: Provides a clean, consistent and efficient way for WordPress plugins and themes to connect to FileMaker via the official API or FX.PHP.
Version: 0.1a
Author: Ian Dunn
Author URI: http://iandunn.name
*/

if( $_SERVER[ 'SCRIPT_FILENAME' ] == __FILE__ )
	die( 'Access denied.' );

if( !class_exists( 'FileMakerAPIWrapper' ) )
{
	/**
	 * @package FileMakerAPIWrapper
	 * @author Ian Dunn <ian@iandunn.name>
	 */
	class FileMakerAPIWrapper
	{
		// Declare variables and constants
		private static $instance;
		private $readablePrivateVars, $writablePrivateVars, $filemaker;
		const NAME		= 'FileMaker API Wrapper';
		const VERSION	= '0.1a';
		const PREFIX	= 'fmaw_';

		/**
		 * Constructor
		 * @author Ian Dunn <ian@iandunn.name>
		 */
		private function __construct()
		{
			set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . '/includes' );	// The official FileMaker API tries to include files based on relative paths, so need to account for that
			require_once( dirname( __FILE__ ) . '/includes/FileMaker.php' );

			//if( !defined( 'FILEMAKER_IP' ) || !defined( 'FILEMAKER_PORT' ) || !defined( 'FILEMAKER_USERNAME' ) || !defined( 'FILEMAKER_PASSWORD' ) )
				//IDAdminNotices::cGetSingleton()->mEnqueue( self::NAME . " error - Connection constants aren't defined. Please see readme.txt for installation instructions.", 'error' );

			$this->readablePrivateVars	= array( 'filemaker' );
			$this->writablePrivateVars	= array();
			$this->filemaker 			= new FileMaker( null, 'http://'. FILEMAKER_IP .':'. FILEMAKER_PORT, FILEMAKER_USERNAME, FILEMAKER_PASSWORD );
			// @todo refacetor to also handle FX.PHP - maybe set class constant based on auto detect above, which checks for files in ./includes
			// @todo switch to https when server ready for it?

			$this->cConnectionTest();
		}

		/**
		 * Provides access to a single instances of the class using the singleton pattern
		 * @author Ian Dunn <ian@iandunn.name>
		 * @return object
		 */
		public static function cGetSingleton()
		{
			if( !isset( self::$instance ) )
			{
				$class = __CLASS__;
				self::$instance = new $class;
			}

			return self::$instance;
		}

		/**
		 * Public getter for private variables
		 * @author Ian Dunn <ian@iandunn.name>
		 * @param string $variable
		 * @return mixed
		 */
		public function __get( $variable )
		{
			if( in_array( $variable, $this->readablePrivateVars ) )
				return $this->$variable;
			else
				throw new Exception( self::NAME ." error: Variable '". $variable ."' doesn't exist or isn't accessible." );
		}

		/**
		 * Public setter for private variables
		 * @author Ian Dunn <ian@iandunn.name>
		 * @param string $variable
		 * @param mixed $value
		 */
		public function __set( $variable, $value )
		{
			if( in_array( $variable, $this->writablePrivateVars ) )
				$this->$variable = $value;
			else
				throw new Exception( self::NAME ." error: Variable '". $variable ."' doesn't exist or isn't accessible." );
		}

		/**
		 * Send a e-mail notifications if we can't connect to the FileMaker server
		 * @author Ian Dunn <ian@iandunn.name>
		 */
		private function cConnectionTest()
		{
			if( get_transient( self::PREFIX . '_connection-error' ) )
				return;

			// @todo refacetor to also handle FX.PHP

			$databases = $this->filemaker->listDatabases();

			if( $this->filemaker->isError( $databases ) )
			{
				set_transient( self::PREFIX . '_connection-error', true, 60 * 30 );

				if( defined( 'FILEMAKER_ERROR_EMAILS' ) && strcmp( FILEMAKER_ERROR_EMAILS, '' ) !== 0 )
					$extraEmails = ',' . FILEMAKER_ERROR_EMAILS;
				else
					$extraEmails = '';

				wp_mail(
					get_bloginfo( 'admin_email' ) . $extraEmails,
					"Critical error: ". $_SERVER[ 'SERVER_NAME' ] ." can't retrieve data from FileMaker server",
					"The WP FM API plugin was not able to retrieve data from the FileMaker server.\nError code: ". $databases->getCode() ."\nError message: ". $databases->getMessage()
				);
			}
		}
	}
}

//require_once( dirname( __FILE__ ) . '/includes/IDAdminNotices/id-admin-notices.php' );

?>