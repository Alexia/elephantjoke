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
	 *
	 * @var		object
	 */
	private $mouse;

	/**
	 * API Key
	 *
	 * @var		string
	 */
	private $apiKey;

	/**
	 * API Secret
	 *
	 * @var		string
	 */
	private $apiSecret;

	/**
	 * From Number
	 *
	 * @var		integer
	 */
	private $from;

	/**
	 * To Number
	 *
	 * @var		integer
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
		$this->mouse = mouseHole::instance(['curl' => 'mouseTransferCurl', 'request' => 'mouseRequestHttp', 'output' => 'mouseOutputOutput']);
		$this->mouse->output->addTemplateFolder(__DIR__.'/../templates');

		$this->apiKey = $apikey;
		$this->apiSecret = $apisecret;
		$this->from = $from;
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
			"Q: What time is it when an elephant sits on your fence?\nA:Time to build a new fence.",
			"Q: What do you get when you cross an elephant with a parrot?\nA:An animal that tells you everything it remembers!",
			"Q: Why was the elephant afraid of the computer store?\nA:Because they sold the world's best mice.",
			"Q: What do you call an elephant in a phone booth?\nA:Stuck!",
			"Q: What do you call an elephant with a machine gun?\nA: Sir.",
			"Q: Why is an elephant big, grey, and wrinkly?\nA: Because, if it was small, white and smooth it would be an Aspirin.",
			"Q: What is gray and not there?\nA: No elephants.",
			"Q: How do you get an elephant on top of an oak tree?\nA: Stand him on an acorn and wait fifty years.",
			"Q: What's the similarity between an elephant and a plum?\nA: They're both purple, except for the elephant.",
			"Q: What is convenient and weighs 20,000 pounds?\nA: An elephant six-pack.",
			"Q: What do you get if you cross an elephant with a kangaroo?\nA: Big holes all over Australia.",
			"Q: What do you call an elephant riding on a train?\nA: A passenger.",
			"Q: What's gray, has two tusks, and weighs 3,000 pounds?\nA: A statue of a walrus.",
			"Q: Why did all the elephants wear red sweatshirts?\nA: They were all on the same team.",
			"Q: What has twelve legs, is pink, and chants, \"Na, na, na\"?\nA: Three pink elephants singing \"Hey Jude.\"",
			"Q: What's the best way to make an elephant sculpture?\nA: Take a block of marble and a chisel, and chip away anything that doesn't look like elephant.",
			"Q: Why did the elephant dry his dishes with a blue dish towel?\nA: Because they were wet.",
			"Q: What kind of elephants live at the North Pole?\nA: Cold ones.",
			"Q: How do you tell if there is an elephant in your bed?\nA: The big \"E\" on his pajamas.",
			"Q: How do you tell if there is an elephant under your bed?\nA: The ceiling is REALLY close.",
			"Q: What do you call two elephants on a bicycle?\nA: Optimistic! ",
			"Q: What do you get if you take an elephant into the city?\nA: Free Parking.",
			"Q: How do you know if there is an elephant in the pub?\nA: It's bike is outside.",
			"Q: How many elephants does it take to change a light bulb?\nA: Don't be stupid, elephants can't change light bulbs.",
			"Q: What do you get when you cross an elephant with a rhinoceros?\nA: Elephino.",
			"Q: Why do elephants paint the soles of their feet yellow?\nA: So that they can hide upside-down in bowls of custard.",
			"Q: How do you stop an elephant from charging?\nA: Take away his credit card.",
			"Q: Why do elephants have trunks?\nA: Because they would look silly with glove compartments.";
			"Q: What do you get when you cross an elephant and a mountain climber?\nA: Zero - a mountain climber is a scaler.",
			"Q: What is beautiful, gray and wears glass slippers?\nA: Cinderelephant."
		];

		$textKey = array_rand($text);

		return $text[$textKey];
	}

	/**
	 * Checks if the to number is valid.
	 *
	 * @access	public
	 * @param	integer	To Number
	 * @return	boolean
	 */
	public function isValidToNumber($toNumber) {
		$valid = false;
		if (is_numeric($toNumber)) {
			$valid = true;
		}

		return $valid;
	}

	/**
	 * Returns the to phone number.
	 *
	 * @access	public
	 * @return	void
	 */
	public function getToNumber() {
		return $this->to;
	}

	/**
	 * Sets the to phone number.
	 *
	 * @access	public
	 * @param	integer	To Number
	 * @return	void
	 */
	public function setToNumber($toNumber) {
		$this->to = $toNumber;
	}

	/**
	 * Send the elephant joke
	 *
	 * @access	public
	 * @param	
	 * @return	mixed string || json data
	 */
	public function sendElephantJoke() {
		$errorMessage = null;

		if ($this->isValidToNumber($this->to)) {
			$fields = [
				'api_key'		=> $this->apiKey,
				'api_secret'	=> $this->apiSecret,
				'text'			=> $this->generateElephantJoke(),
				'from'			=> $this->from,
				'to'			=> $this->to
			];

			$jsonReturn = $this->mouse->curl->post('https://rest.nexmo.com/sms/json?'.http_build_query($fields), $fields, ['headers' => ['Content-Type: application/x-www-form-urlencoded']], true);

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
