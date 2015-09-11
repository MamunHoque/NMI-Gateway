<?php

class NMI_Gateway {

	/**
	 * End point URL
	 * @var string
	 */
	private $targetUrl = 'https://secure.merchantservicecorp.net/api/transact.php';

	/**
	 * Default parameters - username and password
	 * @var array
	 */
	public $default_params = array(
		'username' => 'demo', //set the user
		'password' => 'password', //set the password
	);

	/**
	 * [buildRequestString description]
	 * @param  Array  $params [description]
	 * @return [type]         [description]
	 */
	public function buildRequestString(Array $params) {
		$params = array_merge($this->default_params, $params);
		$string = '';
		foreach ($params as $key => $value) {
			$string .= $key . '=' . $value . '&';
		}
		return $string;
	}

	/**
	 * [decodeRequestString description]
	 * @param  [type] $strings [description]
	 * @return [type]          [description]
	 */
	public function decodeRequestString($strings) {
		if (empty($strings)) {
			return false;
		}
		$result = array();
		$strings_param = explode('&', $strings);
		foreach ($strings_param as $str) {
			$value = explode('=', $str);
			$result[$value[0]] = $value[1];
		}
		return $result;
	}

	/**
	 * [sendRequest description]
	 * @param  [type] $request_string [description]
	 * @return [type]                 [description]
	 */
	public function sendRequest($request_string) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->targetUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
		$result = curl_exec($ch);
		if ($result) {
			return $this->decodeRequestString($result);
		}
		return array();
	}

    /**
     * Use this method to capture the sell
     * @param $ccnumber
     * @param $ccexp
     * @param $cvv
     * @param $amount
     * @param string $firstname
     * @param string $lastname
     * @return array
     */
	public function sell($ccnumber, $ccexp, $cvv, $amount, $firstname = '', $lastname = '') {
		$request_string = $this->buildRequestString(array(
			'type' => 'sale',
			'ccnumber' => $ccnumber,
			'ccexp' => $ccexp,
			'cvv' => $cvv,
			'amount' => $amount,
			'firstname' => $firstname,
			'lastname' => $lastname,
		));
		$request = $this->sendRequest($request_string);
		return $request;
	}
}