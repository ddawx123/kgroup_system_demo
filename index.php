<?php
header('Content-Type: text/plain; charset=UTF-8');
$response = array(
	'code'	=>	503,
	'message'	=>	'站点建设中，暂不开放。',
	'requestId'	=>	date('YmdHis', time())
);
echo json_encode($response,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);