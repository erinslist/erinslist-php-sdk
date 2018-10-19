<?php

namespace Erinslist;

class ProtocolException extends \Exception {

    public function __construct($response, $curl) {
    	$message = is_string($response) ? $response : $response->message;
        $message = 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage.'. Message: '.$message;
        parent::__construct($message);
    }
}