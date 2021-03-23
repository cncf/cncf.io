<?php

defined( 'ABSPATH' ) || exit;

use Wpai\Http\Request;
use Wpai\Http\JsonResponse;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Adapter\Ftp as FtpAdapter;

class RemoteFilesystem {

	private $options;
	private $filesystem;
	private $error = false;
	private $rel_type;
	private $default_port = false;
	private $error_stack = [];
	private $type;
	private $contents;
	private $orig_type = false;
	private $allow_hidden_files_folders;
	// Should match list in classes/upload.php#56 - xml|gzip|zip|csv|tsv|gz|json|txt|dat|psv|sql|xls|xlsx
	private $allowed_file_extensions = ['xml','gzip','zip','csv','tsv','gz','json','txt','dat','psv','sql','xls','xlsx'];
	private $debug;
	private $orig_root = false;

	public function __construct( $options ) {

		// Enable debug filter
		$this->debug = apply_filters('wpai_ftp_enable_debug', false);

		// Show hidden files filter.
		$this->allow_hidden_files_folders = apply_filters('wpai_ftp_allow_hidden_files_folders', false);

		// Allowed file extensions filter.
		$this->allowed_file_extensions = apply_filters('wpai_ftp_allowed_file_extensions', $this->allowed_file_extensions);

		// Default options
		$default_options = [
			'root'                           => '/',
			'timeout'                        => 10,
			// FTP only options
			'passive'                        => true,
			'ignorePassiveAddress'           => false,
			'enableTimestampsOnUnixListings' => true,
		];

		$this->options = $this->option_merge( $default_options, $options );

		// Root override
		$this->options['root'] = apply_filters('wpai_ftp_root', $this->options['root'], PMXI_Plugin::getCurrentImportId());

		// Ensure no trailing slash or text after the URL exists.
		$this->options['host'] = preg_replace( '@(?<![/:])/.*@', '', $this->options['host'] );

		// Connect to FTP server.
		$this->connect();

		// Process any relative file references.
		$this->get_relative();

	}

	/**
	 * Determine protocol and attempt to connect.
	 */
	private function connect() {
		if ( preg_match( '%^sftp://%i', trim( $this->options['host'] ) ) || !empty($this->options['privateKey']) ) {
			$this->default_port    = [ 22, 2222 ];
			$this->options['host'] = str_replace( 'sftp://', '', $this->options['host'] );
			$this->buildFilesystem( 'sftp' );
		} elseif ( preg_match( '%^ftp://%i', trim( $this->options['host'] ) ) ) {
			$this->default_port    = [ 21 ];
			$this->options['host'] = str_replace( 'ftp://', '', $this->options['host'] );
			$this->buildFilesystem( 'ftp' );
		} elseif ( preg_match( '%^ftps://%i', trim( $this->options['host'] ) ) ) {
			$this->default_port    = [ 21 ];
			$this->options['host'] = str_replace( 'ftps://', '', $this->options['host'] );
			$options['ssl']        = true;
			$this->buildFilesystem( 'ftp' );
		} elseif ( trim( $this->options['port'] ) == 21 ) {
			$this->default_port    = [ 21 ];
			$this->buildFilesystem( 'ftp' );
		} elseif ( trim( $this->options['port'] ) == 22 || trim( $this->options['port'] ) == 2222 ) {
			$this->default_port    = [ 22, 2222 ];
			$this->buildFilesystem( 'sftp' );
		} else {
			// Try SFTP by default.
			$this->default_port = [ 22, 2222 ];
			$this->buildFilesystem( 'sftp' );

		}
	}

	private function buildFilesystem( $type ) {

		$this->type = $type;
		if( $this->orig_type === false )
			$this->orig_type = $type;

		try {

			switch ( $type ) {

				case 'ftp':
					$this->filesystem = new Filesystem( new FtpAdapter( $this->options ) );
					break;
				case 'sftp':
					$this->filesystem = new Filesystem( new SftpAdapter( $this->options ) );
					break;
			}

		} catch ( \Exception $e ) {
			$this->error = $e->getMessage();

		}
	}

