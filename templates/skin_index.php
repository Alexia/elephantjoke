<?php
/**
 * Elephant Joke
 * Index Template
 *
 * @author		Alexia E. Smith
 * @copyright	(c) 2014 NoName Studios
 * @license		LGPLv3.0
 * @package		Elephant Joke
 *
**/

class skin_index {
	/**
	 * Main Index Template
	 *
	 * @access	public
	 * @param	array	Array of saved form inputs.
	 * @param	string	[Optional] Error Message
	 * @return	string	Finished HTML
	 */
	public function index($form, $errorMessage = null) {
		$HTML .= "
			<html>
				<head>
					<title>Get Elephant Joke</title>
				</head>
				<body>
					<form action='index.php' method='POST'>
						<h2>";
		if (!empty($errorMessage)) {
			$HTML .= $errorMessage;
		} elseif ($errorMessage !== null) {
			$HTML .= 'Joke sent!  It should arrive soon.  To end your Elephant Jokes&#8482; subscription at any time simply respond with an elephant.';
		}
		$HTML .= "
					</h2>
					<fieldset>
						<label for='number'><strong>Enter your number below and click the button.  Alternatively text ELEPHANT to <em>+12132633657</em> to get a joke.</strong></label><br/>
						<input id='number' name='number' type='text' value='".intval($form['number'])."'>
						<input id='submit' type='submit' value='Get an Elephant Joke!*'/>
					</fieldset>
				</form>
				<a href='http://en.wikipedia.org/wiki/Elephant_joke'>Wikipedia: Elephant joke</a>
			</body>
		</html>";

		return $HTML;
	}
}
?>