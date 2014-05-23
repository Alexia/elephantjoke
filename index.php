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
		
		$this->elephantJoke = new elephantJoke($this->apiKey, $this->apiSecret, $this->fromNumber);
		$this->mouse = mouseHole::instance();
		$this->mouse->output->addTemplateFolder(__DIR__.'/templates');

		if ($this->mouse->post['callback'] != 'true') {
			$this->displayIndex();
		}
	}

	/**
	 * Display the Main Index
	 *
	 * @access	public
	 * @return	void	[Outputs to Screen]
	 */
	public function displayIndex() {
		$this->mouse->output->loadTemplate('index');

		$this->mouse->output->index->index($form, $errorMessage);
	}
}
$index = new index();
?>