	public function listContents( $recursive = false ) {

		try {
			// Store the contents in a parameter since we are using a recursive method on error.
			$this->contents = $this->filesystem->listContents( $this->options['dir'], $recursive );

			// Filter the contents.
			$this->filter_contents();

		} catch ( \Exception $e ) {

			$this->error = $e->getMessage();

			// Log all of the error messages if debug mode is enabled.
			if( $this->debug ){
				error_log("WPAI_FTP_DEBUG");
				error_log("Error Message:");
				error_log($e->getMessage());
				error_log("Options Array:");
				error_log(print_r($this->options, true));
				error_log("END WPAI_FTP_DEBUG");

			}

			if ( str_replace( [
					'Root is invalid or does not exist:',
				], '',$e->getMessage() ) !== $e->getMessage()  && $this->orig_root === false) {

				// Save the original root specified.
				$this->orig_root = $this->options['root'];

				if( $this->options['root'] !== '/home') {
					$this->options['root'] = '/home';
					$this->error_stack[]   = $this->error;
					$this->error           = false;
					$this->buildFilesystem( $this->type );
					$this->listContents( $recursive );
				}
				else
					return $this->contents;

			}
			// Check if it was a login failure or connection failure.
			// Don't retry if login failure or if host couldn't be found.
			elseif ( str_replace( [ 'Could not login',
								'php_network_getaddresses: getaddrinfo failed:',
							  ], '',$e->getMessage() ) !== $e->getMessage() ) {

				return $this->contents;

			} else {
				errorProcessing:

				// Retry with default port(s)
				if ( is_array( $this->default_port ) && count( $this->default_port ) > 0) {
					$port = array_pop( $this->default_port );
					while ( $port === $this->options['port'] && count( $this->default_port ) > 0 ) {
						$port = array_pop( $this->default_port );
					}

					if ( $port != $this->options['port'] ) {

						$this->options['port'] = $port;
						$this->error_stack[]   = $this->error;
						$this->error           = false;
						$this->buildFilesystem( $this->type );
						$this->listContents( $recursive );

					}else{
						goto errorProcessing;
					}

				} elseif ( $this->orig_type === $this->type && empty( $this->options['privateKey'] ) ) {

					$this->type         = ( $this->type === 'sftp' ) ? 'ftp' : 'sftp';
					$this->default_port = ( $this->type === 'sftp' ) ? [ 22, 2222 ] : [ 21 ];

					$this->error_stack[] = $this->error;
					$this->error         = false;
					$this->buildFilesystem( $this->type );
					$this->listContents( $recursive );

				} elseif ( count( $this->error_stack ) > 0 ) {

					// Sort the errors so they are in order
					$this->error = '<br/><br/><b>Connection Attempt:</b><br/>' . implode( '<br/><br/><b>Connection Attempt:</b><br/>', $this->error_stack ) . '<br/><br/><b>Connection Attempt:</b><br/>' . $this->error;
				}

				// Return if there was an error.
				return $this->contents;
			}
		}

		// If an additional error wasn't caught then clear the error stack and move on.
		$this->error       = false;
		$this->error_stack = [];

		return $this->contents;
	}

	public function copy() {
		try {
			$uploads     = wp_upload_dir();
			$destination = wp_all_import_secure_file( $uploads['basedir'] . DIRECTORY_SEPARATOR . PMXI_Plugin::UPLOADS_DIRECTORY, PMXI_Plugin::getCurrentImportId(), true );

			// Write the file.
			$result = file_put_contents( $destination . '/' . basename( $this->options['dir'] ), $this->filesystem->readStream( $this->options['dir'] ) );

			if ( $result ) {
				return [ $destination . '/' . basename( $this->options['dir'] ) ];
			}
		} catch ( \Exception $e ) {
			$this->error = $e->getMessage();

			return false;
		}

	}

	public function getError() {
		return $this->error;
	}

