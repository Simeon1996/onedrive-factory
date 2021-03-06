<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveCurl.php';
class OneDriveClient
{
	const API_URL = "https://api.onedrive.com/v1.0";
	protected $accessToken = null;
	public function __construct($accessToken) {
		$this->accessToken = $accessToken;
	}
	public function listDrive() {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath('/drive/root/children');
		return $api->makeRequest();
	}
	public function listFolder($path) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/{$path}");
		return $api->makeRequest();
	}
	public function createFolder($name) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath('/drive/root/children');
		$api->setHeader('Content-Type', 'application/json');
		$api->setOption(CURLOPT_POST, true);
		$api->setOption(CURLOPT_POSTFIELDS, json_encode(array(
			'name'   => $name,
			'folder' => (object) array(),
		)));
	  	return $api->makeRequest();
	}
	public function uploadFile($inStream, $inSize, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setOption(CURLOPT_INFILE, $my_file);
		$api->setOption(CURLOPT_PUT, true);
		$api->setOption(CURLOPT_INFILESIZE, $inSize);
		$api->setPath("/drive/root:/{$pathname}:/content");
		return $api->makeRequest();
	}
	public function downloadFile($outStream, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/{$pathname}:/content");
		$api->setOption(CURLOPT_FILE, $outStream);
		return $api->makeRequest();
	}
}