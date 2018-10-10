<?php

namespace Erinslist;

class ProtocolException extends \Exception {

    public function __construct($response, $curl) {
        $message = 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage.'. Message: '.$response->message;
        parent::__construct($message);
    }
}