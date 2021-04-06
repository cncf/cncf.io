<?php
namespace Wpai\App\UnsecuredController;

use Wpai\Http\Request;
use Wpai\Http\JsonResponse;
use Wpai\Http\Response;

require_once(WP_ALL_IMPORT_ROOT_DIR . '/classes/filesystem/RemoteFilesystem.php');

class FtpbrowserController {

	/** @var callable */
	private $logger;

	public function __construct($container)
	{

		$this->logger = function($m) {
			print("<div class='progress-msg'>[". date("H:i:s") ."] $m</div>\n");
		};
	}

	public function loadAction(Request $request){
		$req = $request->getJsonParams();

		if ( ! wp_verify_nonce($_GET['_nonce'], 'wpai-ftp-browser')) {
			return $this->sendRes('Security Check Failed', 401, 'text');
		}

		$conn_details = $req['conn_details'];
		$dir = $req['dir'];

		// Ensure values exist for required parameters.
		foreach( $conn_details as $key => $val ){
			if( empty($val) && !in_array( $key, ['port','key', 'pass'] )){
				return $this->sendRes('Missing Host Details.', 400, 'text');
			}
		}

		// Make sure either password or key are provided
		if( empty($conn_details['pass']) && empty($conn_details['key'])){
			return $this->sendRes('A password or SFTP Private key is required.', 400, 'text');
		}

		// Options array
		$options = [
			'host' => stripslashes($conn_details['host']),
			'port' => $conn_details['port'],
			'username' => $conn_details['user'],
			'password' => $conn_details['pass'],
			'root' => '/',
			'timeout' => 10,
			'dir' => $dir,
			// FTP only options
			'passive' => true,
			'ignorePassiveAddress' => false,
			'privateKey' => $conn_details['key'],
		];

		$ftp = new \RemoteFilesystem( $options );

		// Get contents.
		$contents['data'] = $ftp->listContents();

		if( $ftp->getError() !== false ){
			return $this->sendRes($ftp->getError(), 400, 'text');
		}

		// Check if port changed and send new port if needed.
		if( $conn_details['port'] != $ftp->get_port() ){
			$contents['port'] = $ftp->get_port();
		}

		// Check if the host protocol needs to be noted and add it if needed.
		if( !(strpos(strtolower($conn_details['host']), $ftp->get_protocol() . '://') !== false) ){
			$contents['host'] = $ftp->get_protocol() . '://' . $conn_details['host'];
		}

		// Check if the root path has changed and update as needed.
		if( !(strpos(strtolower($conn_details['root']), $ftp->get_root()) !== false) ){
			$contents['root'] = $ftp->get_root();
		}

		// Return contents if all went well.
		return $this->sendRes($contents);

	}

	public function existsAction(Request $request){

	}

	public function copyAction(Request $request){

	}

	private function sendRes($res, $status = 200, $type = 'json'){
		return ($type == 'json') ? new JsonResponse($res, $status) : new Response($res, $status);
	}

}