	private function option_merge( $default, $opts ) {
		$options = array_merge( $default, $opts );

		if ( isset( $opts['ftp_host'] ) ) {
			$options['host'] = $opts['ftp_host'];
		}
		if ( isset( $opts['ftp_port'] ) ) {
			$options['port'] = $opts['ftp_port'];
		}
		if ( isset( $opts['ftp_path'] ) ) {
			$options['dir'] = $opts['ftp_path'];
		}
		if ( isset( $opts['ftp_root'] ) ) {
			$options['root'] = $opts['ftp_root'];
		}
		if ( isset( $opts['ftp_username'] ) ) {
			$options['username'] = $opts['ftp_username'];
		}
		if ( isset( $opts['ftp_password'] ) ) {
			$options['password'] = $opts['ftp_password'];
		}
		if ( isset( $opts['ftp_private_key'] ) ) {
			$options['privateKey'] = $opts['ftp_private_key'];
		}

		return $options;
	}

	private function get_relative() {

		try {
			$matches = [];

			// Check if a relative file reference was provided.
			preg_match( '#{(.*)\.(.{0,4})}#', $this->options['dir'], $matches );

			// Ensure all of the expected pieces were found or do nothing.
			if ( isset( $matches[0] ) && isset( $matches[1] ) && isset( $matches[2] ) ) {
				$relative       = $matches[1]; // Relative reference such as oldest.
				$this->rel_type = $matches[2]; // The file extension to find.

				// Remove relative file reference from dir before LIST.
				$this->options['dir'] = trim( str_replace( $matches[0], '', $this->options['dir'] ), '/' );

				$contents = $this->listContents();

				if ( $this->error !== false ) {
					throw new Exception( 'Failed to retrieve remote file listing.' );
				}

				switch ( $relative ) {
					case ( 'any' ):

						// Filter out any non files and filter by file type.
						$contents = array_filter( $contents, function ( $var ) {
							return ( isset( $var['type'] ) && $var['type'] == 'file' && isset( $var['extension'] ) && ( $var['extension'] == $this->rel_type || empty( $this->rel_type ) ) );
						} );

						$file = array_pop( $contents );

						isset( $file['path'] ) && $this->options['dir'] = $file['path'];

						break;

					case ( 'oldest' ):

						// Sort by timestamp newest to oldest.
						uasort( $contents, function ( $a, $b ) {
							return $b['timestamp'] - $a['timestamp'];
						} );

						// Filter out any non files and filter by file type.
						$contents = array_filter( $contents, function ( $var ) {
							return ( isset( $var['type'] ) && $var['type'] == 'file' && isset( $var['extension'] ) && ( $var['extension'] == $this->rel_type || empty( $this->rel_type ) ) );
						} );

						$file = array_pop( $contents );

						isset( $file['path'] ) && $this->options['dir'] = $file['path'];
						break;

					case ( 'newest' ):

						// Sort by timestamp oldest to newest.
						uasort( $contents, function ( $a, $b ) {
							return $a['timestamp'] - $b['timestamp'];
						} );

						// Filter out any non files and filter by file type.
						$contents = array_filter( $contents, function ( $var ) {
							return ( isset( $var['type'] ) && $var['type'] == 'file' && isset( $var['extension'] ) && ( $var['extension'] == $this->rel_type || empty( $this->rel_type ) ) );
						} );

						$file = array_pop( $contents );
						isset( $file['path'] ) && $this->options['dir'] = $file['path'];
						break;
				}
			}
		} catch ( \Exception $e ) {
			$this->error = $e->getMessage();

		}
	}

	public function get_port() {
		return $this->options['port'];
	}

	public function get_protocol() {
		return $this->type;
	}

	public function get_root() {
		return $this->options['root'];
	}

	private function filter_contents(){
		// Build filter string.
		$filters = [];

		if( !$this->allow_hidden_files_folders ) {
			$filters[] = '^\.'; // Match leading period.
		}

		if( count($filters) > 0) {
			$filter = '@' . implode( '|', $filters ) . '@';

			$this->contents = array_filter( $this->contents, function ( $var ) use ( $filter ) {

				return ( preg_match( $filter, $var['basename'] ) !== 1 && ( $var['type'] === 'dir' || in_array( $var['extension'], $this->allowed_file_extensions ) ) );

			} );


		}
	}

}