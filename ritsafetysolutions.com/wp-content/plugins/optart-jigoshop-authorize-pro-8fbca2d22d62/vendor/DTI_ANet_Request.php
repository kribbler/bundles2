<?php
/**
 *  Sends requests to the Authorize.Net gateways.
 *
 */


abstract class DTI_ANet_Request
{

	protected $_api_login;
	protected $_transaction_key;
	protected $_post_string;
	protected $_sandbox = true;
	protected $_log_file = false;
	public $VERIFY_PEER = true;				// Set to false if getting connection errors.


	/**
	 *  Set the _post_string
	 */
	abstract protected function _setPostString();

	/**
	 *  Handle the response string
	 */
	abstract protected function _handleResponse( $string );

	/**
	 *  Get the post url. We need this because until 5.3 you
	 *  you could not access child constants in a parent class.
	 */
	abstract protected function _getPostUrl();


	/**
	 *  Constructor.
	 *
	 *  @param string $api_login_id			The Merchant's API Login ID.
	 *  @param string $transaction_key		The Merchant's Transaction Key.
	 */
	public function __construct( $api_login_id = false, $transaction_key = false )
	{
		$this->_api_login =
			($api_login_id ? $api_login_id :
				( defined( 'AUTHORIZENET_API_LOGIN_ID' ) ? AUTHORIZENET_API_LOGIN_ID : '' )
		);
		$this->_transaction_key =
			($transaction_key ? $transaction_key :
				( defined( 'AUTHORIZENET_TRANSACTION_KEY' ) ? AUTHORIZENET_TRANSACTION_KEY : '' )
		);
		$this->_sandbox = ( defined( 'DTI_AUTHORIZENET_SANDBOX' ) ? DTI_AUTHORIZENET_SANDBOX : true );
		$this->_log_file = ( defined( 'DTI_AUTHORIZENET_LOG_FILE' ) ? DTI_AUTHORIZENET_LOG_FILE : false );
	}


	/**
	 *  Alter the gateway url.
	 *
	 *  @param bool $bool Use the Sandbox.
	 */
	public function setSandbox( $bool )
	{
		$this->_sandbox = $bool;
	}


	/**
	 *  Set a log file.
	 *
	 *  @param string $filepath Path to log file.
	 */
	public function setLogFile( $filepath )
	{
		$this->_log_file = $filepath;
	}


	/**
	 *  Return the post string.
	 *
	 *  @return string
	 */
	public function getPostString()
	{
		return $this->_post_string;
	}


	/**
	 *  Posts the request to AuthorizeNet & returns response.
	 *
	 *  @return AuthorizeNetARB_Response The response.
	 */
	protected function _sendRequest()
	{
		$this->_setPostString();
		$post_url = $this->_getPostUrl();
		$curl_request = curl_init( $post_url );
		curl_setopt( $curl_request, CURLOPT_POSTFIELDS, $this->_post_string );
		curl_setopt( $curl_request, CURLOPT_HEADER, 0 );
		curl_setopt( $curl_request, CURLOPT_TIMEOUT, 45 );
		curl_setopt( $curl_request, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl_request, CURLOPT_SSL_VERIFYHOST, 2 );
		if ( $this->VERIFY_PEER ) {
			curl_setopt( $curl_request, CURLOPT_SSL_VERIFYPEER, true );
			curl_setopt( $curl_request, CURLOPT_CAINFO, dirname(__FILE__) . '/ssl/cert.pem' );
		} else {
			curl_setopt( $curl_request, CURLOPT_SSL_VERIFYPEER, false );
		}

		if ( preg_match( '/xml/', $post_url ) ) {
			curl_setopt( $curl_request, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml") );
		}

		$response = curl_exec( $curl_request );

		if ( $this->_log_file ) {

			$header = 'Log Date: ' . date('r') . PHP_EOL;
			if ( $curl_error = curl_error( $curl_request ) ) {
				file_put_contents( $this->_log_file, "-----CURL ERROR-----\n$header$curl_error\n\n", FILE_APPEND );
			} else {
				// Do not log requests that could contain CC info.
				// file_put_contents( $this->_log_file, "----Request----\n{$this->_post_string}\n", FILE_APPEND );
				file_put_contents( $this->_log_file, "-----CURL Response-----\n$header$response\n\n", FILE_APPEND );
			}
		}
		curl_close( $curl_request );

		return $this->_handleResponse( $response );
	}

}