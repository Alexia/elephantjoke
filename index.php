<?php
require_once(__DIR__.'/mouse/mouse.php');
$mouse = mouseHole::instance(['curl' => 'mouseTransferCurl', 'request' => 'mouseRequestHttp']);

$errorMessage = null;
if (intval($mouse->request->request['number'])) {
	$errorMessage = false;
	$text = [
		"Q: Why did the elephant paint its fingernails red?\nA:So it could hide in the strawberry patch.",
		"Q: How can you tell that an elephant is in the bathtub with you?\nA:By the smell of peanuts on its breath.",
		"Q: How can you tell that an elephant has been in your refrigerator/ice box?\nA:By the footprints in the butter/cheesecake/cream cheese.",
		"Q: What time is it when an elephant sits on your fence?\nA:Time to build a new fence."
	];

	$textKey = array_rand($text);

	$fields = [
		'api_key'		=> '944d02e0',
		'api_secret'	=> '04afbc9d',
		'text'			=> $text[$textKey],
		'from'			=> 12132633657,
		'to'			=> intval($mouse->request->request['number'])
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
}
?>