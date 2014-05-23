<?php
/**
 * Elephant Joke
 * Elephant Joke Class
 *
 * @author Tim "Telshin" Aldridge
 * @copyright (c) 2014 NoName Studios
 * @license All Rights Reserved
 * @package Elephant Joke
 *
**/

class elephantJoke {
	/**
	 * Mouse
	 */
	private $mouse;

	/**
	 * API Key variable
	 */
	private $apiKey;

	/**
	 * API Secret variable
	 */
	private $apiSecret;

	/**
	 * From variable
	 */
	private $from;

	/**
	 * From variable
	 */
	private $to;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param array[Optional] Array of object keys to classes to autoload.
	 * @param array[Optional] Array of settings.
	 * @return void
	 */
	public function __construct($apikey, $apisecret, $from) {
		// Setup mouse
		// TODO: Setup proper mouse support and stuff
		require_once(__DIR__.'/../mouse/mouse.php');
		$this->mouse = mouseHole::instance(['curl' => 'mouseTransferCurl', 'request' => 'mouseRequestHttp']);
		$this->apiKey = $apikey;
		$this->apiSecret = $apisecret;
		$this->from = $from;
		$this->to = intval(self:$:mouse->request->request['number']);
	}

	/**
	 * Elephant joke generator
	 *
	 * @access public
	 * @return string
	 */
	public function generateElephantJoke() {
		$text = [
			"Q: Why did the elephant paint its fingernails red?\nA:So it could hide in the strawberry patch.",
			"Q: How can you tell that an elephant is in the bathtub with you?\nA:By the smell of peanuts on its breath.",
			"Q: How can you tell that an elephant has been in your refrigerator/ice box?\nA:By the footprints in the butter/cheesecake/cream cheese.",
			"Q: What time is it when an elephant sits on your fence?\nA:Time to build a new fence."
		];

		$textKey = array_rand($text);

		return $text[$textKey];
	}

	/**
	 * Send the elephant joke
	 *
	 * @access public
	 * @return mixed string || json data
	 */
	public function sendElephantJoke() {
		$errorMessage = null;

		if (is_numeric($to)) {
			$fields = [
				'api_key'		=> $this->apiKey,
				'api_secret'	=> $this->apiSecret,
				'text'			=> $this->elephantJokes(),
				'from'			=> $this->from,
				'to'			=> $this->to
			];

			$jsonReturn = $mouse->curl->post('https://rest.nexmo.com/sms/json?'.http_build_query($fields), $fields, ['headers' => ['Content-Type: application/x-www-form-urlencoded']], true);

			$jsonReturn = @json_decode($jsonReturn, true);

			if ($jsonReturn !== null) {
				if ($jsonReturn['messages'][0]['status'] > 0) {
					$errorMessage = 'There was an error return from the service: "'.$jsonReturn['messages'][0]['error-text'].'"';
				}
			} elseif ($jsonReturn === null) {
				$errorMessage = 'There was no response from the service.  Please double check the internet connection.';
			}
		} else {
			$errorMessage = 'A phone number to send was not supplied for this call. Please resubmit with a phone number.';
		}

		if ($errorMessage !== null) {
			return $jsonReturn;
		} else {
			return $errorMessage;
		}
	}
}
?>