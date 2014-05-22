<?php
require_once(__DIR__.'/mouse/mouse.php');
$mouse = mouseHole::instance(['curl' => 'mouseTransferCurl', 'request' => 'mouseRequestHttp']);

$errorMessage = null;
if (intval($mouse->request->request['msisdn'])) {
	if (stristr($mouse->request->request['text'], 'elephant') || stristr($mouse->request->request['text'], 'joke')) {
		$return = $mouse->curl->post('http://www.nonamestudios.com/elephantjoke/index.php', ['number' => intval($mouse->request->request['msisdn'])]);
	}
}
?>