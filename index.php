<?php
/**
 * Elephant Joke
 * Index
 *
 * @author		Alexia E. Smith
 * @copyright	(c) 2014 NoName Studios
 * @license		LGPLv3.0
 * @package		Elephant Joke
 *
**/

class index {
	/**
	 * API Key
	 *
	 * @var		string
	 */
	private $apiKey = '944d02e0';

	/**
	 * API Secret
	 *
	 * @var		string
	 */
	private $apiSecret = '04afbc9d';

	/**
	 * From Phone Number
	 *
	 * @var		string
	 */
	private $fromNumber = 12132633657;

	/**
	 * The elephantJoke class storage.
	 *
	 * @var		object
	 */
	private $elephantJoke;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct() {
		require_once(__DIR__.'/classes/elephantJoke.php');
		$this->elephantJoke = new elephantJoke($this->apiKey, $this->apiSecret, $this->fromNumber);
		$this->mouse = mouseHole::instance();

		$callback = false;
		if ($this->elephantJoke->isValidToNumber($this->mouse->request->post['msisdn'])) {
			$this->elephantJoke->setToNumber($this->mouse->request->post['msisdn']);
			$callback = true;
		} elseif ($this->elephantJoke->isValidToNumber($this->mouse->request->post['number'])) {
			$this->elephantJoke->setToNumber($this->mouse->request->post['number']);
		}

		$jokeReturn = $this->elephantJoke->sendElephantJoke();

		if ($callback !== true) {
			$this->displayIndex($jokeReturn);
		}
	}

	/**
	 * Display the Main Index
	 *
	 * @access	public
	 * @param	mixed	Return from sendElephantJoke().
	 * @return	void	[Outputs to Screen]
	 */
	public function displayIndex($jokeReturn) {
		$this->mouse->output->loadTemplate('index');

		$form = [];
		$form['number'] = $this->elephantJoke->getToNumber();

		echo $this->mouse->output->index->index($form, $jokeReturn);
	}

}
$index = new index();
?>