<?php
/**
 *  Easily use the Authorize.Net Server Integration Method (SIM).
 *
 *  @link	   http://www.authorize.net/support/SIM_guide.pdf SIM Guide
 *  
 *  Parse an AuthorizeNet SIM Response.
 */


class DTI_ANet_SIM_Response extends DTI_ANet_Response
{
	
	// For ARB transactions
	public $subscription_id;
	public $subscription_paynum;
	
	
	/**
	 *  Constructor.
	 *
	 *  @param string $api_login_id
	 *  @param string $md5_setting For verifying an Authorize.Net message.
	 */
	public function __construct( $api_login_id = false, $md5_setting = false )
	{
		$this->api_login_id = ($api_login_id ? $api_login_id : (defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID : ""));
		$this->md5_setting = ($md5_setting ? $md5_setting : (defined('AUTHORIZENET_MD5_SETTING') ? AUTHORIZENET_MD5_SETTING : ""));
		$this->response = $_POST;
		
		// Set fields without x_ prefix
		foreach ( $_POST as $key => $value ) {
			$name = substr( $key, 2 );
			$this->$name = strip_tags( stripslashes( trim( $value )));
		}
		
		// Set some human readable fields
		$map = array(
			'avs_response' => 'x_avs_code',
			'authorization_code' => 'x_auth_code',
			'transaction_id' => 'x_trans_id',
			'customer_id' => 'x_cust_id',
			'md5_hash' => 'x_MD5_Hash',
			'card_code_response' => 'x_cvv2_resp_code',
			'cavv_response' => 'x_cavv_response',
		);
		
		foreach ( $map as $key => $value ) {
			$this->$key = (isset($_POST[$value]) ? $_POST[$value] : "");
		}
		
		$this->approved = ($this->response_code == self::APPROVED);
		$this->declined = ($this->response_code == self::DECLINED);
		$this->error	= ($this->response_code == self::ERROR);
		$this->held	    = ($this->response_code == self::HELD);
	}
	
	
	/**
	 *  Verify the request is AuthorizeNet.
	 *
	 *  @return bool
	 */
	public function isAuthorizeNet()
	{
        return count( $_POST ) && $this->md5_hash && ( $this->generateHash() == $this->md5_hash );
	}
	
	
	/**
	 *  Generates an Md5 hash to compare against Authorize.Net's.
	 *
	 *  @return string Hash
	 */
	public function generateHash()
	{
		$amount = ($this->amount ? $this->amount : "0.00");
        return strtoupper( md5( $this->md5_setting . $this->api_login_id . $this->transaction_id . $amount ));
	}
	
	
	/**
	 *  A snippet to send to AuthorizeNet to redirect the user back to the
	 *  merchant's server. Used on relay response page.
	 *
	 *  @param string $redirect_url Where to redirect the user.
	 *
	 *  @return string
	 */
	public static function getRelayResponseSnippet( $redirect_url )
	{
		return "<html><head><script language=\"javascript\">
				<!--
				window.location=\"{$redirect_url}\";
				//-->
				</script>
				</head><body><noscript><meta http-equiv=\"refresh\" content=\"1;url={$redirect_url}\"></noscript></body></html>";
	}
	
}
